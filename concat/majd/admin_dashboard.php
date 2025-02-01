<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

include('database.php');

$sql = "SELECT id, first_name, last_name, email, created_at FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body class="bg-light" style="direction: rtl;">

    <div class="container mt-5">
        <h1 class="text-center mb-4">لوحة تحكم المدير</h1>

        <div class="mb-4 text-end">
            <button id="addUserBtn" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#userModal">
                إضافة مستخدم جديد
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">الاسم</th>
                        <th class="text-center">البريد الإلكتروني</th>
                        <th class="text-center">تاريخ الإنشاء</th>
                        <th class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="text-center"><?php echo $user['id']; ?></td>
                            <td class="text-center"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                            <td class="text-center"><?php echo $user['email']; ?></td>
                            <td class="text-center"><?php echo $user['created_at']; ?></td>
                            <td class="text-center">
                                <button onclick="editUser(<?php echo $user['id']; ?>)" class="btn btn-warning btn-sm">تعديل</button>
                                <button onclick="deleteUser(<?php echo $user['id']; ?>)" class="btn btn-danger btn-sm">حذف</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="userModal" class="modal fade" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">إضافة مستخدم جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="add_user.php" method="post">
                <input type="hidden" name="user_id" id="user_id">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">الاسم الأول</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">الاسم الأخير</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">حفظ التغييرات</button>
                        <button type="button" class="btn btn-secondary w-100 mt-2" data-bs-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>


     function editUser(userId) {
    document.getElementById('modalTitle').innerText = "تعديل مستخدم";
    document.getElementById('user_id').value = userId;
    const form = document.getElementById('userForm');
    form.reset();

    
    // جلب بيانات المستخدم من الخادم
    fetchUserData(userId);
}

function fetchUserData(userId) {
    fetch('get_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${userId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('first_name').value = data.user.first_name;
            document.getElementById('last_name').value = data.user.last_name;
            document.getElementById('email').value = data.user.email;
        } else {
            alert("حدث خطأ أثناء جلب البيانات.");
        }
    })
    .catch(error => console.error('Error:', error));
}






















        
        function deleteUser(userId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'لا يمكن التراجع عن هذه العملية!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، حذف!',
                cancelButtonText: 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_user.php?id=' + userId;
                }
            });
        }

        document.getElementById('userForm').onsubmit = function(event) {
            event.preventDefault();
            Swal.fire('تم حفظ التغييرات!', '', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
            modal.hide();
        };

        document.getElementById('addUserBtn').onclick = function() {
    document.getElementById('modalTitle').innerText = "إضافة مستخدم جديد";
    document.getElementById('userForm').reset();
    document.getElementById('user_id').value = "";
};
    </script>


</body>
</html>
