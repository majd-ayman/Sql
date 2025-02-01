<?php
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM Employees WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    $sql = "UPDATE Employees SET Name = '$name', Address = '$address', Salary = $salary WHERE id = $id";
    if ($conn->query($sql)) {
        echo "Employee updated successfully!";
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Employee</title>
</head>
<body>
    <h1>Update Employee</h1>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= $row['Name'] ?>" required><br>
        <label>Address:</label><br>
        <textarea name="address" required><?= $row['Address'] ?></textarea><br>
        <label>Salary:</label><br>
        <input type="number" name="salary" value="<?= $row['Salary'] ?>" step="0.01" required><br><br>
        <button type="submit">Update Employee</button>
    </form>
</body>
</html>
