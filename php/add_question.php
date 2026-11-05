<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../questions.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$title = trim($_POST["title"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$question = trim($_POST["question"] ?? "");

if ($title == "" || $subject == "" || $question == "") {
    die("Please fill in all fields.");
}

if (strlen($title) > 200 || strlen($subject) > 100) {
    die("Title or subject is too long.");
}

$sql = "INSERT INTO questions (user_id, title, subject, question)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $title, $subject, $question);

if ($stmt->execute()) {
    header("Location: ../questions.php");
    exit();
} else {
    echo "Question could not be posted.";
}
?>