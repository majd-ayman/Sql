<?php
include('database.php');

session_start();
$errorEmail = $errorPassword = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = "Please enter a valid email address.";
    }

    if (strlen($password) < 8) {
        $errorPassword = "Password must be at least 8 characters long.";
    }

    if (empty($errorEmail) && empty($errorPassword)) {
        $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); 

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] === 'Admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: welcome.php");
                }
                exit;
            } else {
                $errorPassword = "Invalid email or password.";
            }
        } else {
            $errorEmail = "No user found with that email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #777;
            margin-bottom: 20px;
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

        label {
            display: block;
            text-align: left;
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
            text-align: left;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: black;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .signup-text {
            margin-top: 15px;
            color: #555;
        }

        .signup-text a {
            color: #007BFF;
            text-decoration: none;
        }

        .signup-text a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            text-align: left;
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

.logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ff4b2b;
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
        <h1>Login</h1>
        <p>Welcome back! Please enter your credentials.</p>

        <form id="loginForm" method="POST">
            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>">
            <div class="error"><?= $errorEmail ?></div>

            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <div class="error"><?= $errorPassword ?></div>

            <button type="submit">Login</button>
        </form>

        <div class="signup-text">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>

    <script>
        function validateLogin() {
            let valid = true;

            const email = document.getElementById('email').value;
            const emailError = document.getElementById('emailError');
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!email.match(emailPattern)) {
                emailError.textContent = 'Please enter a valid email address.';
                valid = false;
            } else {
                emailError.textContent = '';
            }

            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            if (password.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters long.';
                valid = false;
            } else {
                passwordError.textContent = '';
            }

            if (valid) {

                fetch('login_server.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: email, password: password })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.role === 'Admin') {
                            window.location.href = 'admin_dashboard.php'; // صفحة إدارة المدير
                        } else if (data.role === 'User') {
                            window.location.href = 'welcome.php';
                        }
                    } else {
                        alert('Invalid email or password.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            return false; 
        }
    </script>

</body>
</html>
