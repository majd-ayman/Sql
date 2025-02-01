<?php
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM Employees WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Employee</title>
</head>
<body>
    <h1>Employee Details</h1>
    <p><strong>ID:</strong> <?= $row['id'] ?></p>
    <p><strong>Name:</strong> <?= $row['Name'] ?></p>
    <p><strong>Address:</strong> <?= $row['Address'] ?></p>
    <p><strong>Salary:</strong> <?= $row['Salary'] ?></p>
    <a href="index.php">Back</a>
</body>
</html>
