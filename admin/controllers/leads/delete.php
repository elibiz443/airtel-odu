<?php
  declare(strict_types=1);
  require_once __DIR__ . '/../../../connector.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM leads WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: ' . ROOT_URL . '/dashboard');
    exit;
  }
?>
