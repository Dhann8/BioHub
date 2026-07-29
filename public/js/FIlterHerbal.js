    function toggleSymptom(btn) {
      btn.classList.toggle('active');
    }

    function goToStep(step) {
      document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
      document.getElementById('step-' + step).classList.add('active');

      // Update indicators
      if (step === 2) {
        document.getElementById('dot-2').classList.remove('bg-gray-200', 'text-gray-400');
        document.getElementById('dot-2').classList.add('bg-[#2E7D32]', 'text-white', 'shadow-lg', 'shadow-green-900/20');
        document.getElementById('line-1').classList.remove('w-0');
        document.getElementById('line-1').classList.add('w-full');
      } else {
        document.getElementById('dot-2').classList.add('bg-gray-200', 'text-gray-400');
        document.getElementById('dot-2').classList.remove('bg-[#2E7D32]', 'text-white', 'shadow-lg', 'shadow-green-900/20');
        document.getElementById('line-1').classList.add('w-0');
        document.getElementById('line-1').classList.remove('w-full');
      }
      
      // Scroll to top of wizard
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }