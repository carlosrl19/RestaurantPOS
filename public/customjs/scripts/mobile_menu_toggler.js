document.getElementById('open-menu').addEventListener('click', function () {
    document.getElementById('mobile-menu').classList.add('show');
});

document.getElementById('close-menu').addEventListener('click', function () {
    document.getElementById('mobile-menu').classList.remove('show');
});