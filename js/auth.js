
function loginCheck() {
    var email = document.getElementById("loginEmail").value.trim();
    var password = document.getElementById("loginPassword").value;
    var message = document.getElementById("loginMessage");

    message.style.color = "red";

    if (email == "" || password == "") {
        message.textContent = "Please fill in all fields.";
    }
    else if (!email.includes("@")) {
        message.textContent = "Enter a valid email.";
    }
    else {
        message.textContent = "All fields are valid.";
        message.style.color = "green";
    }

    return false;
}

function registerCheck() {
    var name = document.getElementById("fullName").value.trim();
    var email = document.getElementById("registerEmail").value.trim();
    var password = document.getElementById("registerPassword").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var message = document.getElementById("registerMessage");

    message.style.color = "red";

    if (name == "" || email == "" || password == "" || confirmPassword == "") {
        message.textContent = "Please fill in all fields.";
    }
    else if (!email.includes("@")) {
        message.textContent = "Enter a valid email.";
    }
    else if (password.length < 8) {
        message.textContent = "Password must have at least 8 characters.";
    }
    else if (password != confirmPassword) {
        message.textContent = "Passwords do not match.";
    }
    else {
        message.textContent = "All fields are valid.";
        message.style.color = "green";
    }

    return false;
}
