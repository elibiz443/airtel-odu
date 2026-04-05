<?php
declare(strict_types=1);

function db_init(PDO $pdo): void {
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(190) NOT NULL UNIQUE,
      password_hash VARCHAR(255) NOT NULL,
      created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  $pdo->exec("
    CREATE TABLE IF NOT EXISTS leads (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      ref VARCHAR(16) NOT NULL UNIQUE,
      created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      agent_type VARCHAR(64) NOT NULL,
      enterprise_cp VARCHAR(190) NOT NULL,
      agent_name VARCHAR(190) NOT NULL,
      agent_mobile_number VARCHAR(32) NOT NULL,
      lead_type VARCHAR(190) NOT NULL,
      connection_type VARCHAR(64) NOT NULL,
      full_name VARCHAR(255) NOT NULL,
      customer_phone VARCHAR(32) NOT NULL,
      customer_alt_phone VARCHAR(32) NULL,
      customer_email VARCHAR(190) NOT NULL,
      preferred_package VARCHAR(190) NOT NULL,
      preferred_date DATE NOT NULL,
      preferred_time VARCHAR(16) NOT NULL,
      nearest_landmark VARCHAR(255) NOT NULL,
      installation_town VARCHAR(190) NOT NULL,
      mapped_estate VARCHAR(190) NOT NULL,
      number_of_devices INT NOT NULL,
      ip VARCHAR(64) NULL,
      ua VARCHAR(255) NULL,
      INDEX idx_created_at (created_at),
      INDEX idx_town (installation_town),
      INDEX idx_phone (customer_phone)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");
}

function db_seed_default_user(PDO $pdo): void {
  $username = 'super_admin';
  $password = 'secure345';

  $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
  $stmt->execute([$username]);

  if ($stmt->fetch()) return;

  $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
  $hash = password_hash($password, $algo);

  if (!$hash) {
    throw new RuntimeException('password_hash failed');
  }

  $insert = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
  $insert->execute([$username, $hash]);
}
