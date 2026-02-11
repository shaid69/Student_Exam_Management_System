<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'student_exam';

$conn = new mysqli($host,$user,$pass,$dbname);
if($conn->connect_error) die('Connection error: '.$conn->connect_error);
$conn->set_charset('utf8mb4');
