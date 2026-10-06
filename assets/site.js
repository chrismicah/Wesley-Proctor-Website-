(() => {
  const menu = document.querySelector('.menu-button');
  const nav = document.querySelector('.site-nav');
  const closeMenu = () => {
    nav?.classList.remove('is-open');
    menu?.setAttribute('aria-expanded', 'false');
    if (menu) menu.textContent = 'Menu +';
  };
  menu?.addEventListener('click', () => {
    const open = menu.getAttribute('aria-expanded') !== 'true';
    menu.setAttribute('aria-expanded', String(open));
    menu.textContent = open ? 'Close −' : 'Menu +';
    nav.classList.toggle('is-open', open);
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      const active = document.activeElement;
      const openDetail = active?.closest('.nav-details[open]');
      document.querySelectorAll('.nav-details').forEach(el => { el.open = false; });
      if (openDetail) openDetail.querySelector('summary').focus();
      if (menu?.getAttribute('aria-expanded') === 'true') { closeMenu(); menu.focus(); }
    }
  });
  document.querySelectorAll('.nav-details').forEach(detail => {
    detail.addEventListener('toggle', () => {
      if (detail.open) document.querySelectorAll('.nav-details').forEach(other => { if (other !== detail) other.open = false; });
    });
  });
  document.addEventListener('click', event => {
    if (!event.target.closest('.nav-details')) document.querySelectorAll('.nav-details').forEach(detail => { detail.open = false; });
    if (!event.target.closest('.site-header') && menu?.getAttribute('aria-expanded') === 'true') closeMenu();
  });
  const current = location.pathname.split('/').pop() || 'index.html';
  nav?.querySelectorAll('a').forEach(link => {
    if (link.getAttribute('href').replace('./', '') === current) link.setAttribute('aria-current', 'page');
  });
})();
