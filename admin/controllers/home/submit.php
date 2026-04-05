<?php
  declare(strict_types=1);

  function clean_phone(string $s): string {
    return preg_replace('/\D+/', '', $s);
  }

  function get_post(string $k): string {
    return isset($_POST[$k]) ? trim((string)$_POST[$k]) : '';
  }

  function bad_request(string $msg): void {
    http_response_code(400);
    $title = 'Fix';
    $back = defined('ROOT_URL') ? ROOT_URL . '/' : '/';
    echo '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title><link rel="stylesheet" href="' . htmlspecialchars((defined('ROOT_URL') ? ROOT_URL : '') . '/assets/css/output.css', ENT_QUOTES, 'UTF-8') . '"></head><body class="min-h-screen bg-zinc-700 text-white"><div class="mx-auto max-w-xl px-4 py-12"><div class="rounded-3xl border border-white/10 bg-white/5 p-6"><div class="text-sm text-white/70">Something’s missing.</div><div class="mt-2 text-lg font-semibold">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div><a class="mt-6 inline-flex items-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-zinc-950 hover:bg-white/90 transition" href="' . htmlspecialchars($back, ENT_QUOTES, 'UTF-8') . '">Back</a></div></div></body></html>';
    exit;
  }

  $connectionType = get_post('connection_type');
  $preferredPackage = get_post('preferred_package');
  $numberDevicesRaw = get_post('number_of_devices');
  $customerName = get_post('full_name');
  $customerPhone = clean_phone(get_post('customer_phone'));
  $customerAlt = clean_phone(get_post('customer_alt_phone'));
  $customerEmail = get_post('customer_email');
  $installationTown = get_post('installation_town');
  $nearestLandmark = get_post('nearest_landmark');
  $preferredDate = get_post('preferred_date');
  $preferredTime = get_post('preferred_time');
  $whatsappTo = clean_phone(get_post('whatsapp_to'));

  $numberDevices = (int)preg_replace('/\D+/', '', $numberDevicesRaw);

  $mappedEstate = get_post('mapped_estate');
  $otherEstate  = get_post('other_estate');

  if ($mappedEstate === '' && $otherEstate !== '') {
    $mappedEstate = $otherEstate;
  }

  if ($mappedEstate === '') bad_request('Mapped estate');


  if ($connectionType === '') bad_request('Type of connection');
  if ($preferredPackage === '') bad_request('Preferred package');
  if ($numberDevices <= 0) bad_request('Number of devices');
  if ($customerName === '') bad_request('Customer name');
  if ($customerPhone === '') bad_request('Customer phone');
  if ($customerEmail === '' || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) bad_request('Customer email');
  if ($installationTown === '') bad_request('Installation town');
  if ($mappedEstate === '') bad_request('Mapped estate');
  if ($nearestLandmark === '') bad_request('Nearest landmark');
  if ($preferredDate === '') bad_request('Visit date');
  if ($preferredTime === '') bad_request('Visit time');

  $agentType = 'Enterprise';
  $enterpriseCP = 'Renecy Ventures';
  $agentName = 'Godwin ndeke';
  $agentMobileNumber = '+254 103 338 353';
  $leadType = 'Confirmed';

  $ref = strtoupper(bin2hex(random_bytes(4)));
  $createdAt = gmdate('Y-m-d H:i:s');

  $data = [
    'ref' => $ref,
    'created_at' => $createdAt,
    'agent_type' => $agentType,
    'enterprise_cp' => $enterpriseCP,
    'agent_name' => $agentName,
    'agent_mobile_number' => $agentMobileNumber,
    'lead_type' => $leadType,
    'connection_type' => $connectionType,
    'full_name' => $customerName,
    'customer_phone' => $customerPhone,
    'customer_alt_phone' => $customerAlt,
    'customer_email' => $customerEmail,
    'preferred_package' => $preferredPackage,
    'preferred_date' => $preferredDate,
    'preferred_time' => $preferredTime,
    'nearest_landmark' => $nearestLandmark,
    'installation_town' => $installationTown,
    'mapped_estate' => $mappedEstate,
    'number_of_devices' => $numberDevices,
    'meta' => [
      'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
      'ua' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ]
  ];

  $ip = (string)($data['meta']['ip'] ?? '');
  $ua = (string)($data['meta']['ua'] ?? '');
  if (strlen($ua) > 255) $ua = substr($ua, 0, 255);

  if (!isset($pdo) || !($pdo instanceof PDO)) {
    throw new RuntimeException('DB connection not available');
  }

  $inserted = false;
  for ($i = 0; $i < 3; $i++) {
    try {
      $stmt = $pdo->prepare(
        'INSERT INTO leads (
          ref, created_at, agent_type, enterprise_cp,
          agent_name, agent_mobile_number, lead_type,
          connection_type, full_name, customer_phone,
          customer_alt_phone, customer_email, preferred_package,
          preferred_date, preferred_time, nearest_landmark,
          installation_town, mapped_estate, number_of_devices,
          ip, ua
        ) VALUES (
          ?, ?, ?, ?, ?,
          ?, ?, ?, ?, ?,
          ?, ?, ?, ?, ?,
          ?, ?, ?, ?, ?,
          ?
        )'
      );

      $stmt->execute([
        $ref,
        $createdAt,
        $agentType,
        $enterpriseCP,
        $agentName,
        $agentMobileNumber,
        $leadType,
        $connectionType,
        $customerName,
        $customerPhone,
        $customerAlt !== '' ? $customerAlt : null,
        $customerEmail,
        $preferredPackage,
        $preferredDate,
        $preferredTime,
        $nearestLandmark,
        $installationTown,
        $mappedEstate,
        $numberDevices,
        $ip,
        $ua
      ]);

      $inserted = true;
      break;
    } catch (Throwable $e) {
      $ref = strtoupper(bin2hex(random_bytes(4)));
      $data['ref'] = $ref;
    }
  }

  if (!$inserted) {
    bad_request('Could not save lead');
  }

  $waMsg = "Hi Airtel, please confirm my installation.\n" .
    "Ref: {$ref}\n" .
    "Name: {$customerName}\n" .
    "Phone: {$customerPhone}\n" .
    "Town: {$installationTown}\n" .
    "Estate: {$mappedEstate}\n" .
    "Landmark: {$nearestLandmark}\n" .
    "Connection: {$connectionType}\n" .
    "Package: {$preferredPackage}\n" .
    "Visit: {$preferredDate} {$preferredTime}\n" .
    "Devices: {$numberDevices}";

  $waTo = $whatsappTo !== '' ? $whatsappTo : preg_replace('/\D+/', '', getenv('AIRTEL_WA_TO') ?: '');
  $waLink = $waTo !== '' ? ('https://wa.me/' . $waTo . '?text=' . rawurlencode($waMsg)) : ('https://wa.me/?text=' . rawurlencode($waMsg));

  $leadTo = getenv('AIRTEL_LEAD_TO') ?: '';
  if ($leadTo !== '') {
    $subject = "Install request {$ref}";
    $body = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    @mail($leadTo, $subject, $body);
  }
?>
