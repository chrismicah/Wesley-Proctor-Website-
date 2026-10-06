#!/usr/bin/env python3
"""Render the site without requiring a runtime build or changing public routes."""
from pathlib import Path
from html import escape
import json
import re
from bs4 import BeautifulSoup
ROOT = Path(__file__).resolve().parents[1]
services = [
 ('Nonprofit-Formation-Incorporation.php','Nonprofit formation','Build the foundation for your mission.','Step-by-step support to establish your nonprofit and navigate the 501(c)(3) process.', ['Discuss your mission and organization', 'Prepare your incorporation documents', 'Get guidance through your nonprofit application']),
 ('For-profit-Business-Formation.php','Business formation','Make your next chapter official.','Turn your business idea into an organization with practical guidance on formation and next steps.', ['Clarify your business purpose', 'Prepare your formation paperwork', 'Understand the next steps for your business']),
 ('Consultation-Coaching.php','Consultation & coaching','A clearer path starts with a conversation.','One-on-one and group support to work through questions, overcome challenges, and move your vision forward.', ['Share your goals and current challenges', 'Choose a consultation or coaching session', 'Leave with guidance for your next step']),
 ('Workshops-Trainings.php','Workshops & training','Give your team the tools to grow.','Practical learning for nonprofit leaders, business owners, boards, and teams, tailored to your needs.', ['Tell us about your team and learning goals', 'Explore relevant topics and session formats', 'Plan a workshop that fits your organization'])
]
HEADER='''<a class="skip" href="#main">Skip to content</a>
<header class="site-header"><div class="wrap header-inner">
<a class="brand" href="./index.html" aria-label="Wesley Proctor Enterprise home"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a>
<button class="menu-button" type="button" aria-controls="site-navigation" aria-expanded="false">Menu +</button>
<nav class="site-nav" id="site-navigation" aria-label="Main navigation">
<a href="./about.html">Meet Dr. Proctor</a>
<details class="nav-details"><summary>Our services</summary><div class="nav-dropdown">'''+''.join(f'<a href="./{r}">{escape(t)}</a>' for r,t,*_ in services)+'''</div></details>
<details class="nav-details"><summary>Book Dr. Proctor</summary><div class="nav-dropdown"><a href="./speaking-engagement-form.php">Speaking engagements</a><a href="./workshop-seminar-training-form.php">Workshop & seminar booking</a></div></details>
<a href="./payment.html">Make a payment</a><a class="nav-cta" href="./contact.html">Let’s talk <span aria-hidden="true">↗</span></a></nav></div></header>'''
FOOTER='''<footer class="site-footer"><div class="wrap"><div class="footer-grid"><div>
<a class="brand" href="./index.html"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a><p class="footer-description">Helping people turn their purpose into organizations that make a difference.</p></div>
<div><p class="eyebrow footer-label">Explore</p><div class="footer-links"><a href="./about.html">Meet Dr. Proctor</a><a href="./index.html#services">Our services</a><a href="./speaking-engagement-form.php">Speaking & booking</a><a href="./calendar.html">Calendar</a><a href="./courses-trainings.html">Courses & resources</a><a href="./products.html">Products</a><a href="./payment.html">Make a payment</a></div></div>
<div><p class="eyebrow footer-label">Get in touch</p><div class="footer-links"><a href="mailto:wesleyproctorenterprise@gmail.com">wesleyproctorenterprise@gmail.com</a><a href="tel:4848366444">484-836-6444</a><a href="https://www.instagram.com/drwesleyproctor/" target="_blank" rel="noopener noreferrer">Follow Dr. Proctor on Instagram ↗</a></div></div></div>
<div class="footer-bottom"><span>© 2026 Wesley Proctor Enterprise, LLC</span><span>Business & education development.</span></div></div></footer>'''

def button(text,url,kind=''):
 return f'<a class="btn {kind}" href="{url}">{text}<span class="arrow" aria-hidden="true">↗</span></a>'
def band():
 return '<section class="booking-band"><div class="wrap booking-inner"><div><h2>Let’s put your purpose<br>into motion.</h2><p>Your idea. Your organization. A clear next step.</p></div>'+button('Start a conversation','./contact.html')+'</div></section>'
def page(title,description,body,prefix=''):
 return prefix+f'''<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="{escape(description,quote=True)}"><meta name="theme-color" content="#173f42"><title>{escape(title)} | Wesley Proctor Enterprise</title><link rel="icon" href="./assets/favicon.ico"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="./assets/site.css"><script src="./assets/site.js" defer></script></head><body data-wpe-version="2">{HEADER}<main id="main">{body}</main>{FOOTER}</body></html>\n'''
def pagehero(label,title,description):
 return f'<section class="page-hero"><div class="wrap"><div class="breadcrumb"><a href="./index.html">Home</a><span aria-hidden="true">/</span><span>{escape(label)}</span></div><p class="eyebrow">{escape(label)}</p><h1>{title}</h1><p>{description}</p></div></section>'
def write(name,content):
 (ROOT/name).write_text('\n'.join(line.rstrip() for line in content.splitlines())+'\n')

content=json.loads((ROOT/'scripts/content/live-content.json').read_text())
def source(route): return BeautifulSoup(content[route],'html.parser')
def text(tag): return tag.get_text(' ',strip=True) if tag else ''
soup=source('index.html')
paragraphs=soup.find_all('p')
intro=text(paragraphs[0]); mission=text(paragraphs[1]); abouttext=text(paragraphs[-1])
original_services=[]
for card in soup.select('.icon-box > .col-md-3'):
 original_services.append((text(card.find('h3')),text(card.find('p')),card.find('a')['href']))
assert len(original_services)==4
home='''<section class="hero"><div class="wrap hero-grid"><div class="hero-copy"><p class="eyebrow">Business & education development</p><h1>Wesley<br>Proctor<br><span>Enterprise.</span></h1><p>'''+escape(intro)+'''</p><div class="hero-actions">'''+button('Explore our services','#services','btn-lime')+'''<a class="text-link" href="./about.html">Meet Dr. Proctor <span aria-hidden="true">↗</span></a></div><p class="hero-note">Formation · Coaching · Training · Speaking</p></div><div class="hero-photo"><img src="./assets/images/Doc%20Photo-%20Bio%20(1).JPG" alt="Dr. Wesley Proctor smiling in a checked suit" width="1024" height="683" fetchpriority="high"><div class="portrait-caption"><div><strong>Dr. Wesley T. Proctor</strong><small>Business & nonprofit consultant</small></div><span aria-hidden="true">↗</span></div></div></div></section>
<section class="section" id="services"><div class="wrap"><div class="section-heading"><div><p class="eyebrow">Mission of the organization</p><h2>A foundation for<br>your next chapter.</h2></div><p>'''+escape(mission)+'''</p></div><div class="service-list">'''
for i,(title,desc,route) in enumerate(original_services,1):
 home+=f'<a class="service-row" href="{route}"><span class="service-number">0{i}</span><div><h3>{escape(title)}</h3><span class="service-cta">Register now</span></div><p>{escape(desc)}</p><span class="arrow" aria-hidden="true">↗</span></a>'
home+='''</div></div></section><section class="section about-band"><div class="wrap about-grid"><div class="about-photo"><img src="./assets/images/Doc%20Photo-%20Bio%20(1).JPG" alt="Dr. Proctor, nonprofit consultant and educator" width="1024" height="683" loading="lazy"></div><div class="about-copy"><p class="eyebrow">About us</p><h2>People. Purpose.<br>Possibility.</h2><p>'''+escape(abouttext)+'''</p><a class="text-link" href="./about.html">Get to know Dr. Proctor <span aria-hidden="true">↗</span></a></div></div></section>
<section class="section"><div class="wrap testimonial"><div><p class="eyebrow">Client testimonial</p></div><div><span class="quote-mark" aria-hidden="true">“</span><blockquote>We can’t thank Dr. Wesley Proctor enough for helping to build, develop and structure our nonprofit. Dr. Proctor has made certain that all of our paperwork is filed on time and correctly. Without his leadership and foresight our nonprofit would be in serious trouble. Thank you Dr. Proctor for all of your help throughout the years.</blockquote><div class="quote-credit"><img src="./assets/images/Brian_Westbrook_Philly_HOF_(cropped_1).jpg" alt="" width="52" height="52" loading="lazy"><div><strong>Brian Westbrook</strong><span>Former Pro Bowl NFL running back<br>CEO of Brian Westbrook Foundation, Inc.</span></div></div><details class="testimonial-original"><summary>View our original client testimonials</summary><div class="testimonial-images"><img src="./Brian%20Westbrook%20Testimonial%20.png" alt="Brian Westbrook’s original testimonial thanking Dr. Proctor for nonprofit formation and ongoing support" loading="lazy"><img src="./Jumaine%20Jones%20Testimonial.png" alt="Jumaine Jones’s original testimonial about Dr. Proctor’s consulting" loading="lazy"></div></details></div></div></section>'''+band()
write('index.html',page('Business & Nonprofit Consulting','Nonprofit and business formation, consultation, coaching, workshops, and speaking with Dr. Wesley Proctor.',home))
about=source('about.html'); ps=about.find_all('p'); first=text(ps[0])
body=pagehero('Meet Dr. Proctor','Dr. Wesley T. Proctor','Business & education development. Nonprofit expertise. A hands-on approach.')+'<section class="section"><div class="wrap about-grid"><div class="about-photo"><img src="./assets/images/Doc%20Photo-%20Bio%20(1).JPG" alt="Dr. Wesley T. Proctor" width="1024" height="683"></div><div class="prose"><p class="eyebrow">About Dr. Proctor</p><p>'+escape(first)+'</p></div></div><div class="wrap prose biography">'+''.join('<p>'+escape(text(p))+'</p>' for p in ps[1:] if text(p))+'</div></section>'+band()
write('about.html',page('Meet Dr. Wesley Proctor','Learn about Dr. Wesley Proctor and his work in nonprofit development, education, and business consulting.',body))
# Keep existing public form fields and service descriptions. The server handlers
# remain from origin/main until the real hosting source can be retrieved.
for route in [s[0] for s in services]+['speaking-engagement-form.php','workshop-seminar-training-form.php']:
 soup=source(route); form=soup.find('form'); assert form
 title=next((item[1] for item in services if item[0]==route), 'Speaking engagement' if route=='speaking-engagement-form.php' else 'Workshop/Seminar Training')
 prefix=(ROOT/'scripts/content/handlers'/route).read_text()
 # These unused passwords were committed publicly, despite SMTPAuth=false.
 prefix=re.sub(r'(?m)^\s*\$mail->Password\s*=.*\n','\n',prefix)
 prefix=prefix.replace("$social_security_number = $_POST['social_security_number'];",'// Sensitive identifiers are collected separately, not by this inquiry form.')
 prefix=re.sub(r'\s*Social Security Number \(SSN\): <u>\$social_security_number</u> <br> <br>','',prefix)
 # Reject malformed email addresses before an SMTP connection; never return raw mail errors.
 prefix=prefix.replace("$email = $_POST['email'];", """$email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(422);
        $output = '<div class="form-status" role="alert">Please provide a valid email address.</div>';
    } else {""")
 # Encode visitor-provided email body values and avoid undefined/array warnings.
 prefix=re.sub(r"\$_POST\[['\"]([a-z_]+)['\"]\](?=;)",lambda m: "htmlspecialchars(is_string($_POST['"+m[1]+"'] ?? null) ? trim($_POST['"+m[1]+"']) : '', ENT_QUOTES, 'UTF-8')",prefix)
 # Preserve the name and business fields already present in the live coaching form.
 if route=='Consultation-Coaching.php':
  prefix=prefix.replace("$phone=", "$name = htmlspecialchars(is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '', ENT_QUOTES, 'UTF-8');\n    $business_name = htmlspecialchars(is_string($_POST['business_name'] ?? null) ? trim($_POST['business_name']) : '', ENT_QUOTES, 'UTF-8');\n    $phone=")
  prefix=prefix.replace('Email: <u>$email</u>', 'Name: <u>$name</u> <br> <br>\n                          Business name: <u>$business_name</u> <br> <br>\n                          Email: <u>$email</u>')
 # Close the validation branch just before the existing outer POST block closes.
 pos=prefix.rfind('\n  }'); assert pos!=-1
 prefix=prefix[:pos]+'\n    }'+prefix[pos:]
 prefix=prefix.replace('$mail->setFrom($email);',"$mail->setFrom('form@wesleyproctorenterprise.com', 'Wesley Proctor Enterprise');")
 prefix=re.sub(r'echo "Message could not be sent\. Mailer Error: \{\$mail->ErrorInfo\}";', "http_response_code(503);\n    $output = '<div class=\"form-status\" role=\"alert\">Your request could not be sent. Please <a href=\"./contact.html\">email or call our team</a>.</div>';\n    error_log('WPE form delivery failed: ' . $mail->ErrorInfo);",prefix)
 # Replace inaccessible popup/inline scripting with a truthful inline message.
 prefix=re.sub(r"\$output = '<div id=\"popup\">.*?</script>\s*';", "$output = '<div class=\"form-status\" role=\"status\">Thank you. Your form has been successfully submitted.</div>';",prefix,flags=re.S)
 intro=[]
 for p in soup.find_all('p'):
  if not p.find_parent(['form','li']) and text(p) and text(p) != 'Please provide the following information:': intro.append(str(p))
 lists=[str(ul) for ul in soup.find_all('ul') if not ul.find_parent('form')]
 # Group labels and controls without rewriting the original labels or choices.
 for br in list(form.find_all('br')): br.decompose()
 for label in list(form.find_all('label')):
  target=form.find(id=label.get('for'))
  if target and target.get('name')=='social_security_number':
   label.decompose(); target.decompose(); continue
  if target and target.get('type')!='radio':
   if target.get('type')=='phone': target['type']='tel'
   wrapper=soup.new_tag('div',attrs={'class':'field'})
   label.insert_before(wrapper); wrapper.append(label.extract()); wrapper.append(target.extract())
  elif target: label['class']='radio-option'; label.insert(0,target.extract())
 for inp in form.find_all('input'):
  if inp.get('type') in ['text','email','tel','date']: inp['class']='form-control'; inp['maxlength']='1000'
  if inp.get('name')=='email': inp['autocomplete']='email'
  if inp.get('name')=='phone': inp['autocomplete']='tel'
  if inp.get('type')=='submit': inp['class']='btn'; inp['value']='Submit request'
 form['action']=''; form['method']='post'; form['class']='inquiry-form'
 # Group session options semantically and require a selection to prevent missing POST keys.
 radios=form.find_all('input',attrs={'type':'radio'})
 if radios:
  grouped={}
  for r in radios: grouped.setdefault(r['name'],[]).append(r)
  for name,items in grouped.items():
   field=soup.new_tag('fieldset',attrs={'class':'field'}); legend=soup.new_tag('legend'); legend.string='Session duration' if name=='session' else 'Does it cost a fee to attend this event?'; field.append(legend)
   items[0].find_parent('label').insert_before(field)
   for r in items: r['required']=''; field.append(r.find_parent('label').extract())
 introhtml=''.join(intro+lists)
 heading=next((text(h) for h in soup.find_all(['h2','h3','h4']) if 'QUESTIONNAIRE' in text(h).upper()),'Please provide the following information')
 contentbody=pagehero(title,title,'Wesley Proctor Enterprise')+'<section class="section"><div class="wrap content-grid"><article class="service-overview">'+introhtml+'</article><div class="form-panel"><h2>'+escape(heading)+'</h2><?php echo $output; ?>'+str(form)+'<p class="form-note">Prefer a conversation? <a href="./contact.html">Email or call our team.</a></p>'
 if route=='Nonprofit-Formation-Incorporation.php': contentbody+='<p class="form-note">Please do not include Social Security numbers in this inquiry. Any sensitive filing details will be arranged separately.</p>'
 contentbody+='</div></div></section>'
 write(route,page(title,title+' with Dr. Wesley Proctor.',contentbody,prefix+'\n'))
# Preserve current merchant IDs and form submissions, restyle buttons only.
soup=source('payment.html'); body=pagehero('Make a payment','Make a Payment','Please make your payment for the services below. We appreciate your business!')+'<section class="section"><div class="wrap payment-grid">'
for box in soup.select('.donate-box .box'):
 title=text(box.find('h3')); form=box.find('form'); assert form
 for img in list(form.find_all('img')): img.decompose()
 imagebutton=form.find('input',attrs={'type':'image'})
 if imagebutton:
  btn=soup.new_tag('button',attrs={'class':'btn','type':'submit'});btn.string='Continue to PayPal ↗';imagebutton.replace_with(btn)
 body+='<article class="payment-item"><h2>'+escape(title)+'</h2>'+str(form)+'</article>'
body+='</div><div class="wrap"><p class="form-note">Please confirm your service and amount with our team before paying. <a href="./contact.html">Contact us with questions.</a></p></div></section>'
write('payment.html',page('Make a payment','Make your Wesley Proctor Enterprise service payment through PayPal.',body))
for route,label in [('calendar.html','Calendar'),('courses-trainings.html','Courses & Training'),('products.html','Products')]:
 soup=source(route); assert 'Coming Soon' in text(soup)
 body=pagehero(label,label,'Wesley Proctor Enterprise')+'<section class="section"><div class="wrap"><div class="notice"><h2>Coming Soon</h2>'+button('Contact our team','./contact.html')+'</div></div></section>'
 write(route,page(label,label+' from Wesley Proctor Enterprise.',body))
# Contact was an untouched French template; use verified business contacts from
# the real site's footer rather than the template's Paris address and fake form.
contact=pagehero('Get in touch','Contact Us','Let’s talk about your business, your nonprofit, or your next event.')+'''<section class="section"><div class="wrap contact-grid"><div><a class="contact-link" href="mailto:wesleyproctorenterprise@gmail.com"><small>Email</small><strong>wesleyproctorenterprise@gmail.com ↗</strong></a><a class="contact-link" href="tel:4848366444"><small>Phone</small><strong>484-836-6444 ↗</strong></a><a class="contact-link" href="https://www.instagram.com/drwesleyproctor/" target="_blank" rel="noopener noreferrer"><small>Follow us</small><strong>@drwesleyproctor ↗</strong></a></div><aside class="notice"><h2>How can we help?</h2><p>Explore our services or send a speaking request with a few details about your event.</p><div style="margin-top:24px"><a class="text-link" href="./index.html#services">Explore our services ↗</a></div>'''+button('Book Dr. Proctor','./speaking-engagement-form.php')+'''</aside></div></section>'''
write('contact.html',page('Contact','Contact Wesley Proctor Enterprise by email or phone.',contact))
from xml.sax.saxutils import escape as xml_escape
routes=list(content)
urls=['https://wesleyproctorenterprise.com/']+['https://wesleyproctorenterprise.com/'+r for r in routes if r!='index.html']
write('sitemap.xml','<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'+''.join('  <url><loc>'+xml_escape(u)+'</loc></url>\n' for u in urls)+'</urlset>\n')
print('Rendered 13 public pages using the October 6 live content; PHP handlers based on origin/main.')
