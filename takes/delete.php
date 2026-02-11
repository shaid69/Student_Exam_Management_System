<?php
require_once '../database.php';
session_start(); if(!isset($_SESSION['user_id'])) header('Location: ../login.php');
if(isset($_GET['sid']) && isset($_GET['eid'])){
  $sid = $_GET['sid']; $eid = $_GET['eid'];
  $stmt = $conn->prepare('DELETE FROM takes WHERE sid=? AND eid=?');
  $stmt->bind_param('ii',$sid,$eid); $stmt->execute();
}
header('Location: view.php');
