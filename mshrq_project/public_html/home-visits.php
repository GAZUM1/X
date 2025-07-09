<?php
// public_html/home-visits.php
require_once '../db.php';

// استرجاع بيانات الأطباء من قاعدة البيانات
$stmt = $pdo->query("SELECT id, name, phone FROM doctors");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $preferred_date = trim($_POST['preferred_date']);
    $doctor_id = trim($_POST['doctor_id']);

    if (!empty($name) && !empty($phone) && !empty($preferred_date) && !empty($doctor_id)) {
        // حفظ بيانات حجز الزيارة
        $stmt = $pdo->prepare("INSERT INTO home_visits (name, phone, preferred_date, doctor_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $preferred_date, $doctor_id]);

        // إضافة إشعار جديد في جدول الإشعارات
        $notif_message = "📢 حجز زيارة منزلية جديدة بواسطة $name يوم $preferred_date.";
        $notif_stmt = $pdo->prepare("INSERT INTO notifications (message, type, created_at) VALUES (?, 'home_visit', NOW())");
        $notif_stmt->execute([$notif_message]);

        $success = "تم حجز الزيارة بنجاح.";
    } else {
        $error = "املأ كل الحقول يا غالي.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حجز الزيارة المنزلية</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container mx-auto">
            <h2 class="mb-4 text-center text-primary">حجز زيارة منزلية</h2>

            <?php if(isset($success)): ?>
                <div class="alert alert-success" id="successMsg"><?= $success ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger" id="errorMsg"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="home-visits.php">
                <div class="mb-3">
                    <label for="name" class="form-label">اسمك:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">رقم تليفونك:</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="preferred_date" class="form-label">التاريخ المفضل للزيارة:</label>
                    <input type="date" name="preferred_date" id="preferred_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="doctor_id" class="form-label">اختار الطبيب:</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" required>
                        <option value="">اختر الطبيب</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?> - <?= $doctor['phone'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">احجز الزيارة</button>
            </form>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-outline-secondary">🏠 الرجوع للرئيسية</a>
            </div>
        </div>
    </div>

    <!-- JavaScript لإخفاء الرسائل بعد 5 ثواني -->
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
