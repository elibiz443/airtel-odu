<?php
  declare(strict_types=1);
  require_once __DIR__ . '/../../../connector.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    header('Location: ' . ROOT_URL . '/dashboard/users');
    exit;
  }
?>