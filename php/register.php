<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../register.html");
    exit();
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";

if ($name == "" || $email == "" || $password == "") {
    die("Please fill in all fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

if ($password != $confirmPassword) {
    die("Passwords do not match.");
}

if (strlen($password) < 8) {
    die("Password must have at least 8 characters.");
}

// Check if email already exists
$sql = "SELECT id FROM users WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Email already registered.");
}

$stmt->close();

// Save new student
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, role)
        VALUES (?, ?, ?, 'student')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $hashedPassword);

if ($stmt->execute()) {
    header("Location: ../login.html");
    exit();
} else {
    echo "Registration failed.";
}

$stmt->close();
$conn->close();
?>