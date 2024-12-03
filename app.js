
const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
});

// Check for sign-up error and set the sign-up mode
window.addEventListener("DOMContentLoaded", () => {
    const signupError = document.querySelector("#signup-error");
    if (signupError) {
        container.classList.add("sign-up-mode");
    }
});
