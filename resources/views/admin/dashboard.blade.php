@extends('layouts.admin')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .dashboard-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Ambient Glow & Shine Effects */
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.08); }
        }

        .animate-glow {
            animation: pulse-glow 6s infinite ease-in-out;
        }

        @keyframes shine {
            100% { left: 125%; }
        }

        .animate-shine {
            position: relative;
            overflow: hidden;
        }

        .animate-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 25%;
            height: 200%;
            opacity: 0;
            transform: rotate(25deg);
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.35) 50%,
                rgba(255, 255, 255, 0) 100%
            );
        }

        .animate-shine:hover::after {
            animation: shine 1.2s ease-out;
            opacity: 1;
        }

        /* ----------------------------------------------------
           FULLCALENDAR NEXT-GEN CUSTOM STYLING (NOTION/CRON STYLE)
        ---------------------------------------------------- */
        #calendar {
            --fc-border-color: #f1f5f9;
            --fc-page-bg-color: #ffffff;
            --fc-neutral-bg-color: #f8fafc;
            --fc-today-bg-color: #f0fdf4;
        }

        #calendar .fc-scrollgrid {
            border-radius: 24px !important;
            border: 1px solid #e2e8f0 !important;
            overflow: hidden;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
        }

        #calendar .fc-toolbar {
            margin-bottom: 1.5rem !important;
        }

        #calendar .fc-toolbar-title {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.02em;
        }

        #calendar .fc-button {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #334155 !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.8rem !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            text-transform: capitalize !important;
        }

        #calendar .fc-button:hover {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
            transform: translateY(-1px);
        }

        #calendar .fc-button-active {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3) !important;
        }

        #calendar .fc-col-header-cell {
            background-color: #f8fafc;
            padding: 14px 0 !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        #calendar .fc-col-header-cell-cushion {
            color: #475569;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            text-decoration: none !important;
        }

        #calendar .fc-timegrid-slot {
            height: 3.2rem !important;
        }

        #calendar .fc-timegrid-slot-label-cushion {
            color: #94a3b8;
            font-size: 0.725rem;
            font-weight: 700;
        }

        /* Modern Event Cards with Left Accent Bar */
        #calendar .fc-timegrid-event,
        #calendar .fc-daygrid-event {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05) !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            background: #ffffff !important;
            border-left: 4px solid #10b981 !important;
            margin: 2px 4px !important;
        }

        #calendar .fc-timegrid-event:hover,
        #calendar .fc-daygrid-event:hover {
            transform: translateY(-2px) scale(1.015);
            box-shadow: 0 10px 25px -3px rgba(16, 185, 129, 0.2) !important;
            z-index: 20 !important;
        }

        #calendar .fc-event-main {
            padding: 6px 10px !important;
        }

        /* Live Red Line Waktu Berjalan */
        #calendar .fc-timegrid-now-indicator-line {
            border-color: #ef4444 !important;
            border-width: 2px !important;
        }

        #calendar .fc-timegrid-now-indicator-arrow {
            border-color: #ef4444 !important;
            border-width: 5px !important;
        }

        @media (max-width: 640px) {
            #calendar .fc-toolbar {
                flex-direction: column;
                gap: 0.75rem;
                align-items: stretch !important;
            }

            #calendar .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
            }

            #calendar .fc-toolbar-title {
                font-size: 1.1rem !important;
                text-align: center;
            }

            #calendar .fc-button {
                padding: 0.35rem 0.65rem !important;
                font-size: 0.75rem !important;
            }
        }
    </style>

    <div class="dashboard-font mx-auto max-w-7xl space-y-8">

        {{-- Banner Header Dashboard --}}
        <div class="animate-shine relative overflow-hidden rounded-[32px] border border-white/10 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 p-6 sm:p-10 text-white shadow-2xl shadow-emerald-950/20">
            {{-- Decorative Ambient Glowing Orbs --}}
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl animate-glow"></div>
            <div class="pointer-events-none absolute right-1/3 -bottom-12 h-48 w-48 rounded-full bg-teal-400/15 blur-2xl animate-glow" style="animation-delay: 2s;"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3.5 py-1 text-xs font-bold uppercase tracking-widest text-emerald-300 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                        </span>
                        Panel Kontrol Utama
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white font-heading">
                        Dashboard {{ Auth::user()->role === 'pimpinan' ? 'Pimpinan' : 'Admin' }}
                    </h1>
                    <p class="mt-2 text-xs sm:text-sm leading-relaxed text-slate-300">
                        Selamat datang kembali, <span class="font-bold text-white underline decoration-emerald-500/50 decoration-2 underline-offset-4">{{ Auth::user()->name }}</span>! Pantau reservasi venue, kelola ketersediaan, dan tinjau persetujuan acara dalam satu tampilan terpadu.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('bookings.index') }}"
                        class="group inline-flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-300 px-6 py-3.5 text-xs font-extrabold text-slate-950 shadow-xl shadow-emerald-500/20 transition-all duration-300 hover:scale-[1.03] hover:shadow-emerald-500/35 active:scale-[0.98]">
                        <i data-lucide="calendar-check" class="h-4 w-4 transition-transform group-hover:scale-110"></i>
                        <span>Kelola Booking</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Grid Metric Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
            {{-- Card 1: Total Event --}}
            <div class="group relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-emerald-300 hover:shadow-xl hover:shadow-emerald-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Total Event Bulan Ini</span>
                        <p class="mt-2 text-3xl sm:text-4xl font-black tracking-tight text-slate-900">{{ $totalEventBulanIni ?? 0 }}</p>
                        <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            <i data-lucide="trending-up" class="h-3 w-3"></i>
                            <span>Aktivitas Bulan Berjalan</span>
                        </div>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-slate-700 border border-slate-100 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-all duration-300 shadow-sm">
                        <i data-lucide="calendar" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>

            {{-- Card 2: Menunggu Persetujuan --}}
            <div class="group relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-amber-300 hover:shadow-xl hover:shadow-amber-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Perlu Tindakan</span>
                        <p class="mt-2 text-3xl sm:text-4xl font-black tracking-tight text-amber-600">{{ $menungguPersetujuan ?? 0 }}</p>
                        <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">
                            <i data-lucide="clock" class="h-3 w-3"></i>
                            <span>Menunggu Konfirmasi</span>
                        </div>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 group-hover:bg-amber-500 group-hover:text-white group-hover:border-amber-500 transition-all duration-300 shadow-sm">
                        <i data-lucide="hourglass" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>

            {{-- Card 3: Total Venue Aktif --}}
            <div class="group relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-teal-300 hover:shadow-xl hover:shadow-teal-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Fasilitas Venue</span>
                        <p class="mt-2 text-3xl sm:text-4xl font-black tracking-tight text-slate-900">{{ $totalVenue ?? 0 }}</p>
                        <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">
                            <i data-lucide="check-circle-2" class="h-3 w-3"></i>
                            <span>Siap Digunakan</span>
                        </div>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-slate-700 border border-slate-100 group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-600 transition-all duration-300 shadow-sm">
                        <i data-lucide="building-2" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Perlu Persetujuan --}}
        <div class="rounded-[32px] border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm transition-all duration-300 hover:shadow-md">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 shadow-sm">
                        <i data-lucide="bell" class="h-6 w-6"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 font-heading">Antrean Persetujuan</h2>
                        <p class="text-xs text-slate-500">Permohonan reservasi yang memerlukan verifikasi resmi</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-amber-50 border border-amber-200/80 px-3.5 py-1.5 text-xs font-bold text-amber-800 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-ping"></span>
                    {{ $menungguPersetujuan ?? 0 }} Pengajuan Pending
                </span>
            </div>

            <div class="space-y-3">
                @forelse($pendingBookings as $booking)
                    <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-2xl bg-slate-50/70 border border-slate-200/60 hover:bg-white hover:border-amber-300 hover:shadow-md transition-all duration-200 gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-black text-slate-700 uppercase shadow-inner">
                                {{ substr($booking->user->name ?? 'U', 0, 2) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition-colors">{{ $booking->event_name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                                    <span>Pemohon: <strong class="text-slate-700">{{ $booking->user->name ?? '-' }}</strong></span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-200/50">
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100/80 px-3 py-1 text-[11px] font-bold text-amber-800 border border-amber-200">
                                <i data-lucide="clock" class="h-3 w-3"></i> Pending
                            </span>
                            <a href="{{ route('bookings.index') }}" class="rounded-xl bg-white border border-slate-200 px-4 py-2 text-xs font-bold text-slate-700 shadow-sm hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all active:scale-95">
                                Tinjau
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border-2 border-dashed border-slate-200 py-10 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                            <i data-lucide="check-circle" class="h-6 w-6"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-600">Semua Pengajuan Selesai</p>
                        <p class="text-xs text-slate-400 mt-1">Tidak ada reservasi yang menunggu persetujuan saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Section Kalender Booking --}}
        <div class="rounded-[32px] border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm transition-all duration-300 hover:shadow-md">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                        <i data-lucide="calendar-range" class="h-6 w-6"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 font-heading">Kalender Pendudukan Venue</h2>
                        <p class="text-xs text-slate-500">Visualisasi jadwal penggunaan seluruh lokasi</p>
                    </div>
                </div>

                {{-- Status Legend Pills --}}
                <div class="flex items-center gap-3 text-xs font-bold text-slate-700 bg-slate-50/80 p-2 rounded-2xl border border-slate-200/60 self-start sm:self-auto">
                    <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-1.5 shadow-sm border border-slate-100">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span>Disetujui</span>
                    </div>
                    <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-1.5 shadow-sm border border-slate-100">
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                        <span>Pending</span>
                    </div>
                </div>
            </div>

            <div id="calendar" class="min-h-[700px] bg-white"></div>
        </div>
    </div>

    {{-- Event Detail Modal --}}
    <div id="eventModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-md transition-opacity duration-300 opacity-0">
        <div id="eventModalCard" class="relative w-full max-w-lg overflow-hidden rounded-[32px] bg-white shadow-2xl transition-all border border-slate-100 scale-95 opacity-0">
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-900 px-6 py-5 text-white flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-300">Informasi Event Terdaftar</span>
                    <h3 class="text-base font-bold font-heading mt-0.5">Detail Informasi Booking</h3>
                </div>
                <button onclick="closeEventModal()" class="rounded-full bg-white/10 p-1.5 text-slate-300 hover:bg-white/20 hover:text-white transition active:scale-95">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200/70">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Nama Acara / Event</span>
                    <p id="modalEvent" class="font-extrabold text-slate-900 text-base">-</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-200/70">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Lokasi Venue</span>
                        <p id="modalVenue" class="font-bold text-slate-800 text-xs mt-0.5">-</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-200/70">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Pemohon</span>
                        <p id="modalBooker" class="font-bold text-slate-800 text-xs mt-0.5">-</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-200/70">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Status Persetujuan</span>
                        <div class="mt-1">
                            <span id="modalStatus" class="inline-block px-3 py-1 rounded-full text-xs font-bold">-</span>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-200/70">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Waktu Pelaksanaan</span>
                        <p id="modalTime" class="font-bold text-slate-800 text-xs mt-0.5 leading-relaxed">-</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i data-lucide="box" class="h-3.5 w-3.5 text-emerald-600"></i>
                        Fasilitas Tambahan
                    </h4>
                    <div id="modalFacilities" class="grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 flex justify-end">
                <button onclick="closeEventModal()" class="rounded-2xl border border-slate-300 bg-white px-6 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-100 active:scale-95">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        function openEventModal() {
            const modal = document.getElementById('eventModal');
            const card = document.getElementById('eventModalCard');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                card.classList.remove('opacity-0', 'scale-95');
                card.classList.add('opacity-100', 'scale-100');
            });
        }

        function closeEventModal() {
            const modal = document.getElementById('eventModal');
            const card = document.getElementById('eventModalCard');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            card.classList.remove('opacity-100', 'scale-100');
            card.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

        document.addEventListener('click', function (e) {
            const modal = document.getElementById('eventModal');
            if (e.target === modal) closeEventModal();
        });

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                nowIndicator: true,
                slotMinTime: '06:00:00',
                slotMaxTime: '23:00:00',
                slotDuration: '00:30:00',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },
                events: {!! isset($events) ? json_encode($events) : '[]' !!},
                eventContent: function(arg) {
                    let customEl = document.createElement('div');
                    customEl.className = 'flex flex-col h-full justify-between';
                    customEl.innerHTML = `
                        <div class="font-extrabold text-slate-900 text-[11px] truncate leading-tight">${arg.event.title}</div>
                        <div class="text-[10px] text-slate-500 font-medium flex items-center gap-1 mt-1">
                            <span>📍 ${arg.event.extendedProps.venue || 'Venue'}</span>
                        </div>
                    `;
                    return { domNodes: [customEl] };
                },
                eventClick: function (info) {
                    document.getElementById('modalEvent').textContent = info.event.title;
                    document.getElementById('modalVenue').textContent = info.event.extendedProps.venue || '-';
                    document.getElementById('modalBooker').textContent = info.event.extendedProps.booker || '-';
                    document.getElementById('modalTime').textContent = info.event.start ? info.event.start.toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' }) : '-';

                    const facilities = info.event.extendedProps.facilities || [];
                    let facilitiesHtml = '';

                    if (facilities.length > 0) {
                        facilities.forEach(function (facility) {
                            facilitiesHtml += `
                                <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white shadow-sm hover:shadow-md transition">
                                    ${facility.photo ? `<img src="/storage/${facility.photo}" class="w-full h-20 object-cover">` : ''}
                                    <div class="p-2.5">
                                        <p class="text-[11px] font-bold text-slate-800 truncate">${facility.name}</p>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        facilitiesHtml = `<p class="text-xs text-slate-400 col-span-full italic">Tidak ada fasilitas tambahan.</p>`;
                    }

                    document.getElementById('modalFacilities').innerHTML = facilitiesHtml;

                    const status = info.event.extendedProps.status || 'pending';
                    const statusElement = document.getElementById('modalStatus');
                    statusElement.textContent = status.toUpperCase();

                    if (status === 'approved') {
                        statusElement.className = 'inline-block px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 border border-emerald-300 text-emerald-800';
                    } else {
                        statusElement.className = 'inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-100 border border-amber-300 text-amber-800';
                    }

                    openEventModal();
                }
            });
            calendar.render();
        });
    </script>
@endsection