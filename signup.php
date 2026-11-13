<?php
require 'db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = $_POST['username'];
  $e = $_POST['email'];
  $f = $_POST['fullname'];
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (username,email,fullname,password) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss", $u, $e, $f, $p);
  if ($stmt->execute()) {
    $msg = "<div class='alert alert-success'>Registered successfully! You can now <a href='login.php'>log in</a>.</div>";
  } else {
    $msg = "<div class='alert alert-danger'>Error: " . htmlspecialchars($conn->error) . "</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CAT 2 - Sign Up</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5" style="max-width:420px">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="text-center mb-3">Create an Account</h3>
        <?= $msg ?>
        <form method="POST">
          <input class="form-control mb-2" name="username" placeholder="Username" required>
          <input class="form-control mb-2" name="fullname" placeholder="Full name">
          <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
          <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
          <button class="btn btn-primary w-100" type="submit">Sign up</button>
        </form>
        <p class="text-center mt-3 mb-0">Already registered? <a href="login.php">Login</a></p>
      </div>
    </div>
  </div>
</body>
</html>