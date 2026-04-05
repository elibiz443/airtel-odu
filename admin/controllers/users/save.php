<?php
  declare(strict_types=1);
  require_once __DIR__ . '/../../../connector.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;

    if ($id) {
      if (!empty($password)) {
        $hash = password_hash($password, $algo);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password_hash = ? WHERE id = ?");
        $stmt->execute([$username, $hash, $id]);
      } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$username, $id]);
      }
    } else {
      $hash = password_hash($password, $algo);
      $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
      $stmt->execute([$username, $hash]);
    }

    header('Location: ' . ROOT_URL . '/dashboard/users');
    exit;
  }
?>
