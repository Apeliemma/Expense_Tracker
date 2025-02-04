const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('minimized');

            // Toggle the icon between "bars" and "arrow-right"
            if (sidebar.classList.contains('minimized')) {
                toggleIcon.classList.replace('fa-bars', 'fa-arrow-right');
            } else {
                toggleIcon.classList.replace('fa-arrow-right', 'fa-bars');
            }
        });