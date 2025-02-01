<?php
include('config.php'); 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];



    $sql = "SELECT * FROM Employees WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "<p class='error'>No employee found with this ID.</p>";
        exit(); 
    }
} else {
    echo "<p class='error'>Invalid request.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 50%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0px 0px 10px gray;
            border-radius: 8px;
        }
        h1 {
            color: #333;
        }
        .info {
            text-align: left;
            margin: 20px 0;
            font-size: 18px;
        }
        .info p {
            margin: 10px 0;
        }
        .back-btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Employee Details</h1>

    <div class="info">
        <p><strong>ID:</strong> <?php echo $employee['id']; ?></p>
        <p><strong>Name:</strong> <?php echo $employee['name']; ?></p>
        <p><strong>Address:</strong> <?php echo $employee['address']; ?></p>
        <p><strong>Salary:</strong> <?php echo $employee['salary']; ?></p>
        <p><strong>Off Days:</strong> <?php echo $employee['off_days']; ?></p>
    </div>

    <a href="index.php" class="back-btn">Back to Employees List</a>
</div>

</body>
</html>
