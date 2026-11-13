
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
    die("Invalid student.");
}

$conn->begin_transaction();

try {
    // Delete student's answers
    $stmt = $conn->prepare("DELETE FROM answers WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete answers to student's questions
    $stmt = $conn->prepare(
        "DELETE FROM answers WHERE question_id IN
        (SELECT id FROM questions WHERE user_id = ?)"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete student's questions
    $stmt = $conn->prepare("DELETE FROM questions WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete student's notes
    $stmt = $conn->prepare("DELETE FROM notes WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete group memberships
    $stmt = $conn->prepare("DELETE FROM group_members WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete student
    $stmt = $conn->prepare(
        "DELETE FROM users WHERE id = ? AND role = 'student'"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    die("Could not delete student.");
}

header("Location: ../admin.php");
exit();
?>
