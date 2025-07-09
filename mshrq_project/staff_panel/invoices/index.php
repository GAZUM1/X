<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: unauthorized.php");
    exit;
}

require_once '../db.php';

// جلب بيانات الفواتير
$stmt = $pdo->query("SELECT * FROM invoices ORDER BY created_at DESC");
$invoices = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الفواتير</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">الفواتير</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>المبلغ</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><?= $invoice['customer_id'] ?></td>
                        <td><?= number_format($invoice['amount'], 2) ?> جنيه</td>
                        <
