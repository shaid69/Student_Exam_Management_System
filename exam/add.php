<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $eid=$_POST['eid']; $ename=$_POST['ename']; $eplace=$_POST['eplace']; $etime=$_POST['etime'];
  $stmt=$conn->prepare('INSERT INTO exams (eid,ename,eplace,etime) VALUES (?,?,?,?)');
  $stmt->bind_param('isss',$eid,$ename,$eplace,$etime);
  if($stmt->execute()) header('Location: view.php');
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../style.css"><title>Add Exam</title></head>
<body class="bg-gradient"><div class="container py-4"><h3 class="text-white">Add Exam</h3>
<div class="card p-3 mt-3"><form method="post">
<div class="mb-2"><label>Eid</label><input name="eid" class="form-control" required></div>
<div class="mb-2"><label>Ename</label><input name="ename" class="form-control"></div>
<div class="mb-2"><label>Eplace</label><input name="eplace" class="form-control"></div>
<div class="mb-2"><label>Etime</label><input name="etime" class="form-control"></div>
<button class="btn btn-primary">Save</button><a class="btn btn-secondary" href="view.php">Cancel</a>
</form></div></div></body></html>
