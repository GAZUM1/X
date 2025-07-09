<?php
// public_html/complaints.php
session_start(); // علشان نقدر نجيب patient_id لو المريض مسجل دخوله
require_once '../db.php'; // الاتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // بناخد البيانات ونتأكد إنها متقفلة (trim) يعني مفيهاش مسافات زيادة
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    // لو التلاتة مليانين نكمل
    if (!empty($name) && !empty($email) && !empty($message)) {
        
        // نشوف لو فيه مريض مسجل دخوله، نحفظ الـ ID بتاعه
        $patient_id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : null;

        // نحفظ الشكوى في جدول complaints
        if ($patient_id) {
            // لو المريض مسجل دخوله، نحفظ الشكوى مع الـ patient_id
            $stmt = $pdo->prepare("INSERT INTO complaints (name, email, message, patient_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $message, $patient_id]);
        } else {
            // لو مش مسجل، نحفظها عادي بدون patient_id
            $stmt = $pdo->prepare("INSERT INTO complaints (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
        }

        // بعد ما الشكوى تضاف بنجاح، نضيف إشعار للموظفين
        $notify_message = "شكوى جديدة من: $name";
        $type = 'complaint';

        $stmt_notify = $pdo->prepare("INSERT INTO notifications (type, message) VALUES (?, ?)");
        $stmt_notify->execute([$type, $notify_message]);

        // نعرض رسالة نجاح للمستخدم
        $success = "تم إرسال شكواك/ملاحظتك بنجاح.";
    } else {
        // لو فيه حاجة ناقصة
        $error = "محتاج تملأ كل الحقول.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إرسال الشكاوي والملاحظات</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; background-color: #f4f4f4; }
        .container {
            width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #218838;
        }
        .msg { padding: 10px; border-radius: 6px; margin-bottom: 15px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1>أرسل شكوتك أو ملاحظتك</h1>

        <?php if(isset($success)): ?>
            <div class="msg success"><?= $success; ?></div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <div class="msg error"><?= $error; ?></div>
        <?php endif; ?>

        <form action="complaints.php" method="POST">
            <label for="name">اسمك:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">بريدك الإلكتروني:</label>
            <input type="email" name="email" id="email" required>

            <label for="message">نص الشكوى/الملاحظة:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit">إرسال</button>
        </form>
        <p><a href="index.php">الرجوع للرئيسية</a></p>
    </div>
</body>
</html>
