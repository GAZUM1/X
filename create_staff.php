<?php
// create_staff.php
require_once 'db.php';

$username = 'admin';
$password = '123456'; // غيرها لو حابب بكلمة سر أقوى

try {
    // تشفير كلمة المرور
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // التأكد لو الحساب موجود بالفعل
    $check = $pdo->prepare("SELECT * FROM staff WHERE username = ?");
    $check->execute([$username]);

    if ($check->rowCount() > 0) {
        echo "⚠️ الحساب '$username' موجود بالفعل.";
    } else {
        // إدخال الحساب لقاعدة البيانات
        $stmt = $pdo->prepare("INSERT INTO staff (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
        echo "✅ تم إنشاء حساب '$username' بنجاح.";
    }
} catch (PDOException $e) {
    echo "❌ خطأ: " . $e->getMessage();
}
?>
