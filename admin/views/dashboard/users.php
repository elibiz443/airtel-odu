<?php
  declare(strict_types=1);
  require_once __DIR__ . '/../../controllers/users/index.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Management</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="min-h-screen bg-zinc-700 text-white flex flex-col">
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
          <div class="text-xs text-white/60">User Accounts</div>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <a href="<?php echo ROOT_URL; ?>/dashboard" class="hidden sm:inline-flex rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold transition hover:bg-white/10">Dashboard</a>
        <a href="<?php echo ROOT_URL; ?>/admin/controllers/auth/logout.php" class="inline-flex rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-white/90">Logout</a>
      </div>
    </div>
  </header>

  <main class="w-[90%] mx-auto flex-grow py-8 min-h-screen">
    <div class="mb-10 rounded-[2.5rem] border border-white/10 bg-white/5 p-8 backdrop-blur-sm">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h1 class="text-3xl font-black tracking-tighter text-white uppercase">System Users</h1>
          <p class="text-sm text-white/50 mt-1 uppercase tracking-widest font-bold text-[10px]">Database Table: users</p>
        </div>
        <button onclick="document.getElementById('userForm').scrollIntoView({behavior: 'smooth'})" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-red-600 px-6 py-4 text-sm font-black uppercase tracking-widest text-white transition hover:bg-red-500 shadow-xl shadow-red-600/20 cursor-pointer">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
          Add New User
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <?php foreach ($users as $user): ?>
        <div class="group relative rounded-[2rem] border border-white/10 bg-white/5 p-6 transition-all hover:bg-white/[0.07]">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="h-14 w-14 rounded-2xl bg-zinc-800 flex items-center justify-center border border-white/5 group-hover:border-red-500/30 transition-colors">
                <span class="text-lg font-black text-red-500"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></span>
              </div>
              <div>
                <h3 class="text-lg font-black tracking-tight text-white"><?php echo h($user['username']); ?></h3>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">User ID: <?php echo $user['id']; ?></p>
              </div>
            </div>
            <div class="flex gap-2">
              <a href="?edit=<?php echo $user['id']; ?>#userForm" class="p-3 rounded-xl bg-white/5 hover:bg-cyan-500/20 text-white/40 hover:text-cyan-400 transition-all">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
              </a>
              <form action="<?php echo ROOT_URL; ?>/admin/controllers/users/delete.php" method="post" onsubmit="return confirm('Delete this user?')">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <button class="cursor-pointer p-3 rounded-xl bg-white/5 hover:bg-red-500/20 text-white/40 hover:text-red-500 transition-all">
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg>
                </button>
              </form>
            </div>
          </div>
          <div class="mt-6 border-t border-white/5 pt-6">
            <span class="block text-[10px] font-black uppercase tracking-widest text-white/30">Created Date</span>
            <p class="text-sm font-bold text-white/80"><?php echo h($user['created_at']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <section id="userForm" class="mt-16 rounded-[2.5rem] border border-white/10 bg-white/5 p-8 md:p-12">
      <div class="mb-8">
        <h2 class="text-2xl font-black tracking-tighter text-white uppercase"><?php echo isset($editUser) ? 'Update' : 'Register'; ?> User</h2>
        <p class="text-sm text-white/40">Manage security credentials for <?php echo isset($editUser) ? h($editUser['username']) : 'new account'; ?></p>
      </div>
      <form action="<?php echo ROOT_URL; ?>/admin/controllers/users/save.php" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="id" value="<?php echo $editUser['id'] ?? ''; ?>">
        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-white/40 ml-1">Username</label>
          <input type="text" name="username" value="<?php echo isset($editUser) ? h($editUser['username']) : ''; ?>" required class="w-full rounded-2xl border border-white/10 bg-zinc-900/80 px-5 py-4 text-sm text-white outline-none focus:border-red-500/50 transition-all">
        </div>
        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-white/40 ml-1">Password <?php echo isset($editUser) ? '(Leave blank to keep current)' : ''; ?></label>
          <input type="password" name="password" <?php echo isset($editUser) ? '' : 'required'; ?> class="w-full rounded-2xl border border-white/10 bg-zinc-900/80 px-5 py-4 text-sm text-white outline-none focus:border-red-500/50 transition-all" placeholder="••••••••">
        </div>
        <div class="md:col-span-2 pt-4 flex gap-3">
          <button type="submit" class="cursor-pointer flex-1 rounded-2xl bg-red-600 py-4 text-sm font-black uppercase tracking-widest text-white transition hover:bg-red-500 shadow-lg shadow-red-600/20">
            <?php echo isset($editUser) ? 'Update Account' : 'Create Account'; ?>
          </button>
          <?php if(isset($editUser)): ?>
            <a href="?" class="px-8 flex items-center rounded-2xl border border-white/10 bg-white/5 text-sm font-black uppercase tracking-widest text-white transition hover:bg-white/10">Cancel</a>
          <?php else: ?>
            <button type="reset" class="cursor-pointer px-8 rounded-2xl border border-white/10 bg-white/5 text-sm font-black uppercase tracking-widest text-white transition hover:bg-white/10">Clear</button>
          <?php endif; ?>
        </div>
      </form>
    </section>
  </main>

  <footer class="mt-20 border-t border-white/5 bg-zinc-900/40 py-10 backdrop-blur-sm">
    <div class="w-[90%] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
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

  <button id="scrollToTop"  class="fixed bottom-15 right-10 z-[90] flex h-12 w-12 translate-y-20 items-center justify-center rounded-2xl border border-white/10 bg-zinc-900/80 text-white opacity-0 backdrop-blur-md transition-all duration-500 hover:bg-red-600 hover:shadow-2xl hover:shadow-red-600/40 cursor-pointer"
  >
    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
    </svg>
  </button>

  <script src="<?php echo ROOT_URL; ?>/assets/js/scroll.js"></script>
  <script src="<?php echo ROOT_URL; ?>/assets/js/scroll_to_top.js"></script>
</body>
</html>
