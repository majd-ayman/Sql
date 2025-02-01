<?php
include('database.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, email, role, first_name, middle_name, last_name, family_name, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "لم يتم العثور على بيانات المستخدم.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body{
            direction: rtl;
        }
        .bg-white.rounded-lg.shadow-lg.p-8.max-w-lg.w-full.text-center {
            text-align: right;
        }
        .ball {
            position: absolute;
            border-radius: 50%;
            opacity: 0.7;
            animation: move 10s linear infinite;
        }

        @keyframes move {
            0% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(300px, 300px);
            }
            100% {
                transform: translate(0, 0);
            }
        }

        .ball1 { background-color: #FF5733; }
        .ball2 { background-color: #33FF57; }
        .ball3 { background-color: #3357FF; }
        .ball4 { background-color: #F4FF33; }
        .ball5 { background-color: #FF33A8; }
        .ball6 { background-color: #33FFF6; }
    </style>
</head>
<body class="bg-gray-100 overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full">
        <div class="ball ball1" style="width: 150px; height: 150px;"></div>
        <div class="ball ball2" style="width: 120px; height: 120px; animation-duration: 15s;"></div>
        <div class="ball ball3" style="width: 100px; height: 100px; animation-duration: 12s;"></div>
        <div class="ball ball4" style="width: 180px; height: 180px;"></div>
        <div class="ball ball5" style="width: 130px; height: 130px; animation-duration: 18s;"></div>
        <div class="ball ball6" style="width: 110px; height: 110px;"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center h-screen p-8">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg w-full text-center">
            <h1 class="text-3xl font-semibold text-gray-800 mb-4">مرحباً بك، <span class="text-blue-500"><?php echo $_SESSION['user_email']; ?></span></h1>
            <p class="text-gray-600 mb-6">لقد قمت بتسجيل الدخول بنجاح. هذه هي بياناتك:</p>

            <div class="space-y-4">
                <p class="text-lg text-gray-700"><strong>المعرف:</strong> <?php echo $_SESSION['user_id']; ?></p>
                <p class="text-lg text-gray-700"><strong>البريد الإلكتروني:</strong> <?php echo $_SESSION['user_email']; ?></p>
                <p class="text-lg text-gray-700"><strong>الدور:</strong> <?php echo $_SESSION['user_role']; ?></p>
            </div>

            <a href="login.php" class="mt-6 inline-block bg-blue-500 text-white text-lg font-semibold py-3 px-6 rounded-full hover:bg-blue-600 transition duration-300">تسجيل الخروج</a>
        </div>
    </div>

</body>
</html>
