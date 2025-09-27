(function() {
    const checkbox = document.getElementById('show_pwd');
    const pwd1 = document.getElementById('password');
    const pwd2 = document.getElementById('password_confirm');

    checkbox.addEventListener('change', () => {
        const type = checkbox.checked ? 'text' : 'password';
        pwd1.type = type;
        pwd2.type = type;
    });
})();