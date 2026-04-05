const scrollBtn = document.getElementById('scrollToTop');

window.addEventListener('scroll', () => {
  if (window.scrollY > 200) {
    scrollBtn.classList.remove('opacity-0', 'translate-y-20');
    scrollBtn.classList.add('opacity-100', 'translate-y-0');
  } else {
    scrollBtn.classList.remove('opacity-100', 'translate-y-0');
    scrollBtn.classList.add('opacity-0', 'translate-y-20');
  }
});

scrollBtn.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
