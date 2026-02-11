<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(isset($_GET['sec_no'])){
  $sec_no = $_GET['sec_no'];
  $stmt = $conn->prepare('DELETE FROM course_offerings WHERE sec_no=?');
  $stmt->bind_param('i',$sec_no); $stmt->execute();
}
header('Location: view.php');
