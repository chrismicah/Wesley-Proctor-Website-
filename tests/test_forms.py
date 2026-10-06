"""Exercise real handlers with a fake PHPMailer: no sockets or mail delivery."""
import json
from pathlib import Path
import shutil
import subprocess
import tempfile
import unittest
ROOT = Path(__file__).resolve().parents[1]
ROUTES = ['Nonprofit-Formation-Incorporation.php', 'For-profit-Business-Formation.php',
          'Consultation-Coaching.php', 'Workshops-Trainings.php',
          'speaking-engagement-form.php', 'workshop-seminar-training-form.php']
MOCK = r'''<?php
namespace PHPMailer\PHPMailer;
#[\AllowDynamicProperties]
class PHPMailer {
 const ENCRYPTION_STARTTLS = 'tls';
 public $ErrorInfo = 'PRIVATE SMTP DETAIL';
 public function __construct($exceptions) {}
 public function isSMTP() {}
 public function setFrom($email, $name='') { $this->sender=$email; }
 public function addAddress($email) { $this->recipient=$email; }
 public function addReplyTo($email) { $this->reply=$email; }
 public function isHTML($value) {}
 public function send() {
  $GLOBALS['mock_send_count'] = ($GLOBALS['mock_send_count'] ?? 0) + 1;
  $GLOBALS['mock_mail'] = get_object_vars($this);
  if ($GLOBALS['mock_fail'] ?? false) throw new Exception('PRIVATE SMTP DETAIL');
  return true;
 }
}
'''
class Forms(unittest.TestCase):
 def execute(self, route, post, fail=False):
  with tempfile.TemporaryDirectory(prefix='wpe-form-test-') as directory:
   fixture=Path(directory); (fixture/'phpMailer').mkdir()
   shutil.copy(ROOT/route,fixture/route)
   (fixture/'phpMailer/PHPMailer.php').write_text(MOCK)
   (fixture/'phpMailer/Exception.php').write_text('<?php namespace PHPMailer\\PHPMailer; class Exception extends \\Exception {}')
   (fixture/'phpMailer/SMTP.php').write_text('<?php')
   payload=json.dumps(post)
   runner='''<?php
$_SERVER['REQUEST_METHOD']='POST';
$_POST=json_decode($argv[1], true);
$GLOBALS['mock_fail']=$argv[2]==='1';
ob_start(); require $argv[3]; $html=ob_get_clean();
echo json_encode(['status'=>http_response_code() ?: 200,'html'=>$html,'send_count'=>$GLOBALS['mock_send_count'] ?? 0,'mail'=>$GLOBALS['mock_mail'] ?? null]);
'''
   (fixture/'runner.php').write_text(runner)
   proc=subprocess.run(['php','-d','display_errors=1','runner.php',payload,'1' if fail else '0',route],cwd=fixture,capture_output=True,text=True,check=True)
   return json.loads(proc.stdout)
 def test_invalid_emails_do_not_send(self):
  for route in ROUTES:
   for email in ['bad-email', ['array-value'], '']:
    with self.subTest(route=route,email=email):
     result=self.execute(route,{'submit':'Submit','email':email})
     self.assertEqual(result['status'],422); self.assertEqual(result['send_count'],0)
     self.assertIn('valid email address',result['html'])
 def test_all_six_handlers_send_only_to_business_with_safe_body(self):
  post={'submit':'Submit','email':'visitor@example.org','phone':'555-0100',
        'name':'Visitor Name','business_name':'Visitor Business',
        'nonprofit_organization':'<script>alert(1)</script>', 'mailing_address':'A & B',
        'first_last_name':'Test Person','brief_mission_statement':'Help people',
        'name_llc':'<b>Company</b>','full_name':'Test Person','owner_of_the_llc':'Test Person',
        'identification_number':'','llc_provide':'Support','session':'30 minutes',
        'coaching_session':'Consultation','our_meeting':'<script>alert(1)</script>',
        'date':'2026-11-01','speak':'30 minutes','topic':'<script>alert(1)</script>',
        'attending':'20','information':'A & B','cost':'No'}
  for route in ROUTES:
   with self.subTest(route=route):
    result=self.execute(route,post); self.assertEqual(result['status'],200)
    self.assertEqual(result['send_count'],1); self.assertEqual(result['mail']['recipient'],'form@wesleyproctorenterprise.com')
    self.assertEqual(result['mail']['sender'],'form@wesleyproctorenterprise.com')
    self.assertEqual(result['mail']['reply'],'visitor@example.org')
    if route=='Consultation-Coaching.php':
     self.assertIn('Visitor Name',result['mail']['Body']); self.assertIn('Visitor Business',result['mail']['Body'])
    self.assertNotIn('<script>',result['mail']['Body']); self.assertIn('successfully submitted',result['html'])
 def test_delivery_failure_is_not_success_or_private_error(self):
  for route in ROUTES:
   with self.subTest(route=route):
    result=self.execute(route,{'submit':'Submit','email':'visitor@example.org'},fail=True)
    self.assertEqual(result['status'],503); self.assertNotIn('PRIVATE SMTP DETAIL',result['html'])
    self.assertNotIn('successfully submitted',result['html']); self.assertIn('email or call',result['html'])
 def test_nonprofit_has_no_ssn_field_or_email(self):
  result=self.execute(ROUTES[0],{'submit':'Submit','email':'visitor@example.org','social_security_number':'DO-NOT-SEND'})
  self.assertNotIn('DO-NOT-SEND',result['mail']['Body']); self.assertNotIn('name="social_security_number"',result['html'])
if __name__ == '__main__': unittest.main()
