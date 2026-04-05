const filterForm = document.querySelector('form[method="get"]');
if (filterForm) {
  filterForm.addEventListener('submit', () => {
    const pageInput = document.createElement('input');
    pageInput.type = 'hidden';
    pageInput.name = 'page';
    pageInput.value = '1';
    filterForm.appendChild(pageInput);
  });
}

window.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.group.relative.rounded-\\[2\\.5rem\\]');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    setTimeout(() => {
      card.style.transition = 'all 0.5s ease-out';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 50);
  });
});
