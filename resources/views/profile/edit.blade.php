@extends('layouts.admin')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .dashboard-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Profile Upload Avatar Hover Effect */
        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }

        /* Smooth Input Focus Transition - Ditambah pr-12 untuk tombol show/hide password */
        .form-input-modern {
            @apply w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 pr-12 py-3.5 text-sm font-semibold text-slate-800 outline-none transition-all duration-200;
        }

        .form-input-modern:focus {
            @apply bg-white border-emerald-500 ring-4 ring-emerald-500/10;
        }

        .form-input-error {
            @apply border-rose-300 focus:border-rose-500 focus:ring-rose-500/10 bg-rose-50/50;
        }
    </style>

    <div class="dashboard-font mx-auto max-w-7xl space-y-8 p-4 md:p-0">
        
        {{-- =============================================
             MODERN HERO HEADER DENGAN FOTO PROFIL
             ============================================= --}}
        <div class="rounded-[32px] border border-white/10 bg-slate-900 p-8 text-white shadow-2xl shadow-slate-900/15 relative overflow-hidden">
            {{-- Background Ornament --}}
            <div class="absolute -bottom-10 -right-10 h-64 w-64 rounded-full bg-emerald-800/30 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                
                {{-- Kiri: Foto Profil Interaktif & Tombol Hapus --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="relative group shrink-0">
                        {{-- Frame Foto --}}
                        <div class="h-32 w-32 sm:h-40 sm:w-40 rounded-[32px] overflow-hidden border-4 border-white/10 shadow-xl shadow-slate-900/30 bg-slate-800">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}?v={{ $user->updated_at->timestamp }}" alt="Foto {{ $user->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                            @else
                                {{-- Fallback Avatar (Huruf Depan) --}}
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-tr from-emerald-500 to-teal-400 text-5xl font-black text-white">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Overlay Ubah Foto (Muncul saat Hover) --}}
                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                            @csrf
                            @method('PUT')
                            <label for="profile_photo" class="absolute inset-0 flex flex-col items-center justify-center rounded-[32px] bg-slate-900/80 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer backdrop-blur-sm border-2 border-dashed border-emerald-400 m-1">
                                <i data-lucide="camera" class="w-8 h-8 mb-2 text-emerald-400"></i>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-100">Ubah Foto</span>
                                <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/jpeg,image/png" onchange="document.getElementById('photoForm').submit();">
                            </label>
                        </form>
                    </div>

                    {{-- Tombol Hapus Foto dengan Custom Modern Modal Trigger --}}
                    @if($user->profile_photo)
                        <button type="button" onclick="openDeleteModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 text-xs font-bold transition-all active:scale-95">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            <span>Hapus Foto</span>
                        </button>

                        {{-- Modal Konfirmasi Custom --}}
                        <div id="deletePhotoModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
                            <div class="w-full max-w-sm rounded-[28px] border border-slate-800 bg-slate-900 p-6 text-white shadow-2xl scale-95 transition-transform duration-200" id="deletePhotoModalBox">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        <i data-lucide="alert-triangle" class="h-6 w-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-extrabold text-white">Hapus Foto Profil?</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Tampilan akan kembali ke inisial huruf.</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 mt-6">
                                    <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-xl border border-slate-700 bg-slate-800 px-4 py-2.5 text-xs font-bold text-slate-300 transition-all hover:bg-slate-700 active:scale-95">
                                        Batal
                                    </button>
                                    <form action="{{ route('profile.photo.delete') }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-rose-600/25 transition-all hover:bg-rose-700 active:scale-95">
                                            Ya, Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            function openDeleteModal() {
                                const modal = document.getElementById('deletePhotoModal');
                                const box = document.getElementById('deletePhotoModalBox');
                                modal.classList.remove('hidden');
                                setTimeout(() => {
                                    modal.classList.remove('opacity-0');
                                    box.classList.remove('scale-95');
                                    box.classList.add('scale-100');
                                }, 10);
                            }

                            function closeDeleteModal() {
                                const modal = document.getElementById('deletePhotoModal');
                                const box = document.getElementById('deletePhotoModalBox');
                                modal.classList.add('opacity-0');
                                box.classList.remove('scale-100');
                                box.classList.add('scale-95');
                                setTimeout(() => {
                                    modal.classList.add('hidden');
                                }, 200);
                            }
                        </script>
                    @endif
                </div>

                {{-- Kanan: Info Akun Sleek --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-3 mb-3">
                        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-500/10 px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-widest text-emerald-200 backdrop-blur-sm self-center md:self-start">
                            <i data-lucide="verified" class="w-4 h-4 text-emerald-300"></i>
                            <span>{{ $user->role->name ?? 'Pengguna' }}</span>
                        </div>
                        
                        @if($user->email_verified_at)
                            <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-400 self-center md:self-start" title="Email Terverifikasi">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Terverifikasi
                            </div>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white mb-1.5 leading-tight">
                        {{ $user->name }}
                    </h1>
                    <p class="text-sm sm:text-base text-slate-300 font-medium mb-5 max-w-xl mx-auto md:mx-0">
                        {{ $user->email }}
                    </p>

                    <div class="flex items-center justify-center md:justify-start gap-3 pt-2 border-t border-white/5">
                        <p class="text-xs text-slate-400">Terdaftar sejak: <span class="font-bold text-slate-200">{{ $user->created_at->format('d M Y') }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages (Sleek Notification) --}}
        @if(session('success_profile') || session('success_photo'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/80 p-5 text-sm font-bold text-emerald-900 shadow-lg shadow-emerald-500/5 backdrop-blur-sm animation-fade-in">
                <div class="p-1.5 rounded-full bg-emerald-100 text-emerald-600 border border-emerald-200">
                    <i data-lucide="check-circle-2" class="h-5 w-5 shrink-0"></i>
                </div>
                <span>{{ session('success_profile') ?? session('success_photo') }}</span>
            </div>
        @endif
        
        @error('profile_photo')
            <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50/80 p-5 text-sm font-bold text-rose-900 shadow-lg shadow-rose-500/5 backdrop-blur-sm animation-fade-in">
                <i data-lucide="alert-triangle" class="h-6 w-6 text-rose-600 shrink-0"></i>
                <span>Gagal mengubah foto: {{ $message }}</span>
            </div>
        @enderror

        {{-- =============================================
             GRID FORMULIR PENGATURAN
             ============================================= --}}
        <div class="grid gap-8 lg:grid-cols-2 items-start">
            
            {{-- Kartu 1: Informasi Dasar --}}
            <div class="rounded-[28px] border border-slate-200/70 bg-white p-7 sm:p-9 shadow-2xl shadow-slate-200/20 transition-all hover:shadow-emerald-500/5 hover:border-emerald-100">
                <div class="flex items-center gap-4 mb-8 pb-5 border-b border-slate-100">
                    <div class="p-3 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-inner">
                        <i data-lucide="user-cog" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-950 tracking-tight">Detail Personal</h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Kelola nama lengkap dan alamat email utama Anda.</p>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="mb-2.5 block text-xs font-extrabold uppercase tracking-widest text-slate-600">Nama Lengkap</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4.5 text-slate-400">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                class="form-input-modern pl-12 {{ $errors->has('name') ? 'form-input-error' : '' }}"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                        @error('name')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1.5"><i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2.5 block text-xs font-extrabold uppercase tracking-widest text-slate-600">Alamat Email</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4.5 text-slate-400">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="form-input-modern pl-12 {{ $errors->has('email') ? 'form-input-error' : '' }}"
                                placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1.5"><i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2.5 rounded-2xl bg-emerald-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition-all duration-150 hover:bg-emerald-700 hover:shadow-emerald-600/30 active:scale-[0.98]">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            <span>Perbarui Informasi Profil</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Kartu 2: Keamanan Akun --}}
            <div class="rounded-[28px] border border-slate-200/70 bg-white p-7 sm:p-9 shadow-2xl shadow-slate-200/20 transition-all hover:shadow-amber-500/5 hover:border-amber-100">
                <div class="flex items-center gap-4 mb-8 pb-5 border-b border-slate-100">
                    <div class="p-3 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 shadow-inner">
                        <i data-lucide="key-round" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-950 tracking-tight">Keamanan & Password</h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Ganti kata sandi Anda secara berkala untuk perlindungan maksimal.</p>
                    </div>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="mb-2.5 block text-xs font-extrabold uppercase tracking-widest text-slate-600">Password Baru</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4.5 text-slate-400">
                                <i data-lucide="key" class="w-5 h-5"></i>
                            </div>
                            <input type="password" id="password" name="password" required minlength="8"
                                class="form-input-modern pl-12 {{ $errors->has('password') ? 'form-input-error' : '' }}"
                                placeholder="Minimal 8 karakter unik">
                            <button type="button" onclick="togglePassword('password', 'iconNew')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-emerald-600 transition-colors z-10">
                                <i id="iconNew" data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1.5"><i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="mb-2.5 block text-xs font-extrabold uppercase tracking-widest text-slate-600">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4.5 text-slate-400">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                                class="form-input-modern pl-12"
                                placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePassword('password_confirmation', 'iconConfirm')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-emerald-600 transition-colors z-10">
                                <i id="iconConfirm" data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2.5 rounded-2xl bg-slate-900 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-slate-900/10 transition-all duration-150 hover:bg-slate-800 hover:shadow-slate-900/20 active:scale-[0.98]">
                            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Script untuk Toggle Mata Password --}}
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.setAttribute('data-lucide', 'eye-off');
                } else {
                    input.type = 'password';
                    icon.setAttribute('data-lucide', 'eye');
                }
                // Refresh Lucide Icons setelah atribut berubah
                lucide.createIcons();
            }
        }
    </script>
@endsection