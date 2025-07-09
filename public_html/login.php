<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // مثال: التحقق من بيانات دخول ثابتة
    if ($username == 'admin' && $password == 'password') {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_name'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "اسم المستخدم أو كلمة المرور غير صحيحة!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4">تسجيل الدخول</h3>
            <?php if (isset($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">اسم المستخدم</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">دخول</button>
            </form>
            <div class="mt-3 text-center">
                <a href="register.php">ليس لديك حساب؟ أنشئ حساب الآن</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
