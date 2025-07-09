<?php
// staff_panel/complaints/list.php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: ../unauthorized.php");
    exit;
}
require_once '../../db.php';

// جلب جميع الشكاوى
$stmt = $pdo->query("SELECT * FROM complaints ORDER BY created_at DESC");
$complaints = $stmt->fetchAll();

// تحديث حالة الإشعار إذا كان هناك notif_id في الرابط
if (isset($_GET['notif_id'])) {
    $notif_id = $_GET['notif_id'];

    // تحديث حالة الإشعار ليصبح مقروءًا
    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->execute([$notif_id]);
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الشكاوي</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; }
        table { width: 90%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">عرض الشكاوي</h1>
    <table>
        <tr>
            <th>المعرف</th>
            <th>الاسم</th>
            <th>الشكوى/الملاحظة</th>
            <th>الحالة</th>
            <th>التاريخ</th>
        </tr>
        <?php foreach ($complaints as $complaint): ?>
        <tr>
            <td><?php echo $complaint['id']; ?></td>
            <td><?php echo htmlspecialchars($complaint['name']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($complaint['message'])); ?></td>
            <td><?php echo $complaint['status']; ?></td>
            <td><?php echo $complaint['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p style="text-align:center;"><a href="../dashboard.php">الرجوع للوحة التحكم</a></p>
</body>
</html>
