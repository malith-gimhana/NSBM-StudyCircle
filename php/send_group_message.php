
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

$userId = (int)$_SESSION["user_id"];
$groupId = (int)($_POST["group_id"] ?? 0);
$message = trim($_POST["message"] ?? "");
$token = $_POST["chat_token"] ?? "";

if (!hash_equals($_SESSION["chat_token"] ?? "", $token)) {
    die("Invalid request.");
}

if ($groupId <= 0 || $message == "" ||
    mb_strlen($message) > 1000) {
    die("Invalid message.");
}

// Check group membership
$stmt = $conn->prepare(
    "SELECT id FROM group_members
     WHERE group_id = ? AND user_id = ?"
);
$stmt->bind_param("ii", $groupId, $userId);
$stmt->execute();

if ($stmt->get_result()->num_rows == 0) {
    die("You are not a member of this group.");
}

// Save message
$stmt = $conn->prepare(
    "INSERT INTO group_messages (group_id, user_id, message)
     VALUES (?, ?, ?)"
);
$stmt->bind_param("iis", $groupId, $userId, $message);
$stmt->execute();

header("Location: ../group_chat.php?id=" . $groupId);
exit();
?>
