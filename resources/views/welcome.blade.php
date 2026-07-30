<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Booking | Rumah Anno 1925</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 5s ease-in-out infinite; }
        .bg-transition { transition: background-image 1.2s ease-in-out; }
    </style>
</head>
<body class="bg-slate-50 font-sans overflow-x-hidden antialiased text-slate-800">

    <nav class="fixed top-0 left-0 w-full z-50 px-4 sm:px-8 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center shadow-md shadow-emerald-600/20">
                    <i class="fa-solid fa-landmark text-white text-base sm:text-lg"></i>
                </div>
                <div>
                    <span class="text-slate-900 font-extrabold text-base sm:text-lg tracking-wider block leading-none">RUMAH ANNO</span>
                    <span class="text-emerald-600 font-bold text-xs tracking-widest">EST. 1925</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="#about-bg" class="hidden md:inline-block text-slate-600 hover:text-emerald-600 text-sm font-semibold transition mr-4">Tentang</a>
                <a href="#features-bg" class="hidden md:inline-block text-slate-600 hover:text-emerald-600 text-sm font-semibold transition mr-4">Keunggulan</a>
                <a href="#gallery" class="hidden md:inline-block text-slate-600 hover:text-emerald-600 text-sm font-semibold transition mr-4">Galeri</a>
                <a href="{{ route('login') }}" class="text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-5 py-2 sm:px-6 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all duration-300 shadow-md shadow-emerald-600/20 hover:scale-105">
                    Masuk <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>
                </a>
            </div>
        </div>
    </nav>

    <div id="hero-bg" class="relative min-h-screen bg-cover bg-center flex flex-col justify-center items-center overflow-hidden bg-transition pt-28 pb-16 px-4">

        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 via-emerald-950/40 to-slate-50 z-0"></div>

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute w-80 h-80 sm:w-[500px] sm:h-[500px] bg-emerald-200/40 rounded-full blur-[100px] -top-20 -left-20 animate-pulse"></div>
            <div class="absolute w-80 h-80 sm:w-[500px] sm:h-[500px] bg-teal-200/40 rounded-full blur-[100px] bottom-0 right-0 animate-pulse delay-1000"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto my-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs sm:text-sm font-semibold text-emerald-800 bg-white/90 rounded-full border border-emerald-200 shadow-sm backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Sistem Reservasi Online Aktif</span>
            </div>

            <h1 class="text-3xl sm:text-6xl md:text-7xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg leading-tight">
                Abadikan Momen Istimewa di<br>
                <span class="bg-gradient-to-r from-emerald-300 via-teal-200 to-emerald-100 bg-clip-text text-transparent">
                    Rumah Anno 1925
                </span>
            </h1>

            <p class="text-sm sm:text-lg md:text-xl text-emerald-50 mb-10 max-w-2xl mx-auto leading-relaxed font-normal drop-shadow-md">
                Platform reservasi venue heritage terpadu. Pantau ketersediaan jadwal secara real-time, cegah bentrok acara, dan ajukan pemesanan dalam beberapa langkah mudah.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base sm:text-lg font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-full shadow-xl hover:scale-105 hover:shadow-emerald-600/30 transition-all duration-300">
                    Mulai Booking Sekarang
                    <i class="fa-solid fa-calendar-check ml-2.5"></i>
                </a>
                <a href="#about-bg" class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-4 text-base font-semibold text-slate-800 bg-white/90 hover:bg-white backdrop-blur-md rounded-full border border-slate-200 shadow-sm transition-all duration-300">
                    Jelajahi Venue
                </a>
            </div>

            <div class="grid grid-cols-3 gap-3 sm:gap-6 mt-12 max-w-2xl mx-auto pt-8 border-t border-white/30 backdrop-blur-sm bg-white/20 p-6 rounded-2xl shadow-sm">
                <div class="text-center">
                    <p class="text-2xl sm:text-4xl font-extrabold text-white drop-shadow">100<span class="text-emerald-300 text-lg sm:text-2xl font-bold">+</span></p>
                    <p class="text-[10px] sm:text-xs text-emerald-100 uppercase tracking-wider font-semibold mt-1">Kapasitas Tamu</p>
                </div>
                <div class="text-center border-x border-white/30">
                    <p class="text-2xl sm:text-4xl font-extrabold text-emerald-300 drop-shadow">1 Jam</p>
                    <p class="text-[10px] sm:text-xs text-emerald-100 uppercase tracking-wider font-semibold mt-1">Buffer Jeda Event</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl sm:text-4xl font-extrabold text-amber-200 drop-shadow">08.00 - 22.00</p>
                    <p class="text-[10px] sm:text-xs text-emerald-100 uppercase tracking-wider font-semibold mt-1">Jam Operasional</p>
                </div>
            </div>
        </div>
    </div>

    <div id="about-bg" class="py-16 sm:py-28 relative bg-cover bg-center bg-fixed bg-transition">
        <div class="absolute inset-0 bg-slate-50/90 backdrop-blur-md z-0"></div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10 sm:mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-2 block">Warisan Cagar Budaya</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">Sejarah & Pesona Kolonial</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="bg-white/90 p-6 sm:p-10 md:p-12 rounded-3xl border border-slate-200/80 shadow-xl backdrop-blur-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4">
                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed text-left">
                            <span class="text-emerald-700 font-semibold">Rumah Anno 1925</span> berdiri megah di kawasan Siring Kota Banjarmasin, menghadirkan pesona arsitektur klasik yang terawat sempurna. Bangunan bersejarah ini mencerminkan keanggunan masa lalu dan menjadi salah satu ikon cagar budaya kebanggaan Kalimantan Selatan.
                        </p>
                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed text-left">
                            Kini difungsikan sebagai destinasi wisata unggulan, restoran, dan ruang acara serbaguna, Rumah Anno 1925 siap menyuguhkan atmosfer nostalgia yang autentik untuk setiap kegiatan istimewa Anda.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 text-center shadow-sm">
                            <i class="fa-solid fa-camera-retro text-emerald-600 text-2xl mb-2"></i>
                            <h4 class="text-xs font-bold text-slate-800 uppercase">Spot Foto Classic</h4>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 text-center shadow-sm">
                            <i class="fa-solid fa-utensils text-emerald-600 text-2xl mb-2"></i>
                            <h4 class="text-xs font-bold text-slate-800 uppercase">Area Resto & Cafe</h4>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 text-center shadow-sm">
                            <i class="fa-solid fa-masks-theater text-emerald-600 text-2xl mb-2"></i>
                            <h4 class="text-xs font-bold text-slate-800 uppercase">Event Seni Culture</h4>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 text-center shadow-sm">
                            <i class="fa-solid fa-wifi text-emerald-600 text-2xl mb-2"></i>
                            <h4 class="text-xs font-bold text-slate-800 uppercase">Fasilitas Modern</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="gallery" class="py-16 sm:py-24 bg-slate-100/80 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-2 block">Suasana & Fungsionalitas Venue</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">Galeri Rumah Anno 1925</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 aspect-video sm:aspect-square bg-slate-200 shadow-md">
                    <img src="{{ asset('images/rumah-anno/hero1.jpg') }}" alt="Gedung Rumah Anno 1925" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent opacity-80 group-hover:opacity-90 transition"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <span class="text-xs font-semibold text-emerald-300 uppercase tracking-wider">Sunset</span>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 aspect-video sm:aspect-square bg-slate-200 shadow-md">
                    <img src="{{ asset('images/rumah-anno/hero2.jpg') }}" alt="Area Indoor Event" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent opacity-80 group-hover:opacity-90 transition"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <span class="text-xs font-semibold text-emerald-300 uppercase tracking-wider">Daylight</span>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 aspect-video sm:aspect-square bg-slate-200 shadow-md sm:col-span-2 md:col-span-1">
                    <img src="{{ asset('images/rumah-anno/hero3.jpg') }}" alt="Lanskap Siring Banjarmasin" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent opacity-80 group-hover:opacity-90 transition"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <span class="text-xs font-semibold text-emerald-300 uppercase tracking-wider">Sunrise</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="features-bg" class="py-16 sm:py-28 relative bg-cover bg-center bg-fixed bg-transition">
        <div class="absolute inset-0 bg-slate-50/95 backdrop-blur-md z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12 sm:mb-20">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-2 block">Fitur Unggulan</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">Kenapa Memilih E-Booking?</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="p-8 bg-white/90 backdrop-blur-xl rounded-3xl hover:-translate-y-2 hover:border-emerald-500/50 transition-all duration-300 border border-slate-200/80 group shadow-lg">
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 border border-emerald-200">
                        <i class="fa-regular fa-calendar-check text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Kalender Interaktif</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Cek ketersediaan tanggal & jam secara rinci tanpa perlu bertanya ulang ke pengelola venue.</p>
                </div>

                <div class="p-8 bg-white/90 backdrop-blur-xl rounded-3xl hover:-translate-y-2 hover:border-amber-500/50 transition-all duration-300 border border-slate-200/80 group shadow-lg">
                    <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 border border-amber-200">
                        <i class="fa-solid fa-hourglass-half text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Auto-Buffer Waktu</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Sistem otomatis memberi jeda 1 jam antar-event untuk sterilisasi & pembersihan ruangan.</p>
                </div>

                <div class="p-8 bg-white/90 backdrop-blur-xl rounded-3xl hover:-translate-y-2 hover:border-blue-500/50 transition-all duration-300 border border-slate-200/80 group shadow-lg">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 border border-blue-200">
                        <i class="fa-solid fa-user-shield text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Multi-Role Access</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Alur verifikasi berlapis antara Admin, Pimpinan, dan Pemohon agar transaksi transparan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 sm:py-24 bg-slate-100/60 border-t border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-2 block">Alur Pemesanan</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">4 Langkah Mudah Reservasi</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm relative">
                    <span class="text-4xl font-black text-emerald-600/10 absolute top-4 right-4">01</span>
                    <i class="fa-solid fa-right-to-bracket text-emerald-600 text-xl mb-4 block"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Login / Register</h4>
                    <p class="text-xs text-slate-500">Buat akun atau masuk untuk memulai reservasi.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm relative">
                    <span class="text-4xl font-black text-emerald-600/10 absolute top-4 right-4">02</span>
                    <i class="fa-solid fa-calendar-days text-emerald-600 text-xl mb-4 block"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Pilih Tanggal</h4>
                    <p class="text-xs text-slate-500">Cek kalender dan pilih waktu yang masih kosong.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm relative">
                    <span class="text-4xl font-black text-emerald-600/10 absolute top-4 right-4">03</span>
                    <i class="fa-solid fa-file-lines text-emerald-600 text-xl mb-4 block"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Isi Detail Event</h4>
                    <p class="text-xs text-slate-500">Lengkapi formulir keperluan acara Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm relative">
                    <span class="text-4xl font-black text-emerald-600/10 absolute top-4 right-4">04</span>
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl mb-4 block"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Persetujuan</h4>
                    <p class="text-xs text-slate-500">Tunggu verifikasi otomatis dari admin/pimpinan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-slate-900 text-slate-100 border-t border-slate-800">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-8 text-white tracking-wide">Lokasi & Kontak Resmi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left max-w-3xl mx-auto bg-slate-800/80 p-6 sm:p-8 rounded-3xl border border-slate-700 shadow-xl backdrop-blur-md">
                <div class="space-y-4">
                    <div>
                        <span class="block text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1"><i class="fa-solid fa-location-dot mr-1"></i> Area Parkir & Siring</span> 
                        <p class="text-sm font-medium text-slate-200">Siring Kota Banjarmasin</p>
                    </div>
                    <div>
                        <span class="block text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1"><i class="fa-solid fa-map mr-1"></i> Provinsi</span> 
                        <p class="text-sm font-medium text-slate-200">Kalimantan Selatan</p>
                    </div>
                    <div>
                        <span class="block text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1"><i class="fa-solid fa-phone mr-1"></i> Layanan Informasi / WA</span> 
                        <p class="text-sm font-medium text-slate-200">0851-4778-6123</p>
                    </div>
                </div>
                <div class="pt-4 md:pt-0 border-t md:border-t-0 border-slate-700">
                    <div>
                        <span class="block text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1"><i class="fa-solid fa-building mr-1"></i> Alamat Lengkap Presisi</span> 
                        <p class="text-sm font-medium text-slate-200 leading-relaxed">
                            MHMV+277, Gadang, Kec. Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan 70123
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-xs text-slate-500 mt-12">&copy; {{ date('Y') }} Rumah Anno 1925 E-Booking System. Built with high precision.</p>
        </div>
    </div>

    <a href="https://wa.me/6285147786123" target="_blank" class="fixed bottom-6 right-6 z-50 w-12 h-12 sm:w-14 sm:h-14 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-xl hover:scale-110 transition duration-300 border-2 border-emerald-300">
        <i class="fa-brands fa-whatsapp text-2xl sm:text-3xl"></i>
    </a>

    <script>
        const bgImages = [
            "{{ asset('images/rumah-anno/hero1.jpg') }}",
            "{{ asset('images/rumah-anno/hero2.jpg') }}",
            "{{ asset('images/rumah-anno/hero3.jpg') }}"
        ];
        
        let currentIndex = 0;
        const heroBg = document.getElementById('hero-bg');
        const aboutBg = document.getElementById('about-bg');
        const featuresBg = document.getElementById('features-bg');

        function setBackground(url) {
            heroBg.style.backgroundImage = `url('${url}')`;
            aboutBg.style.backgroundImage = `url('${url}')`;
            featuresBg.style.backgroundImage = `url('${url}')`;
        }

        function changeBackground() {
            if(bgImages[0].includes('MASUKKAN_LINK')) return; 

            currentIndex = (currentIndex + 1) % bgImages.length;
            setBackground(bgImages[currentIndex]);
        }

        setBackground(bgImages[0]);
        setInterval(changeBackground, 5000);
    </script>
</body>
</html>