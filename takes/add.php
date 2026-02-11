<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
$students = $conn->query('SELECT sid,sname FROM students');
$exams = $conn->query('SELECT eid,ename FROM exams');
$secs = $conn->query('SELECT sec_no FROM course_offerings');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $sid=$_POST['sid']; $eid=$_POST['eid']; $sec_no=$_POST['sec_no']; $marks=$_POST['marks'];
  $stmt = $conn->prepare('INSERT INTO takes (sid,eid,sec_no,marks) VALUES (?,?,?,?)');
  $stmt->bind_param('iiid',$sid,$eid,$sec_no,$marks);
  if($stmt->execute()) header('Location: view.php');
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../style.css"><title>Add Takes</title></head>
<body class="bg-gradient"><div class="container py-4">
  <h3 class="text-white">Record Marks</h3>
  <div class="card p-3 mt-3">
    <form method="post">
      <div class="mb-2"><label>Student</label><select class="form-control" name="sid"><?php while($r=$students->fetch_assoc()){ echo "<option value={$r['sid']}>".htmlspecialchars($r['sname'])." ({$r['sid']})</option>"; }?></select></div>
      <div class="mb-2"><label>Exam</label><select class="form-control" name="eid"><?php while($r=$exams->fetch_assoc()){ echo "<option value={$r['eid']}>".htmlspecialchars($r['ename'])." ({$r['eid']})</option>"; }?></select></div>
      <div class="mb-2"><label>Sec_no</label><select class="form-control" name="sec_no"><?php while($r=$secs->fetch_assoc()){ echo "<option value={$r['sec_no']}>".$r['sec_no']."</option>"; }?></select></div>
      <div class="mb-2"><label>Marks</label><input class="form-control" name="marks" required></div>
      <button class="btn btn-primary">Save</button>
      <a class="btn btn-secondary" href="view.php">Cancel</a>
    </form>
  </div>
</div></body></html>
