// Member 5 - Simple frontend functions

function joinGroup(button) {
    button.textContent = "Joined";
    button.disabled = true;
}

function addGroup() {
    var name = document.getElementById("groupName").value.trim();
    var subject = document.getElementById("groupSubject").value;
    var description = document.getElementById("groupDescription").value.trim();
    var message = document.getElementById("groupMessage");

    if (name == "" || subject == "" || description == "") {
        message.textContent = "Please fill in all fields.";
        message.style.color = "red";
        return false;
    }

    var card = document.createElement("div");
    card.className = "group-card";

    var heading = document.createElement("h3");
    heading.textContent = name;

    var subjectText = document.createElement("p");
    subjectText.textContent = "Subject: " + subject;

    var details = document.createElement("p");
    details.textContent = description;

    var button = document.createElement("button");
    button.className = "green-btn";
    button.textContent = "Join Group";
    button.onclick = function() {
        joinGroup(button);
    };

    card.appendChild(heading);
    card.appendChild(subjectText);
    card.appendChild(details);
    card.appendChild(button);
    document.getElementById("groupList").appendChild(card);

    message.textContent = "Group added to this page.";
    message.style.color = "green";
    return false;
}

function joinSession(button) {
    button.textContent = "Joined";
    button.disabled = true;
}

function addSession() {
    var title = document.getElementById("sessionTitle").value.trim();
    var date = document.getElementById("sessionDate").value;
    var time = document.getElementById("sessionTime").value;
    var place = document.getElementById("sessionPlace").value.trim();
    var message = document.getElementById("sessionMessage");

    if (title == "" || date == "" || time == "" || place == "") {
        message.textContent = "Please fill in all fields.";
        message.style.color = "red";
        return false;
    }

    var card = document.createElement("div");
    card.className = "group-card";

    var heading = document.createElement("h3");
    heading.textContent = title;

    var dateText = document.createElement("p");
    dateText.textContent = "Date: " + date + " at " + time;

    var placeText = document.createElement("p");
    placeText.textContent = "Location: " + place;

    var button = document.createElement("button");
    button.className = "green-btn";
    button.textContent = "Join Session";
    button.onclick = function() {
        joinSession(button);
    };

    card.appendChild(heading);
    card.appendChild(dateText);
    card.appendChild(placeText);
    card.appendChild(button);
    document.getElementById("sessionList").appendChild(card);

    message.textContent = "Session added to this page.";
    message.style.color = "green";
    return false;
}
