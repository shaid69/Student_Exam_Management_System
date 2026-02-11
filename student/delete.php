<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(isset($_GET['sid'])){
  $sid = $_GET['sid'];
  $stmt = $conn->prepare('DELETE FROM students WHERE sid=?');
  $stmt->bind_param('i',$sid); $stmt->execute();
}
header('Location: view.php');
