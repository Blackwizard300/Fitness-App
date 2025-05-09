document.getElementById('age-up').addEventListener('click', function() {
    let ageField = document.getElementById('age');
    let currentAge = parseInt(ageField.value);
    if (!isNaN(currentAge)) {
      ageField.value = currentAge + 1;
    }
  });
  
  document.getElementById('age-down').addEventListener('click', function() {
    let ageField = document.getElementById('age');
    let currentAge = parseInt(ageField.value);
    if (!isNaN(currentAge) && currentAge > 0) {
      ageField.value = currentAge - 1;
    }
  });
  