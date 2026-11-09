const brandHeader = document.querySelector('.site-header');
const brandMenu = brandHeader.querySelector('.menu-toggle');

brandHeader.addEventListener('focusout', (event) => {
  if (!brandHeader.contains(event.relatedTarget)) brandMenu.setAttribute('aria-expanded', 'false');
});
