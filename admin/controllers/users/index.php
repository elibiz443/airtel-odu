<?php
  declare(strict_types=1);

  require_once __DIR__ . '/../../../connector.php';

  $users = [];
  $editUser = null;

  $stmt = $pdo->prepare("SELECT id, username, created_at FROM users ORDER BY created_at DESC");
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  function h(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }
?>
