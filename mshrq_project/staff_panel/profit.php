<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: unauthorized.php");
    exit;
}

require_once '../db.php';

// جلب إجمالي المكسب
$stmt = $pdo->query("SELECT SUM(total_income) as total_income FROM reports");
$totalIncome = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إجمالي المكسب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">إجمالي المكسب</h1>
        <p class="text-center">إجمالي المكسب: <?= number_format($totalIncome, 2) ?> جنيه</p>
    </div>
</body>
</html>
