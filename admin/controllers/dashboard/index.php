<?php
  declare(strict_types=1);

  require_once __DIR__ . '/../../../connector.php';
  require_once __DIR__ . '/../../../auth.php';

  require_admin();

  function q(string $k): string {
    return isset($_GET[$k]) ? trim((string)$_GET[$k]) : '';
  }

  function h($s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }

  function normalize_phone(string $raw): string {
    $p = preg_replace('/\D+/', '', $raw);
    if ($p === null) return '';
    if (substr($p, 0, 3) === '254' && strlen($p) >= 12) return $p;
    if (substr($p, 0, 1) === '0' && strlen($p) === 10) return '254' . substr($p, 1);
    if (substr($p, 0, 1) === '7' && strlen($p) === 9) return '254' . $p;
    return $p;
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

  $limit = 20;
  $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
  $offset = ($page - 1) * $limit;

  $town = q('town');
  $search = q('q');
  $fromRaw = q('from');
  $toRaw = q('to');

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
    $params = array_merge($params, [$like, $like, $like, $like, $like, $like, $like, $like, $like, $like]);
  }

  $whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

  $total = (int)$pdo->query('SELECT COUNT(*) FROM leads')->fetchColumn();

  $filtered = $total;
  if ($whereSql !== '') {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM leads ' . $whereSql);
    $stmt->execute($params);
    $filtered = (int)$stmt->fetchColumn();
  }

  $totalPages = ceil($filtered / $limit);

  $stmt = $pdo->prepare('SELECT * FROM leads ' . $whereSql . ' ORDER BY created_at DESC LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset);
  $stmt->execute($params);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $towns = [
    "Bungoma","Eldoret","Garissa","Kakamega","Kilifi","Kisii","Kisumu","Kitale","Machakos","Meru","Migori","Mombasa","Nairobi","Nakuru"
  ];

  $queryParams = $_GET;
  unset($queryParams['page']);
  $baseQS = http_build_query($queryParams);

  $csvQs = http_build_query(array_merge($_GET, ['format' => 'csv']));
  $xlsQs = http_build_query(array_merge($_GET, ['format' => 'xls']));
?>
