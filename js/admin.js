// Remove a row from the admin table (frontend demo)
function removeRow(button, countId) {
    var answer = confirm("Do you want to remove this item?");

    if (answer == true) {
        var row = button.parentElement.parentElement;
        row.remove();

        var count = document.getElementById(countId);
        count.textContent = Number(count.textContent) - 1;

        document.getElementById("adminMessage").textContent = "Item removed from this page.";
    }
}
