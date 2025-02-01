<?php
include('config.php');

$sql = "SELECT * FROM Employees";
$result = $conn->query($sql);

$resultStats = $conn->query("SELECT MAX(salary) AS highest_salary, MIN(salary) AS lowest_salary, COUNT(id) AS employee_count, SUM(salary) AS total_salary FROM Employees");
$stats = $resultStats->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h3 {
            color: #555;
        }

        a, button {
            text-decoration: none;
            background-color: rgb(155, 235, 239);
            color: black;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            display: inline-block;
            transition: 0.3s;
        }

        a:hover, button:hover {
            background-color: #0056b3;
            color: white;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 8px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            cursor: pointer;
        }

        /* تصميم الكروت */
        .stats-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 20px;
            font-weight: bold;
            color: #0056b3;
        }

        /* جدول الموظفين */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: rgb(222, 104, 198);
            color: black;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #ddd;
        }

        /* أزرار الزيادة والنقصان */
        .btn-increase {
            background-color: #28a745; /* أخضر للزيادة */
            color: white;
        }

        .btn-decrease {
            background-color: #dc3545; /* أحمر للنقصان */
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Management</h1>
        <a href="create.php">Add New Employee</a>

        <!-- الإحصائيات داخل الكروت -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Highest Salary</h3>
                <p><?php echo $stats['highest_salary']; ?></p>
            </div>

            <div class="stat-card">
                <h3>Lowest Salary</h3>
                <p><?php echo $stats['lowest_salary']; ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Employees</h3>
                <p><?php echo $stats['employee_count']; ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Salary</h3>
                <p><?php echo $stats['total_salary']; ?></p>
            </div>
        </div>

        <!-- نموذج البحث عن الموظف -->
        <form method="GET">
            <input type="text" name="search_id" placeholder="Search by ID">
            <button type="submit">Search</button>
        </form>

        <!-- جدول عرض الموظفين -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Salary</th>
                <th>Off Days</th>
                <th>Actions</th>
            </tr>
            <?php
            // تعديل جملة الاستعلام إذا تم البحث
            if (isset($_GET['search_id']) && !empty($_GET['search_id'])) {
                $searchId = (int)$_GET['search_id'];
                $sql = "SELECT * FROM Employees WHERE id = $searchId";
            }
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['salary']}</td>
                        <td>{$row['off_days']}</td>
                        <td>
                            <a href='read.php?id={$row['id']}'>View</a> 
                            <a href='update.php?id={$row['id']}'>Edit</a> 
                            <a href='delete.php?id={$row['id']}' onclick=\"return confirm('Are you sure?');\">Delete</a>
                            <!-- أزرار تعديل الراتب -->
                            <a class='btn-increase' href='increase_salary.php?id={$row['id']}'>Increase</a>
                            <a class='btn-decrease' href='decrease_salary.php?id={$row['id']}'>Decrease</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
