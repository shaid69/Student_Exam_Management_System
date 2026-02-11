<?php
require_once 'database.php';
session_start();
if(!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Students - Admin Panel</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    font-family: "Inter", sans-serif;
    background: linear-gradient(135deg,#4f46e5,#9333ea,#ec4899);
    background-size: 300% 300%;
    animation: bgMove 12s ease infinite;
    color: #fff;
    min-height: 100vh;
    margin: 0;
}
@keyframes bgMove {0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%;}}

/* SIDEBAR */
.sidebar {
    width: 250px; height: 100vh;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    position: fixed; top: 0; border-right:1px solid rgba(255,255,255,0.2);
    padding-top: 30px;
}
.sidebar a {
    color:#fff; padding:12px 25px; display:block; text-decoration:none; font-size:17px; transition:.3s;
}
.sidebar a.active, .sidebar a:hover { background: rgba(255,255,255,0.25); padding-left:35px; }

/* TOP NAV */
.navbar-custom {
    margin-left: 250px;
    background: rgba(0,0,0,0.35);
    backdrop-filter: blur(12px);
    border-bottom:1px solid rgba(255,255,255,0.2);
}

/* MAIN CONTENT */
.main-content {
    margin-left: 250px;
    padding: 30px;
}

/* SEARCH BOX */
.search-box {
    background: rgba(255,255,255,0.12);
    border: none;
    color: #fff;
}
.search-box::placeholder { color: #ddd; }

/* GLASS TABLE */
.table-glass {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    border-radius: 20px;
    padding: 20px;
}
.table-hover tbody tr:hover { background: rgba(255,255,255,0.25); }
.table-dark th, .table-dark td { vertical-align: middle; }

/* Responsive scrollbar for table */
.table-responsive { max-height: 60vh; overflow-y: auto; }

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3 class="text-center fw-bold mb-4">⚡ Admin Panel</h3>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="students.php" class="active"><i class="bi bi-people-fill"></i> All Students</a>
    <a href="course/view.php"><i class="bi bi-journal-bookmark-fill"></i> Courses</a>
    <a href="exam/view.php"><i class="bi bi-journal-check"></i> Exams</a>
    <a href="takes/view.php"><i class="bi bi-clipboard-check-fill"></i> Marks</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- TOP NAV -->
<nav class="navbar navbar-dark navbar-custom px-4">
    <span class="fs-4 fw-semibold">Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?></span>
</nav>

<!-- MAIN CONTENT -->
<div class="main-content">
    <h2 class="fw-bold mb-4">All Students</h2>

    <!-- SEARCH BOX -->
    <input type="text" id="studentSearch" class="form-control search-box mb-3" placeholder="Search by SID, Name, or Program...">

    <!-- TABLE -->
    <div class="table-glass p-3 rounded-4 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-dark mb-0" id="studentsTable">
                <thead class="table-light text-dark">
                    <tr>
                        <th>SID</th>
                        <th>Name</th>
                        <th>Program</th>
                        <th>Sec_no</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $students = $conn->query("SELECT * FROM students ORDER BY sid ASC");
                    while($s = $students->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($s['sid']) ?></td>
                        <td><?= htmlspecialchars($s['sname']) ?></td>
                        <td><?= htmlspecialchars($s['program']) ?></td>
                        <td><?= htmlspecialchars($s['sec_no']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// LIVE SEARCH
document.getElementById('studentSearch').addEventListener('keyup', function() {
    let q = this.value.toLowerCase();
    document.querySelectorAll('#studentsTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

</body>
</html>
