// Selecting the necessary elements from the login form
const loginForm = document.querySelector('form');
const errorViewer = document.getElementById('error-viewer');
const errorMessage = document.getElementById('error-message');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const submitButton = document.querySelector('button[type="submit"]');

// Function to show a toast message
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.innerText = message;
    toast.className = `toast ${type}`;
    toast.style.position = 'fixed';
    toast.style.top = '20px'; 
    toast.style.right = '20px';
    toast.style.padding = '20px 40px';
    toast.style.borderRadius = '10px';
    toast.style.backgroundColor = type === 'success' ? '#4CAF50' : '#f44336';
    toast.style.color = '#fff';
    toast.style.fontSize = '18px';
    toast.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)';
    toast.style.zIndex = '1000';

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 10000); 
}

loginForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    submitButton.disabled = true;
    submitButton.classList.add('cursor-not-allowed', 'opacity-50');
    submitButton.innerText = 'Logging in...';

    const formData = new FormData();
    formData.append('username', usernameInput.value);
    formData.append('password', passwordInput.value);

    try {
        const response = await fetch('/admin/auth', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData
        });
        const data = await response.json();

        if (response.ok) {
            showToast('Login successful Redirecting...', 'success');
            window.location.href = '/admin/home';
        } else {
            errorViewer.classList.remove('hidden');
            errorMessage.innerText = data.message || 'Invalid username or password.';
            showToast('Login failed. Please check your credentials and try again.', 'error');
        }
    } catch (error) {
        errorViewer.classList.remove('hidden');
        errorMessage.innerText = 'An unexpected error occurred. Please try again.';
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.classList.remove('cursor-not-allowed', 'opacity-50');
        submitButton.innerText = 'Login';
    }
});
 