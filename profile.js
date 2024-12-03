
    document.getElementById('profile-icon').onclick = function() {
        document.getElementById('profile-popup').style.display = 'block';
    };

    document.getElementById('close-btn').onclick = function() {
        document.getElementById('profile-popup').style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == document.getElementById('profile-popup')) {
            document.getElementById('profile-popup').style.display = 'none';
        }
    };

    document.addEventListener("DOMContentLoaded", function() {
        // Get references to DOM elements
        const profileImageInput = document.getElementById("profile-image-input");
        const profileImagePreview = document.getElementById("profile-image-preview");
    
        // Add event listener for file input change
        profileImageInput.addEventListener("change", function() {
            const file = profileImageInput.files[0]; // Get the selected file
    
            // Check if a file is selected
            if (file) {
                // Create a FileReader object to read the file
                const reader = new FileReader();
    
                // Set up a function to run when the FileReader finishes loading the file
                reader.onload = function(event) {
                    // Set the preview image's src attribute to the data URL of the loaded file
                    profileImagePreview.src = event.target.result;
                };
    
                // Read the selected file as a data URL
                reader.readAsDataURL(file);
            }
        });
    });
    
