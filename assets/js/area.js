document.addEventListener('DOMContentLoaded', () => {
  const townSelect = document.getElementById('installationTown');
  const estateSelect = document.getElementById('mappedEstate');
  const otherEstateInput = document.getElementById('otherEstate');

  townSelect?.addEventListener('change', function() {
    const selectedTown = this.value;
    const estates = subareasData[selectedTown] || [];

    // Reset and enable the estate dropdown
    estateSelect.innerHTML = '<option value="" selected disabled>Choose estate</option>';
    estateSelect.disabled = false;

    // Populate the dropdown with estates from the PHP array
    estates.forEach(estate => {
      const option = document.createElement('option');
      option.value = estate;
      option.textContent = estate;
      estateSelect.appendChild(option);
    });

    // Hide the "Other" input if it was visible from a previous selection
    otherEstateInput.classList.add('hidden');
    otherEstateInput.required = false;
  });

  // Handle the "Other" option logic
  estateSelect?.addEventListener('change', function() {
    if (this.value === 'Other') {
      otherEstateInput.classList.remove('hidden');
      otherEstateInput.required = true;
      otherEstateInput.focus();
    } else {
      otherEstateInput.classList.add('hidden');
      otherEstateInput.required = false;
    }
  });
});
