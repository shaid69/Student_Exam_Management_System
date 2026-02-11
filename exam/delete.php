<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(isset($_GET['eid'])){
  $eid = $_GET['eid'];
  $stmt = $conn->prepare('DELETE FROM exams WHERE eid=?');
  $stmt->bind_param('i',$eid); $stmt->execute();
}
header('Location: view.php');
