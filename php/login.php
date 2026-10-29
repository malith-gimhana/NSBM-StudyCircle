<?php
session_start();
include "db.php";

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($email == "" || $password == "") {
    die("Please fill in all fields.");
}

$sql = "SELECT id, password, role FROM users WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] == "admin") {
            header("Location: ../admin.php");
        } else {
            header("Location: ../dashboard.html");
        }

        exit();
    }
}

echo "Invalid email or password.";

$stmt->close();
$conn->close();
?>