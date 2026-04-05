<header id="main-header" class="sticky top-0 z-[60] border-b border-slate-200 bg-white/90 backdrop-blur transition-all duration-300">
  <div id="header-container" class="w-[90%] mx-auto flex items-center justify-between py-4 transition-all duration-500 ease-in-out">
    <a href="<?php echo ROOT_URL; ?>" class="flex items-center gap-3 hover:scale-105 transition-all duration-500">
      <div id="logo-box" class="h-11 w-11 2xl:h-14 2xl:w-14 rounded-lg border-2 border-[#E4002B] shadow-md shadow-gray-400 flex items-center justify-center">
        <img src="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" class="w-[80%] h-auto">
      </div>
      <div id="logo-text" class="transition-all duration-300">
        <p class="text-[1rem] 2xl:text-[1.5rem] font-semibold uppercase tracking-[0.3em] text-[#E4002B]">Airtel ODU Shop</p>
        <p class="text-[0.75rem] 2xl:text-[1.125rem] text-slate-500">Fast installation. Simple request flow.</p>
      </div>
    </a>
    <div class="hidden items-center gap-3 md:flex">
      <a href="#packages" class="nav-link rounded-full px-4 py-2 text-[0.875rem] 2xl:text-[1.25rem] font-medium text-slate-700 transition hover:bg-slate-200">Packages</a>
      <a href="#how-it-works" class="nav-link rounded-full px-4 py-2 text-[0.875rem] 2xl:text-[1.25rem] font-medium text-slate-700 transition hover:bg-slate-200">How it works</a>
      <a href="https://wa.me/+254103338353" target="_blank" rel="noopener noreferrer" class="rounded-full bg-[#E4002B] px-5 py-1.5 text-[0.875rem] 2xl:text-[1.25rem] font-semibold text-white shadow-md shadow-gray-400 border-2 border-[#E4002B] hover:bg-transparent hover:text-[#E4002B] transition-all duration-500 ease-in-out">Contact</a>
    </div>
    <button id="open-sidebar" class="block md:hidden text-slate-700 p-2 cursor-pointer hover:text-[#E4002B] transition">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
  </div>
</header>

<div id="sidebar-overlay" class="fixed inset-0 z-[60] bg-black/50 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<aside id="sidebar" class="fixed top-0 left-0 z-[70] h-full w-[75%] -translate-x-full bg-white p-6 transition-transform duration-300 ease-in-out border-r border-slate-200">
  <div class="flex items-center justify-between mb-8">
    <a href="<?php echo ROOT_URL; ?>" class="flex items-center gap-2 hover:scale-105 transition-all duration-500">
      <div id="logo-box" class="h-8 w-8 rounded-md border border-[#E4002B] shadow shadow-gray-400 flex items-center justify-center">
        <img src="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" class="w-[80%] h-auto">
      </div>
      <div id="logo-text" class="transition-all duration-300">
        <p class="text-sm font-semibold uppercase text-[#E4002B] tracking-[0.2em]">Airtel ODU Shop</p>
        <p class="text-[0.6rem] text-slate-500">Fast installation. Simple request flow.</p>
      </div>
    </a>
    <button id="close-sidebar" class="text-slate-700 p-2 cursor-pointer hover:text-[#E4002B] transition">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>
  <nav class="flex flex-col gap-4">
    <a href="#packages" class="nav-link text-lg font-medium text-slate-700 py-2 border-b border-slate-100 hover:text-[#E4002B] transition">Packages</a>
    <a href="#how-it-works" class="nav-link text-lg font-medium text-slate-700 py-2 border-b border-slate-100 hover:text-[#E4002B] transition">How it works</a>
    <a href="https://wa.me/+254103338353" target="_blank" class="mt-4 block text-center bg-[#E4002B] py-2 rounded-lg font-semibold text-white shadow-md shadow-gray-600 border-2 border-[#E4002B] hover:bg-transparent hover:text-[#E4002B] transition-all duration-500 ease-in-out">Contact Us</a>
  </nav>
</aside>