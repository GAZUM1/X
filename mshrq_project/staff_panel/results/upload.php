<?php
// staff_panel/results/upload.php
require_once '../../db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference = trim($_POST['reference']);

    if (!empty($reference) && isset($_FILES['result_pdf'])) {
        $file = $_FILES['result_pdf'];
        $filename = time() . '_' . basename($file['name']); // اسم فريد
        $targetDir = '../../public_html/uploads/';
        $targetFilePath = $targetDir . $filename;

        // تأكد إن الملف PDF
        $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($fileType === 'pdf') {
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                // حفظ المسار في قاعدة البيانات (فقط اسم الملف)
                $stmt = $pdo->prepare("INSERT INTO results (reference, file_path) VALUES (?, ?)");
                $stmt->execute([$reference, $filename]);

                $message = "تم رفع النتيجة بنجاح.";
            } else {
                $message = "فشل في رفع الملف.";
            }
        } else {
            $message = "من فضلك ارفع ملف PDF فقط.";
        }
    } else {
        $message = "الرجاء إدخال الرقم المرجعي واختيار ملف.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رفع نتيجة تحليل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Tahoma', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-primary {
            width: 100%;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h2 class="mb-4">📤 رفع نتيجة التحليل (PDF)</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3 text-end">
            <label class="form-label">الرقم المرجعي:</label>
            <input type="text" name="reference" class="form-control" placeholder="مثال: 123456" required>
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">اختيار ملف PDF:</label>
            <input type="file" name="result_pdf" class="form-control" accept=".pdf" required>
        </div>

        <button type="submit" class="btn btn-primary">رفع النتيجة</button>
    </form>

    <div class="mt-4">
        <a href="dashboard.php" class="btn btn-secondary">🏠 العودة إلى لوحة التحكم</a>
    </div>
</div>

</body>
</html>
