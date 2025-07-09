<?php
require_once("../../db.php");

if (!isset($_GET['id'])) {
    die("معرف النتيجة غير موجود.");
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT patient_name, pdf_path FROM results WHERE id = ?");
$stmt->execute([$id]);
$res = $stmt->fetch();

if (!$res) {
    die("النتيجة مش موجودة.");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head><meta charset="UTF-8"><title>تحميل نتيجة التحليل</title></head>
<body>
    <h2>نتيجة <?= htmlspecialchars($res['patient_name']) ?></h2>

    <?php if ($res['pdf_path']): ?>
        <p>اضغط على الزر لتحميل ملف الـ PDF:</p>
        <a href="staff_panel/results/<?= htmlspecialchars($res['pdf_path']) ?>" download>
            <button>⬇️ تحميل النتيجة PDF</button>
        </a>
    <?php else: ?>
        <p>لم يتم رفع النتيجة بعد. يرجى المحاولة لاحقًا.</p>
    <?php endif; ?>
</body>
</html>
