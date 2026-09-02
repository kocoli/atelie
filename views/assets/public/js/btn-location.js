const btnLogin = document.querySelector('#link-login');
const btnRegister = document.querySelector('#link-register');
const btnAbout = document.querySelector('#link-about');

if (btnLogin) {
    btnLogin.addEventListener('click', () => {
        window.location.href = 'http://localhost/atelie/views/public/login.php';
    });
}

if (btnRegister) {
    btnRegister.addEventListener('click', () => {
        window.location.href = 'http://localhost/atelie/views/public/register.php';
    });
}

if (btnAbout) {
    btnAbout.addEventListener('click', () => {
        window.location.href = 'http://localhost/atelie/views/public/about.php';
    });
}