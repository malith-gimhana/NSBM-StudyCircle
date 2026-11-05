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
$question_id = (int) ($_POST["question_id"] ?? 0);
$answer = trim($_POST["answer"] ?? "");

if ($question_id <= 0 || $answer == "") {
    die("Please enter an answer.");
}

$check = $conn->prepare("SELECT id FROM questions WHERE id = ?");
$check->bind_param("i", $question_id);
$check->execute();

if ($check->get_result()->num_rows == 0) {
    die("Question not found.");
}

$sql = "INSERT INTO answers (question_id, user_id, answer)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $question_id, $user_id, $answer);

if ($stmt->execute()) {
    header("Location: ../questions.php");
    exit();
} else {
    echo "Answer could not be posted.";
}
?>