  fetch('navbar.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('site-header').innerHTML = data;
    })
    .catch(error => {
      console.error('Error loading navbar:', error);
    });