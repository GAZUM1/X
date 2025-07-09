<?php
require_once '../db.php';
$resultData = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reference = trim($_POST['reference']);
    if (!empty($reference)) {
        $stmt = $pdo->prepare("SELECT * FROM results WHERE reference = ?");
        $stmt->execute([$reference]);
        $resultData = $stmt->fetch();
        if (!$resultData) {
            $error = "مفيش نتيجة بالرقم المرجعي ده.";
        }
    } else {
        $error = "من فضلك ادخل الرقم المرجعي.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الاستعلام عن النتائج</title>
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
        .result-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #e9f7ef;
            border-left: 5px solid #28a745;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h2 class="mb-4">🔍 استعلام عن نتيجة التحاليل</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3 text-end">
            <label class="form-label">ادخل الرقم المرجعي:</label>
            <input type="text" name="reference" class="form-control" placeholder="مثال: 123456" required>
        </div>
        <button type="submit" class="btn btn-primary">عرض النتيجة</button>
    </form>

    <?php if ($resultData): ?>
        <div class="result-box text-end">
            <h5>📄 النتيجة:</h5>
            <p>
                <a href="uploads/<?= htmlspecialchars($resultData['file_path']) ?>" class="btn btn-success" download>
                    ⬇️ تحميل النتيجة (PDF)
                </a>
            </p>
            <p><strong>🚚 تم التسليم؟</strong> <?= $resultData['delivered'] ? 'نعم ✅' : 'لا ❌' ?></p>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">🏠 الرجوع للصفحة الرئيسية</a>
    </div>
</div>

</body>
</html>
