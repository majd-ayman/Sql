<?php
include ('config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];
    $off_days = $_POST['off_days'];

    if (!empty($name) && !empty($address) && !empty($salary) && !empty($off_days)) {
        $sql = "INSERT INTO Employees (name, address, salary, off_days) 
                VALUES ('$name', '$address', '$salary', '$off_days')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); 
            exit();
        } else {
            $message = "<p class='error'>Error: " . $conn->error . "</p>";
        }
    } else {
        $message = "<p class='error'>Please fill in all fields!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            text-align: center;

        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3; 
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Employee</h1> 

    <?php if (isset($message)) echo $message; ?>

    <form action="create.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        
        <label>Address:</label>
        <input type="text" name="address" required>
        
        <label>Salary:</label>
        <input type="number" name="salary" required>
        
        <label>Off Days:</label>
        <input type="number" name="off_days" required>

        <button type="submit">Add Employee</button> 
    </form>
</div>

</body>
</html>
