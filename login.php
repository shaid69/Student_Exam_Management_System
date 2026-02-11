<?php
require_once 'database.php';
session_start();
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT id,name,password,verified FROM users WHERE email=?');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->bind_result($id,$name,$hash,$verified);
    if($stmt->fetch()){
        if(!$verified){ $errors[]='Email not verified.'; }
        elseif(password_verify($password,$hash)){
            $_SESSION['user_id']=$id; $_SESSION['user_name']=$name; header('Location: dashboard.php'); exit;
        } else $errors[]='Invalid credentials.';
    } else $errors[]='Invalid credentials.';
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="bg-gradient">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4">Login</h3>
          <?php if(!empty($_SESSION['message'])){ echo '<div class="alert alert-info">'.$_SESSION['message'].'</div>'; unset($_SESSION['message']); }
          if($errors) echo '<div class="alert alert-danger">'.implode('<br>',$errors).'</div>';?>

          <form method="post">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Login</button>
          </form>
          <p class="mt-3 text-center">Don't have account? <a href="register.php">Register</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
