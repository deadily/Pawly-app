// resources/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.getElementById('open-login-modal');
    const overlay = document.getElementById('modal-overlay');
    const modalLogin = document.getElementById('modal-login');
    const modalRegister = document.getElementById('modal-register');

    // Открытие модалки Входа
    if (loginBtn) {
        loginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal('login');
        });
    }

    // Функции управления (если они еще не объявлены глобально)
    window.openModal = function(type) {
        overlay.style.display = 'block';
        if (type === 'login') {
            modalLogin.style.display = 'flex';
            modalRegister.style.display = 'none';
        } else {
            modalLogin.style.display = 'none';
            modalRegister.style.display = 'flex';
        }
    };

    window.closeModals = function() {
        overlay.style.display = 'none';
        modalLogin.style.display = 'none';
        modalRegister.style.display = 'none';
    };

    window.switchModal = function(type) {
        openModal(type);
    };

    // Закрытие по клику на фон
    overlay.addEventListener('click', closeModals);
});