<?php
session_start();
require 'db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
  $stmt->bind_param("s", $_POST['username']);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if ($row && password_verify($_POST['password'], $row['password'])) {
    $_SESSION['user'] = $_POST['username'];
    $msg = "<div class='alert alert-success'>Welcome, " . htmlspecialchars($_SESSION['user']) . "! Login successful.</div>";
  } else {
    $msg = "<div class='alert alert-danger'>Invalid username or password.</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CAT 2 - Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5" style="max-width:420px">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="text-center mb-3">Login</h3>
        <?= $msg ?>
        <form method="POST">
          <input class="form-control mb-2" name="username" placeholder="Username" required>
          <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
          <button class="btn btn-success w-100" type="submit">Login</button>
        </form>
        <p class="text-center mt-3 mb-0">No account? <a href="signup.php">Sign up</a></p>
      </div>
    </div>
  </div>
</body>
</html>