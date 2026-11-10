<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../sessions.php");
    exit();
}

$title = trim($_POST["title"] ?? "");
$date = $_POST["session_date"] ?? "";
$time = $_POST["session_time"] ?? "";
$location = trim($_POST["location"] ?? "");

if ($title == "" || $date == "" || $time == "" || $location == "") {
    die("Please fill in all fields.");
}

$sql = "INSERT INTO sessions (title, session_date, session_time, location)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $title, $date, $time, $location);

if ($stmt->execute()) {
    header("Location: ../sessions.php");
    exit();
}

echo "Could not add session.";
?>