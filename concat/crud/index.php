<?php
include 'config.php';

$sql = "SELECT * FROM Employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employees Management</title>
</head>
<body>
    <h1>Employees List</h1>
    <a href="create.php">Add New Employee</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Salary</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Address'] ?></td>
                <td><?= $row['Salary'] ?></td>
                <td>
                    <a href="read.php?id=<?= $row['id'] ?>">View</a> |
                    <a href="update.php?id=<?= $row['id'] ?>">Update</a> |
                    <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
