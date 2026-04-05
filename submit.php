<?php
  declare(strict_types=1);
  require __DIR__ . '/connector.php';
  require __DIR__ . '/admin/controllers/home/submit.php';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Submitted</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="min-h-screen bg-zinc-700 text-white">
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-700 via-zinc-800 to-zinc-950"></div>
    <div class="absolute -top-40 left-1/2 h-[40rem] w-[40rem] -translate-x-1/2 rounded-full bg-red-600/20 blur-3xl"></div>
    <div class="absolute top-24 right-[-12rem] h-[36rem] w-[36rem] rounded-full bg-cyan-400/10 blur-3xl"></div>
  </div>

  <div class="mx-auto max-w-2xl px-4 py-12">
    <a href="<?php echo ROOT_URL; ?>/" class="inline-flex items-center gap-2 text-sm text-white/70 hover:text-white transition">
      <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10">←</span>
      Back
    </a>

    <div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-7">
      <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/70">
        <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
        Submitted
      </div>

      <h1 class="mt-4 text-3xl font-semibold tracking-tight">Congrats.</h1>
      <p class="mt-2 text-sm text-white/60">Ref: <span class="font-semibold text-white"><?php echo htmlspecialchars($ref); ?></span></p>

      <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
        <button id="copyRef" data-ref="<?php echo htmlspecialchars($ref, ENT_QUOTES); ?>" class="cursor-pointer rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold hover:bg-white/10 transition">Copy ref</button>
        <a href="<?php echo htmlspecialchars($waLink, ENT_QUOTES); ?>" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-2xl bg-green-500/90 px-5 py-3 text-sm font-semibold text-zinc-800 hover:bg-green-500 transition">
          Confirm on WhatsApp
        </a>
      </div>

      <div class="mt-5 rounded-2xl border border-white/10 bg-zinc-800/50 p-4 text-sm text-white/70">
        We’ll use your slot: <span class="font-semibold text-white"><?php echo htmlspecialchars($preferredDate . ' ' . $preferredTime); ?></span>
      </div>

      <div class="mt-6 flex flex-wrap gap-3">
        <a href="<?php echo ROOT_URL; ?>/" class="inline-flex items-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-zinc-800 hover:bg-white/90 transition">New request</a>
      </div>
    </div>
  </div>

  <script src="<?php echo ROOT_URL; ?>/assets/js/submit.js"></script>
</body>
</html>
