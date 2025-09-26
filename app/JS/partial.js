document.addEventListener('DOMContentLoaded', function () {
    const burger   = document.getElementById('burger');
    const navLinks = document.querySelector('header nav ul');

    if (!burger || !navLinks) return;

    burger.addEventListener('click', () => {
        const open = burger.classList.toggle('active');
        navLinks.classList.toggle('active', open);
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
});