<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: unauthorized.php");
    exit;
}

require_once '../db.php';

// استعلام لجلب جميع العملاء من جدول customers
$query = "SELECT * FROM customers ORDER BY id DESC";
$stmt = $pdo->query($query);
$customers = $stmt->fetchAll();

// حساب المكسب الإجمالي
$total_profit = 0;
foreach ($customers as $customer) {
    $total_profit += $customer['amount_paid'] - $customer['amount_due']; // حساب المكسب لكل عميل
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض المكسب - معمل المشرق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f1f3f5; font-family: 'Cairo', sans-serif; }
        .card { background-color: #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; }
        .logout-btn { position: fixed; top: 20px; right: 20px; z-index: 999; }
        footer { margin-top: 60px; text-align: center; color: #777; font-size: 14px; }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <h1 class="mb-4 fw-bold">👋 أهلاً بيك في صفحة المكسب الإجمالي</h1>

    <!-- جدول عرض المكسب لكل عميل -->
    <h3>إجمالي المكسب لكل عميل</h3>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>اسم العميل</th>
                <th>المبلغ المدفوع</th>
                <th>المتبقي</th>
                <th>المكسب</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= htmlspecialchars($customer['name']) ?></td>
                    <td><?= number_format($customer['amount_paid'], 2) ?> جنيه</td>
                    <td><?= number_format($customer['amount_due'], 2) ?> جنيه</td>
                    <td><?= number_format($customer['amount_paid'] - $customer['amount_due'], 2) ?> جنيه</td> <!-- حساب المكسب هنا -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>إجمالي المكسب: <?= number_format($total_profit, 2) ?> جنيه</h4>

    <a href="admin/index.php" class="btn btn-outline-primary mt-3">الرجوع إلى لوحة تحكم الموظف</a>
</div>

<footer>&copy; <?= date("Y") ?> معمل المشرق - جميع الحقوق محفوظة.</footer>

</body>
</html>
