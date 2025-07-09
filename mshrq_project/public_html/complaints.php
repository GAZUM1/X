<?php
// public_html/complaints.php
require_once '../db.php';

$success = $error = '';

// إضافة إشعار جديد للمسؤول
function addNotification($message) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (?)");
    $stmt->execute([$message]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = trim($_POST['name']);
    $message = trim($_POST['message']);

    // التحقق من البيانات
    if (!empty($name) && !empty($message)) {
        // إضافة الشكوى إلى قاعدة البيانات
        $stmt = $pdo->prepare("INSERT INTO complaints (name, message) VALUES (?, ?)");
        $stmt->execute([$name, $message]);

        // إضافة إشعار للمسؤول
        addNotification("📢 تم تقديم شكوى جديدة من " . htmlspecialchars($name));

        $success = "✅ تم إرسال شكواك/ملاحظتك بنجاح.";
    } else {
        $error = "⚠️ لازم تملأ كل البيانات.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إرسال الشكاوي والملاحظات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background-color: #f0f8ff;
        }
        .form-container {
            margin-top: 50px;
            max-width: 600px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container mx-auto">
            <h2 class="mb-4 text-center text-primary">📩 أرسل شكوتك أو ملاحظتك</h2>

            <!-- عرض الرسائل بنجاح أو خطأ -->
            <?php if($success): ?>
                <div class="alert alert-success" id="successMsg"><?= $success ?></div>
            <?php endif; ?>
            <?php if($error): ?>
                <div class="alert alert-danger" id="errorMsg"><?= $error ?></div>
            <?php endif; ?>

            <!-- نموذج إرسال الشكاوى -->
            <form method="POST" action="complaints.php">
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">نص الشكوى / الملاحظة:</label>
                    <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">📬 إرسال</button>
            </form>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-outline-secondary">🏠 الرجوع للرئيسية</a>
            </div>
        </div>
    </div>

    <!-- JavaScript لإخفاء الرسائل بعد وقت -->
    <script>
        setTimeout(() => {
            const success = document.getElementById('successMsg');
            const error = document.getElementById('errorMsg');
            if(success) success.style.display = 'none';
            if(error) error.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
