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
    die("Invalid group.");
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("DELETE FROM group_members WHERE group_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM study_groups WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    die("Could not delete group.");
}

header("Location: ../admin.php");
exit();
?>
