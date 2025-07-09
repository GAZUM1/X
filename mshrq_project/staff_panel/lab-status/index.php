<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: unauthorized.php");
    exit;
}

require_once '../db.php';

// جلب حالة المعمل
$stmt = $pdo->query("SELECT * FROM lab_status ORDER BY updated_at DESC");
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حالة المعمل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">حالة المعمل</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم المهمة</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= $task['task_name'] ?></td>
                        <td><?= ucfirst($task['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
