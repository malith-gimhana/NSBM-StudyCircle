<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../groups.php");
    exit();
}

$name = trim($_POST["group_name"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$description = trim($_POST["description"] ?? "");

if ($name == "" || $subject == "" || $description == "") {
    die("Please fill in all fields.");
}

$sql = "INSERT INTO study_groups (group_name, subject, description)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $subject, $description);

if ($stmt->execute()) {
    header("Location: ../groups.php");
    exit();
}

echo "Could not create group.";
?>