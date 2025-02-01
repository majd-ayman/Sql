<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("INSERT INTO Employees (Name, Address, Salary) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $address, $salary);

    if ($stmt->execute()) {
        echo "Employee added successfully!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
</head>
<body>
    <h1>Add New Employee</h1>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br>
        <label>Address:</label><br>
        <textarea name="address" required></textarea><br>
        <label>Salary:</label><br>
        <input type="number" name="salary" step="0.01" required><br><br>
        <button type="submit">Add Employee</button>
    </form>
</body>
</html>
