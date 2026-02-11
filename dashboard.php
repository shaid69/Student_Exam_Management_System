<?php
require_once 'database.php';
session_start();
if(!isset($_SESSION['user_id'])) header('Location: login.php');

// REAL-TIME COUNTS
$students_count = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$courses_count  = $conn->query("SELECT COUNT(*) AS total FROM course_offerings")->fetch_assoc()['total'];
$exams_count    = $conn->query("SELECT COUNT(*) AS total FROM exams")->fetch_assoc()['total'];
$marks_count    = $conn->query("SELECT COUNT(*) AS total FROM takes")->fetch_assoc()['total'];

// STUDENTS PER COURSE
$spc_query = $conn->query("
    SELECT c.course_no AS course, COUNT(t.sid) AS total
    FROM course_offerings c
    LEFT JOIN takes t ON c.sec_no = t.sec_no
    GROUP BY c.course_no
");
$course_labels = [];
$course_data   = [];
while ($row = $spc_query->fetch_assoc()) {
    $course_labels[] = $row['course'];
    $course_data[]   = $row['total'];
}

// EXAMS PER MONTH
$exam_month_q = $conn->query("
    SELECT MONTHNAME(etime) AS month, COUNT(*) AS total
    FROM exams
    GROUP BY MONTH(etime)
    ORDER BY MONTH(etime)
");
$exam_months = [];
$exam_totals = [];
while ($row = $exam_month_q->fetch_assoc()) {
    $exam_months[] = $row['month'];
    $exam_totals[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Professional Dashboard</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: "Inter", sans-serif;
    background: linear-gradient(135deg,#4f46e5,#9333ea,#ec4899);
    background-size: 300% 300%;
    animation: bgMove 12s ease infinite;
    color: #fff;
}
@keyframes bgMove {0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%;}}

/* Sidebar */
.sidebar {
    width:250px; height:100vh;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    position: fixed; top:0; border-right:1px solid rgba(255,255,255,0.2);
    padding-top:30px;
}
.sidebar a {
    color:#fff; padding:12px 25px; display:block; text-decoration:none; font-size:17px; transition:.3s;
}
.sidebar a:hover { background: rgba(255,255,255,0.25); padding-left:35px; }

/* Navbar */
.navbar-custom { margin-left:250px; background: rgba(0,0,0,0.35); backdrop-filter: blur(12px); border-bottom:1px solid rgba(255,255,255,0.2); }

/* Main Content */
.main-content { margin-left:250px; padding:30px; }

/* Stat Cards */
.stat-card {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    border-radius:18px; padding:25px; transition:.4s; cursor:pointer;
}
.stat-card:hover { transform:translateY(-8px); box-shadow:0 0 25px rgba(255,255,255,0.45); }
.stat-icon { font-size:45px; margin-bottom:10px; }

/* Charts */
.chart-box { background: rgba(255,255,255,0.12); border-radius:15px; padding:20px; backdrop-filter:blur(12px); }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3 class="text-center fw-bold mb-4">⚡ Admin Panel</h3>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="student/view.php"><i class="bi bi-people-fill"></i> Students</a>
    <a href="course/view.php"><i class="bi bi-journal-bookmark-fill"></i> Courses</a>
    <a href="exam/view.php"><i class="bi bi-journal-check"></i> Exams</a>
    <a href="takes/view.php"><i class="bi bi-clipboard-check-fill"></i> Marks</a>
    <a href="student.php"><i class="bi bi-people-fill"></i> All Students</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Navbar -->
<nav class="navbar navbar-dark navbar-custom px-4">
    <span class="fs-4 fw-semibold">Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?></span>
</nav>

<!-- Main Content -->
<div class="main-content">
    <h2 class="fw-bold mb-4">Dashboard Overview (Real-Time)</h2>

    <!-- STAT CARDS -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card text-center"><div class="stat-icon"><i class="bi bi-people-fill"></i></div><h3><?= $students_count ?></h3><p>Students</p></div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center"><div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div><h3><?= $courses_count ?></h3><p>Courses</p></div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center"><div class="stat-icon"><i class="bi bi-journal-check"></i></div><h3><?= $exams_count ?></h3><p>Exams</p></div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center"><div class="stat-icon"><i class="bi bi-clipboard-check-fill"></i></div><h3><?= $marks_count ?></h3><p>Marks Records</p></div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="chart-box"><h5 class="mb-3">Students per Course</h5><canvas id="chartStudents"></canvas></div>
        </div>
        <div class="col-md-6">
            <div class="chart-box"><h5 class="mb-3">Exams per Month</h5><canvas id="chartExams"></canvas></div>
        </div>
    </div>

</div>

<script>
// Charts
new Chart(document.getElementById('chartStudents'), {
    type: 'bar',
    data: { labels: <?= json_encode($course_labels) ?>, datasets:[{label:"Students", data:<?= json_encode($course_data) ?>, backgroundColor:"rgba(255,255,255,0.6)"}]},
    options:{ responsive:true, scales:{ y:{ beginAtZero:true } } }
});

new Chart(document.getElementById('chartExams'), {
    type: 'line',
    data: { labels: <?= json_encode($exam_months) ?>, datasets:[{label:"Exams", data:<?= json_encode($exam_totals) ?>, borderColor:"#fff", backgroundColor:"rgba(255,255,255,0.2)", borderWidth:2, fill:true}]},
    options:{ responsive:true, scales:{ y:{ beginAtZero:true } } }
});
</script>

</body>
</html>
