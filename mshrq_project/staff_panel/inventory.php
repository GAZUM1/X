<?php
// الاتصال بقاعدة البيانات
require_once '../db.php';

// معالجة إضافة عنصر جديد إلى المخزون
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $query = "INSERT INTO inventory (name, description, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $description, $quantity, $price]);

    header('Location: inventory.php');
    exit;
}

// حذف عنصر من الجرد
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM inventory WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    header('Location: inventory.php');
    exit;
}

// استعلام لجلب جميع العناصر من جدول inventory
$query = "SELECT * FROM inventory";
$stmt = $pdo->query($query);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الجرد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        table th, table td {
            text-align: center;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .form-control, .btn {
            border-radius: 0.375rem;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">صفحة الجرد</h3>
        </div>
        <div class="card-body">
            <!-- نموذج إضافة عنصر جديد -->
            <h4>إضافة عنصر جديد</h4>
            <form method="POST" action="inventory.php">
                <div class="mb-3">
                    <label for="name" class="form-label">اسم العنصر</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">الكمية</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">السعر</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">إضافة العنصر</button>
            </form>
        </div>
    </div>

    <!-- عرض العناصر في جدول -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">قائمة العناصر</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم العنصر</th>
                        <th>الوصف</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 2) ?> ج.م</td>
                            <td><?= $item['added_on'] ?></td>
                            <td>
                                <a href="inventory.php?delete=<?= $item['id'] ?>" class="btn btn-danger">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
