<?php
require_once("../../db.php");

// تهيئة شرط البحث
$where = "";
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $where = "WHERE name LIKE ? OR phone LIKE ? OR id LIKE ?";
    $params = [$search, $search, $search];
}

// تنفيذ الاستعلام مع البحث إن وُجد
$stmt = $pdo->prepare("SELECT * FROM customers $where ORDER BY id DESC");
$stmt->execute($params);
$customers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة العملاء</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4 text-center">📋 قائمة العملاء</h3>

    <!-- مربع البحث -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم أو رقم التليفون أو رقم المسلسل" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button class="btn btn-primary" type="submit">🔍 بحث</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>م</th>
                    <th>الاسم</th>
                    <th>السن</th>
                    <th>الهاتف</th>
                    <th>نوع التحليل</th>
                    <th>المدفوع</th>
                    <th>المتبقي</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($customers): ?>
                    <?php foreach ($customers as $index => $cust): ?>
                        <tr>
                            <td><?= $cust['id'] ?></td>
                            <td><?= htmlspecialchars($cust['name']) ?></td>
                            <td><?= $cust['age'] ?></td>
                            <td><?= $cust['phone'] ?></td>
                            <td><?= $cust['test_type'] ?></td>
                            <td><?= $cust['amount_paid'] ?> جنيه</td>
                            <td><?= $cust['amount_due'] ?> جنيه</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">لا توجد نتائج مطابقة</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
