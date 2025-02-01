<?php
include('config.php'); // استدعاء ملف الاتصال بقاعدة البيانات

// التحقق من استلام ID الموظف عبر GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // جلب بيانات الموظف من قاعدة البيانات
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

// تحديث بيانات الموظف عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];
    $off_days = $_POST['off_days'];

    // التحقق من عدم ترك الحقول فارغة
    if (!empty($name) && !empty($address) && !empty($salary) && !empty($off_days)) {
        $updateQuery = "UPDATE Employees SET name='$name', address='$address', salary='$salary', off_days='$off_days' WHERE id=$id";

        if ($conn->query($updateQuery) === TRUE) {
            header("Location: index.php"); // إعادة التوجيه إلى الصفحة الرئيسية بعد التحديث
            exit();
        } else {
            $message = "<p class='error'>Error updating record: " . $conn->error . "</p>";
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
    <title>Update Employee</title>
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
    <h1>Update Employee</h1>

    <?php if (isset($message)) echo $message; ?>

    <form action="update.php?id=<?php echo $id; ?>" method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $employee['name']; ?>" required>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo $employee['address']; ?>" required>

        <label>Salary:</label>
        <input type="number" name="salary" value="<?php echo $employee['salary']; ?>" required>

        <label>Off Days:</label>
        <input type="number" name="off_days" value="<?php echo $employee['off_days']; ?>" required>

        <button type="submit">Update Employee</button>
    </form>
</div>

</body>
</html>
