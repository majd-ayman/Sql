<?php
include('config.php');

// تحديد نوع العملية (increase أو decrease) من الرابط
$action = isset($_GET['action']) ? $_GET['action'] : 'increase';

// معالجة النموذج عند الإرسال
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام القيم المرسلة من النموذج
    $action = isset($_POST['action']) ? $_POST['action'] : 'increase';
    $update_option = isset($_POST['update_option']) ? $_POST['update_option'] : 'all';
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

    // التأكد من صحة قيمة المبلغ
    if ($amount <= 0) {
        echo "Please enter a valid amount.";
        exit;
    }

    // بناء جملة SQL للتحديث بناءً على الخيار المحدد
    if ($update_option === "all") {
        if ($action === "increase") {
            $sql = "UPDATE Employees SET salary = salary + $amount";
        } else { // decrease
            $sql = "UPDATE Employees SET salary = salary - $amount";
        }
    } elseif ($update_option === "specific") {
        if (!isset($_POST['employee_id']) || empty($_POST['employee_id'])) {
            echo "Please provide an employee ID.";
            exit;
        }
        $employee_id = intval($_POST['employee_id']);

        if ($action === "increase") {
            $sql = "UPDATE Employees SET salary = salary + $amount WHERE id = $employee_id";
        } else { // decrease
            $sql = "UPDATE Employees SET salary = salary - $amount WHERE id = $employee_id";
        }
    } else {
        echo "Invalid update option.";
        exit;
    }

    // تنفيذ الاستعلام وإذا نجح يتم إعادة التوجيه إلى index.php
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Salary Options</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #003f8a;
        }
        /* إخفاء حقل رقم الموظف في البداية */
        #employee_id_div {
            display: none;
        }
    </style>
    <script>
        function toggleEmployeeId() {
            var option = document.querySelector('input[name="update_option"]:checked').value;
            var employeeIdDiv = document.getElementById('employee_id_div');
            if (option === "specific") {
                employeeIdDiv.style.display = "block";
            } else {
                employeeIdDiv.style.display = "none";
            }
        }
        window.onload = function() {
            toggleEmployeeId();
            var radios = document.getElementsByName("update_option");
            for (var i = 0; i < radios.length; i++){
                radios[i].addEventListener('change', toggleEmployeeId);
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Update Salary (<?php echo ucfirst($action); ?>)</h2>
        <form action="update_salary_options.php?action=<?php echo $action; ?>" method="POST">
            <!-- تمرير نوع العملية للخلفية -->
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <p>You have two options:</p>
            <label>
                <input type="radio" name="update_option" value="all" checked> Update for all employees.
            </label>
            <label>
                <input type="radio" name="update_option" value="specific"> Update for a specific employee.
            </label>
            <div id="employee_id_div">
                <label for="employee_id">Employee ID:</label>
                <input type="text" name="employee_id" id="employee_id" placeholder="Enter Employee ID">
            </div>
            <label for="amount">Amount to <?php echo $action; ?>:</label>
            <input type="number" name="amount" id="amount" placeholder="Enter amount" required>
            <button type="submit">Update Salary</button>
        </form>
    </div>
</body>
</html>
