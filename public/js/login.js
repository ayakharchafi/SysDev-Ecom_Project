document.addEventListener('DOMContentLoaded', function() {
    const loginApp = {
      elements: {
        usernameInput: document.getElementById('username'),
        passwordInput: document.getElementById('password'),
        loginButton: document.getElementById('loginButton'),
        togglePassword: document.getElementById('togglePassword'),
        rememberMe: document.getElementById('rememberMe'),
        forgotPassword: document.getElementById('forgotPassword')
      },
  
      init: function() {
        this.bindEvents();
        this.checkRememberedUser();
      },
  
      bindEvents: function() {
        this.elements.loginButton.addEventListener('click', (e) => {
          e.preventDefault();
          this.handleLogin();
        });
  
        this.elements.togglePassword.addEventListener('click', () => {
          this.togglePasswordVisibility();
        });
  
        this.elements.forgotPassword.addEventListener('click', (e) => {
          e.preventDefault();
          this.handleForgotPassword();
        });
  
        this.elements.passwordInput.addEventListener('keyup', (e) => {
          if (e.key === 'Enter') this.handleLogin();
        });
      },
  
      handleLogin: function() {
        const username = this.elements.usernameInput.value.trim();
        const password = this.elements.passwordInput.value.trim();
        const rememberMe = this.elements.rememberMe.checked;
  
        if (!username || !password) {
          alert('Please enter both username and password');
          return;
        }
  
        console.log('Login attempted:', { username, password, rememberMe });
  
        if (rememberMe) {
          localStorage.setItem('rememberedUser', username);
        } else {
          localStorage.removeItem('rememberedUser');
        }
  
        alert('Login successful! Redirecting...');
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
  
      handleForgotPassword: function() {
        const email = prompt('Enter your email for password reset:');
        if (email) {
          console.log('Password reset requested for:', email);
          alert(`Password reset instructions sent to ${email}`);
        }
      },
  
      checkRememberedUser: function() {
        const rememberedUser = localStorage.getItem('rememberedUser');
        if (rememberedUser) {
          this.elements.usernameInput.value = rememberedUser;
          this.elements.rememberMe.checked = true;
        }
      }
    };
  
    loginApp.init();
  });