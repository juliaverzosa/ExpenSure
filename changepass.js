// changepass.js

document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("change-password-modal");
    var btn = document.getElementById("change-password-btn");
    var span = document.getElementsByClassName("close-btn")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

