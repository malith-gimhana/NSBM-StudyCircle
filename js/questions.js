// Add a question to the page
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

    var card = document.createElement("div");
    card.className = "question-card";

    var subjectText = document.createElement("span");
    subjectText.className = "question-subject";
    subjectText.textContent = subject;

    var heading = document.createElement("h3");
    heading.textContent = title;

    var paragraph = document.createElement("p");
    paragraph.textContent = details;

    var answerArea = document.createElement("div");
    answerArea.className = "answer-area";
    answerArea.innerHTML = '<h4>Answers</h4><div class="answer-list"></div><input type="text" class="answer-input" placeholder="Write an answer"><button type="button" class="answer-btn" onclick="addAnswer(this)">Reply</button>';

    card.appendChild(subjectText);
    card.appendChild(heading);
    card.appendChild(paragraph);
    card.appendChild(answerArea);

    document.getElementById("questionList").prepend(card);
    document.getElementById("questionTitle").value = "";
    document.getElementById("questionSubject").value = "";
    document.getElementById("questionDetails").value = "";

    message.textContent = "Question added to this page.";
    message.style.color = "green";
    return false;
}

// Add an answer under a question
function addAnswer(button) {
    var area = button.parentElement;
    var input = area.querySelector(".answer-input");
    var answer = input.value.trim();

    if (answer == "") {
        alert("Please write an answer.");
        return;
    }

    var paragraph = document.createElement("p");
    paragraph.textContent = answer;
    area.querySelector(".answer-list").appendChild(paragraph);
    input.value = "";
}
