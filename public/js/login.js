document.addEventListener('DOMContentLoaded', function() {
  const loginApp = {
    elements: {
      togglePassword: document.getElementById('togglePassword'),
      passwordInput: document.getElementById('password'),
      rememberMe: document.getElementById('rememberMe'),
      forgotPassword: document.getElementById('forgotPassword')
    },

    init: function() {
      this.bindEvents();
      this.checkRememberedUser();
    },

    bindEvents: function() {
      // Only keep password toggle functionality
      this.elements.togglePassword.addEventListener('click', (e) => {
        e.preventDefault();
        this.togglePasswordVisibility();
      });
      
      // Remove form submission handling
    },

    togglePasswordVisibility: function() {
      const passwordInput = this.elements.passwordInput;
      const toggleIcon = this.elements.togglePassword.querySelector('.icon');
      const toggleText = this.elements.togglePassword.querySelector('.text-wrapper-2');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleText.textContent = 'Hide';
        toggleIcon.src = '/tern_application/public/img/open_eye.svg';
      } else {
        passwordInput.type = 'password';
        toggleText.textContent = 'Show';
        toggleIcon.src = '/tern_application/public/img/closed_eye.svg';
      }
    },

    checkRememberedUser: function() {
      // Now uses cookies instead of localStorage
      const cookies = document.cookie.split(';');
      const rememberedUser = cookies.find(c => c.includes('rememberedUser'));
      
      if (rememberedUser) {
        const username = rememberedUser.split('=')[1].trim();
        document.getElementById('username').value = username;
        this.elements.rememberMe.checked = true;
      }
    }
  };

  loginApp.init();
});