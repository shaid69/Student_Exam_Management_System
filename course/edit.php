<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(!isset($_GET['sec_no'])) header('Location: view.php');
$sec_no = $_GET['sec_no'];
$stmt = $conn->prepare('SELECT sec_no,time,room,course_no,semester,year FROM course_offerings WHERE sec_no=?');
$stmt->bind_param('i',$sec_no); $stmt->execute(); $res=$stmt->get_result(); $row=$res->fetch_assoc();
if(!$row) header('Location: view.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $time=$_POST['time']; $room=$_POST['room']; $course_no=$_POST['course_no']; $semester=$_POST['semester']; $year=$_POST['year'];
  $stmt = $conn->prepare('UPDATE course_offerings SET time=?,room=?,course_no=?,semester=?,year=? WHERE sec_no=?');
  $stmt->bind_param('ssssii',$time,$room,$course_no,$semester,$year,$sec_no);
  if($stmt->execute()) header('Location: view.php');
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../style.css"><title>Edit Course</title></head>
<body class="bg-gradient"><div class="container py-4"><h3 class="text-white">Edit Course Offering</h3>
<div class="card p-3 mt-3"><form method="post">
<div class="mb-2"><label>Sec_no</label><input class="form-control" value="<?=htmlspecialchars($row['sec_no'])?>" disabled></div>
<div class="mb-2"><label>Time</label><input name="time" class="form-control" value="<?=htmlspecialchars($row['time'])?>"></div>
<div class="mb-2"><label>Room</label><input name="room" class="form-control" value="<?=htmlspecialchars($row['room'])?>"></div>
<div class="mb-2"><label>Course_no</label><input name="course_no" class="form-control" value="<?=htmlspecialchars($row['course_no'])?>"></div>
<div class="mb-2"><label>Semester</label><input name="semester" class="form-control" value="<?=htmlspecialchars($row['semester'])?>"></div>
<div class="mb-2"><label>Year</label><input name="year" class="form-control" value="<?=htmlspecialchars($row['year'])?>"></div>
<button class="btn btn-primary">Update</button>
<a class="btn btn-secondary" href="view.php">Cancel</a>
</form></div></div></body></html>
