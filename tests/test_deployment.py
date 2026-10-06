"""Verify the actual remote release script against disposable local directories."""
from pathlib import Path
import os
import subprocess
import tarfile
import tempfile
import unittest
ROOT=Path(__file__).resolve().parents[1]
REMOTE=(ROOT/'scripts/deploy-godaddy.sh').read_text().split("<<'REMOTE'\n",1)[1].rsplit('\nREMOTE',1)[0]
# Simulate the remote home using a task-specific variable. Never repurpose HOME.
REMOTE=REMOTE.replace('$HOME/.wpe-deploy/','$WPE_TEST_HOME/.wpe-deploy/')
class Deployment(unittest.TestCase):
 def fixture(self,directory,bad_php=False):
  root=Path(directory); live=root/'public_html'; live.mkdir()
  (live/'index.html').write_text('previous-homepage')
  (live/'.htaccess').write_text('existing SSL configuration')
  (live/'uploads').mkdir(); (live/'uploads/customer.pdf').write_text('preserve customer file')
  release=root/'.wpe-deploy/test-release'; release.mkdir(parents=True)
  stage=root/'input'; stage.mkdir(); (stage/'index.html').write_text('new-homepage')
  (stage/'service.php').write_text('<?php broken(' if bad_php else '<?php echo "works";')
  (stage/'assets').mkdir(); (stage/'assets/site.css').write_text('body { color: teal; }')
  with tarfile.open(release/'site.tar.gz','w:gz') as archive:
   for f in stage.rglob('*'): archive.add(f,arcname=str(f.relative_to(stage)),recursive=False)
  return root,live,release
 def run_release(self,root,live):
  env=dict(os.environ,WPE_TEST_HOME=str(root))
  return subprocess.run(['bash','-s','--',str(live),'test-release'],input=REMOTE,env=env,text=True,capture_output=True)
 def test_backup_overlay_preserves_ssl_and_untracked_files(self):
  with tempfile.TemporaryDirectory(prefix='wpe-release-test-') as directory:
   root,live,release=self.fixture(directory); result=self.run_release(root,live)
   self.assertEqual(result.returncode,0,result.stderr)
   self.assertEqual((live/'index.html').read_text(),'new-homepage')
   self.assertEqual((live/'.htaccess').read_text(),'existing SSL configuration')
   self.assertEqual((live/'uploads/customer.pdf').read_text(),'preserve customer file')
   with tarfile.open(release/'before.tar.gz') as backup:
    self.assertEqual(backup.extractfile('./index.html').read(),b'previous-homepage')
   self.assertEqual((live/'service.php').stat().st_mode & 0o777,0o644)
 def test_invalid_server_php_never_overwrites_live_files(self):
  with tempfile.TemporaryDirectory(prefix='wpe-release-test-') as directory:
   root,live,release=self.fixture(directory,bad_php=True); result=self.run_release(root,live)
   self.assertNotEqual(result.returncode,0)
   self.assertEqual((live/'index.html').read_text(),'previous-homepage')
   self.assertFalse((live/'service.php').exists())
 def test_missing_live_homepage_refuses_deployment(self):
  with tempfile.TemporaryDirectory(prefix='wpe-release-test-') as directory:
   root,live,release=self.fixture(directory); (live/'index.html').unlink()
   result=self.run_release(root,live); self.assertNotEqual(result.returncode,0)
   self.assertFalse((live/'service.php').exists())
if __name__=='__main__': unittest.main()
