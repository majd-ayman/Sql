<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

include('database.php');

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    if (is_numeric($userId)) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            header("Location: admin_dashboard.php?message=UserDeleted");
            exit();
        } else {
            header("Location: admin_dashboard.php?message=ErrorDeletingUser");
            exit();
        }
    } else {
        header("Location: admin_dashboard.php?message=InvalidId");
        exit();
    }
} else {
    header("Location: admin_dashboard.php?message=NoIdProvided");
    exit();
}
?>
