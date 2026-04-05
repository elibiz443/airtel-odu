<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

require_once __DIR__ . '/config.php';

function require_admin(): void {
  if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ' . ROOT_URL . '/auth/login');
    exit;
  }
}
