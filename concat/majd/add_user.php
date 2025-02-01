<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($_POST['password'])) {
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

        if ($stmt->execute()) {
            header("Location: admin_dashboard.php?message=UserAdded");
            exit();
        } else {
            header("Location: admin_dashboard.php?message=ErrorAddingUser");
            exit();
        }
    } else {
        header("Location: admin_dashboard.php?message=MissingFields");
        exit();
    }
}
?>
