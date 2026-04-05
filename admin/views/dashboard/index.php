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
    <div class="absolute -top-40 left-1/2 h-[40rem] w-[40rem] -translate-x-1/2 rounded-full bg-red-600/10 blur-3xl"></div>
    <div class="absolute top-24 right-[-12rem] h-[36rem] w-[36rem] rounded-full bg-cyan-400/5 blur-3xl"></div>
  </div>

  <header class="sticky top-0 z-40 border-b border-white/10 bg-zinc-900/60 backdrop-blur">
    <div class="w-[90%] mx-auto flex items-center justify-between py-3">
      <div class="flex items-center gap-3">
        <div class="grid h-9 w-9 place-items-center rounded-xl bg-white/5 ring-1 ring-white/10">
          <span class="text-sm font-semibold text-red-400">A</span>
        </div>
        <div class="leading-tight">
          <div class="text-sm font-semibold tracking-wide">Admin</div>
          <div class="text-xs text-white/60">Leads Management</div>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <a href="<?php echo ROOT_URL; ?>/dashboard/users" class="inline-flex items-center gap-2 rounded-2xl bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-500 shadow-lg shadow-red-600/20">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
          Add/Edit User
        </a>
        <a href="<?php echo ROOT_URL; ?>/admin/controllers/auth/logout.php" class="inline-flex rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-white/90">Logout</a>
      </div>
    </div>
  </header>

  <main class="w-[90%] mx-auto flex-grow py-8 min-h-screen">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
        <div class="text-[10px] font-black uppercase tracking-widest text-white/40">Total Pipeline</div>
        <div class="mt-2 text-4xl font-black text-white"><?php echo $total; ?></div>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
        <div class="text-[10px] font-black uppercase tracking-widest text-white/40">Filtered Results</div>
        <div class="mt-2 text-4xl font-black text-red-500"><?php echo $filtered; ?></div>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
        <div class="text-[10px] font-black uppercase tracking-widest text-white/40">Data Export</div>
        <div class="mt-3 flex gap-2">
          <a href="<?php echo ROOT_URL; ?>/dashboard/export?<?php echo h($csvQs); ?>" class="flex-1 text-center rounded-xl bg-white py-2 text-xs font-black text-zinc-950 uppercase tracking-tighter transition hover:bg-zinc-200">CSV</a>
          <a href="<?php echo ROOT_URL; ?>/dashboard/export?<?php echo h($xlsQs); ?>" class="flex-1 text-center rounded-xl border border-white/10 bg-white/5 py-2 text-xs font-black text-white uppercase tracking-tighter transition hover:bg-white/10">Excel</a>
        </div>
      </div>
    </div>

    <form class="mt-8 rounded-[2.5rem] border border-white/10 bg-white/5 p-8" method="get" action="<?php echo ROOT_URL; ?>/dashboard">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-12 md:items-end">
        <div class="md:col-span-3">
          <label class="text-[10px] font-black uppercase tracking-widest text-white/40 ml-1">Installation Town</label>
          <select name="town" class="mt-2 w-full rounded-2xl border border-white/10 bg-zinc-900/80 px-4 py-3 text-sm text-white outline-none focus:border-red-500/50 transition-all">
            <option value="">All Regions</option>
            <?php foreach ($towns as $t): ?>
              <option value="<?php echo h($t); ?>" <?php echo $town === $t ? 'selected' : ''; ?>><?php echo h($t); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="md:col-span-4">
          <label class="text-[10px] font-black uppercase tracking-widest text-white/40 ml-1">Search Keywords</label>
          <input name="q" value="<?php echo h($search); ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-zinc-900/80 px-4 py-3 text-sm text-white outline-none placeholder:text-white/20 focus:border-red-500/50 transition-all" placeholder="Ref, phone or estate...">
        </div>
        <div class="md:col-span-5 flex gap-2">
          <button class="flex-1 rounded-2xl bg-red-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white transition hover:bg-red-500" type="submit">Apply Filters</button>
          <a href="<?php echo ROOT_URL; ?>/dashboard" class="rounded-2xl border border-white/10 bg-white/5 px-6 py-3 text-sm font-black uppercase tracking-widest text-white transition hover:bg-white/10">Reset</a>
        </div>
      </div>
    </form>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <?php foreach ($rows as $r): ?>
        <?php
          $ref = (string)($r['ref'] ?? '');
          $fullName = (string)($r['full_name'] ?? '');
          $phone = normalize_phone((string)($r['customer_phone'] ?? ''));
          $altPhone = !empty($r['customer_alt_phone']) ? normalize_phone((string)$r['customer_alt_phone']) : null;
          $pkg = (string)($r['preferred_package'] ?? '');
          
          $waMsg = "Ref: $ref\nName: $fullName\nPhone: $phone\nTown: ".($r['installation_town'] ?? '')."\nPackage: $pkg";
          $waLink = $phone !== '' ? ('https://wa.me/' . $phone . '?text=' . rawurlencode($waMsg)) : '#';
        ?>
        <div class="group relative rounded-[2.5rem] border border-white/10 bg-white/5 p-8 transition-all hover:bg-white/[0.08] hover:shadow-2xl hover:shadow-red-600/10">
          
          <div class="flex items-start justify-between border-b border-white/5 pb-6">
            <div class="flex items-center gap-5">
              <div class="h-14 w-14 rounded-2xl bg-red-600/20 flex items-center justify-center border border-red-600/30">
                <span class="text-xl font-black text-red-500"><?php echo strtoupper(substr($fullName, 0, 1)); ?></span>
              </div>
              <div>
                <div class="flex items-center gap-2">
                  <h3 class="text-xl font-black tracking-tight text-white"><?php echo h($fullName); ?></h3>
                  <span class="rounded-lg bg-green-600/10 px-2 py-0.5 text-[10px] font-black uppercase text-green-500 border border-green-600/20"><?php echo h($r['lead_type'] ?? 'General'); ?></span>
                </div>
                <p class="text-xs font-bold text-white/40 uppercase tracking-widest mt-1">
                  Ref: <span class="text-white/70"><?php echo h($ref); ?></span> • 
                  <span class="text-white/70"><?php echo h($r['created_at'] ?? ''); ?></span>
                </p>
              </div>
            </div>
            <form action="<?php echo ROOT_URL; ?>/admin/controllers/leads/delete.php" method="post" onsubmit="return confirm('Permanently delete this lead?')">
              <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
              <button type="submit" class="cursor-pointer p-3 rounded-2xl bg-white/5 hover:bg-red-500/20 text-white/40 hover:text-red-500 transition-all border border-transparent hover:border-red-500/30">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5"/></svg>
              </button>
            </form>
          </div>

          <div class="grid grid-cols-2 gap-x-8 gap-y-6 pt-8">
            
            <div class="space-y-4">
              <div>
                <span class="block text-[10px] font-black uppercase tracking-widest text-white/30 mb-1">Primary Contact</span>
                <p class="font-bold text-white/90"><?php echo h($phone); ?></p>
                <p class="text-xs text-white/50"><?php echo h($r['customer_email'] ?? 'No Email'); ?></p>
              </div>
              <?php if ($altPhone): ?>
              <div>
                <span class="block text-[10px] font-black uppercase tracking-widest text-white/30 mb-1">Alternative Phone</span>
                <p class="font-bold text-white/70 text-sm"><?php echo h($altPhone); ?></p>
              </div>
              <?php endif; ?>
            </div>

            <div class="space-y-4">
              <div>
                <span class="block text-[10px] font-black uppercase tracking-widest text-white/30 mb-1">Installation Site</span>
                <p class="font-bold text-white/90"><?php echo h($r['installation_town'] ?? ''); ?></p>
                <p class="text-xs text-white/50"><?php echo h($r['mapped_estate'] ?? ''); ?></p>
              </div>
              <div>
                <span class="block text-[10px] font-black uppercase tracking-widest text-white/30 mb-1">Nearest Landmark</span>
                <p class="text-xs font-bold text-white/70 italic">"<?php echo h($r['nearest_landmark'] ?? 'Not specified'); ?>"</p>
              </div>
            </div>

            <div class="space-y-4 border-t border-white/5 pt-4">
              <div>
                <span class="block text-[10px] font-black uppercase tracking-widest text-white/30 mb-1">Package & Capacity</span>
                <p class="font-bold text-red-500 uppercase tracking-tight"><?php echo h($pkg); ?></p>
                <p class="text-xs font-bold text-white/60"><?php echo h($r['connection_type'] ?? ''); ?> • <?php echo (int)($r['number_of_devices'] ?? 1); ?> Devices</p>
              </div>
            </div>

            <div class="space-y-4 border-t border-white/5 pt-4">
              <div>
                <span class="block text-[10px] font-black uppercase tracking-widest text-white/30 mb-1">Preferred Timing</span>
                <p class="font-bold text-white/90"><?php echo date('D, jS M Y', strtotime($r['preferred_date'])); ?></p>
                <p class="text-xs font-bold text-white/60 uppercase"><?php echo h($r['preferred_time'] ?? ''); ?></p>
              </div>
            </div>

            <div class="col-span-2 rounded-2xl bg-zinc-900/50 p-4 border border-white/5">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <span class="block text-[10px] font-black uppercase tracking-widest text-white/20 mb-1">Originating Agent</span>
                  <p class="text-sm font-bold text-white/80"><?php echo h($r['agent_name'] ?? 'N/A'); ?></p>
                  <p class="text-[10px] text-white/40"><?php echo h($r['agent_mobile_number'] ?? ''); ?></p>
                </div>
                <div class="text-right">
                  <span class="block text-[10px] font-black uppercase tracking-widest text-white/20 mb-1">Enterprise Partner</span>
                  <p class="text-sm font-bold text-cyan-500"><?php echo h($r['enterprise_cp'] ?? 'Standard'); ?></p>
                  <p class="text-[10px] text-white/40 uppercase"><?php echo h($r['agent_type'] ?? ''); ?></p>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8 flex items-center justify-between border-t border-white/5 pt-6">
            <div></div>
            
            <a href="<?php echo h($waLink); ?>" target="_blank" class="group/btn inline-flex items-center gap-3 rounded-2xl bg-emerald-500 px-6 py-3 text-xs font-black uppercase tracking-widest text-zinc-950 transition-all hover:bg-emerald-400 hover:scale-105 active:scale-95 shadow-xl shadow-emerald-500/20">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.63 1.432h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
              Contact Lead
            </a>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if ($totalPages > 1): ?>
        <div class="mt-12 flex items-center justify-center gap-2 pb-10">
          <?php if ($page > 1): ?>
            <a href="?<?php echo $baseQS; ?>&page=<?php echo $page - 1; ?>" class="group flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 transition hover:bg-red-600">
              <svg class="h-5 w-5 text-white/50 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
          <?php endif; ?>

          <div class="flex items-center gap-2 rounded-[2rem] border border-white/10 bg-zinc-900/50 p-1.5 backdrop-blur-md">
            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);

            for ($i = $start; $i <= $end; $i++): ?>
              <a href="?<?php echo $baseQS; ?>&page=<?php echo $i; ?>" class="flex h-10 min-w-[2.5rem] items-center justify-center px-3 rounded-xl text-xs font-black uppercase tracking-tighter transition-all <?php echo $i === $page ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'text-white/40 hover:bg-white/5 hover:text-white'; ?>">
                <?php echo $i; ?>
              </a>
            <?php endfor; ?>
          </div>

          <?php if ($page < $totalPages): ?>
            <a href="?<?php echo $baseQS; ?>&page=<?php echo $page + 1; ?>" class="group flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 transition hover:bg-red-600">
              <svg class="h-5 w-5 text-white/50 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (count($rows) === 0): ?>
      <div class="mt-20 text-center">
        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-white/5 border border-white/10 mb-6">
          <svg class="h-10 w-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="2"/></svg>
        </div>
        <h3 class="text-xl font-black text-white uppercase tracking-tighter">No Leads Found</h3>
        <p class="mt-2 text-white/40 text-sm">Adjust your filters or add a new lead manually.</p>
      </div>
    <?php endif; ?>
  </main>

  <footer class="mt-20 border-t border-white/5 bg-zinc-900/40 py-10 backdrop-blur-sm">
    <div class="mx-auto max-w-6xl px-4 flex flex-col md:flex-row justify-between items-center gap-6">
      <div class="text-center md:text-left">
        <div class="text-lg font-black text-white tracking-tighter uppercase">Admin<span class="text-red-600">Portal</span></div>
        <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mt-1">&copy; <?php echo date('Y'); ?> All rights reserved</p>
      </div>
      <div class="flex items-center gap-8">
        <div class="text-right">
          <p class="text-[10px] font-black text-white/40 uppercase tracking-widest leading-none">Status</p>
          <div class="flex items-center gap-2 mt-1 justify-end">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Online</span>
          </div>
        </div>
        <div class="h-8 w-px bg-white/10"></div>
        <p class="text-[10px] font-black text-white/40 uppercase tracking-widest">Built for performance</p>
      </div>
    </div>
  </footer>

  <button id="scrollToTop"  class="fixed bottom-8 right-8 z-[90] flex h-12 w-12 translate-y-20 items-center justify-center rounded-2xl border border-white/10 bg-zinc-900/80 text-white opacity-0 backdrop-blur-md transition-all duration-500 hover:bg-red-600 hover:shadow-2xl hover:shadow-red-600/40 cursor-pointer"
  >
    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
    </svg>
  </button>

  <script src="<?php echo ROOT_URL; ?>/assets/js/scroll_to_top.js"></script>
  <script src="<?php echo ROOT_URL; ?>/assets/js/pagination.js"></script>
</body>
</html>
