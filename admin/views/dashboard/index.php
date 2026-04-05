<?php
  declare(strict_types=1);
  require_once __DIR__ . '/../../controllers/dashboard/index.php';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="min-h-screen bg-zinc-700 text-white">
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-700 via-zinc-800 to-zinc-950"></div>
    <div class="absolute -top-40 left-1/2 h-[40rem] w-[40rem] -translate-x-1/2 rounded-full bg-red-600/16 blur-3xl"></div>
    <div class="absolute top-24 right-[-12rem] h-[36rem] w-[36rem] rounded-full bg-cyan-400/10 blur-3xl"></div>
  </div>

  <header class="sticky top-0 z-40 border-b border-white/10 bg-zinc-900/60 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
      <div class="flex items-center gap-3">
        <div class="grid h-9 w-9 place-items-center rounded-xl bg-white/5 ring-1 ring-white/10">
          <span class="text-sm font-semibold text-red-400">A</span>
        </div>
        <div class="leading-tight">
          <div class="text-sm font-semibold tracking-wide">Admin</div>
          <div class="text-xs text-white/60">Leads</div>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <a href="<?php echo ROOT_URL; ?>/" class="hidden sm:inline-flex rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold transition hover:bg-white/10">Site</a>
        <a href="<?php echo ROOT_URL; ?>/admin/controllers/auth/logout.php" class="inline-flex rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-white/90">Logout</a>
      </div>
    </div>
  </header>

  <main class="mx-auto max-w-6xl px-4 py-8">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-xs text-white/60">Total</div>
        <div class="mt-2 text-3xl font-semibold"><?php echo $total; ?></div>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-xs text-white/60">Showing</div>
        <div class="mt-2 text-3xl font-semibold"><?php echo $filtered; ?></div>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-xs text-white/60">Export</div>
        <div class="mt-3 flex flex-wrap gap-2">
          <a href="<?php echo ROOT_URL; ?>/dashboard/export?<?php echo h($csvQs); ?>" class="inline-flex items-center rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-white/90">CSV</a>
          <a href="<?php echo ROOT_URL; ?>/dashboard/export?<?php echo h($xlsQs); ?>" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold transition hover:bg-white/10">Excel</a>
        </div>
      </div>
    </div>

    <form class="mt-5 rounded-3xl border border-white/10 bg-white/5 p-6" method="get" action="<?php echo ROOT_URL; ?>/dashboard">
      <div class="grid grid-cols-1 gap-3 md:grid-cols-12 md:items-end">
        <div class="md:col-span-3">
          <label class="text-xs text-white/60">Town</label>
          <select name="town" class="mt-1 w-full rounded-2xl border border-white/10 bg-zinc-900/60 px-4 py-3 text-sm outline-none focus:border-white/20 focus:bg-zinc-950">
            <option value="">All</option>
            <?php foreach ($towns as $t): ?>
              <option value="<?php echo h($t); ?>" <?php echo $town === $t ? 'selected' : ''; ?>><?php echo h($t); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="md:col-span-3">
          <label class="text-xs text-white/60">Search</label>
          <input name="q" value="<?php echo h($search); ?>" class="mt-1 w-full rounded-2xl border border-white/10 bg-zinc-900/60 px-4 py-3 text-sm outline-none placeholder:text-white/30 focus:border-white/20 focus:bg-zinc-900" placeholder="Ref / phone / estate">
        </div>

        <div class="md:col-span-3">
          <label class="text-xs text-white/60">From (ISO)</label>
          <input name="from" value="<?php echo h($fromRaw); ?>" class="mt-1 w-full rounded-2xl border border-white/10 bg-zinc-900/60 px-4 py-3 text-sm outline-none placeholder:text-white/30 focus:border-white/20 focus:bg-zinc-950" placeholder="2026-02-01T00:00:00Z">
        </div>

        <div class="md:col-span-3">
          <label class="text-xs text-white/60">To (ISO)</label>
          <input name="to" value="<?php echo h($toRaw); ?>" class="mt-1 w-full rounded-2xl border border-white/10 bg-zinc-900/60 px-4 py-3 text-sm outline-none placeholder:text-white/30 focus:border-white/20 focus:bg-zinc-950" placeholder="2026-02-28T23:59:59Z">
        </div>

        <div class="md:col-span-12 flex flex-wrap gap-2 pt-2">
          <button class="inline-flex items-center rounded-2xl bg-red-600/90 px-5 py-3 text-sm font-semibold transition hover:bg-red-600" type="submit">Filter</button>
          <a href="<?php echo ROOT_URL; ?>/dashboard" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold transition hover:bg-white/10">Reset</a>
        </div>
      </div>
    </form>

    <div class="mt-5 overflow-hidden rounded-3xl border border-white/10 bg-white/5">
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-white/5 text-left text-xs text-white/60">
            <tr>
              <th class="px-4 py-3">Ref</th>
              <th class="px-4 py-3">Created</th>
              <th class="px-4 py-3">Agent Type</th>
              <th class="px-4 py-3">Enterprise CP</th>
              <th class="px-4 py-3">Agent Name</th>
              <th class="px-4 py-3">Agent Mobile</th>
              <th class="px-4 py-3">Lead Type</th>
              <th class="px-4 py-3">Connection</th>
              <th class="px-4 py-3">Customer Name</th>
              <th class="px-4 py-3">Customer Phone</th>
              <th class="px-4 py-3">Alt Phone</th>
              <th class="px-4 py-3">Email</th>
              <th class="px-4 py-3">Visit Date</th>
              <th class="px-4 py-3">Visit Time</th>
              <th class="px-4 py-3">Landmark</th>
              <th class="px-4 py-3">Town</th>
              <th class="px-4 py-3">Estate</th>
              <th class="px-4 py-3">Devices</th>
              <th class="px-4 py-3">WhatsApp</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/10">
            <?php foreach ($rows as $r): ?>
              <?php
                $ref = (string)($r['ref'] ?? '');
                $fullName = (string)($r['full_name'] ?? '');
                $phone = normalize_phone((string)($r['customer_phone'] ?? ''));
                $altPhone = normalize_phone((string)($r['customer_alt_phone'] ?? ''));
                $pkg = (string)($r['preferred_package'] ?? '');
                $waMsg =
                  'Ref: ' . $ref . "\n" .
                  'Customer name: ' . $fullName . "\n" .
                  'Customer phone: ' . $phone . "\n" .
                  'Alt phone: ' . $altPhone . "\n" .
                  'Email: ' . (string)($r['customer_email'] ?? '') . "\n" .
                  'Town: ' . (string)($r['installation_town'] ?? '') . "\n" .
                  'Estate: ' . (string)($r['mapped_estate'] ?? '') . "\n" .
                  'Landmark: ' . (string)($r['nearest_landmark'] ?? '') . "\n" .
                  'Connection: ' . (string)($r['connection_type'] ?? '') . "\n" .
                  'Package: ' . $pkg . "\n" .
                  'Visit: ' . (string)($r['preferred_date'] ?? '') . ' ' . (string)($r['preferred_time'] ?? '') . "\n" .
                  'Devices: ' . (string)($r['number_of_devices'] ?? '');
                $waLink = $phone !== '' ? ('https://wa.me/' . $phone . '?text=' . rawurlencode($waMsg)) : '';
              ?>
              <tr class="transition hover:bg-white/5">
                <td class="px-4 py-3 font-semibold"><?php echo h($ref); ?></td>
                <td class="px-4 py-3 text-white/70"><?php echo h($r['created_at'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['agent_type'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['enterprise_cp'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['agent_name'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['agent_mobile_number'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['lead_type'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['connection_type'] ?? ''); ?></td>
                <td class="px-4 py-3 text-white/80"><?php echo h($fullName); ?></td>
                <td class="px-4 py-3 text-white/80"><?php echo h($phone); ?></td>
                <td class="px-4 py-3 text-white/80"><?php echo h($altPhone); ?></td>
                <td class="px-4 py-3"><?php echo h($r['customer_email'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['preferred_date'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['preferred_time'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['nearest_landmark'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['installation_town'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['mapped_estate'] ?? ''); ?></td>
                <td class="px-4 py-3"><?php echo h($r['number_of_devices'] ?? ''); ?></td>
                <td class="px-4 py-3">
                  <?php if ($waLink !== ''): ?>
                    <a class="inline-flex items-center rounded-2xl bg-green-500/90 px-3 py-2 text-xs font-semibold text-zinc-950 transition hover:bg-green-500" href="<?php echo h($waLink); ?>" target="_blank" rel="noreferrer">Chat</a>
                  <?php else: ?>
                    <span class="text-xs text-white/40">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (count($rows) === 0): ?>
              <tr>
                <td colspan="21" class="px-4 py-10 text-center text-sm text-white/60">No leads</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
