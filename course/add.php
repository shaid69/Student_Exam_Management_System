<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $sec_no=$_POST['sec_no']; $time=$_POST['time']; $room=$_POST['room']; $course_no=$_POST['course_no']; $semester=$_POST['semester']; $year=$_POST['year'];
  $stmt=$conn->prepare('INSERT INTO course_offerings (sec_no,time,room,course_no,semester,year) VALUES (?,?,?,?,?,?)');
  $stmt->bind_param('isssis',$sec_no,$time,$room,$course_no,$semester,$year);
  if($stmt->execute()) header('Location: view.php');
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../style.css">
<title>Add Course Offering</title></head><body class="bg-gradient">
<div class="container py-4"><h3 class="text-white">Add Course Offering</h3>
<div class="card p-3 mt-3"><form method="post">
<div class="mb-2"><label>Sec_no</label><input name="sec_no" class="form-control" required></div>
<div class="mb-2"><label>Time</label><input name="time" class="form-control"></div>
<div class="mb-2"><label>Room</label><input name="room" class="form-control"></div>
<div class="mb-2"><label>Course_no</label><input name="course_no" class="form-control"></div>
<div class="mb-2"><label>Semester</label><input name="semester" class="form-control"></div>
<div class="mb-2"><label>Year</label><input name="year" class="form-control"></div>
<button class="btn btn-primary">Save</button>
<a class="btn btn-secondary" href="view.php">Cancel</a>
</form></div></div></body></html>
