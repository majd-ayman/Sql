<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('database.php');

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $firstName = trim($_POST['firstName']);
    $middleName = trim($_POST['middleName']);
    $lastName = trim($_POST['lastName']);
    $familyName = trim($_POST['familyName']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $role = 'User';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "❌ البريد الإلكتروني غير صالح.";
    }

    if (strlen($mobile) != 10 || !ctype_digit($mobile)) {
        $errors['mobile'] = "❌ يجب أن يكون رقم الهاتف 10 أرقام فقط.";
    }

    if (empty($firstName) || empty($middleName) || empty($lastName) || empty($familyName)) {
        $errors['fullName'] = "❌ يجب إدخال جميع أقسام الاسم.";
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $errors['password'] = "❌ يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل، وحرف كبير، وحرف صغير، ورقم، ورمز خاص.";
    }

    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "❌ كلمتا المرور غير متطابقتين.";
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors['email'] = "❌ هذا البريد الإلكتروني مسجل مسبقًا.";
    }
    $stmt->close();

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (email, mobile, first_name, middle_name, last_name, family_name, password, role) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $email, $mobile, $firstName, $middleName, $lastName, $familyName, $hashedPassword, $role);
        if ($stmt->execute()) {
            $successMessage = "✅ تم التسجيل بنجاح! سيتم توجيهك إلى صفحة تسجيل الدخول.";
            header("refresh:3;url=login.php");
        } else {
            $errors['database'] = "❌ حدث خطأ أثناء التسجيل.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
                background-color: white;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
                text-align: center;
                margin-top: 20rem;
            }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #DC3545;
            color: black;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #a71d2a;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            text-align: left;
        }

        .signup-text {
            margin-top: 20px;
        }

        .error-message {
            color: red;
            font-size: 1rem;
            margin-top: 10px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }


        .home-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            font-size: 18px;
            font-weight: bold;
            color: black;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            border: none;
            border-radius: 30px;
            text-decoration: none;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 15px rgba(255, 75, 43, 0.3);
        }

        .home-button::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
        }

        .home-button:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .home-button:hover {
            box-shadow: 0 4px 20px rgba(255, 75, 43, 0.6);
            transform: scale(1.05);
        }

        .home-button i {
            margin-right: 8px;
            font-size: 20px;
        }
    </style>
</head>
<body>


 <header>
       
        <a href="hellow.php" class="home-button">
            <i class="fas fa-home"></i> Home
        </a>
    </header>
<div class="container">
    <h2>تسجيل حساب جديد</h2>

    <?php if (!empty($successMessage)): ?>
        <p class="success"><?= $successMessage; ?></p>
    <?php endif; ?>

            
    <form method="POST" style="direction: rtl;">
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <div class="error"><?= $errors['email'] ?? ''; ?></div>

        <input type="text" name="mobile" placeholder="رقم الهاتف" required>
        <div class="error"><?= $errors['mobile'] ?? ''; ?></div>

        <input type="text" name="firstName" placeholder="الاسم الأول" required>
        <input type="text" name="middleName" placeholder="الاسم الأوسط" required>
        <input type="text" name="lastName" placeholder="اسم العائلة" required>
        <input type="text" name="familyName" placeholder="اسم العائلة" required>
        <div class="error"><?= $errors['fullName'] ?? ''; ?></div>

        <input type="password" name="password" placeholder="كلمة المرور" required>
        <div class="error"><?= $errors['password'] ?? ''; ?></div>

        <input type="password" name="confirmPassword" placeholder="تأكيد كلمة المرور" required>
        <div class="error"><?= $errors['confirmPassword'] ?? ''; ?></div>

        <button type="submit">تسجيل</button>
    </form>
    <style>
.signup-text {
            text-align: center;
            color: #333;
            font-size: 18px;
        }


        .login-button {
            display: inline-block;
            margin-top: 10px;
            padding: 12px 25px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            border: none;
            border-radius: 30px;
            text-decoration: none;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 15px rgba(255, 75, 43, 0.3);
        }

        .login-button::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
        }

        .login-button:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .login-button:hover {
            box-shadow: 0 4px 20px rgba(255, 75, 43, 0.6);
            transform: scale(1.05);
        }


        .floating {
            animation: floatUpDown 2s infinite alternate ease-in-out;
        }

        @keyframes floatUpDown {
            0% { transform: translateY(0); }
            100% { transform: translateY(-8px); }
        }
</style>
<div class="signup-text">
        <p>Already have an account?</p>
        <a href="login.php" class="login-button floating">Login</a>
    </div>
</div>

</body>
</html>
