<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once __DIR__ . "/../data/UserRepository.php";

try {
    $repo = new UserRepository();
    $users = $repo->getAll();
} catch (Throwable $e) {
    die("Error: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registered Users</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f2f4f8; padding: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background: #1a73e8; color: #fff; }
  </style>
</head>
<body>
  <h2>Registered Users</h2>
  <table>
    <tr><th>ID</th><th>Full Name</th><th>Email</th><th>Registered At</th></tr>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u["id"] ?></td>
        <td><?= htmlspecialchars($u["full_name"]) ?></td>
        <td><?= htmlspecialchars($u["email"]) ?></td>
        <td><?= $u["created_at"] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>