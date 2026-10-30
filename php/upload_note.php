
<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    die("Please login first.");
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Invalid request.");
}

$user_id = $_SESSION["user_id"];
$title = trim($_POST["title"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$description = trim($_POST["description"] ?? "");

if ($title == "" || $subject == "" || $description == "") {
    die("Please fill in all fields.");
}

if (strlen($title) > 150 || strlen($subject) > 100) {
    die("Title or subject is too long.");
}

if (!isset($_FILES["noteFile"])) {
    die("Please select a PDF file.");
}

$file = $_FILES["noteFile"];

if ($file["error"] != UPLOAD_ERR_OK) {
    die("File upload failed.");
}

if ($file["size"] > 5 * 1024 * 1024) {
    die("File must be less than 5MB.");
}


$finfo = new finfo(FILEINFO_MIME_TYPE);
$fileType = $finfo->file($file["tmp_name"]);

if ($fileType != "application/pdf") {
    die("Only PDF files are allowed.");
}


$folder = "../uploads/notes/";

if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}


$fileName = bin2hex(random_bytes(16)) . ".pdf";
$filePath = $folder . $fileName;

if (!move_uploaded_file($file["tmp_name"], $filePath)) {
    die("Could not save the file.");
}


$sql = "INSERT INTO notes
        (user_id, title, subject, description, file_name)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "issss",
    $user_id,
    $title,
    $subject,
    $description,
    $fileName
);

if ($stmt->execute()) {
    header("Location: ../notes.php");
    exit();
} else {
    unlink($filePath);
    echo "Could not save note details.";
}

$stmt->close();
$conn->close();
?>
