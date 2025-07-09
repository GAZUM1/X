<?php
// staff_panel/home-visits/manage.php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: ../unauthorized.php");
    exit;
}
require_once '../../db.php';

// جلب الزيارات مع اسم الدكتور المختار
$stmt = $pdo->query("SELECT hv.*, d.name AS doctor_name 
                     FROM home_visits hv 
                     LEFT JOIN doctors d ON hv.doctor_id = d.id 
                     ORDER BY hv.created_at DESC");
$visits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الزيارات المنزلية</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; background-color: #f9f9f9; }
        table { width: 95%; margin: 30px auto; border-collapse: collapse; background-color: #fff; box-shadow: 0 0 10px #ccc; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #007BFF; color: white; }
        h1 { text-align: center; margin-top: 40px; color: #333; }
        a { display: block; text-align: center; margin: 20px auto; text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
    <h1>إدارة الزيارات المنزلية</h1>
    <table>
        <tr>
            <th>المعرف</th>
            <th>الاسم</th>
            <th>رقم الهاتف</th>
            <th>التاريخ المفضل</th>
            <th>اسم الدكتور</th>
            <th>الحالة</th>
            <th>التاريخ المحدد</th>
        </tr>
        <?php foreach ($visits as $visit): ?>
        <tr>
            <td><?php echo $visit['id']; ?></td>
            <td><?php echo htmlspecialchars($visit['name']); ?></td>
            <td><?php echo htmlspecialchars($visit['phone']); ?></td>
            <td><?php echo htmlspecialchars($visit['preferred_date']); ?></td>
            <td><?php echo $visit['doctor_name'] ? htmlspecialchars($visit['doctor_name']) : 'غير محدد'; ?></td>
            <td><?php echo $visit['status']; ?></td>
            <td><?php echo $visit['status'] == 'scheduled' ? htmlspecialchars($visit['preferred_date']) : '-'; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="../dashboard.php">رجوع للوحة التحكم</a>
</body>
</html>
