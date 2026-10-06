// Uses one isolated headless browser. Never submits a real payment or inquiry.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const { chromium } = require(process.env.PLAYWRIGHT_MODULE_PATH || 'playwright');
const base = process.env.WPE_BASE_URL || 'http://127.0.0.1:4187';
const out = process.env.WPE_QA_OUTPUT || '.context/deployment-audit';
const routes = ['index.html','about.html','contact.html','payment.html','calendar.html','courses-trainings.html','products.html','Nonprofit-Formation-Incorporation.php','For-profit-Business-Formation.php','Consultation-Coaching.php','Workshops-Trainings.php','speaking-engagement-form.php','workshop-seminar-training-form.php'];
const results=[];const check=(name,detail)=>{results.push({name,pass:true,detail});};
(async()=>{
 fs.mkdirSync(out,{recursive:true});
 const options={headless:true};if(process.env.PLAYWRIGHT_EXECUTABLE_PATH)options.executablePath=process.env.PLAYWRIGHT_EXECUTABLE_PATH;
 const browser=await chromium.launch(options);
 try {
  const context=await browser.newContext({reducedMotion:'reduce'});
  await context.route('https://www.paypal.com/**',route=>route.fulfill({status:200,contentType:'text/html',body:'Payment intercepted by local QA. No transaction.'}));
  const page=await context.newPage();const errors=[];page.on('pageerror',e=>errors.push(e.message));
  for(const width of [360,768,1440]){
   await page.setViewportSize({width,height:960});
   for(const route of routes){
    const response=await page.goto(`${base}/${route}`,{waitUntil:'networkidle'});
    assert.equal(response.status(),200,route+' HTTP status');
    const detail=await page.evaluate(async()=>{
     for(const img of document.images)img.loading='eager';
     await Promise.all([...document.images].map(img=>img.decode().catch(()=>{})));
     return {width:innerWidth,scrollWidth:document.documentElement.scrollWidth,brokenImages:[...document.images].filter(e=>!e.complete||!e.naturalWidth).map(e=>e.src),unlabeled:[...document.querySelectorAll('input:not([type=hidden]):not([type=submit]),select,textarea')].filter(e=>!e.labels?.length&&!e.getAttribute('aria-label')).map(e=>e.name),main:document.querySelectorAll('main').length,h1:document.querySelectorAll('h1').length,emptyLinks:[...document.querySelectorAll('a')].filter(e=>!e.getAttribute('href')).length};
    });
    assert.ok(detail.scrollWidth<=width,`${route} overflows at ${width}: ${detail.scrollWidth}`);
    assert.deepEqual(detail.brokenImages,[],route+' images');assert.deepEqual(detail.unlabeled,[],route+' labels');
    assert.equal(detail.main,1);assert.equal(detail.h1,1);assert.equal(detail.emptyLinks,0);
    assert.deepEqual(errors,[]);check(`Page ${route} at ${width}px`,detail);
   }
  }
  await page.setViewportSize({width:390,height:844});await page.goto(base);
  const menu=page.locator('.menu-button');await menu.focus();await page.keyboard.press('Enter');
  assert.equal(await menu.getAttribute('aria-expanded'),'true');
  await page.locator('.nav-details').first().locator('summary').click();
  await page.getByRole('link',{name:'Nonprofit formation',exact:true}).click();assert.ok(page.url().endsWith('Nonprofit-Formation-Incorporation.php'));check('Mobile service navigation is functional');
  await page.goto(base);await menu.click();await page.keyboard.press('Escape');assert.equal(await menu.getAttribute('aria-expanded'),'false');assert.ok(await menu.evaluate(e=>e===document.activeElement));check('Escape closes menu and returns focus');
  await page.goto(`${base}/Consultation-Coaching.php`);
  const form=page.locator('.inquiry-form');await form.locator('input[name=email]').fill('visitor@example.org');
  await form.locator('input[name=name]').fill('QA Person');await form.locator('input[name=business_name]').fill('QA Organization');
  assert.equal(await form.evaluate(el=>el.checkValidity()),false);check('Consultation requires a session duration');
  await page.goto(`${base}/payment.html`);const merchantIds=await page.locator('input[name=hosted_button_id]').evaluateAll(els=>els.map(e=>e.value));
  assert.deepEqual(merchantIds,['AZPVX6VRSJ6L2','AZPVX6VRSJ6L2','AZPVX6VRSJ6L2','AZPVX6VRSJ6L2']);
  let paymentData='';page.on('request',request=>{if(request.url().startsWith('https://www.paypal.com/'))paymentData=request.postData()||'';});
  await page.getByRole('button',{name:'Continue to PayPal'}).first().click();await page.waitForURL('https://www.paypal.com/**');assert.ok(paymentData.includes('hosted_button_id=AZPVX6VRSJ6L2'));check('Existing PayPal POST preserved; intercepted before delivery');
  await page.goto(base);const ratios=await page.evaluate(()=>{
   const styles=getComputedStyle(document.documentElement);const c=document.createElement('canvas');c.width=c.height=1;const ctx=c.getContext('2d');
   const rgb=name=>{ctx.fillStyle=styles.getPropertyValue(name).trim();ctx.fillRect(0,0,1,1);return [...ctx.getImageData(0,0,1,1).data].slice(0,3);};
   const lum=color=>color.map(x=>x/255).map(x=>x<=.04045?x/12.92:((x+.055)/1.055)**2.4).reduce((v,x,i)=>v+x*[.2126,.7152,.0722][i],0);
   return [['--paper','--teal'],['--lime','--teal'],['--ink','--lime'],['--muted','--paper'],['--action','--paper']].map(([a,b])=>{const x=lum(rgb(a)),y=lum(rgb(b));return {pair:`${a}/${b}`,ratio:(Math.max(x,y)+.05)/(Math.min(x,y)+.05)};});
  });assert.ok(ratios.every(r=>r.ratio>=4.5),JSON.stringify(ratios));check('Primary text color combinations meet AA contrast',ratios);
  const hrefs=await page.locator('a[href]').evaluateAll(els=>[...new Set(els.map(e=>e.href))]);for(const href of hrefs.filter(h=>h.startsWith(base))){const response=await context.request.get(href);assert.equal(response.status(),200,href);}check('All homepage internal links return HTTP 200');
  for(const width of [1440,390]){
   await page.setViewportSize({width,height:1000});await page.goto(base,{waitUntil:'networkidle'});await page.evaluate(()=>document.fonts.ready);
   await page.screenshot({path:`${out}/final-${width}.png`,fullPage:true});await page.screenshot({path:`${out}/preview-${width}.png`,fullPage:false});
  }
  await page.goto(`${base}/Nonprofit-Formation-Incorporation.php`);assert.equal(await page.locator('[name=social_security_number]').count(),0);check('No public SSN input');
  await page.screenshot({path:`${out}/final-nonprofit-mobile.png`,fullPage:true});
  console.log(`${results.length} browser checks passed.`);fs.writeFileSync(`${out}/final-browser.json`,JSON.stringify({base,results,errors},null,2));
 }finally{await browser.close();}
})().catch(e=>{fs.writeFileSync(`${out}/browser-failure.txt`,e.stack);console.error(e);process.exitCode=1;});
