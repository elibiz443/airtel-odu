<?php
  require_once __DIR__ . '/../../controllers/auth/login.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Login</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="min-h-screen bg-zinc-700 text-white">
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-700 via-zinc-800 to-zinc-950"></div>
    <div class="absolute -top-40 left-1/2 h-[40rem] w-[40rem] -translate-x-1/2 rounded-full bg-red-600/20 blur-3xl"></div>
    <div class="absolute top-24 right-[-12rem] h-[36rem] w-[36rem] rounded-full bg-cyan-400/10 blur-3xl"></div>
  </div>

  <div class="mx-auto max-w-md px-4 py-14">
    <a href="<?php echo ROOT_URL; ?>/" class="inline-flex items-center gap-2 text-sm text-white/70 hover:text-white transition">
      <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10">←</span>
      Site
    </a>

    <div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-7">
      <div class="text-sm text-white/60">Admin</div>
      <h1 class="mt-2 text-2xl font-semibold">Dashboard login</h1>

      <?php if ($err !== ''): ?>
        <div class="mt-4 rounded-2xl border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-200"><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endif; ?>

      <form class="mt-6 space-y-4" method="post" action="<?php echo ROOT_URL; ?>/auth/login">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <div>
          <label class="text-xs text-white/60">User</label>
          <input name="user" value="<?php echo htmlspecialchars($_POST['user'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="username" class="mt-1 w-full rounded-2xl border border-white/10 bg-zinc-900/60 px-4 py-3 text-sm outline-none placeholder:text-white/30 focus:border-white/20 focus:bg-zinc-900" placeholder="admin">
        </div>
        <div>
          <label class="text-xs text-white/60">Password</label>
          <input name="pass" type="password" autocomplete="current-password" class="mt-1 w-full rounded-2xl border border-white/10 bg-zinc-900/60 px-4 py-3 text-sm outline-none placeholder:text-white/30 focus:border-white/20 focus:bg-zinc-900" placeholder="••••••••">
        </div>
        <button class="w-full rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-zinc-950 hover:bg-white/90 transition" type="submit">Sign in</button>
      </form>
    </div>
  </div>
</body>
</html>
