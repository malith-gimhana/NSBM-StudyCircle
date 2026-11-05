function addQuestion() {
    var title = document.getElementById("questionTitle").value.trim();
    var subject = document.getElementById("questionSubject").value;
    var details = document.getElementById("questionDetails").value.trim();
    var message = document.getElementById("questionMessage");

    if (title == "" || subject == "" || details == "") {
        message.textContent = "Please fill in all fields.";
        message.style.color = "red";
        return false;
    }

    return true;
}

function addAnswer(form) {
    var input = form.querySelector(".answer-input");
    var answer = input.value.trim();

    if (answer == "") {
        alert("Please write an answer.");
        return false;
    }

    return true;
}