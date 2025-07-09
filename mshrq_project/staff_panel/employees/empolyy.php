<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mshrq_project/db.php';

    // جلب قائمة الموظفين
    $stmt = $pdo->query("SELECT * FROM employees");
    if ($stmt) {
        $employees = $stmt->fetchAll();
    } else {
        echo "خطأ في جلب الموظفين";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $employeeId = $_POST['employee_id'];
        $discount = $_POST['discount'];
        
        // تحديث الخصم للموظف
        $stmt = $pdo->prepare("UPDATE employees SET discount = ? WHERE id = ?");
        $stmt->execute([$discount, $employeeId]);
        
        // إعادة توجيه بعد التحديث
        header("Location: manage.php");
        exit;
    }
} catch (PDOException $e) {
    echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الموظفين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">إدارة الموظفين</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الراتب</th>
                <th>الخصم</th>
                <th>تعديل الخصم</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee['id'] ?></td>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <td><?= number_format($employee['salary'], 2) ?> جنيه</td>
                    <td><?= number_format($employee['discount'], 2) ?> جنيه</td>
                    <td>
                        <form action="manage.php" method="POST" class="d-inline">
                            <input type="hidden" name="employee_id" value="<?= $employee['id'] ?>">
                            <input type="number" name="discount" value="<?= $employee['discount'] ?>" class="form-control form-control-sm" required>
                            <button type="submit" class="btn btn-success mt-2 btn-sm">تحديث الخصم</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
