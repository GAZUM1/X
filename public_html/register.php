<?php
session_start();
require_once '../db.php'; // اتأكد إن المسار صحيح

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // التحقق من صحة البيانات
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = "من فضلك املأ جميع الحقول.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "البريد الإلكتروني غير صالح.";
    } elseif ($password !== $confirm_password) {
        $error = "كلمتا المرور غير متطابقتين.";
    } else {
        // التحقق من أن الإيميل مش موجود
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "البريد الإلكتروني مسجل بالفعل.";
        } else {
            // تشفير الباسورد
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // إدخال المستخدم
            $insert = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $insert->execute([$first_name, $last_name, $email, $hashed_password]);

            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $first_name . ' ' . $last_name;
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(45deg, #1d1d1d, #2f2f2f);
            font-family: 'Cairo', sans-serif;
            color: #fff;
            padding: 0;
            margin: 0;
        }

        .login-container {
            max-width: 550px;
            margin: 80px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 4px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #00c3ff;
        }

        .btn-primary {
            background-color: #00c3ff;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            width: 100%;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #007bff;
            transform: scale(1.05);
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 20px;
            font-size: 1rem;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .form-label {
            text-align: right;
            font-size: 1rem;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }

        .emoji {
            font-size: 3rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1><span class="emoji">📝</span> إنشاء حساب</h1>

    <?php if (isset($error)): ?>
        <div class="error-message">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="mb-3">
            <label for="first_name" class="form-label">الاسم الأول</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">اسم العائلة</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">تأكيد كلمة المرور</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">إنشاء الحساب</button>
    </form>

    <div class="footer">
        <p>لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>
    </div>
</div>

</body>
</html>
