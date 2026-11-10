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

$user_id = $_SESSION["user_id"];
$group_id = (int) ($_POST["group_id"] ?? 0);

if ($group_id <= 0) {
    die("Invalid group.");
}

$check = $conn->prepare(
    "SELECT id FROM study_groups WHERE id = ?"
);
$check->bind_param("i", $group_id);
$check->execute();

if ($check->get_result()->num_rows == 0) {
    die("Group not found.");
}
$check->close();

$check = $conn->prepare(
    "SELECT id FROM group_members WHERE group_id = ? AND user_id = ?"
);
$check->bind_param("ii", $group_id, $user_id);
$check->execute();

if ($check->get_result()->num_rows == 0) {
    $sql = "INSERT INTO group_members (group_id, user_id)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $group_id, $user_id);
    $stmt->execute();
}

$check->close();

header("Location: ../groups.php");
exit();
?>