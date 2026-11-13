<?php
require 'db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conn->prepare("INSERT INTO feedback (name,email,message) VALUES (?,?,?)");
  $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['message']);
  if ($stmt->execute()) {
    $msg = "<div class='alert alert-success'>Thank you! Your feedback was saved.</div>";
  } else {
    $msg = "<div class='alert alert-danger'>Error: " . htmlspecialchars($conn->error) . "</div>";
  }
}
$res = $conn->query("SELECT * FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CAT 2 - Feedback</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5" style="max-width:700px">
    <div class="card shadow mb-4">
      <div class="card-body">
        <h3 class="text-center mb-3">Feedback Form</h3>
        <?= $msg ?>
        <form method="POST">
          <input class="form-control mb-2" name="name" placeholder="Your name" required>
          <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
          <textarea class="form-control mb-3" name="message" rows="3" placeholder="Your feedback" required></textarea>
          <button class="btn btn-primary w-100" type="submit">Submit</button>
        </form>
      </div>
    </div>

    <h4>Submitted feedback</h4>
    <table class="table table-bordered table-striped bg-white">
      <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Message</th><th>Time</th></tr></thead>
      <tbody>
      <?php while ($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars($r['message']) ?></td>
          <td><?= $r['submitted_at'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>