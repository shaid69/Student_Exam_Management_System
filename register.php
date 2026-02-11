<?php
require_once 'database.php';
require_once 'smtp_config.php';
session_start();
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if(!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6){
        $errors[] = 'Please provide valid name, email and password (min 6 chars).';
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) $errors[] = 'Email already registered.';
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));
            $stmt = $conn->prepare('INSERT INTO users (name,email,password,verify_token,verified) VALUES (?,?,?,?,0)');
            $stmt->bind_param('ssss', $name, $email, $hash, $token);
            if($stmt->execute()){
                $verify_link = sprintf("%s/verify.php?token=%s", rtrim((isset($_SERVER['HTTPS'])? 'https':'http')."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']), '/'), $token);
                send_verification_email($email, $name, $verify_link);
                $_SESSION['message'] = 'Registration successful! Check email to verify your account.';
                header('Location: index.php'); exit;
            } else $errors[]='Database error.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="bg-gradient">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4">Create account</h3>
          <?php if($errors): ?>
            <div class="alert alert-danger"><?php echo implode('<br>', $errors);?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Full name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Register</button>
          </form>
          <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
