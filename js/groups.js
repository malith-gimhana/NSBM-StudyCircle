function joinGroup(button) {
    return confirm("Do you want to join this group?");
}

function addGroup() {
    var name = document.getElementById("groupName").value.trim();
    var subject = document.getElementById("groupSubject").value;
    var description = document.getElementById("groupDescription").value.trim();
    var message = document.getElementById("groupMessage");

    if (name == "" ||  subject == "" ||  description == "") {
        message.textContent = "Please fill in all fields.";
        message.style.color = "red";
        return false;
    }

    return true;
}

function joinSession(button) {
    alert("Session details are shown above.");
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

    return true;
}