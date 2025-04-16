document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const rememberMeCheckbox = document.getElementById('rememberMe');
    const forgotPasswordLink = document.getElementById('forgotPassword');
    const forgotPasswordModal = document.getElementById('forgotPasswordModal');
    const resetPasswordForm = document.getElementById('resetPasswordForm');
    const closeModalBtn = document.querySelector('.close-modal');
    
    // Check if there are saved credentials
    checkSavedCredentials();
    
    // Toggle Password Visibility
    togglePasswordBtn.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Update button text and icon
        if (type === 'text') {
            togglePasswordBtn.innerHTML = '<span class="material-symbols-outlined">visibility</span> Show';
        } else {
            togglePasswordBtn.innerHTML = '<span class="material-symbols-outlined">visibility_off</span> Hide';
        }
    });
    
    // Login Form Submit
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = usernameInput.value;
        const password = passwordInput.value;
        const rememberMe = rememberMeCheckbox.checked;
        
        // Save credentials if "Remember Me" is checked
        if (rememberMe) {
            localStorage.setItem('savedUsername', username);
            // In a real application, you would NOT store passwords in localStorage
            // This is just for demonstration purposes
            localStorage.setItem('savedPassword', password);
            localStorage.setItem('rememberMe', 'true');
        } else {
            // Clear saved credentials
            localStorage.removeItem('savedUsername');
            localStorage.removeItem('savedPassword');
            localStorage.removeItem('rememberMe');
        }
        
        // Simulate login (in a real app, you would send this to a server)
        simulateLogin(username, password);
    });
    
    // Forgot Password Link
    forgotPasswordLink.addEventListener('click', function(e) {
        e.preventDefault();
        forgotPasswordModal.style.display = 'flex';
    });
    
    // Close Modal
    closeModalBtn.addEventListener('click', function() {
        forgotPasswordModal.style.display = 'none';
    });
    
    // Close Modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === forgotPasswordModal) {
            forgotPasswordModal.style.display = 'none';
        }
    });
    
    // Reset Password Form Submit
    resetPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        
        // Simulate sending reset email (in a real app, you would send this to a server)
        alert(`Password reset link has been sent to ${email}`);
        forgotPasswordModal.style.display = 'none';
        resetPasswordForm.reset();
    });
    
    // Check for saved credentials
    function checkSavedCredentials() {
        const savedUsername = localStorage.getItem('savedUsername');
        const savedPassword = localStorage.getItem('savedPassword');
        const savedRememberMe = localStorage.getItem('rememberMe');
        
        if (savedUsername && savedPassword && savedRememberMe === 'true') {
            usernameInput.value = savedUsername;
            passwordInput.value = savedPassword;
            rememberMeCheckbox.checked = true;
        }
    }
    
    // Simulate login (in a real app, this would be an API call)
    function simulateLogin(username, password) {
        // For demonstration purposes only
        console.log('Login attempt:', { username, password });
        alert(`Login successful! Welcome, ${username}!`);
        
        // In a real application, you would redirect to a dashboard or home page
        // window.location.href = 'dashboard.html';
    }
});