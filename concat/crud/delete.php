
<?php
require 'config.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM Employees WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
