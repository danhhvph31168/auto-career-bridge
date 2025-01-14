document.querySelectorAll(".auth-pass-inputgroup .password-addon").forEach(function (toggleButton) {
    toggleButton.addEventListener("click", function () {
        const passwordInput = this.closest(".auth-pass-inputgroup").querySelector(".password-input");
        const icon = this.querySelector("i");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    });
});
