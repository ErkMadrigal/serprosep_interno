(() => {
    'use strict';
  const form = document.querySelector('form');
  const emailInput = document.getElementById('inputEmail');
  const passwordInput = document.getElementById('inputPassword');

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    if (!emailInput.value) {
      emailInput.classList.add('is-invalid');
    } else {
      emailInput.classList.remove('is-invalid');
    }

    if (!passwordInput.value) {
      passwordInput.classList.add('is-invalid');
    } else {
      passwordInput.classList.remove('is-invalid');
    }

    if (emailInput.value && passwordInput.value) {
      // Simulate a successful login

      let user = {
        action: "login",
        name_user: emailInput.value,
        password: passwordInput.value,
      };

      console.log('Login successful');
      fetch('http://localhost/serprosep_interno/API/auth', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-API-KEY': 'k8sd7f9a2v1b4mzqp0xlj5ngtu3wrceh'
        },
        body: user ? JSON.stringify(user) : null 
      }).then(response => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error('Network response was not ok');
        }
      }).then(data => {
        console.log('Login successful:', data);
        localStorage.setItem('user', JSON.stringify(data));
        localStorage.setItem('token', data.token);
      }).catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
    }
  });
})();
