<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(!isset($_GET['eid'])) header('Location: view.php');
$eid = $_GET['eid'];
$stmt = $conn->prepare('SELECT eid,ename,eplace,etime FROM exams WHERE eid=?');
$stmt->bind_param('i',$eid); $stmt->execute(); $res=$stmt->get_result(); $row=$res->fetch_assoc();
if(!$row) header('Location: view.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $ename=$_POST['ename']; $eplace=$_POST['eplace']; $etime=$_POST['etime'];
  $stmt = $conn->prepare('UPDATE exams SET ename=?,eplace=?,etime=? WHERE eid=?');
  $stmt->bind_param('sssi',$ename,$eplace,$etime,$eid);
  if($stmt->execute()) header('Location: view.php');
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../style.css"><title>Edit Exam</title></head>
<body class="bg-gradient"><div class="container py-4"><h3 class="text-white">Edit Exam</h3>
<div class="card p-3 mt-3"><form method="post">
<div class="mb-2"><label>Eid</label><input class="form-control" value="<?=htmlspecialchars($row['eid'])?>" disabled></div>
<div class="mb-2"><label>Ename</label><input name="ename" class="form-control" value="<?=htmlspecialchars($row['ename'])?>"></div>
<div class="mb-2"><label>Eplace</label><input name="eplace" class="form-control" value="<?=htmlspecialchars($row['eplace'])?>"></div>
<div class="mb-2"><label>Etime</label><input name="etime" class="form-control" value="<?=htmlspecialchars($row['etime'])?>"></div>
<button class="btn btn-primary">Update</button><a class="btn btn-secondary" href="view.php">Cancel</a>
</form></div></div></body></html>
