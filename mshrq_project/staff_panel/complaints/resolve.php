<?php
// staff_panel/complaints/resolve.php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: ../unauthorized.php");
    exit;
}
require_once '../../db.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$complaint_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // تحديث حالة الشكوى إلى "تم الحل"
    $stmt = $pdo->prepare("UPDATE complaints SET status = 'resolved' WHERE id = ?");
    $stmt->execute([$complaint_id]);

    // ===== تسجيل الحدث في logs/actions.log =====
    $staff_name = $_SESSION['staff_name'] ?? 'موظف غير معروف';
    $log_message = "[" . date('Y-m-d H:i') . "] الموظف ($staff_name) قام بحل الشكوى رقم ($complaint_id)" . PHP_EOL;

    $log_path = __DIR__ . '/../../logs/actions.log';
    file_put_contents($log_path, $log_message, FILE_APPEND);
    // ============================================

    header("Location: list.php");
    exit;
}

// جلب بيانات الشكوى
$stmt = $pdo->prepare("SELECT * FROM complaints WHERE id = ?");
$stmt->execute([$complaint_id]);
$complaint = $stmt->fetch();
if (!$complaint) {
    die("الشكاية دي مش موجودة.");
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حل الشكوى</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; }
        .container { width: 500px; margin: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>حل الشكوى (معرف: <?php echo $complaint['id']; ?>)</h1>
        <p><strong>الاسم:</strong> <?php echo htmlspecialchars($complaint['name']); ?></p>
        <p><strong>الإيميل:</strong> <?php echo htmlspecialchars($complaint['email']); ?></p>
        <p><strong>نص الشكوى:</strong><br><?php echo nl2br(htmlspecialchars($complaint['message'])); ?></p>
        <form action="resolve.php?id=<?php echo $complaint['id']; ?>" method="POST">
            <button type="submit">تأكيد حل الشكوى</button>
        </form>
        <p><a href="list.php">رجوع لقائمة الشكاوي</a></p>
    </div>
</body>
</html>
