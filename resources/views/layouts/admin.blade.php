<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - E-Booking Rumah Anno 1925</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Bricolage+Grotesque:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1, h2, h3, h4, .font-heading {
            font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', sans-serif;
        }

        /* Custom Scrollbar Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* Toast Slide-In Animation */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-toast {
            animation: slideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">

        {{-- Mobile Sidebar Backdrop --}}
        <div id="sidebarBackdrop" onclick="toggleSidebar()"
            class="hidden fixed inset-0 z-30 bg-slate-950/60 backdrop-blur-sm lg:hidden transition-all duration-300"></div>

        {{-- Sidebar Navigation --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-slate-800/80 bg-slate-900 text-white shadow-2xl transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 print:hidden">
            
            {{-- Brand Logo Header --}}
            <div class="border-b border-slate-800/80 p-5">
                <div class="flex items-center gap-3">
                    <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 shadow-lg shadow-emerald-500/20 transition-transform duration-300 hover:scale-105">
                        <i data-lucide="calendar-check-2" class="h-5 w-5 text-white"></i>
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-sm font-extrabold tracking-widest text-white truncate font-heading">
                            RUMAH ANNO
                        </h2>
                        <p class="text-[10px] font-bold tracking-wider text-emerald-400 uppercase">
                            E-Booking System
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation Links --}}
            <nav class="sidebar-scroll flex-1 space-y-1.5 overflow-y-auto p-4">
                <div class="mb-2 mt-1 px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                    Menu Utama
                </div>

                @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan'))
                    <a href="{{ Auth::user()->role === 'admin' ? url('/admin/dashboard') : url('/pimpinan/dashboard') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('*/dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="layout-dashboard" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Dashboard {{ ucfirst(Auth::user()->role) }}</span>
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('*/dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="house" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Dashboard Utama</span>
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->role === 'user')
                    <a href="{{ route('venues.browse') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('venues/browse') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="building-2" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Jelajahi Venue</span>
                    </a>

                    <a href="{{ route('bookings.create') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('bookings/create') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="calendar-plus" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Booking</span>
                    </a>
                @endif

                <a href="{{ route('bookings.index') }}"
                    class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('bookings*') && !Request::is('bookings/create') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                    <i data-lucide="calendar-days" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="text-xs">{{ (Auth::check() && Auth::user()->role === 'user') ? 'Riwayat Booking' : 'Kelola Booking' }}</span>
                </a>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('venues.index') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('venues*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="building-2" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Data Venue</span>
                    </a>

                    <a href="{{ route('facilities.index') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('facilities*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="monitor-smartphone" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Data Fasilitas</span>
                    </a>

                    <a href="{{ route('users.index') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('users*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="users" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Data Pengguna</span>
                    </a>
                @endif

                @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan'))
                    <a href="{{ route('laporan.index') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('laporan*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="bar-chart-3" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Laporan Rekap</span>
                    </a>
                @endif

                <div class="mb-2 mt-5 px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                    Lainnya
                </div>

                <a href="{{ route('templates.index') }}"
                    class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('templates*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                    <i data-lucide="file-text" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="text-xs">Template Dokumen</span>
                </a>

                <a href="{{ route('notifications.index') }}"
                    class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('notifications*') && !Request::is('notifications/unread') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                    <i data-lucide="bell" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="text-xs">Semua Notifikasi</span>
                </a>

                @if(Auth::check() && Auth::user()->role === 'user')
                    <a href="{{ route('profile.edit') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('profile*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="user-circle" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Profil Saya</span>
                    </a>

                    <a href="{{ route('help.index') }}"
                        class="group flex items-center rounded-xl px-3.5 py-2.5 transition-all duration-200 hover:translate-x-1.5 {{ Request::is('bantuan') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-lg shadow-emerald-900/30 border-l-4 border-emerald-300' : 'text-slate-400 hover:bg-slate-800/80 hover:text-slate-100' }}">
                        <i data-lucide="circle-help" class="mr-3 h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                        <span class="text-xs">Pusat Bantuan</span>
                    </a>
                @endif
            </nav>

            {{-- Logout Section --}}
            <div class="border-t border-slate-800/80 p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="group flex w-full items-center justify-center gap-2 rounded-xl bg-rose-500/10 px-3.5 py-2.5 text-xs font-bold text-rose-400 transition-all duration-200 hover:bg-rose-600 hover:text-white active:scale-95">
                        <i data-lucide="log-out" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <div class="relative flex flex-1 flex-col overflow-hidden bg-slate-50">

            {{-- Top Navbar --}}
            <header class="z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-md print:hidden">
                @php
                    $hour = now()->hour;
                    $headerHint = $hour < 12 ? 'Cek agenda dan update ketersediaan booking hari ini.' : 'Pantau aktivitas dan status pengajuan booking terbaru.';
                @endphp

                <div class="flex items-center justify-between gap-3 px-4 py-3.5 lg:px-8">
                    
                    {{-- Left Header Section --}}
                    <div class="flex items-center gap-3 min-w-0">
                        <button onclick="toggleSidebar()"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:bg-slate-50 active:scale-95 lg:hidden">
                            <i data-lucide="menu" class="h-5 w-5 text-slate-700"></i>
                        </button>
                        
                        <div class="min-w-0">
                            <div class="inline-flex items-center gap-1.5 rounded-full border border-emerald-100 bg-emerald-50 px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-emerald-700">
                                <i data-lucide="sparkles" class="h-3 w-3 text-emerald-500"></i>
                                <span>Panel {{ Auth::user()->role === 'admin' ? 'Admin' : (Auth::user()->role === 'pimpinan' ? 'Pimpinan' : 'Pengguna') }}</span>
                            </div>
                            <h1 class="mt-0.5 truncate text-base font-extrabold tracking-tight text-slate-900 sm:text-xl font-heading">
                                Halo, {{ Auth::user()->name ?? 'Pengguna' }}
                            </h1>
                            <p class="hidden truncate text-xs font-medium text-slate-500 sm:block">
                                {{ $headerHint }}
                            </p>
                        </div>
                    </div>

                    {{-- Right Header Section --}}
                    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                        @if(Auth::check())
                            {{-- Notification Toggle --}}
                            <div class="relative">
                                <button id="notifBellBtn" onclick="toggleNotifDropdown()"
                                    class="group relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:border-emerald-300 hover:bg-emerald-50/50 active:scale-95">
                                    <i data-lucide="bell" class="h-4 w-4 text-slate-600 transition-transform group-hover:rotate-12"></i>
                                    <span id="notifBadge"
                                        class="absolute -right-1 -top-1 hidden h-4 w-4 items-center justify-center rounded-full bg-gradient-to-r from-rose-500 to-red-500 text-[9px] font-extrabold text-white shadow-md shadow-rose-500/30 animate-pulse">0</span>
                                </button>

                                {{-- Notification Dropdown --}}
                                <div id="notifDropdown"
                                    class="fixed left-4 right-4 top-16 z-50 hidden overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-2xl opacity-0 translate-y-2 transition-all duration-200 sm:absolute sm:left-auto sm:right-0 sm:top-12 sm:w-80">
                                    <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="bell" class="w-3.5 h-3.5 text-slate-500"></i>
                                            <span class="text-xs font-bold text-slate-800">Notifikasi</span>
                                        </div>
                                        <form action="{{ route('notifications.readAll') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                                Tandai dibaca
                                            </button>
                                        </form>
                                    </div>
                                    <ul id="notifList" class="max-h-64 divide-y divide-slate-100 overflow-y-auto text-xs">
                                        <li class="px-4 py-6 text-center text-slate-400">Belum ada notifikasi</li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- User Badge (Interactive Hover & Loading Animation to Profile) --}}
                        <a href="{{ route('profile.edit') }}" 
                           onclick="showPageLoader(event, this.href)"
                           class="group relative flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white p-1.5 shadow-sm transition-all duration-300 hover:border-emerald-400 hover:shadow-lg hover:shadow-emerald-500/10 hover:-translate-y-0.5 active:scale-95">
                            
                            <div class="hidden text-right pl-1 sm:block">
                                <p class="text-xs font-bold leading-tight text-slate-800 transition-colors group-hover:text-emerald-600">{{ Auth::user()->name ?? 'Guest' }}</p>
                                <p class="text-[10px] font-extrabold leading-tight text-emerald-600 capitalize">{{ Auth::user()->role ?? 'User' }}</p>
                            </div>
                            
                            <div class="relative">
                                <div class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-lg bg-gradient-to-tr from-emerald-600 to-teal-500 text-xs font-bold uppercase text-white shadow-md shadow-emerald-600/20 transition-transform duration-300 group-hover:scale-105">
                                    @if(Auth::check() && Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ Auth::user()->updated_at->timestamp }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="h-full w-full object-cover">
                                    @else
                                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                    @endif
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-white bg-emerald-500 animate-pulse"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Main Page Body --}}
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Overlay Loading Animasi saat Profil Diklik --}}
    <div id="pageLoaderOverlay" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950/70 backdrop-blur-md hidden opacity-0 transition-opacity duration-300">
        <div class="flex flex-col items-center p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-2xl">
            <div class="relative flex items-center justify-center mb-4">
                <div class="absolute h-12 w-12 rounded-full border-4 border-emerald-500/20 animate-ping"></div>
                <div class="h-12 w-12 rounded-full border-4 border-emerald-500 border-t-transparent animate-spin"></div>
                <div class="absolute text-emerald-400">
                    <i data-lucide="user-cog" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-xs font-extrabold text-white tracking-wider uppercase">Memuat Profil...</p>
            <p class="text-[10px] text-slate-400 mt-1">Menyiapkan data Anda</p>
        </div>
    </div>

    {{-- Toast Container --}}
    @if(Auth::check())
        <div id="notifToastContainer" class="fixed right-4 top-4 z-50 space-y-2 print:hidden pointer-events-none"></div>

        <script>
            let notifKnownIds = [];

            function toggleNotifDropdown() {
                const dropdown = document.getElementById('notifDropdown');
                if (!dropdown) return;

                if (dropdown.classList.contains('hidden')) {
                    dropdown.classList.remove('hidden');
                    requestAnimationFrame(() => {
                        dropdown.classList.remove('opacity-0', 'translate-y-2');
                        dropdown.classList.add('opacity-100', 'translate-y-0');
                    });
                } else {
                    dropdown.classList.remove('opacity-100', 'translate-y-0');
                    dropdown.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => dropdown.classList.add('hidden'), 180);
                }
            }

            document.addEventListener('click', function (e) {
                const dropdown = document.getElementById('notifDropdown');
                const btn = document.getElementById('notifBellBtn');
                if (dropdown && btn && !dropdown.contains(e.target) && !btn.contains(e.target)) {
                    dropdown.classList.remove('opacity-100', 'translate-y-0');
                    dropdown.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => dropdown.classList.add('hidden'), 180);
                }
            });

            function showToast(message) {
                const container = document.getElementById('notifToastContainer');
                const toast = document.createElement('div');
                toast.className = 'animate-toast pointer-events-auto bg-slate-900/95 backdrop-blur-md text-white text-xs p-4 rounded-2xl shadow-2xl max-w-xs border border-slate-700/80 flex items-start gap-3';
                toast.innerHTML = `
                    <div class="p-1.5 bg-emerald-500/20 text-emerald-400 rounded-xl shrink-0 mt-0.5">
                        <i data-lucide="bell-ring" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="font-extrabold text-emerald-400 uppercase tracking-wider text-[10px]">Pemberitahuan Baru</span>
                        <p class="text-slate-200 mt-0.5 leading-snug font-medium">${message}</p>
                    </div>
                `;
                container.appendChild(toast);
                lucide.createIcons();

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 6000);
            }

            function fetchNotifications(isFirstLoad) {
                fetch('{{ route("notifications.unread") }}')
                    .then(res => res.json())
                    .then(data => {
                        const badge = document.getElementById('notifBadge');
                        const list = document.getElementById('notifList');

                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('hidden');
                            badge.classList.add('flex');
                        } else {
                            badge.classList.add('hidden');
                            badge.classList.remove('flex');
                        }

                        if (data.items.length > 0) {
                            list.innerHTML = data.items.map(item => `
                                <li class="p-3.5 hover:bg-slate-50 transition-colors flex items-start gap-2.5">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0 mt-1.5"></span>
                                    <div>
                                        <p class="text-xs text-slate-700 font-semibold leading-relaxed">${item.message}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 font-medium">${item.created_at}</p>
                                    </div>
                                </li>
                            `).join('');
                        } else {
                            list.innerHTML = '<li class="px-4 py-6 text-xs text-slate-400 text-center">Belum ada notifikasi</li>';
                        }

                        if (!isFirstLoad) {
                            data.items.forEach(item => {
                                if (!notifKnownIds.includes(item.id)) {
                                    showToast(item.message);
                                }
                            });
                        }
                        notifKnownIds = data.items.map(item => item.id);
                    })
                    .catch(() => { });
            }

            fetchNotifications(true);
            setInterval(() => fetchNotifications(false), 15000);
        </script>
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function showPageLoader(event, url) {
            event.preventDefault();
            const overlay = document.getElementById('pageLoaderOverlay');
            if (overlay) {
                overlay.classList.remove('hidden');
                requestAnimationFrame(() => {
                    overlay.classList.remove('opacity-0');
                });
            }
            setTimeout(() => {
                window.location.href = url;
            }, 400);
        }

        lucide.createIcons();
    </script>
</body>

</html>