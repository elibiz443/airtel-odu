window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('edit')) {
    const formElement = document.getElementById('userForm');
    if (formElement) {
      formElement.scrollIntoView({ behavior: 'smooth' });
    }
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});
