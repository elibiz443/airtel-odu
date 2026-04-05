<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../connector.php';

$err = '';

if (!isset($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
  header('Location: ' . ROOT_URL . '/dashboard');
  exit;
}

$maxAttempts = 6;
$windowSec = 600;
$lockSec = 600;
$now = time();

if (!isset($_SESSION['login_attempts']) || !is_array($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = ['count' => 0, 'first' => $now, 'lock_until' => 0];
}

$attempts = &$_SESSION['login_attempts'];
if ($attempts['lock_until'] > $now) {
  $err = 'Too many attempts. Try again later.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $err === '') {
  $csrf = isset($_POST['csrf']) ? (string)$_POST['csrf'] : '';
  if (!hash_equals((string)$_SESSION['csrf'], $csrf)) {
    $err = 'Wrong login';
  } else {
    if (($now - (int)$attempts['first']) > $windowSec) {
      $attempts['count'] = 0;
      $attempts['first'] = $now;
    }

    $u = isset($_POST['user']) ? trim((string)$_POST['user']) : '';
    $p = isset($_POST['pass']) ? (string)$_POST['pass'] : '';

    if ($u === '' || $p === '') {
      $err = 'Wrong login';
    } else {
      $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1');
      $stmt->execute([$u]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row && password_verify($p, (string)$row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['admin_user'] = (string)$row['username'];
        $_SESSION['admin_user_id'] = (int)$row['id'];
        unset($_SESSION['login_attempts']);
        header('Location: ' . ROOT_URL . '/dashboard');
        exit;
      }

      $attempts['count'] = (int)$attempts['count'] + 1;
      if ((int)$attempts['count'] >= $maxAttempts) {
        $attempts['lock_until'] = $now + $lockSec;
      }
      $err = 'Wrong login';
    }
  }
}
?>
