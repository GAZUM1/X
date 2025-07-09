<?php
// public_html/results.php
require_once '../db.php';

$resultData = null;
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
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الاستعلام عن النتائج</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; }
        .container { width: 500px; margin: auto; }
        input { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>الاستعلام عن نتائج التحاليل</h1>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="results.php" method="POST">
            <label for="reference">الرقم المرجعي:</label>
            <input type="text" name="reference" id="reference" required>
            <button type="submit">عرض النتيجة</button>
        </form>
        <?php if($resultData): ?>
            <h2>النتيجة:</h2>
            <p><?php echo nl2br(htmlspecialchars($resultData['result'])); ?></p>
            <p>تم تسليم النتيجة: <?php echo $resultData['delivered'] ? 'نعم' : 'لا'; ?></p>
        <?php endif; ?>
        <p><a href="index.php">الرجوع للرئيسية</a></p>
    </div>
</body>
</html>
