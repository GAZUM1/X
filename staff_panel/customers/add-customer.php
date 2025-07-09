<?php
require_once("../../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $test_type = $_POST["test_type"];
    $amount_paid = $_POST["amount_paid"];
    $amount_due = $_POST["amount_due"];

    $stmt = $pdo->prepare("INSERT INTO customers (name, age, phone, test_type, amount_paid, amount_due) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $age, $phone, $test_type, $amount_paid, $amount_due]);

    echo "<script>alert('تم إضافة العميل بنجاح'); window.location.href='add-customer.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة عميل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">إضافة عميل جديد</h3>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>السن</label>
                    <input type="number" name="age" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>رقم التليفون</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>نوع التحليل</label>
                    <input type="text" name="test_type" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>المبلغ المدفوع</label>
                    <input type="number" step="0.01" name="amount_paid" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>المبلغ المتبقي</label>
                    <input type="number" step="0.01" name="amount_due" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">💾 تسجيل العميل</button>
        </form>
    </div>
</div>

</body>
</html>
