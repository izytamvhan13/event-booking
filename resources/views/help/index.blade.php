@extends('layouts.admin')

@section('content')
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                <i data-lucide="help-circle" class="h-3.5 w-3.5"></i>
                <span>Pusat Bantuan & Layanan</span>
            </div>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl font-heading">
                Pusat Bantuan
            </h1>
            <p class="text-sm text-slate-500">
                Panduan praktis dan jawaban atas pertanyaan yang sering diajukan.
            </p>
        </div>
    </div>

    {{-- Main Grid Content --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Section 1: Cara Mengajukan Booking --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800 font-heading">Cara Mengajukan Booking</h2>
                    <p class="text-xs text-slate-400">4 langkah mudah melakukan reservasi</p>
                </div>
            </div>

            <ol class="relative mt-6 space-y-6 border-l-2 border-emerald-100 ml-3.5 pl-6">
                <li class="relative group">
                    <span class="absolute -left-[35px] top-0 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white shadow-md shadow-emerald-500/20 transition-transform group-hover:scale-110">
                        1
                    </span>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Cari Venue</h3>
                    <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                        Buka menu <strong class="text-emerald-700">Jelajahi Venue</strong> untuk memilih tempat yang sesuai dengan agenda acara Anda.
                    </p>
                </li>

                <li class="relative group">
                    <span class="absolute -left-[35px] top-0 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white shadow-md shadow-emerald-500/20 transition-transform group-hover:scale-110">
                        2
                    </span>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Isi Formulir</h3>
                    <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                        Klik tombol <strong class="text-emerald-700">Booking Venue Ini</strong>, lalu lengkapi detail tanggal, waktu, serta kebutuhan acara.
                    </p>
                </li>

                <li class="relative group">
                    <span class="absolute -left-[35px] top-0 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white shadow-md shadow-emerald-500/20 transition-transform group-hover:scale-110">
                        3
                    </span>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pantau Status</h3>
                    <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                        Cek pembaruan proses persetujuan melalui menu <strong class="text-emerald-700">Riwayat Booking</strong> secara berkala.
                    </p>
                </li>

                <li class="relative group">
                    <span class="absolute -left-[35px] top-0 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white shadow-md shadow-emerald-500/20 transition-transform group-hover:scale-110">
                        4
                    </span>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Konfirmasi Notifikasi</h3>
                    <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                        Sistem akan mengirimkan notifikasi resmi jika pengajuan Anda telah disetujui oleh admin atau pimpinan.
                    </p>
                </li>
            </ol>
        </div>

        {{-- Section 2: Pertanyaan Umum (Accordion FAQ) --}}
        <div class="flex flex-col gap-6">
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <i data-lucide="message-square-code" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800 font-heading">Pertanyaan Umum (FAQ)</h2>
                        <p class="text-xs text-slate-400">Temukan jawaban cepat untuk pertanyaan populer</p>
                    </div>
                </div>

                <div class="mt-4 space-y-3">
                    <details class="group rounded-2xl border border-slate-200/80 bg-slate-50/50 p-4 transition-all duration-200 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between font-bold text-slate-800 text-sm">
                            <span>Apakah saya bisa membatalkan booking?</span>
                            <span class="ml-2 shrink-0 rounded-full bg-white p-1 text-slate-500 shadow-sm transition-transform duration-300 group-open:-rotate-180">
                                <i data-lucide="chevron-down" class="h-4 w-4"></i>
                            </span>
                        </summary>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 border-t border-slate-200/60 pt-3">
                            Ya, pembatalan dapat dilakukan dengan menghubungi tim admin melalui kontak bantuan resmi di bawah sebelum tanggal pelaksanaan acara.
                        </p>
                    </details>

                    <details class="group rounded-2xl border border-slate-200/80 bg-slate-50/50 p-4 transition-all duration-200 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between font-bold text-slate-800 text-sm">
                            <span>Berapa lama proses persetujuan booking?</span>
                            <span class="ml-2 shrink-0 rounded-full bg-white p-1 text-slate-500 shadow-sm transition-transform duration-300 group-open:-rotate-180">
                                <i data-lucide="chevron-down" class="h-4 w-4"></i>
                            </span>
                        </summary>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 border-t border-slate-200/60 pt-3">
                            Proses pengecekan dan verifikasi dokumen oleh admin umumnya memerlukan waktu 1–2 hari kerja.
                        </p>
                    </details>

                    <details class="group rounded-2xl border border-slate-200/80 bg-slate-50/50 p-4 transition-all duration-200 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between font-bold text-slate-800 text-sm">
                            <span>Bagaimana jika saya lupa password akun?</span>
                            <span class="ml-2 shrink-0 rounded-full bg-white p-1 text-slate-500 shadow-sm transition-transform duration-300 group-open:-rotate-180">
                                <i data-lucide="chevron-down" class="h-4 w-4"></i>
                            </span>
                        </summary>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 border-t border-slate-200/60 pt-3">
                            Jika Anda masih bisa masuk, gunakan menu <strong class="text-emerald-700">Profil Saya</strong> untuk memperbarui password. Jika tidak dapat masuk, mintalah admin untuk melakukan reset password akun Anda.
                        </p>
                    </details>
                </div>
            </div>

            {{-- Section 3: Kontak Bantuan --}}
            <div class="rounded-3xl border border-slate-200/80 bg-gradient-to-br from-slate-900 to-slate-800 p-6 text-white shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        <i data-lucide="headset" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-heading text-white">Butuh Bantuan Lebih Lanjut?</h2>
                        <p class="text-xs text-slate-400">Hubungi tim pengelola langsung jika ada kendala teknis</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <a href="mailto:admin@ebooking.local" class="group flex items-center gap-3 rounded-2xl border border-slate-700/80 bg-slate-800/50 p-3.5 transition-all duration-200 hover:border-emerald-500/50 hover:bg-slate-800">
                        <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 group-hover:scale-110 transition-transform">
                            <i data-lucide="mail" class="h-4 w-4"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Email Admin</p>
                            <p class="truncate text-xs font-semibold text-slate-200">admin@ebooking.local</p>
                        </div>
                    </a>

                    <a href="tel:085147786123" class="group flex items-center gap-3 rounded-2xl border border-slate-700/80 bg-slate-800/50 p-3.5 transition-all duration-200 hover:border-emerald-500/50 hover:bg-slate-800">
                        <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 group-hover:scale-110 transition-transform">
                            <i data-lucide="phone-call" class="h-4 w-4"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Telepon / Hotline</p>
                            <p class="truncate text-xs font-semibold text-slate-200">(0851) 4778-6123</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection