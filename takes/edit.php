<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(!isset($_GET['sid']) || !isset($_GET['eid'])) header('Location: view.php');
$sid = $_GET['sid']; $eid = $_GET['eid'];
$stmt = $conn->prepare('SELECT sid,eid,sec_no,marks FROM takes WHERE sid=? AND eid=?');
$stmt->bind_param('ii',$sid,$eid); $stmt->execute(); $res=$stmt->get_result(); $row=$res->fetch_assoc();
if(!$row) header('Location: view.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $sec_no=$_POST['sec_no']; $marks=$_POST['marks'];
  $stmt = $conn->prepare('UPDATE takes SET sec_no=?,marks=? WHERE sid=? AND eid=?');
  $stmt->bind_param('iddi',$sec_no,$marks,$sid,$eid);
  if($stmt->execute()) header('Location: view.php');
}
$secs = $conn->query('SELECT sec_no FROM course_offerings');
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../style.css"><title>Edit Takes</title></head>
<body class="bg-gradient"><div class="container py-4">
  <h3 class="text-white">Edit Marks</h3>
  <div class="card p-3 mt-3">
    <form method="post">
      <div class="mb-2"><label>Sid</label><input class="form-control" value="<?=htmlspecialchars($row['sid'])?>" disabled></div>
      <div class="mb-2"><label>Eid</label><input class="form-control" value="<?=htmlspecialchars($row['eid'])?>" disabled></div>
      <div class="mb-2"><label>Sec_no</label><select name="sec_no" class="form-control"><?php while($r=$secs->fetch_assoc()){ $sel = ($r['sec_no']==$row['sec_no'])? 'selected':''; echo "<option value={$r['sec_no']} $sel>{$r['sec_no']}</option>"; } ?></select></div>
      <div class="mb-2"><label>Marks</label><input name="marks" class="form-control" value="<?=htmlspecialchars($row['marks'])?>"></div>
      <button class="btn btn-primary">Update</button><a class="btn btn-secondary" href="view.php">Cancel</a>
    </form>
  </div>
</div></body></html>
