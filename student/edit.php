<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(!isset($_GET['sid'])) header('Location: view.php');
$sid = $_GET['sid'];
$stmt = $conn->prepare('SELECT sid,sname,program,sec_no FROM students WHERE sid=?');
$stmt->bind_param('i',$sid); $stmt->execute(); $res=$stmt->get_result(); $row=$res->fetch_assoc();
if(!$row) header('Location: view.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $sname=$_POST['sname']; $program=$_POST['program']; $sec_no=$_POST['sec_no'];
  $stmt = $conn->prepare('UPDATE students SET sname=?,program=?,sec_no=? WHERE sid=?');
  $stmt->bind_param('sssi',$sname,$program,$sec_no,$sid);
  if($stmt->execute()) header('Location: view.php');
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css"><title>Edit Student</title></head><body class="bg-gradient">
<div class="container py-4">
  <h3 class="text-white">Edit Student</h3>
  <div class="card p-3 mt-3">
    <form method="post">
      <div class="mb-2"><label>Sid</label><input class="form-control" value="<?=htmlspecialchars($row['sid'])?>" disabled></div>
      <div class="mb-2"><label>Sname</label><input name="sname" class="form-control" value="<?=htmlspecialchars($row['sname'])?>"></div>
      <div class="mb-2"><label>Program</label><input name="program" class="form-control" value="<?=htmlspecialchars($row['program'])?>"></div>
      <div class="mb-2"><label>Sec_no</label><input name="sec_no" class="form-control" value="<?=htmlspecialchars($row['sec_no'])?>"></div>
      <button class="btn btn-primary">Update</button>
      <a class="btn btn-secondary" href="view.php">Cancel</a>
    </form>
  </div>
</div>
</body></html>
