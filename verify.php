<?php
require_once 'database.php';
session_start();
if(!isset($_GET['token'])){ header('Location: index.php'); exit; }
$token = $_GET['token'];
$stmt = $conn->prepare('SELECT id FROM users WHERE verify_token=? AND verified=0');
$stmt->bind_param('s', $token);
$stmt->execute();
$stmt->store_result();
if($stmt->num_rows==1){
    $stmt = $conn->prepare('UPDATE users SET verified=1, verify_token=NULL WHERE verify_token=?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $_SESSION['message']='Email verified! You can login now.';
} else {
    $_SESSION['message']='Invalid or expired token.';
}
header('Location: login.php');
