<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $sid = $_POST['sid']; $sname = $_POST['sname']; $program = $_POST['program']; $sec_no = $_POST['sec_no'];
  $stmt = $conn->prepare('INSERT INTO students (sid,sname,program,sec_no) VALUES (?,?,?,?)');
  $stmt->bind_param('isss',$sid,$sname,$program,$sec_no);
  if($stmt->execute()) header('Location: view.php'); else $err='Failed to add.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css"><title>Add Student</title></head><body class="bg-gradient">
<div class="container py-4">
  <h3 class="text-white">Add Student</h3>
  <div class="card p-3 mt-3">
    <?php if($err) echo '<div class="alert alert-danger">'.$err.'</div>'; ?>
    <form method="post">
      <div class="mb-2"><label>Sid</label><input name="sid" class="form-control" required></div>
      <div class="mb-2"><label>Sname</label><input name="sname" class="form-control" required></div>
      <div class="mb-2"><label>Program</label><input name="program" class="form-control"></div>
      <div class="mb-2"><label>Sec_no</label><input name="sec_no" class="form-control"></div>
      <button class="btn btn-primary">Save</button>
      <a class="btn btn-secondary" href="view.php">Cancel</a>
    </form>
  </div>
</div>
</body></html>
