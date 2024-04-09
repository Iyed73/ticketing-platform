
document.addEventListener('DOMContentLoaded', function() {
    const notif = document.querySelector('.notBtn');
    const box = document.querySelector('.notifBox');
	const btn = document.querySelector('.notification_icon');

    btn.addEventListener('click', function() {
        notif.classList.toggle('active');
        box.classList.toggle('active');
    });
});
