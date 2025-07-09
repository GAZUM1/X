<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: unauthorized.php");
    exit;
}

require_once '../db.php';

// إشعارات غير مقروءة حسب النوع
$stmt = $pdo->query("SELECT type, COUNT(*) as total FROM notifications WHERE is_read = 0 GROUP BY type");
$notif_counts = ['complaint' => 0, 'home_visit' => 0, 'new_customer' => 0];
foreach ($stmt as $row) {
    $notif_counts[$row['type']] = $row['total'];
}

if (isset($_GET['notif_id'])) {
    $notif_id = $_GET['notif_id'];
    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->execute([$notif_id]);
}

// إحصائيات لوحة التحكم
$totalComplaints = $pdo->query("SELECT COUNT(*) FROM complaints")->fetchColumn();
$pendingComplaints = $pdo->query("SELECT COUNT(*) FROM complaints WHERE status != 'resolved'")->fetchColumn();

$today = date('Y-m-d'); 
$todayVisits = $pdo->prepare("SELECT COUNT(*) FROM home_visits WHERE preferred_date = ?");
$todayVisits->execute([$today]);
$todayVisitsCount = $todayVisits->fetchColumn();

$totalResults = $pdo->query("SELECT COUNT(*) FROM results")->fetchColumn();

// جرافيك التحاليل آخر 7 أيام
$chartData = ['labels' => [], 'data' => []];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM results WHERE DATE(created_at) = ?");
    $stmt->execute([$date]);
    $chartData['labels'][] = $date;
    $chartData['data'][] = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - معمل المشرق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f1f3f5; font-family: 'Cairo', sans-serif; }
        .dashboard-header { margin-top: 40px; position: relative; }
        .card { background-color: #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; }
        .logout-btn { position: fixed; top: 20px; right: 20px; z-index: 999; }
        .badge-notif { position: absolute; top: 5px; right: 10px; background-color: red; color: white; padding: 3px 7px; font-size: 12px; border-radius: 50%; }
        .card-position { position: relative; }
        footer { margin-top: 60px; text-align: center; color: #777; font-size: 14px; }
        #datetime { font-size: 1.2em; color: #333; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container dashboard-header text-center">
    <h1 class="mb-4 fw-bold">👋 أهلاً بيك د/ شريف، <span class="text-primary"><?= htmlspecialchars($_SESSION['staff_username']) ?></span></h1>
    <p class="lead">إختر القسم اللي تحب تشتغل عليه 👇</p>
    <div id="datetime"></div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">

        <!-- الشكاوى -->
        <div class="col">
            <div class="card border-primary h-100 card-position">
                <?php if ($notif_counts['complaint'] > 0): ?>
                    <div class="badge-notif"><?= $notif_counts['complaint'] ?></div>
                <?php endif; ?>
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-chat-dots"></i> الشكاوى</h5>
                    <a href="complaints/list.php?notif_id=<?= $notif_counts['complaint'] ?>" class="btn btn-outline-primary mt-2">عرض الشكاوى</a>
                </div>
            </div>
        </div>

        <!-- الزيارات المنزلية -->
        <div class="col">
            <div class="card border-success h-100 card-position">
                <?php if ($notif_counts['home_visit'] > 0): ?>
                    <div class="badge-notif"><?= $notif_counts['home_visit'] ?></div>
                <?php endif; ?>
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-house-door"></i> الزيارات المنزلية</h5>
                    <a href="home-visits/manage.php?notif_id=<?= $notif_counts['home_visit'] ?>" class="btn btn-outline-success mt-2">إدارة الزيارات</a>
                </div>
            </div>
        </div>

        <!-- نتائج التحاليل -->
        <div class="col">
            <div class="card border-warning h-100 card-position">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-flask"></i> نتائج التحاليل</h5>
                    <a href="results/upload.php" class="btn btn-outline-warning mt-2">رفع النتائج</a>
                </div>
            </div>
        </div>

        <!-- عميل جديد -->
        <div class="col">
            <div class="card border-info h-100 card-position">
                <?php if ($notif_counts['new_customer'] > 0): ?>
                    <div class="badge-notif"><?= $notif_counts['new_customer'] ?></div>
                <?php endif; ?>
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-person-plus"></i> عميل جديد</h5>
                    <a href="customers/add-customer.php" class="btn btn-outline-info mt-2">إضافة عميل</a>
                </div>
            </div>
        </div>

        <!-- قائمة العملاء -->
        <div class="col">
            <div class="card border-dark h-100">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-people"></i> قائمة العملاء</h5>
                    <a href="customers/customers-list.php" class="btn btn-outline-dark mt-2">عرض القائمة</a>
                </div>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="col">
            <div class="card border-secondary h-100">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-graph-up"></i> إحصائيات سريعة</h5>
                    <ul class="list-unstyled mt-3">
                        <li>📨 عدد الشكاوى: <strong><?= $totalComplaints ?></strong></li>
                        <li>⏳ شكاوى قيد المعالجة: <strong><?= $pendingComplaints ?></strong></li>
                        <li>🏠 زيارات اليوم: <strong><?= $todayVisitsCount ?></strong></li>
                        <li>🧪 تحاليل مرفوعة: <strong><?= $totalResults ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>
        

      <!-- إضافة رابط المكسب الإجمالي داخل لوحة تحكم الموظف -->
<div class="col">
    <div class="card border-success h-100 card-position">
        <div class="card-body text-center">
            <h5 class="card-title"><i class="bi bi-cash-coin"></i> المكسب الإجمالي</h5>
            <a href="earnings.php" class="btn btn-outline-success mt-2">عرض المكسب الإجمالي</a>
        </div>
    </div>
</div>
<!-- رابط إدارة الجرد -->
<div class="col mt-4">
    <div class="card border-info h-100">
        <div class="card-body text-center">
            <h5 class="card-title"><i class="bi bi-archive"></i> إدارة الجرد</h5>
            <a href="inventory.php" class="btn btn-outline-info mt-2">عرض الجرد وإضافة عناصر</a>
        </div>
    </div>
</div>

<!-- قسم الموظفين -->
<div class="col">
    <div class="card border-warning h-100 card-position">
        <div class="card-body text-center">
            <h5 class="card-title"><i class="bi bi-person-badge"></i> الموظفين</h5>
            <a href="empolyy.php" class="btn btn-outline-warning mt-2">إدارة الموظفين</a>
        </div>
    </div>
</div>

    </div>

    <!-- جرافيك -->
    <div class="mt-5">
        <h3 class="mb-3">📊 التحاليل خلال آخر 7 أيام</h3>
        <canvas id="resultsChart" width="400" height="150"></canvas>
    </div>

    <a href="logout.php" class="btn btn-danger logout-btn">🚪 تسجيل الخروج</a>
</div>

<footer>&copy; <?= date("Y") ?> معمل المشرق - جميع الحقوق محفوظة.</footer>

<!-- JavaScript لعرض التاريخ والوقت -->
<script>
    function updateTime() {
        const now = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('datetime').textContent = "الوقت الحالي: " + now.toLocaleString('ar-EG', options);
    }
    setInterval(updateTime, 1000);
</script>

<!-- Chart.js رسم -->
<script>
    const ctx = document.getElementById('resultsChart').getContext('2d');
    const resultsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartData['labels']) ?>,
            datasets: [{
                label: 'عدد التحاليل',
                data: <?= json_encode($chartData['data']) ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>
