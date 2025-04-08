// File baru: public/js/notification-handler.js
const NotificationHandler = {
    play: function(sound) {
        if (!sound) {
            sound = document.getElementById('notificationSound');
        }
        
        if (sound) {
            sound.currentTime = 0;
            sound.play().catch(err => {
                console.error('Failed to play notification sound:', err);
            });
        }
    },
    
    initAudio: function() {
        // Memastikan audio terinisialisasi pada interaksi pengguna
        const sounds = document.querySelectorAll('audio');
        sounds.forEach(sound => {
            sound.load();
        });
        
        // Preload audio saat interaksi pengguna pertama
        document.addEventListener('click', function enableAudio() {
            sounds.forEach(sound => {
                sound.play().then(() => {
                    sound.pause();
                    sound.currentTime = 0;
                }).catch(err => {/* ignore */});
            });
            document.removeEventListener('click', enableAudio);
        }, { once: true });
    }
};

document.addEventListener('DOMContentLoaded', function() {
    NotificationHandler.initAudio();
});

window.NotificationHandler = NotificationHandler;