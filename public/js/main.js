document.addEventListener('DOMContentLoaded', function() {
    // AJAX Delete Post
    const deleteBtn = document.getElementById('delete-post-btn');

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this post?')) {
                const postId = this.dataset.id;
                const urlRoot = this.dataset.urlroot;
                const url = `${urlRoot}/posts/delete/${postId}`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = `${urlRoot}/posts`;
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while trying to delete the post.');
                });
            }
        });
    }

    // Inactivity Logout Timer
    if (typeof IS_LOGGED_IN !== 'undefined' && IS_LOGGED_IN) {
        let inactivityTimer;
        const logoutTime = 1200000; // 20 minutes in milliseconds

        function resetTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(logout, logoutTime);
        }

        function logout() {
            window.location.href = `${URLROOT}/users/logout`;
        }

        // Events that reset the timer
        window.addEventListener('mousemove', resetTimer, false);
        window.addEventListener('mousedown', resetTimer, false);
        window.addEventListener('keypress', resetTimer, false);
        window.addEventListener('touchmove', resetTimer, false);
        window.addEventListener('scroll', resetTimer, false);

        // Start the timer
        resetTimer();
    }
});
