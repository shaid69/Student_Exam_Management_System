<?php
session_start();
if (isset($_SESSION['user_id'])) header('Location: dashboard.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Exam Management</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    /* ===============================
       PROFESSIONAL LANDING THEME
       =============================== */

    body {
      background: linear-gradient(135deg, #0d1117, #111827, #0d1b2a);
      background-size: 300% 300%;
      animation: bgMove 14s ease infinite;
      min-height: 100vh;
      color: #e5e7eb;
      font-family: "Inter", sans-serif;
    }

    @keyframes bgMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* NAVBAR */
    .navbar {
      background: rgba(17, 24, 39, 0.7) !important;
      backdrop-filter: blur(8px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .navbar-brand {
      font-weight: 700;
      color: #60a5fa !important;
    }

    /* HERO SECTION */
    .hero {
      padding: 120px 20px;
      text-align: center;
    }

    .hero h1 {
      font-weight: 800;
      font-size: 3rem;
      color: #f3f4f6;
    }

    .hero p {
      font-size: 1.2rem;
      color: #9ca3af;
      max-width: 600px;
      margin: auto;
    }

    /* CTA BUTTONS */
    .btn-primary-custom {
      background: #2563eb;
      padding: 12px 28px;
      border-radius: 10px;
      border: none;
      font-size: 1.1rem;
      transition: 0.3s;
    }

    .btn-primary-custom:hover {
      background: #1d4ed8;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    }

    .btn-outline-light-custom {
      border: 1px solid rgba(255, 255, 255, 0.4);
      padding: 10px 24px;
      border-radius: 10px;
      color: #e5e7eb;
      transition: 0.3s;
    }

    .btn-outline-light-custom:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-3px);
    }

    /* FEATURES SECTION */
    .feature-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 14px;
      padding: 25px;
      text-align: center;
      transition: 0.3s;
      color: #e5e7eb;
    }

    .feature-card:hover {
      transform: translateY(-6px);
      border-color: #3b82f6;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .feature-card i {
      font-size: 45px;
      margin-bottom: 10px;
      color: #3b82f6;
    }

  </style>

</head>

<body>

  <!-- NAV -->
  <nav class="navbar navbar-expand-lg navbar-dark py-3">
    <div class="container">
      <a class="navbar-brand" href="#">Student Exam Management</a>

      <div class="d-flex">
        <a class="btn btn-outline-light-custom me-2" href="login.php">Login</a>
        <a class="btn btn-primary-custom" href="register.php">Register</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header class="hero">
    <h1>Effortless Student & Exam Management</h1>
    <p>Track students, manage courses, schedule exams, and record marks — all in one powerful and modern system.</p>
    <a href="register.php" class="btn btn-primary-custom mt-3">Get Started</a>
  </header>

  <!-- FEATURES -->
  <section class="container py-5">
    <div class="row g-4 justify-content-center">

      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-people-fill"></i>
          <h4 class="fw-bold">Manage Students</h4>
          <p>Organize student profiles, details, and academic records.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-journal-bookmark-fill"></i>
          <h4 class="fw-bold">Course Management</h4>
          <p>Create, update, and manage course offerings easily.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-journal-check"></i>
          <h4 class="fw-bold">Exam Scheduling</h4>
          <p>Host exams, record marks, and monitor performance.</p>
        </div>
      </div>

    </div>
  </section>

</body>

</html>
