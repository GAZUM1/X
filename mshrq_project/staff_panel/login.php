<?php
// staff_panel/login.php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM staff WHERE username = ?");
    $stmt->execute([$username]);
    $staff = $stmt->fetch();

    if ($staff && password_verify($password, $staff['password'])) {
        $_SESSION['staff_logged_in'] = true;
        $_SESSION['staff_username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "اسم المستخدم أو كلمة المرور غلط.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل دخول الموظفين</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h1 class="mb-4">تسجيل دخول الموظفين</h1>

    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form action="login.php" method="POST" class="border p-4 rounded shadow-sm bg-white">
        <div class="mb-3">
            <label for="username" class="form-label">اسم المستخدم:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">دخول</button>
    </form>

</div>

</body>
</html>
