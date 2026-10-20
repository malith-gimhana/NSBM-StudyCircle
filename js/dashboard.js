
function searchNotes() {
    var search = document.getElementById("searchNotes").value.toLowerCase().trim();
    var cards = document.querySelectorAll(".note-card");
    var found = 0;

    for (var i = 0; i < cards.length; i++) {
        var text = cards[i].textContent.toLowerCase();

        if (text.includes(search)) {
            cards[i].style.display = "block";
            found++;
        }
        else {
            cards[i].style.display = "none";
        }
    }

    if (found == 0) {
        document.getElementById("noResults").hidden = false;
    }
    else {
        document.getElementById("noResults").hidden = true;
    }
}


function uploadCheck() {
    var title = document.getElementById("noteTitle").value.trim();
    var subject = document.getElementById("subject").value;
    var description = document.getElementById("description").value.trim();
    var file = document.getElementById("noteFile").value;
    var message = document.getElementById("uploadMessage");

    message.style.color = "red";

    if (title == "" || subject == "" || description == "" || file == "") {
        message.textContent = "Please fill in all fields.";
    }
    else {
        message.textContent = "All fields are valid.";
        message.style.color = "green";
    }

    return false;
}

