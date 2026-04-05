<?php
declare(strict_types=1);

$hostName = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
$hostName = preg_replace('/:\d+$/', '', $hostName);
$isLocal = in_array($hostName, ['localhost', '127.0.0.1'], true);

if (!defined('ROOT_URL')) {
  define('ROOT_URL', $isLocal ? 'http://localhost/airtel-odu' : 'https://airtelodu.com');
}

if (!defined('ROOT_PATH')) {
  define('ROOT_PATH', $isLocal ? ($_SERVER['DOCUMENT_ROOT'] . '/airtel-odu') : dirname(__FILE__));
}

if ($isLocal) {
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'airtelodu_db');
  define('DB_USER', 'root');
  define('DB_PASS', '');
} else {
  define('DB_HOST', 'localhost');
  define('DB_NAME', '');
  define('DB_USER', '');
  define('DB_PASS', '');
}
