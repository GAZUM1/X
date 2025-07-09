<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>معمل المشرق للتحاليل الطبية</title>
    <!-- Bootstrap 5 RTL CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Google Font Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #121212;
            color: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        /* Sidebar */
        .sidebar {
            width: 240px;
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            background-color: #1f1f1f;
            padding-top: 30px;
            box-shadow: -2px 0 10px rgba(0,0,0,0.5);
            z-index: 1000;
            text-align: center;
        }
        .sidebar .logo {
            margin-bottom: 20px;
            font-size: 48px;
            line-height: 1;
        }
        .sidebar .logo span {
            display: block;
            font-size: 60px;
        }
        .sidebar .logo h3 {
            color: #00c3ff;
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }
        .sidebar a {
            display: block;
            padding: 15px;
            color: #f8f9fa;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #007bff33;
            color: #00ffff;
            padding-right: 25px;
        }
        /* Main content */
        .main-content {
            margin-right: 260px;
            padding: 20px;
        }
        .hero {
            background: url('images/lab-bg.jpg') no-repeat center center;
            background-size: cover;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 0 0 10px #000;
            border-radius: 15px;
            overflow: hidden;
        }
        .hero h1 {
            font-size: 50px;
            color: #ffffff;
        }
        .hero p.lead {
            font-size: 24px;
            color: #e0e0e0;
        }
        .card {
            background-color: #1e1e1e;
            border: none;
            color: #ffffff;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px #00c3ff66;
        }
        h2, h5 {
            color: #00c3ff;
        }
        footer {
            background-color: #000000;
        }
        .btn-outline-primary, .btn-outline-success, .btn-outline-danger {
            border-width: 2px;
        }
        .btn-outline-primary:hover {
            background-color: #00c3ff;
            color: #000;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <span>🧪</span>
        <h3>معمل المشرق</h3>
    </div>
    <a href="index.php">🏠 الرئيسية</a>
    <a href="complaints.php">📝 الشكاوي</a>
    <a href="home-visits.php">🚑 الزيارات المنزلية</a>
    <a href="results.php">🧾 نتائج التحاليل</a>
    <!-- إضافة الأزرار في شريط التنقل -->
    <a href="login.php" class="btn btn-outline-primary my-3">تسجيل الدخول</a>
    <a href="register.php" class="btn btn-outline-primary my-3">تسجيل</a>
    <div class="text-end mt-3 me-3">
    <a href="logout.php" class="btn btn-outline-light">🚪 تسجيل الخروج</a>
</div>

    </div>

<!-- Main Content -->
<div class="main-content">

    <!-- Hero Section -->
    <section class="hero text-center mb-5">
        <div>
            <h1>أهلاً بك في معمل المشرق</h1>
            <p class="lead">دقة – أمان – راحة</p>
        </div>
    </section>

    <!-- تحليل الدم الشامل Section -->
    <section class="container my-5">
        <h2 class="text-center mb-4">خدمات التحاليل في معمل المشرق</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- تحليل دم شامل -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/4.jpg" class="card-img-top" alt="تحليل دم شامل">
                    <div class="card-body">
                        <h5 class="card-title">تحليل دم شامل</h5>
                        <p class="card-text">فحص مكونات الدم مثل الهيموجلوبين وخلايا الدم البيضاء والحمراء والصفائح الدموية.</p>
                    </div>
                </div>
            </div>
            <!-- وظائف الكبد -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/3.jpg" class="card-img-top" alt="وظائف الكبد">
                    <div class="card-body">
                        <h5 class="card-title">وظائف الكبد</h5>
                        <p class="card-text">تقييم صحة الكبد عن طريق قياس إنزيمات ووظائف الكبد الأساسية.</p>
                    </div>
                </div>
            </div>
            <!-- تحليل فيروس C -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/2.jpg" class="card-img-top" alt="تحليل فيروس C">
                    <div class="card-body">
                        <h5 class="card-title">تحليل فيروس C</h5>
                        <p class="card-text">اكتشاف الإصابة بفيروس التهاب الكبد C ومدى تطوره داخل الجسم.</p>
                    </div>
                </div>
            </div>
            <!-- تحليل الغدة الدرقية -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/5.jpg" class="card-img-top" alt="تحليل الغدة الدرقية">
                    <div class="card-body">
                        <h5 class="card-title">تحليل الغدة الدرقية</h5>
                        <p class="card-text">قياس مستويات الهرمونات T3، T4 وTSH للتأكد من نشاط أو خمول الغدة.</p>
                    </div>
                </div>
            </div>
            <!-- تحليل البول -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/6.jpg" class="card-img-top" alt="تحليل البول">
                    <div class="card-body">
                        <h5 class="card-title">تحليل البول</h5>
                        <p class="card-text">فحص شامل لمكونات البول للكشف عن أمراض الجهاز البولي أو السكري.</p>
                    </div>
                </div>
            </div>
            <!-- تحليل الهرمونات -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/7.jpg" class="card-img-top" alt="تحليل الهرمونات">
                    <div class="card-body">
                        <h5 class="card-title">تحليل الهرمونات</h5>
                        <p class="card-text">قياس نسب هرمونات مثل الإستروجين، التستوستيرون، البرولاكتين وغيرها.</p>
                    </div>
                </div>
            </div>
            <!-- تحليل الحمل -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/8.jpg" class="card-img-top" alt="تحليل الحمل">
                    <div class="card-body">
                        <h5 class="card-title">تحليل الحمل</h5>
                        <p class="card-text">فحص وجود هرمون HCG لتأكيد الحمل سواء عن طريق الدم أو البول.</p>
                    </div>
                </div>
            </div>
            <!-- تحليل البراز -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/9.jpg" class="card-img-top" alt="تحليل البراز">
                    <div class="card-body">
                        <h5 class="card-title">تحليل البراز</h5>
                        <p class="card-text">فحص للكشف عن الطفيليات أو البكتيريا أو مشاكل الهضم.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- خدماتنا Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">خدماتنا</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">تحاليل طبية شاملة</h5>
                            <p class="card-text">أحدث الأجهزة لضمان دقة النتائج.</p>
                            <a href="results.php" class="btn btn-outline-primary">استعلام عن نتيجة</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">زيارات منزلية</h5>
                            <p class="card-text">خدمة سحب العينات من البيت.</p>
                            <a href="home-visits.php" class="btn btn-outline-success">احجز زيارة</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">استقبال الشكاوي</h5>
                            <p class="card-text">نستقبل ملاحظاتكم ونعمل على تحسين الخدمة.</p>
                            <a href="complaints.php" class="btn btn-outline-danger">أرسل شكوى</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- تواصل معنا Section -->
    <section class="bg-dark py-5 text-center">
        <div class="container">
            <h2 class="text-info">تواصل معنا</h2>
            <p>📍 القاهرة - مدينة نصر - شارع الطيران</p>
            <p>📞 01234567890 - 🕒 من 9 ص لـ 10 م</p>
            <button class="btn btn-primary" onclick="alert('اتصل على: 01234567890')">اتصل بنا</button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-3 text-white">
        جميع الحقوق محفوظة © معمل المشرق 2025
    </footer>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
