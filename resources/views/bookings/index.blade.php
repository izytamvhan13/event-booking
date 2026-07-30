@extends('layouts.admin')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .dashboard-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Custom Scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 9999px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Modal Animation */
        .modal-animated {
            animation: modalFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(8px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>

    <div class="dashboard-font mx-auto max-w-7xl space-y-6">
        
        {{-- Header Section --}}
        <div class="rounded-[32px] border border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-800 p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-1 text-[11px] font-extrabold uppercase tracking-wider text-emerald-100 backdrop-blur-md">
                        <i data-lucide="calendar-check-2" class="w-3.5 h-3.5 text-emerald-300"></i>
                        <span>Manajemen Booking</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        {{ Auth::user()->role === 'user' ? 'Riwayat Booking Saya' : 'Kelola Pengajuan Booking' }}
                    </h2>
                    <p class="mt-1 text-xs sm:text-sm text-slate-200/90 leading-relaxed max-w-2xl">
                        {{ Auth::user()->role === 'user' ? 'Pantau status pengajuan event Anda dan detail berkas yang dikirim di sini.' : 'Manajemen jadwal, persetujuan bertingkat, dan peninjauan berkas pengajuan.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs sm:text-sm font-bold text-emerald-900 shadow-sm">
                <i data-lucide="check-circle-2" class="h-5 w-5 text-emerald-600 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-xs sm:text-sm font-bold text-rose-900 shadow-sm">
                <i data-lucide="alert-circle" class="h-5 w-5 text-rose-600 shrink-0"></i>
                <span><strong>Gagal!</strong> {{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Table Container --}}
        <div class="overflow-hidden rounded-[32px] border border-slate-200/80 bg-white shadow-xl shadow-slate-200/30">
            <div class="overflow-x-auto scrollbar-thin">
                <table class="w-full border-collapse text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="p-4 sm:p-5">Nama Event</th>
                            <th class="p-4 sm:p-5">Lokasi / Venue</th>
                            <th class="p-4 sm:p-5">Waktu Pelaksanaan</th>
                            <th class="p-4 sm:p-5 text-center">Status</th>

                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan')
                                <th class="p-4 sm:p-5 text-center">Aksi (Approval)</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($bookings as $booking)
                            @if(Auth::user()->role !== 'user' || Auth::user()->id === $booking->user_id)
                                <tr class="transition-colors hover:bg-slate-50/70">
                                    <td class="p-4 sm:p-5">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                <i data-lucide="calendar-range" class="w-4 h-4"></i>
                                            </span>
                                            <div>
                                                <div class="font-bold text-slate-900 text-sm sm:text-base">{{ $booking->event_name }}</div>
                                                <span class="mt-0.5 block text-xs font-normal text-slate-400">
                                                    Diajukan oleh: <strong class="text-slate-600 font-semibold">{{ $booking->user->name ?? 'Unknown' }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 sm:p-5 text-slate-700">
                                        <div class="inline-flex items-center gap-1.5 font-semibold text-slate-800">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <span>{{ $booking->venue->name ?? 'Venue Tidak Ditemukan' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 sm:p-5 text-slate-700">
                                        <span class="block font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</span>
                                        <span class="block text-xs text-slate-400 mt-0.5">s/d {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y, H:i') }}</span>
                                    </td>
                                    <td class="p-4 sm:p-5 text-center">
                                        @if($booking->status == 'approved')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-emerald-700">
                                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                                                Disetujui
                                            </span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 border border-rose-200 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-rose-700">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                                Ditolak
                                            </span>
                                            @if($booking->rejection_reason)
                                                <span class="mt-1.5 block text-[11px] font-medium text-rose-600 line-clamp-1" title="{{ $booking->rejection_reason }}">
                                                    Alasan: {{ $booking->rejection_reason }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-amber-700">
                                                <i data-lucide="clock-3" class="w-3.5 h-3.5"></i>
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan')
                                        <td class="p-4 sm:p-5 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="openModal('modalDetail{{ $booking->id }}')"
                                                    class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition-all hover:bg-slate-800 active:scale-95 shadow-sm">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                    <span>Detail</span>
                                                </button>

                                                @if(Auth::user()->role === 'admin')
                                                    @if($booking->status !== 'pending')
                                                        {{-- Sudah final (approved/rejected) --}}
                                                    @elseif($booking->admin_status === 'forwarded')
                                                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-sky-50 border border-sky-200 px-3 py-2 text-xs font-bold text-sky-700">
                                                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                                            <span>Menunggu Pimpinan</span>
                                                        </span>
                                                    @else
                                                        <button onclick="openModal('modalStatus{{ $booking->id }}')"
                                                            class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-300 bg-emerald-50 px-3.5 py-2 text-xs font-bold text-emerald-800 transition-all hover:bg-emerald-100 hover:border-emerald-400 active:scale-95 shadow-sm">
                                                            <i data-lucide="clipboard-check" class="w-3.5 h-3.5"></i>
                                                            <span>Tinjau</span>
                                                        </button>
                                                    @endif
                                                @elseif(Auth::user()->role === 'pimpinan')
                                                    @if($booking->status !== 'pending')
                                                        {{-- Sudah final --}}
                                                    @elseif($booking->admin_status === 'forwarded')
                                                        <button onclick="openModal('modalStatus{{ $booking->id }}')"
                                                            class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-300 bg-emerald-50 px-3.5 py-2 text-xs font-bold text-emerald-800 transition-all hover:bg-emerald-100 hover:border-emerald-400 active:scale-95 shadow-sm">
                                                            <i data-lucide="pen-square" class="w-3.5 h-3.5"></i>
                                                            <span>Ubah Status</span>
                                                        </button>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 border border-slate-200 px-3 py-2 text-xs font-bold text-slate-500">
                                                            <i data-lucide="hourglass" class="w-3.5 h-3.5"></i>
                                                            <span>Menunggu Admin</span>
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>

                                {{-- Modal Section --}}
                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan')
                                    {{-- Modal Detail --}}
                                    <div id="modalDetail{{ $booking->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen px-4 py-6">
                                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalDetail{{ $booking->id }}')"></div>
                                            
                                            <div class="modal-animated relative bg-white rounded-[28px] w-full max-w-2xl shadow-2xl p-6 sm:p-8 z-10 border border-slate-100">
                                                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                                                    <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">Detail Pengajuan Booking</h3>
                                                    <button onclick="closeModal('modalDetail{{ $booking->id }}')" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                                                        <i data-lucide="x" class="w-5 h-5"></i>
                                                    </button>
                                                </div>

                                                <div class="space-y-4 text-xs sm:text-sm text-slate-700">
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
                                                        <div>
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Nama Event</span>
                                                            <p class="font-bold text-slate-900 mt-0.5">{{ $booking->event_name }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Pemohon</span>
                                                            <p class="font-bold text-slate-900 mt-0.5">{{ $booking->user->name ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Venue / Lokasi</span>
                                                            <p class="font-semibold text-slate-800 mt-0.5">{{ $booking->venue->name ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Waktu Kegiatan</span>
                                                            <p class="font-semibold text-slate-800 mt-0.5">
                                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    @if($booking->pic_name)
                                                        <div>
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Penanggung Jawab (PIC)</span>
                                                            <p class="font-semibold text-slate-800 mt-0.5">{{ $booking->pic_name }}</p>
                                                        </div>
                                                    @endif

                                                    @if($booking->description)
                                                        <div>
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi Event</span>
                                                            <p class="text-slate-600 mt-0.5 bg-slate-50 p-3 rounded-xl border border-slate-200/60 leading-relaxed">{{ $booking->description }}</p>
                                                        </div>
                                                    @endif

                                                    <div>
                                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Berkas Persyaratan Terlampir</span>
                                                        <div class="flex flex-wrap gap-2">
                                                            @if($booking->ktp_photo)
                                                                <a href="{{ asset('storage/' . $booking->ktp_photo) }}" target="_blank"
                                                                    class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-800 transition-all hover:bg-emerald-100">
                                                                    <i data-lucide="id-card" class="h-4 w-4"></i>
                                                                    <span>Foto KTP</span>
                                                                </a>
                                                            @endif
                                                            @if($booking->permohonan_file)
                                                                <a href="{{ asset('storage/' . $booking->permohonan_file) }}" target="_blank"
                                                                    class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-800 transition-all hover:bg-emerald-100">
                                                                    <i data-lucide="file-text" class="h-4 w-4"></i>
                                                                    <span>Surat Permohonan</span>
                                                                </a>
                                                            @endif
                                                            @if($booking->proposal_file)
                                                                <a href="{{ asset('storage/' . $booking->proposal_file) }}" target="_blank"
                                                                    class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-800 transition-all hover:bg-emerald-100">
                                                                    <i data-lucide="file-text" class="h-4 w-4"></i>
                                                                    <span>Proposal Event</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <hr class="border-slate-100 my-4">

                                                    <div>
                                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-3">Fasilitas Yang Diminta</span>
                                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                                            @forelse($booking->facilities as $facility)
                                                                <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                                                                    @if($facility->photo)
                                                                        <img src="{{ asset('storage/' . $facility->photo) }}" class="w-full h-24 object-cover">
                                                                    @else
                                                                        <div class="w-full h-24 bg-slate-100 flex items-center justify-center text-slate-300">
                                                                            <i data-lucide="box" class="w-6 h-6"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div class="p-2.5">
                                                                        <p class="font-bold text-slate-800 text-xs truncate">{{ $facility->name }}</p>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <p class="text-xs text-slate-400 italic col-span-full">Tidak mengajukan fasilitas tambahan.</p>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-6 pt-4 border-t border-slate-100 text-right">
                                                    <button onclick="closeModal('modalDetail{{ $booking->id }}')"
                                                        class="px-5 py-2.5 bg-slate-100 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-200 transition-all active:scale-95">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal Status / Approval --}}
                                    <div id="modalStatus{{ $booking->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen px-4 py-6">
                                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalStatus{{ $booking->id }}')"></div>

                                            <div class="modal-animated relative bg-white rounded-[28px] w-full max-w-lg shadow-2xl overflow-hidden z-10 border border-slate-100">
                                                @if(Auth::user()->role === 'admin')
                                                    <div class="p-6 sm:p-7">
                                                        <h3 class="text-lg font-extrabold text-slate-900 mb-1">Tinjau Pengajuan Booking</h3>
                                                        <p class="text-xs sm:text-sm text-slate-500 mb-4">Event: <strong class="text-slate-800">{{ $booking->event_name }}</strong></p>
                                                        <p class="text-xs text-slate-400 mb-5 bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                                                            Cek kelengkapan berkas di tombol "Detail" sebelum memutuskan. Tugas Anda menyaring — keputusan akhir ada di pimpinan.
                                                        </p>

                                                        {{-- Form Teruskan ke Pimpinan --}}
                                                        <div class="rounded-2xl border border-sky-200/80 bg-sky-50/50 p-4 mb-4">
                                                            <label class="block text-xs font-extrabold uppercase tracking-wider text-sky-900 mb-2">
                                                                Catatan untuk Pimpinan <span class="font-normal text-sky-600">(Opsional)</span>
                                                            </label>
                                                            <form action="{{ route('bookings.forward', $booking->id) }}" method="POST" id="formForward{{ $booking->id }}">
                                                                @csrf
                                                                <textarea name="admin_note" rows="2"
                                                                    class="w-full border border-sky-200 rounded-xl p-3 text-xs focus:outline-none focus:border-sky-500 bg-white font-medium text-slate-800"
                                                                    placeholder="Misal: Berkas lengkap, cocok untuk acara internal skala sedang."></textarea>
                                                                <button type="submit"
                                                                    class="mt-3 w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-sky-700 shadow-md shadow-sky-600/20 active:scale-95 transition-all">
                                                                    <i data-lucide="send" class="w-4 h-4"></i>
                                                                    <span>Loloskan & Teruskan ke Pimpinan</span>
                                                                </button>
                                                            </form>
                                                        </div>

                                                        {{-- Form Tolak Langsung --}}
                                                        <div class="rounded-2xl border border-rose-200/80 bg-rose-50/50 p-4">
                                                            <label class="block text-xs font-extrabold uppercase tracking-wider text-rose-900 mb-2">
                                                                Alasan Penolakan <span class="font-normal text-rose-600">(Wajib jika ditolak)</span>
                                                            </label>
                                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <textarea name="rejection_reason" rows="2" required
                                                                    class="w-full border border-rose-200 rounded-xl p-3 text-xs focus:outline-none focus:border-rose-500 bg-white font-medium text-slate-800"
                                                                    placeholder="Ketik alasan mengapa pengajuan ini ditolak..."></textarea>
                                                                <button type="submit"
                                                                    class="mt-3 w-full inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-rose-700 shadow-md shadow-rose-600/20 active:scale-95 transition-all">
                                                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                                                    <span>Tolak Pengajuan</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 text-right">
                                                        <button type="button" onclick="closeModal('modalStatus{{ $booking->id }}')"
                                                            class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-all active:scale-95">
                                                            Batal
                                                        </button>
                                                    </div>
                                                @else
                                                    {{-- Modal Keputusan Pimpinan --}}
                                                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="p-6 sm:p-7 space-y-4">
                                                            <h3 class="text-lg font-extrabold text-slate-900">Ubah Status Booking (Persetujuan)</h3>
                                                            <p class="text-xs sm:text-sm text-slate-500">Event: <strong class="text-slate-800">{{ $booking->event_name }}</strong></p>

                                                            @if($booking->admin_note)
                                                                <div class="rounded-2xl border border-sky-200/80 bg-sky-50/60 p-3.5">
                                                                    <p class="text-[11px] font-extrabold uppercase tracking-wider text-sky-800 mb-0.5">Catatan dari Admin</p>
                                                                    <p class="text-xs text-sky-900 leading-relaxed">{{ $booking->admin_note }}</p>
                                                                </div>
                                                            @endif

                                                            <div>
                                                                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">Keputusan Akhir</label>
                                                                <select name="status" id="statusSelect{{ $booking->id }}" onchange="toggleRejectionReason('{{ $booking->id }}')"
                                                                    class="w-full border border-slate-300 rounded-xl p-3 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500 bg-white">
                                                                    <option value="approved">Setujui Pengajuan</option>
                                                                    <option value="rejected">Tolak Pengajuan</option>
                                                                </select>
                                                            </div>

                                                            <div id="rejectionField{{ $booking->id }}" class="hidden">
                                                                <label class="block text-xs font-extrabold uppercase tracking-wider text-rose-800 mb-2">Alasan Penolakan</label>
                                                                <textarea name="rejection_reason" rows="2"
                                                                    class="w-full border border-rose-200 rounded-xl p-3 text-xs focus:outline-none focus:border-rose-500 bg-white font-medium text-slate-800"
                                                                    placeholder="Tuliskan alasan mengapa pengajuan ditolak..."></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                                                            <button type="button" onclick="closeModal('modalStatus{{ $booking->id }}')"
                                                                class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-all active:scale-95">
                                                                Batal
                                                            </button>
                                                            <button type="submit"
                                                                class="px-5 py-2 bg-emerald-600 rounded-xl text-xs font-bold text-white hover:bg-emerald-700 shadow-md shadow-emerald-600/20 transition-all active:scale-95">
                                                                Simpan Keputusan
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 text-xs sm:text-sm italic">
                                    Belum ada data pengajuan booking.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        function toggleRejectionReason(id) {
            const select = document.getElementById('statusSelect' + id);
            const rejectionField = document.getElementById('rejectionField' + id);
            if (select && rejectionField) {
                if (select.value === 'rejected') {
                    rejectionField.classList.remove('hidden');
                } else {
                    rejectionField.classList.add('hidden');
                }
            }
        }
    </script>
@endsection