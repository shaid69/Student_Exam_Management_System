<?php
require_once '../database.php';
session_start(); 
if(!isset($_SESSION['user_id'])) header('Location: ../login.php');

$rows = [];
$res = $conn->query("SELECT * FROM exams");
if ($res) {
    while ($r = $res->fetch_assoc()) $rows[] = $r;
}

// Stats
$total_exams = count($rows);
$unique_places = count(array_unique(array_column($rows, "eplace")));
$unique_times = count(array_unique(array_column($rows, "etime")));
?>
<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exams</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body { background: #f4f6f9; font-family: "Inter", sans-serif; }

.page-title { font-size: 30px; font-weight: 700; color: #1e3a8a; }

.card-custom { background: #fff; border-radius: 14px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

.info-box { background: #fff; border-radius: 12px; padding: 18px; text-align: center; border: 1px solid #e5e7eb; box-shadow: 0 4px 10px rgba(0,0,0,0.04); }
.info-box h3 { color: #1e40af; font-weight: 700; }
.info-box p { margin: 0; color: #6b7280; }

.table thead th { background: #e7efff; color: #1e3a8a; border-bottom: 2px solid #c7d2fe !important; }
.table tbody tr:hover { background: #f1f5ff; }

#searchInput { border-radius: 8px; border: 1px solid #cbd5e1; }

.btn-add { background: #2563eb; border-radius: 8px; color: white; }
.btn-add:hover { background: #1e40af; }
.btn-back { border-radius: 8px; background: #e2e8f0; }
.btn-back:hover { background: #cbd5e1; }
</style>

</head>

<body>
<div class="container py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">Exams</h3>
        <div>
            <a class="btn btn-add btn-sm" href="add.php">+ Add</a>
            <a class="btn btn-back btn-sm" href="../dashboard.php">Back</a>
        </div>
    </div>

    <!-- INFO CARDS -->
    <div class="row mb-4">
        <div class="col-md-4"><div class="info-box"><h3><?= $total_exams ?></h3><p>Total Exams</p></div></div>
        <div class="col-md-4"><div class="info-box"><h3><?= $unique_places ?></h3><p>Unique Places</p></div></div>
        <div class="col-md-4"><div class="info-box"><h3><?= $unique_times ?></h3><p>Unique Times</p></div></div>
    </div>

    <!-- CHART -->
    <div class="card-custom mb-4">
        <h5 class="mb-3">Exams per Place</h5>
        <canvas id="examChart" height="120"></canvas>
    </div>

    <!-- TABLE + SEARCH -->
    <div class="card-custom">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="mt-1">Exam List</h5>
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Live Search...">
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>EID</th>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="dataTable">
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r['eid'] ?></td>
                    <td><?= $r['ename'] ?></td>
                    <td><?= $r['eplace'] ?></td>
                    <td><?= $r['etime'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="edit.php?eid=<?= $r['eid'] ?>">Edit</a>
                        <a class="btn btn-sm btn-danger" href="delete.php?eid=<?= $r['eid'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");
    rows.forEach(row => row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none");
});

// CHART
const ctx = document.getElementById("examChart");
const labels = [<?php foreach($rows as $r) echo "'".$r['eplace']."',"; ?>];
const counts = {};
labels.forEach(c => counts[c] = (counts[c] || 0) + 1);

new Chart(ctx, {
    type: "bar",
    data: { labels: Object.keys(counts), datasets: [{ label: "Exams", data: Object.values(counts), backgroundColor: "#2563eb" }] },
    options: { scales: { y: { beginAtZero: true } } }
});
</script>

</body>
</html>
