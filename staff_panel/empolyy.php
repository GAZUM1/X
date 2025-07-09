<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

try {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mshrq_project/db.php';

    // ✅ إضافة موظف جديد
    if (isset($_POST['add_employee'])) {
        $name = trim($_POST['name']);
        $salary = floatval($_POST['salary']);
        $discount = floatval($_POST['discount']);

        if ($name && $salary >= 0 && $discount >= 0) {
            $stmt = $pdo->prepare("INSERT INTO employees (name, salary, discount) VALUES (?, ?, ?)");
            $stmt->execute([$name, $salary, $discount]);
            $success = "تمت إضافة الموظف بنجاح.";
        } else {
            $error = "برجاء إدخال بيانات صحيحة.";
        }
    }

    // ✅ تعديل خصم الموظف
    if (isset($_POST['update_discount'])) {
        $employeeId = (int) $_POST['employee_id'];
        $discount = floatval($_POST['discount']);

        if ($discount >= 0) {
            $stmt = $pdo->prepare("UPDATE employees SET discount = ? WHERE id = ?");
            $stmt->execute([$discount, $employeeId]);
            $success = "تم تحديث الخصم بنجاح.";
        } else {
            $error = "الخصم لا يمكن أن يكون بالسالب.";
        }
    }

    // ✅ حذف الموظف
    if (isset($_POST['delete_employee'])) {
        $employeeId = (int) $_POST['employee_id'];
        $stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->execute([$employeeId]);
        $success = "تم حذف الموظف بنجاح.";
    }

    // ✅ جلب بيانات الموظفين
    $stmt = $pdo->query("SELECT * FROM employees");
    $employees = $stmt ? $stmt->fetchAll() : [];

} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الموظفين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Cairo', sans-serif; }
        .container { max-width: 1000px; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">🧑‍💼 إدارة الموظفين</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- ✅ إضافة موظف جديد -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">➕ إضافة موظف جديد</h5>
            <form method="POST" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="اسم الموظف" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="salary" step="0.01" class="form-control" placeholder="الراتب" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="discount" step="0.01" class="form-control" placeholder="الخصم" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="add_employee" class="btn btn-primary w-100">إضافة</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ جدول عرض وتعديل الموظفين -->
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الراتب</th>
                <th>الخصم</th>
                <th>المبلغ بعد الخصم</th>
                <th>تعديل الخصم</th>
                <th>حذف</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): 
                $after_discount = $employee['salary'] - $employee['discount'];
            ?>
                <tr>
                    <td><?= (int) $employee['id'] ?></td>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <td><?= number_format($employee['salary'], 2) ?> جنيه</td>
                    <td><?= number_format($employee['discount'], 2) ?> جنيه</td>
                    <td><?= number_format($after_discount, 2) ?> جنيه</td>

                    <!-- ✅ تعديل الخصم -->
                    <td>
                        <form method="POST" class="d-flex gap-2">
                            <input type="hidden" name="employee_id" value="<?= (int) $employee['id'] ?>">
                            <input type="number" step="0.01" name="discount" value="<?= htmlspecialchars($employee['discount']) ?>" class="form-control form-control-sm" required>
                            <button type="submit" name="update_discount" class="btn btn-success btn-sm">تحديث</button>
                        </form>
                    </td>

                    <!-- ✅ حذف الموظف -->
                    <td>
                        <form method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الموظف؟');">
                            <input type="hidden" name="employee_id" value="<?= (int) $employee['id'] ?>">
                            <button type="submit" name="delete_employee" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
