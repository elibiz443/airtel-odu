document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('copyRef');
  if (!btn) return;

  btn.addEventListener('click', async () => {
    const ref = btn.getAttribute('data-ref') || '';
    if (!ref) return;

    try {
      await navigator.clipboard.writeText(ref);
      btn.textContent = 'Copied';
      setTimeout(() => {
        btn.textContent = 'Copy ref';
      }, 1400);
    } catch (e) {
      btn.textContent = ref;
      setTimeout(() => {
        btn.textContent = 'Copy ref';
      }, 1400);
    }
  });
});
