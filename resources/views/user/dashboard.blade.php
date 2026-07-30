@extends('layouts.admin')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .dashboard-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Glassmorphism & Custom Glow Effects */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.08); }
        }

        .animate-glow {
            animation: pulse-glow 6s infinite ease-in-out;
        }

        /* Shine Animation for Hero Banner */
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

        {{-- Session Flash Notifications --}}
        @if(session('success_register'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm font-bold text-emerald-800 shadow-sm backdrop-blur-md animate-fade-in">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-md shadow-emerald-500/20">
                    <i data-lucide="check" class="h-4 w-4"></i>
                </div>
                <span>{{ session('success_register') }}</span>
            </div>
        @endif

        @if(session('error_gacha'))
            <div class="flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50/90 p-4 text-sm font-bold text-red-800 shadow-sm backdrop-blur-md animate-fade-in">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white shadow-md shadow-red-500/20">
                    <i data-lucide="alert-triangle" class="h-4 w-4"></i>
                </div>
                <span>{{ session('error_gacha') }}</span>
            </div>
        @endif

        {{-- Hero Smart Finder Banner --}}
        <div class="animate-shine relative overflow-hidden rounded-[32px] bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 p-6 sm:p-10 text-white shadow-2xl shadow-emerald-950/20 border border-white/10">
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl animate-glow"></div>
            <div class="pointer-events-none absolute -left-12 -bottom-12 h-52 w-52 rounded-full bg-teal-400/15 blur-3xl animate-glow" style="animation-delay: 2s;"></div>

            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-emerald-300 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                        </span>
                        Rekomendasi Slot Pintar
                    </div>
                    <h2 class="mb-3 text-2xl sm:text-4xl font-black tracking-tight leading-tight text-white font-heading">
                        Cek Slot Otomatis untuk Acara Anda
                    </h2>
                    <p class="max-w-xl text-xs sm:text-sm leading-relaxed text-slate-300 font-normal">
                        Sistem mencocokkan jadwal bentrok secara presisi untuk menemukan venue dan waktu optimal dalam hitungan detik.
                    </p>
                </div>

                <form action="{{ route('user.gacha') }}" method="POST" class="w-full lg:w-auto">
                    @csrf
                    <button type="submit"
                        class="group relative w-full lg:w-auto inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-300 px-7 py-4 text-sm sm:text-base font-extrabold text-slate-950 shadow-xl shadow-emerald-500/20 transition-all duration-300 hover:scale-[1.03] hover:shadow-emerald-500/35 active:scale-[0.98]">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-950/10 text-slate-950 transition-transform group-hover:rotate-12">
                            <i data-lucide="sparkles" class="h-4 w-4"></i>
                        </span>
                        <span>Cari Slot Terbaik Sekarang</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Quick Actions Navigation Grid --}}
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('venues.browse') }}"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-300">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-wider text-emerald-600 mb-1">
                            <span>Jelajahi Venue</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Katalog & Fasilitas</h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">Cek ketersediaan daftar venue cagar budaya & spesifikasi teknisnya.</p>
                    </div>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-600/30">
                        <i data-lucide="building-2" class="h-6 w-6"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('bookings.create') }}"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-sky-500/10 hover:border-sky-300">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-wider text-sky-600 mb-1">
                            <span>Buat Booking Baru</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors">Ajukan Permohonan</h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">Lengkapi formulir reservasi dan tentukan jam pelaksanaan kegiatan.</p>
                    </div>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-sky-50 text-sky-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-sky-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-sky-600/30">
                        <i data-lucide="calendar-plus" class="h-6 w-6"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('bookings.index') }}"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-violet-500/10 hover:border-violet-300 sm:col-span-2 lg:col-span-1">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-wider text-violet-600 mb-1">
                            <span>Riwayat Booking</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-violet-700 transition-colors">Pantau Status Real-time</h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">Tinjau progres pengajuan dan riwayat persetujuan acara Anda.</p>
                    </div>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-violet-50 text-violet-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-violet-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-violet-600/30">
                        <i data-lucide="history" class="h-6 w-6"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Live Calendar Container --}}
        <div class="rounded-[32px] border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm transition-all duration-300 hover:shadow-md">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pb-5 border-b border-slate-100">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                        <i data-lucide="calendar-days" class="h-6 w-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 font-heading">Kalender Pendudukan Venue</h3>
                        <p class="text-xs text-slate-500">Visualisasi jadwal penggunaan tempat secara terintegrasi</p>
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
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-md px-4 py-6 transition-opacity duration-300 opacity-0">
        <div id="detailModalCard" class="w-full max-w-lg rounded-[32px] border border-white/80 bg-white shadow-2xl opacity-0 scale-95 transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-900 px-6 py-5 text-white flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-300">Informasi Event Terdaftar</span>
                    <h3 id="detailModalTitle" class="text-lg font-bold font-heading mt-0.5">Detail Agenda</h3>
                </div>
                <button type="button" onclick="closeDetailModal()"
                    class="rounded-full bg-white/10 p-2 text-slate-300 transition hover:bg-white/20 hover:text-white active:scale-95">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>

            <div class="space-y-4 p-6 sm:p-8">
                <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Nama Agenda / Kegiatan</span>
                    <p id="detailModalEvent" class="text-sm font-extrabold text-slate-900">-</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Lokasi Venue</span>
                        <p id="detailModalVenue" class="text-xs font-bold text-slate-800 mt-0.5">-</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Rentang Waktu</span>
                        <p id="detailModalTime" class="text-xs font-bold text-slate-800 mt-0.5 leading-relaxed">-</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-3.5 text-xs text-emerald-800 flex items-center gap-3">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                    </div>
                    <span class="font-medium">Data jadwal dikonfirmasi dan diverifikasi oleh admin pengelola.</span>
                </div>
            </div>

            <div class="flex justify-end p-6 pt-0">
                <button type="button" onclick="closeDetailModal()"
                    class="rounded-2xl border border-slate-300 bg-white px-6 py-2.5 text-xs font-bold text-slate-700 transition hover:bg-slate-100 active:scale-95 shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        function openDetailModal(eventData) {
            const modal = document.getElementById('detailModal');
            const card = document.getElementById('detailModalCard');

            document.getElementById('detailModalTitle').textContent = eventData.title || 'Kegiatan';
            document.getElementById('detailModalEvent').textContent = eventData.eventName || 'Kegiatan';
            document.getElementById('detailModalVenue').textContent = eventData.venue || 'Venue belum ditentukan';
            document.getElementById('detailModalTime').textContent = eventData.timeRange || '-';

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                card.classList.remove('opacity-0', 'scale-95');
                card.classList.add('opacity-100', 'scale-100');
            });
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            const card = document.getElementById('detailModalCard');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            card.classList.remove('opacity-100', 'scale-100');
            card.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

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
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },
                events: {!! json_encode($events ?? []) !!},
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
                    const title = info.event.title || 'Kegiatan';
                    const eventName = info.event.extendedProps?.event_name || title;
                    const venue = info.event.extendedProps?.venue || 'Venue belum ditentukan';
                    const start = info.event.start ? new Date(info.event.start).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '-';
                    const end = info.event.end ? new Date(info.event.end).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '-';

                    openDetailModal({
                        title: title,
                        eventName: eventName,
                        venue: venue,
                        timeRange: start + ' - ' + end
                    });
                }
            });
            calendar.render();
        });
    </script>
@endsection