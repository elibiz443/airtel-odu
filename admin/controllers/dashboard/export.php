<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../connector.php';
require_once __DIR__ . '/../../../auth.php';

require_admin();

function q(string $k): string {
  return isset($_GET[$k]) ? trim((string)$_GET[$k]) : '';
}

function parse_dt(string $raw): ?string {
  if ($raw === '') return null;
  try {
    $dt = new DateTimeImmutable($raw);
  } catch (Throwable $e) {
    $clean = str_replace('T', ' ', $raw);
    try {
      $dt = new DateTimeImmutable($clean);
    } catch (Throwable $e2) {
      return null;
    }
  }
  $tz = new DateTimeZone('UTC');
  return $dt->setTimezone($tz)->format('Y-m-d H:i:s');
}

$town = q('town');
$search = q('q');
$fromRaw = q('from');
$toRaw = q('to');
$format = strtolower(q('format')) ?: 'csv';

$from = parse_dt($fromRaw);
$to = parse_dt($toRaw);

$where = [];
$params = [];

if ($town !== '') {
  $where[] = 'installation_town = ?';
  $params[] = $town;
}

if ($from !== null) {
  $where[] = 'created_at >= ?';
  $params[] = $from;
}

if ($to !== null) {
  $where[] = 'created_at <= ?';
  $params[] = $to;
}

if ($search !== '') {
  $like = '%' . $search . '%';
  $where[] = '(' .
    'ref LIKE ? OR full_name LIKE ? OR customer_phone LIKE ? OR customer_alt_phone LIKE ? OR customer_email LIKE ? OR ' .
    'mapped_estate LIKE ? OR nearest_landmark LIKE ? OR installation_town LIKE ? OR ' .
    'agent_name LIKE ? OR agent_mobile_number LIKE ?' .
  ')';
  $params = array_merge($params, [$like,$like,$like,$like,$like,$like,$like,$like,$like]);
}

$whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

$stmt = $pdo->prepare('SELECT * FROM leads ' . $whereSql . ' ORDER BY created_at DESC');
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$headers = [
  'Ref',
  'Created At',
  'Agent Type',
  'Enterprise CP',
  'Agent Name',
  'Agent Mobile Number',
  'Type of Lead',
  'Type of Connection',
  'Customer Name',
  'Customer Phone No (Airtel Number)',
  'Customer Alternative Number',
  'Customer Email Address',
  'Customer Preferred Package + Installation Fee',
  'Preferred Date',
  'Preferred Time of Visit',
  'Specific Delivery Location (Nearest Landmark)',
  'Customer Installation Town',
  'Customer Mapped Estate',
  'Number of Devices'
];

function row_out(array $r): array {
  $pkg = (string)($r['preferred_package'] ?? '');
  $pkgPlus = $pkg;

  return [
    (string)($r['ref'] ?? ''),
    (string)($r['created_at'] ?? ''),
    (string)($r['agent_type'] ?? ''),
    (string)($r['enterprise_cp'] ?? ''),
    (string)($r['agent_name'] ?? ''),
    (string)($r['agent_mobile_number'] ?? ''),
    (string)($r['lead_type'] ?? ''),
    (string)($r['connection_type'] ?? ''),
    (string)($r['full_name'] ?? ''),
    (string)($r['customer_phone'] ?? ''),
    (string)($r['customer_alt_phone'] ?? ''),
    (string)($r['customer_email'] ?? ''),
    $pkgPlus,
    (string)($r['preferred_date'] ?? ''),
    (string)($r['preferred_time'] ?? ''),
    (string)($r['nearest_landmark'] ?? ''),
    (string)($r['installation_town'] ?? ''),
    (string)($r['mapped_estate'] ?? ''),
    (string)($r['number_of_devices'] ?? '')
  ];
}

$filename = 'leads_' . gmdate('Ymd_His');

if ($format === 'xls') {
  header('Content-Type: application/vnd.ms-excel; charset=utf-8');
  header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
  echo '<table border="1">';
  echo '<tr>';
  foreach ($headers as $h) echo '<th>' . htmlspecialchars($h, ENT_QUOTES, 'UTF-8') . '</th>';
  echo '</tr>';
  foreach ($rows as $r) {
    echo '<tr>';
    foreach (row_out($r) as $v) echo '<td>' . htmlspecialchars($v, ENT_QUOTES, 'UTF-8') . '</td>';
    echo '</tr>';
  }
  echo '</table>';
  exit;
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

$fp = fopen('php://output', 'w');
fputcsv($fp, $headers);
foreach ($rows as $r) {
  fputcsv($fp, row_out($r));
}
fclose($fp);
exit;
