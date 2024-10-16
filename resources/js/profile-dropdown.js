// resources/js/profile-dropdown.js

document.addEventListener('DOMContentLoaded', function() {
    // Profile Dropdown Elements
    const profileButton = document.getElementById('profile-button');
    const profileDropdown = document.getElementById('profile-dropdown');

    if (profileButton && profileDropdown) {
        // Function to toggle dropdown visibility
        const toggleDropdown = (event) => {
            event.stopPropagation(); // Prevent the event from bubbling up to the document
            profileDropdown.classList.toggle('hidden');
        };

        // Function to close dropdown
        const closeDropdown = () => {
            profileDropdown.classList.add('hidden');
        };

        // Event listener for profile button click
        profileButton.addEventListener('click', toggleDropdown);

        // Event listener for clicks outside the dropdown
        document.addEventListener('click', function(event) {
            const isClickInside = profileButton.contains(event.target) || profileDropdown.contains(event.target);
            if (!isClickInside) {
                closeDropdown();
            }
        });

        // Optional: Close dropdown when pressing the Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDropdown();
            }
        });
    }
});
