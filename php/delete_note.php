<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") != "admin") {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../admin.php");
    exit();
}

$id = (int)($_POST["id"] ?? 0);

if ($id <= 0) {
    die("Invalid note.");
}

$stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../admin.php");
exit();
?>
