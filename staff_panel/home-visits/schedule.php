<?php
// staff_panel/home-visits/schedule.php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: ../unauthorized.php");
    exit;
}
require_once '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $visit_id = $_POST['visit_id'];
    $scheduled_date = $_POST['scheduled_date'];

    if (!empty($visit_id) && !empty($scheduled_date)) {
        $stmt = $pdo->prepare("UPDATE home_visits SET status = 'scheduled', preferred_date = ? WHERE id = ?");
        $stmt->execute([$scheduled_date, $visit_id]);
        $success = "تم تحديد موعد الزيارة.";
    } else {
        $error = "يرجى اختيار الزيارة والتاريخ.";
    }
}

$stmt = $pdo->query("SELECT hv.*, d.name AS doctor_name 
                    FROM home_visits hv 
                    LEFT JOIN doctors d ON hv.doctor_id = d.id 
                    WHERE hv.status = 'pending' 
                    ORDER BY hv.created_at ASC");
$visits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>جدولة الزيارات</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; }
        .container { width: 90%; margin: auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
<div class="container">
    <h2>جدولة الزيارات المنزلية</h2>
    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <table>
        <tr>
            <th>المعرف</th>
            <th>الاسم</th>
            <th>الهاتف</th>
            <th>التاريخ المفضل</th>
            <th>الدكتور</th>
            <th>إجراء</th>
        </tr>
        <?php foreach ($visits as $visit): ?>
        <tr>
            <td><?= $visit['id'] ?></td>
            <td><?= htmlspecialchars($visit['name']) ?></td>
            <td><?= htmlspecialchars($visit['phone']) ?></td>
            <td><?= $visit['preferred_date'] ?></td>
            <td><?= htmlspecialchars($visit['doctor_name']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="visit_id" value="<?= $visit['id'] ?>">
                    <input type="date" name="scheduled_date" required>
                    <button type="submit">حدد الميعاد</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="../dashboard.php">رجوع</a></p>
</div>
</body>
</html>
