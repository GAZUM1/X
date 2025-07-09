<?php
session_start();
session_unset(); // يمسح كل بيانات السيشن
session_destroy(); // يقفل السيشن تمامًا

// يرجع المستخدم لصفحة تسجيل الدخول
header("Location: login.php");
exit();
