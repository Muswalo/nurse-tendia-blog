const newsLetterForm = document.getElementById('newsLetter-form');
const newsLetterEmailInput = document.getElementById('newsLetter-email');
const newsLetterSubmitButton = document.getElementById('newsLetter-submit');
const newsLetterNameInput = document.getElementById('newsLetter-name');
const newsLetterPopUp = document.getElementById('newsletter-popup');

newsLetterForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    newsLetterSubmitButton.disabled = true;
    newsLetterSubmitButton.classList.add('cursor-not-allowed', 'opacity-50');
    newsLetterSubmitButton.innerText = 'Submitting...';

    const email = newsLetterEmailInput.value;
    const name = newsLetterNameInput.value;

    try {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('name', name);

        const response = await fetch('../subscribe.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'An error occurred');
        }

        showToast(data.message)
        newsLetterPopUp.classList.add ('hidden')
    } catch (error) {

        showToast(error, "error")
    } finally {
        newsLetterSubmitButton.disabled = false;
        newsLetterSubmitButton.classList.remove('cursor-not-allowed', 'opacity-50');
        newsLetterSubmitButton.innerText = 'Subscribe';
    }
});

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
