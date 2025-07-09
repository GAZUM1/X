<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: unauthorized.php");
    exit;
}

require_once '../db.php';

// جلب جميع التقارير الشهرية
$stmt = $pdo->query("SELECT * FROM reports ORDER BY report_date DESC");
$reports = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>التقارير الشهرية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">التقارير الشهرية</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الشهر</th>
                    <th>إجمالي الدخل</th>
                    <th>إجمالي المصروفات</th>
                    <th>صافي الربح</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= date('F Y', strtotime($report['report_date'])) ?></td>
                        <td><?= number_format($report['total_income'], 2) ?> جنيه</td>
                        <td><?= number_format($report['total_expenses'], 2) ?> جنيه</td>
                        <td><?= number_format($report['net_profit'], 2) ?> جنيه</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
