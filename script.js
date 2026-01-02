// Dark mode toggle
document.addEventListener('DOMContentLoaded', () => {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
    }

    const themeBtn = document.querySelector('.theme-toggle');
    if (themeBtn) {
        themeBtn.textContent = isDarkMode ? '☀️ Light Mode' : '🌙 Dark Mode';
        themeBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isNowDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isNowDark);
            themeBtn.textContent = isNowDark ? '☀️ Light Mode' : '🌙 Dark Mode';
        });
    }
});

// Form submission confirmation
function confirmAdd() {
    return confirm('Add this task to your to-do list?');
}

function confirmDelete() {
    return confirm('Are you sure you want to delete this task?');
}

function confirmEdit() {
    return confirm('Save changes to this task?');
}

