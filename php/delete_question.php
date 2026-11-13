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
    die("Invalid question.");
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("DELETE FROM answers WHERE question_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    die("Could not delete question.");
}

header("Location: ../admin.php");
exit();
?>
