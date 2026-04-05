document.addEventListener('DOMContentLoaded', () => {
  const headerContainer = document.getElementById('header-container');
  const logoBox = document.getElementById('logo-box');
  const logoText = document.getElementById('logo-text');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  const openBtn = document.getElementById('open-sidebar');
  const closeBtn = document.getElementById('close-sidebar');
  const navLinks = document.querySelectorAll('.nav-link');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      headerContainer.classList.replace('py-4', 'py-2');
      logoBox.classList.replace('h-11', 'h-8');
      logoBox.classList.replace('w-11', 'w-8');
      logoText.classList.add('scale-90', 'origin-left');
    } else {
      headerContainer.classList.replace('py-2', 'py-4');
      logoBox.classList.replace('h-8', 'h-11');
      logoBox.classList.replace('w-8', 'w-11');
      logoText.classList.remove('scale-90', 'origin-left');
    }
  });

  const toggleSidebar = (state) => {
    if (state) {
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('opacity-0', 'pointer-events-none');
      document.body.style.overflow = 'hidden';
    } else {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';
    }
  };

  openBtn.addEventListener('click', () => toggleSidebar(true));
  closeBtn.addEventListener('click', () => toggleSidebar(false));
  overlay.addEventListener('click', () => toggleSidebar(false));

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
      toggleSidebar(false);
    }
  });

  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      const targetId = link.getAttribute('href');
      if (targetId.startsWith('#')) {
        e.preventDefault();
        const targetSection = document.querySelector(targetId);
        if (targetSection) {
          toggleSidebar(false);
          window.scrollTo({
            top: targetSection.offsetTop - 90,
            behavior: 'smooth'
          });
          history.pushState(null, null, ' ');
        }
      }
    });
  });
});
