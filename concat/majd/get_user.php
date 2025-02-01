<?php
session_start();
include('database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $userId = intval($_POST['id']);

    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(["success" => true, "user" => $user]);
    } else {
        echo json_encode(["success" => false, "message" => "المستخدم غير موجود"]);
    }

    $stmt->close();
    $conn->close();
}
?>
