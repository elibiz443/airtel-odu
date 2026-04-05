document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal');
  const packageButtons = document.querySelectorAll('.package-card');
  const closeModalBtn = document.getElementById('closeModal');
  const stepContents = document.querySelectorAll('[data-step]');
  const progressBar = document.getElementById('bar');
  const stepLabel = document.getElementById('stepLabel');
  const nextBtns = document.querySelectorAll('[data-next]');
  const backBtns = document.querySelectorAll('[data-back]');

  let currentStep = 1;

  const updateModalState = () => {
    stepContents.forEach(s => s.classList.add('hidden'));
    const activeStep = document.querySelector(`[data-step="${currentStep}"]`);
    if (activeStep) {
      activeStep.classList.remove('hidden');
    }

    const progress = (currentStep / 2) * 100;
    if (progressBar) progressBar.style.width = `${progress}%`;
    if (stepLabel) stepLabel.textContent = `Step ${currentStep}/2`;
  };

  const openModal = (pName, pType) => {
    const hiddenPkg = document.getElementById('hiddenPackage');
    const displayPkg = document.getElementById('displayPackage');
    const hiddenConn = document.getElementById('hiddenConnectionType');
    const displayConn = document.getElementById('displayConnectionType');

    if (hiddenPkg) hiddenPkg.value = pName;
    if (displayPkg) displayPkg.textContent = pName;
    if (hiddenConn) hiddenConn.value = pType;
    if (displayConn) displayConn.textContent = pType;

    currentStep = 1;
    updateModalState();
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }
  };

  const hideModal = () => {
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = '';
    }
  };

  packageButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const pkg = btn.getAttribute('data-package');
      const type = btn.getAttribute('data-type');
      openModal(pkg, type);
    });
  });

  nextBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const activeStep = document.querySelector(`[data-step="${currentStep}"]`);
      const requiredInputs = activeStep.querySelectorAll('[required]');
      let isValid = true;

      requiredInputs.forEach(input => {
        if (input.offsetParent !== null) {
          if (!input.value || input.value.trim() === "") {
            isValid = false;
          }
        }
      });

      if (isValid && currentStep < 2) {
        currentStep++;
        updateModalState();
      }
    });
  });

  backBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (currentStep > 1) {
        currentStep--;
        updateModalState();
      }
    });
  });

  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', hideModal);
  }

  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) hideModal();
    });
  }
});
