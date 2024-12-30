const form = document.getElementById('contact-form');

const errorViewer = document.getElementById('error-viewer');
const errorMessage = document.getElementById('error-message');

const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const messageInput = document.getElementById('message');

const submitButton = document.getElementById('submit-button');

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

form.addEventListener("submit", async (event) => {
    event.preventDefault();

    submitButton.disabled = true;
    submitButton.classList.add('cursor-not-allowed', 'opacity-50');
    submitButton.innerText = 'Sending...';

    errorViewer.classList.add('hidden');

    const formData = new FormData();
    formData.append('name', nameInput.value);
    formData.append('email', emailInput.value);
    formData.append('message', messageInput.value);

    try {
        const response = await fetch('../send_message.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            nameInput.value = '';
            emailInput.value = '';
            messageInput.value = '';
            showToast('Your message was sent successfully', 'success');
        } else {
            errorViewer.classList.remove('hidden');
            errorMessage.innerText = data.message;
            showToast('Failed to send message. Please try again.', 'error');
        }
    } catch (error) {
        errorViewer.classList.remove('hidden');
        errorMessage.innerText = 'An unexpected error occurred. Please try again.';
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.classList.remove('cursor-not-allowed', 'opacity-50');
        submitButton.innerText = 'Send Message';
    }
});
