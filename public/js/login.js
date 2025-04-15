document.addEventListener('DOMContentLoaded', function() {
  const loginApp = {
      elements: {
          loginForm: document.querySelector('.login-form'),
          togglePassword: document.getElementById('togglePassword'),
          rememberMe: document.getElementById('rememberMe')
      },

      init: function() {
          this.bindEvents();
          this.checkRememberedUser();
      },

      bindEvents: function() {
          this.elements.loginForm.addEventListener('submit', (e) => {
              const username = document.getElementById('username').value.trim();
              const password = document.getElementById('password').value.trim();
              
              if (!username || !password) {
                  e.preventDefault();
                  alert('Please fill in both fields');
              }
          });

          this.elements.togglePassword.addEventListener('click', (e) => {
              e.preventDefault();
              this.togglePasswordVisibility();
          });
      },

      togglePasswordVisibility: function() {
          const passwordInput = document.getElementById('password');
          const type = passwordInput.type === 'password' ? 'text' : 'password';
          passwordInput.type = type;
          
          // Update eye icon (ensure you have both open_eye.svg and closed_eye.svg)
          const icon = this.elements.togglePassword.querySelector('img');
          icon.src = type === 'password' 
              ? '/tern_application/public/img/closed_eye.svg' 
              : '/tern_application/public/img/open_eye.svg';
      },

      checkRememberedUser: function() {
          const remembered = document.cookie.includes('rememberedUser');
          this.elements.rememberMe.checked = remembered;
      }
  };

  loginApp.init();
});