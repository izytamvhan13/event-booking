<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - E-Booking Rumah Anno 1925</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float { animation: float 5s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 flex flex-col justify-between p-4 sm:p-6 lg:p-8 relative overflow-x-hidden antialiased">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute w-96 h-96 sm:w-[600px] sm:h-[600px] bg-emerald-100/70 rounded-full blur-[100px] -top-20 -left-20 animate-pulse"></div>
        <div class="absolute w-96 h-96 sm:w-[600px] sm:h-[600px] bg-teal-100/60 rounded-full blur-[100px] bottom-0 right-0 animate-pulse delay-1000"></div>
    </div>

    <div class="w-full max-w-6xl mx-auto flex justify-between items-center relative z-10 mb-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm text-slate-600 hover:text-emerald-700 transition-all bg-white/80 hover:bg-white border border-slate-200/80 px-4 py-2 rounded-full shadow-sm backdrop-blur-md">
            <i class="fa-solid fa-arrow-left text-emerald-600"></i>
            <span class="font-medium">Kembali ke Beranda</span>
        </a>
        <div class="text-xs sm:text-sm font-extrabold tracking-wider text-slate-700">
            RUMAH ANNO <span class="text-emerald-600">1925</span>
        </div>
    </div>

    <div class="w-full max-w-5xl mx-auto relative z-10 my-auto">
        <div class="overflow-hidden rounded-3xl sm:rounded-[32px] border border-white bg-white/90 shadow-[0_20px_60px_-15px_rgba(16,185,129,0.12)] backdrop-blur-xl grid lg:grid-cols-12">

            <div class="hidden lg:flex lg:col-span-5 flex-col justify-between bg-gradient-to-br from-emerald-800 via-teal-800 to-slate-900 p-10 text-white relative overflow-hidden">
                <!-- Background Decorative Pattern -->
                <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>

                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 text-xs font-semibold text-emerald-200 bg-white/10 rounded-full border border-white/15 backdrop-blur-md">
                        <i class="fa-solid fa-user-plus text-emerald-300"></i>
                        <span>Pendaftaran Akun</span>
                    </div>

                    <h2 class="mt-8 text-3xl font-extrabold leading-tight tracking-tight">
                        Bergabung & Mulai Reservasi Venue Heritage
                    </h2>
                    <p class="mt-4 text-sm text-emerald-100/80 leading-relaxed font-light">
                        Buat akun pengguna untuk kemudahan pengajuan sewa tempat, mengecek status persetujuan, dan mengelola jadwal event Anda secara transparan.
                    </p>
                </div>

                <div class="space-y-3 my-6">
                    <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <div class="w-8 h-8 rounded-xl bg-emerald-400/20 flex items-center justify-center text-emerald-300">
                            <i class="fa-solid fa-bolt text-xs"></i>
                        </div>
                        <span class="text-xs font-medium text-emerald-50">Proses pengajuan cepat & terintegrasi</span>
                    </div>
                    <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <div class="w-8 h-8 rounded-xl bg-amber-400/20 flex items-center justify-center text-amber-300">
                            <i class="fa-solid fa-bell text-xs"></i>
                        </div>
                        <span class="text-xs font-medium text-emerald-50">Notifikasi status booking ter-update</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/15 text-xs text-emerald-200/70 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-emerald-300"></i>
                    <span>Siring Kota Banjarmasin, Kalimantan Selatan</span>
                </div>
            </div>

            <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center bg-white/80">
                <div class="text-center sm:text-left mb-6">
                    <div class="mx-auto sm:mx-0 w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center mb-4 shadow-sm">
                        <i class="fa-solid fa-id-card text-xl"></i>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Baru</h1>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500">Lengkapi data Anda untuk mulai menggunakan layanan e-booking</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-700">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama lengkap"
                                class="w-full rounded-2xl border {{ $errors->has('name') ? 'border-red-300 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/10' }} bg-slate-50/70 py-3 pl-11 pr-4 text-xs sm:text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:bg-white focus:ring-4">
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-700">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                placeholder="nama@email.com"
                                class="w-full rounded-2xl border {{ $errors->has('email') ? 'border-red-300 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/10' }} bg-slate-50/70 py-3 pl-11 pr-4 text-xs sm:text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:bg-white focus:ring-4">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-700">
                            Password
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" required minlength="6"
                                placeholder="Minimal 6 karakter"
                                class="w-full rounded-2xl border {{ $errors->has('password') ? 'border-red-300 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/10' }} bg-slate-50/70 py-3 pl-11 pr-11 text-xs sm:text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:bg-white focus:ring-4">
                            
                            <button type="button" onclick="togglePassword('password', 'toggleIcon1')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors p-1">
                                <i class="fa-regular fa-eye text-sm" id="toggleIcon1"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-700">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6"
                                placeholder="Ulangi password Anda"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 py-3 pl-11 pr-11 text-xs sm:text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10">
                            
                            <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors p-1">
                                <i class="fa-regular fa-eye text-sm" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="registerBtn"
                        class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 px-5 py-3.5 text-xs sm:text-sm font-bold text-white shadow-lg shadow-emerald-600/25 transition-all hover:scale-[1.01] hover:brightness-110 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70 mt-4">
                        <i id="registerIcon" class="fa-solid fa-user-plus"></i>
                        <svg id="registerSpinner" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span id="registerBtnText">Daftar Akun</span>
                    </button>

                    <div class="text-center text-xs sm:text-sm text-slate-500 pt-4 border-t border-slate-100">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}"
                            class="ml-1 font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">Masuk di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="w-full max-w-6xl mx-auto text-center relative z-10 mt-6">
        <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Rumah Anno 1925 E-Booking System. All rights reserved.</p>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.querySelector('form').addEventListener('submit', function () {
            const btn = document.getElementById('registerBtn');
            document.getElementById('registerIcon').classList.add('hidden');
            document.getElementById('registerSpinner').classList.remove('hidden');
            document.getElementById('registerBtnText').textContent = 'Memproses...';
            btn.disabled = true;
        });
    </script>
</body>

</html>