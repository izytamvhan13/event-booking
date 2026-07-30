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

        /* Interactive Facility Card Selection */
        .facility-card-selected {
            border-color: #10b981 !important;
            background-color: #ecfdf5 !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.12) !important;
        }

        /* Panel Transition Fade */
        .panel-fade {
            animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="dashboard-font mx-auto max-w-5xl space-y-6">
        
        {{-- Container Utama --}}
        <div class="rounded-[32px] border border-slate-200/80 bg-white p-6 sm:p-10 shadow-xl shadow-slate-200/30">
            
            {{-- Header Section --}}
            <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200/80 bg-emerald-50 px-3 py-1 text-[11px] font-extrabold uppercase tracking-widest text-emerald-700 mb-2">
                        <i data-lucide="calendar-plus" class="h-3.5 w-3.5"></i>
                        E-Form Reservasi
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 font-heading">
                        Form Pengajuan Booking
                    </h2>
                    <p class="mt-1 text-xs sm:text-sm text-slate-500">
                        Lengkapi detail kegiatan dan pilih fasilitas pendukung yang dibutuhkan.
                    </p>
                </div>
            </div>

            {{-- Banner Info Template Dokumen --}}
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl border border-emerald-200/80 bg-gradient-to-r from-emerald-50/90 via-teal-50/50 to-emerald-50/90 p-4 sm:p-5 shadow-sm">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 shadow-sm">
                        <i data-lucide="file-text" class="h-5 w-5"></i>
                    </div>
                    <p class="text-xs sm:text-sm leading-relaxed text-emerald-950 font-medium">
                        Butuh surat permohonan atau proposal? Unduh template resminya terlebih dahulu sebelum mengajukan booking.
                    </p>
                </div>
                <a href="{{ route('templates.index') }}"
                    class="shrink-0 inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-emerald-600/20 transition-all hover:bg-emerald-700 hover:shadow-lg active:scale-95">
                    <i data-lucide="download" class="h-4 w-4"></i>
                    <span>Lihat Template</span>
                </a>
            </div>

            {{-- Alerts & Validation Errors --}}
            @if($errors->any())
                <div class="mb-8 p-4 sm:p-5 bg-rose-50/90 border border-rose-200 text-rose-800 rounded-2xl text-xs sm:text-sm shadow-sm">
                    <div class="font-bold mb-1.5 flex items-center gap-2 text-rose-900">
                        <i data-lucide="alert-circle" class="h-4 w-4 text-rose-600 shrink-0"></i>
                        <span>Terjadi kesalahan pada inputan:</span>
                    </div>
                    <ul class="list-disc pl-9 space-y-1 text-rose-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success_gacha'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-200/80 text-emerald-800 text-lg shrink-0">🎉</span>
                    <span>{{ session('success_gacha') }}</span>
                </div>
            @endif

            {{-- Main Form --}}
            <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                    {{-- Left Column: Primary Fields --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Nama Kegiatan / Event <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="event_name" value="{{ old('event_name') }}"
                                class="w-full border border-slate-300 rounded-xl p-3 text-xs sm:text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white font-medium text-slate-800"
                                required placeholder="Contoh: Rapat Evaluasi Tahunan">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Nama Penanggung Jawab <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="pic_name" value="{{ old('pic_name') }}"
                                class="w-full border border-slate-300 rounded-xl p-3 text-xs sm:text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white font-medium text-slate-800"
                                required placeholder="Contoh: Budi Santoso">
                            <p class="mt-1.5 text-[11px] text-slate-400">Nama harus sesuai dengan identitas KTP yang diunggah.</p>
                            @error('pic_name')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Deskripsi Event <span class="font-normal text-slate-400 lowercase">(opsional)</span>
                            </label>
                            <textarea name="description" rows="3"
                                class="w-full border border-slate-300 rounded-xl p-3 text-xs sm:text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white font-medium text-slate-800"
                                placeholder="Jelaskan gambaran singkat acara, perkiraan jumlah tamu, atau kebutuhan khusus.">{{ old('description') }}</textarea>
                        </div>

                        {{-- Upload Documents Card --}}
                        <div class="rounded-2xl border border-amber-200/80 bg-amber-50/40 p-5 space-y-4">
                            <p class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-amber-900">
                                <i data-lucide="shield-check" class="h-4 w-4 text-amber-600 shrink-0"></i>
                                Berkas Persyaratan Wajib
                            </p>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Foto/Scan KTP Penanggung Jawab <span class="text-rose-500">*</span></label>
                                    <input type="file" name="ktp_photo" accept="image/*" required
                                        class="w-full border border-slate-300 rounded-xl p-2 text-xs bg-white focus:outline-none focus:border-emerald-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 transition-all">
                                    @error('ktp_photo')
                                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Surat Permohonan Resmi (PDF) <span class="text-rose-500">*</span></label>
                                    <input type="file" name="permohonan_file" accept="application/pdf" required
                                        class="w-full border border-slate-300 rounded-xl p-2 text-xs bg-white focus:outline-none focus:border-emerald-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 transition-all">
                                    @error('permohonan_file')
                                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Proposal Event (PDF) <span class="text-rose-500">*</span></label>
                                    <input type="file" name="proposal_file" accept="application/pdf" required
                                        class="w-full border border-slate-300 rounded-xl p-2 text-xs bg-white focus:outline-none focus:border-emerald-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 transition-all">
                                    @error('proposal_file')
                                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <p class="text-[11px] text-amber-800/80 leading-tight pt-1">
                                Maksimal 2MB untuk berkas foto KTP dan 4MB untuk masing-masing berkas PDF.
                            </p>
                        </div>

                        {{-- Venue Selection --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Venue / Ruangan <span class="text-rose-500">*</span></label>
                            <select name="venue_id" id="venueSelect"
                                class="w-full border border-slate-300 rounded-xl p-3 text-xs sm:text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white font-medium text-slate-800"
                                required onchange="updateVenueDetail()">
                                <option value="">-- Pilih Venue --</option>
                                @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}" {{ (old('venue_id') ?? request('gacha_venue')) == $venue->id ? 'selected' : '' }}>
                                        {{ $venue->name }} (Kapasitas: {{ $venue->capacity }} Orang)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Time Picker Fields --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Mulai <span class="text-rose-500">*</span></label>
                                <input type="datetime-local" name="start_time" id="startTimeInput"
                                    value="{{ old('start_time') ?? request('gacha_start') }}"
                                    class="w-full border border-slate-300 rounded-xl p-3 text-xs font-medium focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white text-slate-800"
                                    onchange="refreshFacilityQuota()" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Selesai <span class="text-rose-500">*</span></label>
                                <input type="datetime-local" name="end_time" id="endTimeInput"
                                    value="{{ old('end_time') ?? request('gacha_end') }}"
                                    class="w-full border border-slate-300 rounded-xl p-3 text-xs font-medium focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white text-slate-800"
                                    onchange="refreshFacilityQuota()" required>
                            </div>
                        </div>

                        {{-- Buffer Time Info Notice --}}
                        <div class="bg-sky-50/80 border border-sky-200/80 text-sky-900 rounded-2xl p-4 text-xs flex items-start gap-3">
                            <i data-lucide="info" class="w-4 h-4 text-sky-600 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed">Sistem memvalidasi jadwal secara otomatis. Terdapat jeda persiapan wajib minimal 1 jam antar jadwal kegiatan.</span>
                        </div>
                    </div>

                    {{-- Right Column: Interactive Venue & Facility Panel --}}
                    <div id="panelDetailVenue"
                        class="border-2 border-dashed border-slate-200 rounded-3xl p-8 bg-slate-50/60 flex flex-col justify-center items-center text-slate-400 min-h-[420px] transition-all">
                        <i data-lucide="image-off" class="w-12 h-12 mb-3 text-slate-300"></i>
                        <p class="text-xs font-medium text-center leading-relaxed">Silakan pilih venue<br>untuk melihat fasilitas dan informasi lokasi.</p>
                    </div>
                </div>

                {{-- Form Action Footer --}}
                <div class="pt-6 mt-10 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('bookings.index') }}"
                        class="px-6 py-3 border border-slate-300 rounded-xl text-slate-700 text-xs font-bold hover:bg-slate-50 active:scale-95 transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-7 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2 active:scale-95">
                        <span>Kirim Pengajuan</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dataVenues = {!! json_encode($venues) !!};
        const facilityUsage = {!! json_encode($facilityUsage) !!};
        const storageUrl = "{{ asset('storage') }}";

        function toggleFacilityQty(facilityId) {
            const checkbox = document.querySelector(`.facility-checkbox[data-facility-id="${facilityId}"]`);
            const qtyInput = document.querySelector(`.facility-qty-input[data-facility-id="${facilityId}"]`);
            const containerCard = document.getElementById(`facilityCard_${facilityId}`);

            if (checkbox && containerCard) {
                if (checkbox.checked) {
                    containerCard.classList.add('facility-card-selected');
                } else {
                    containerCard.classList.remove('facility-card-selected');
                }
            }

            if (!qtyInput) return;
            qtyInput.disabled = !checkbox.checked;
        }

        function computeRemaining(facilityId, totalQuantity) {
            const startEl = document.getElementById('startTimeInput');
            const endEl = document.getElementById('endTimeInput');
            if (!startEl || !endEl || !startEl.value || !endEl.value) return totalQuantity;

            const start = new Date(startEl.value);
            const end = new Date(endEl.value);
            if (isNaN(start) || isNaN(end)) return totalQuantity;

            const bufferStart = new Date(start.getTime() - 60 * 60 * 1000);
            const bufferEnd = new Date(end.getTime() + 60 * 60 * 1000);

            let used = 0;
            facilityUsage.forEach(u => {
                if (u.facility_id !== facilityId) return;
                const uStart = new Date(u.start);
                const uEnd = new Date(u.end);
                if (uStart < bufferEnd && uEnd > bufferStart) {
                    used += u.qty;
                }
            });

            return Math.max(0, totalQuantity - used);
        }

        function refreshFacilityQuota() {
            document.querySelectorAll('.facility-remaining').forEach(el => {
                const facilityId = parseInt(el.dataset.facilityId);
                const total = parseInt(el.dataset.total);
                const remaining = computeRemaining(facilityId, total);

                el.textContent = 'Sisa: ' + remaining;
                el.classList.toggle('text-emerald-600', remaining > 0);
                el.classList.toggle('text-rose-500', remaining <= 0);

                const qtyInput = document.querySelector(`.facility-qty-input[data-facility-id="${facilityId}"]`);
                if (qtyInput) {
                    qtyInput.max = remaining;
                    if (remaining <= 0) {
                        qtyInput.disabled = true;
                        const checkbox = document.querySelector(`.facility-checkbox[data-facility-id="${facilityId}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                            toggleFacilityQty(facilityId);
                        }
                    }
                }
            });
        }

        function updateVenueDetail() {
            const selectEl = document.getElementById('venueSelect');
            const panelEl = document.getElementById('panelDetailVenue');
            const selectedId = parseInt(selectEl.value);

            if (!selectedId) {
                panelEl.className = "border-2 border-dashed border-slate-200 rounded-3xl p-8 bg-slate-50/60 flex flex-col justify-center items-center text-slate-400 min-h-[420px] transition-all";
                panelEl.innerHTML = `
                    <i data-lucide="image-off" class="w-12 h-12 mb-3 text-slate-300"></i>
                    <p class="text-xs font-medium text-center leading-relaxed">Silakan pilih venue di sebelah kiri<br>untuk melihat fasilitas dan informasi lokasi.</p>
                `;
                lucide.createIcons();
                return;
            }

            const venue = dataVenues.find(v => v.id === selectedId);

            if (venue) {
                panelEl.className = "panel-fade space-y-5 bg-slate-50/50 p-6 rounded-3xl border border-slate-200/80 text-left w-full h-full";

                let facilitiesHtml = '';
                if (venue.facilities && venue.facilities.length > 0) {
                    facilitiesHtml = `<div class="flex overflow-x-auto space-x-3 pb-3 pt-1 snap-x scrollbar-thin">`;
                    venue.facilities.forEach(fac => {
                        let photoHtml = fac.photo
                            ? `<img src="${storageUrl}/${fac.photo}" class="w-full h-20 object-cover rounded-t-xl">`
                            : `<div class="w-full h-20 bg-slate-100 flex items-center justify-center rounded-t-xl text-slate-400"><i data-lucide="box" class="w-5 h-5"></i></div>`;

                        const hasQuota = fac.quantity && fac.quantity > 0;
                        const qtyInputHtml = hasQuota ? `
                            <div class="px-2 pb-2">
                                <p class="text-[10px] font-bold text-emerald-600 facility-remaining" data-facility-id="${fac.id}" data-total="${fac.quantity}">Sisa: ${fac.quantity}</p>
                                <input type="number" name="facility_qty[${fac.id}]" min="1" value="1" disabled
                                    class="facility-qty-input w-full border border-slate-200 rounded-lg p-1 text-[11px] mt-0.5 focus:outline-none focus:border-emerald-500 bg-white"
                                    data-facility-id="${fac.id}">
                            </div>
                        ` : '';

                        facilitiesHtml += `
                            <label class="flex-shrink-0 w-32 snap-center cursor-pointer group relative">
                                <div id="facilityCard_${fac.id}" class="border border-slate-200 rounded-2xl group-hover:border-emerald-400 transition-all bg-white overflow-hidden shadow-sm relative">
                                    ${photoHtml}
                                    <div class="absolute top-1.5 right-1.5 bg-white/90 backdrop-blur-sm rounded-lg shadow-sm">
                                        <input type="checkbox" name="facilities[]" value="${fac.id}" class="facility-checkbox w-4 h-4 text-emerald-600 focus:ring-emerald-500 rounded border-slate-300 cursor-pointer m-1" data-facility-id="${fac.id}" onchange="toggleFacilityQty(${fac.id})">
                                    </div>
                                    <div class="p-2 bg-white">
                                        <p class="text-[11px] font-bold text-slate-800 text-center truncate" title="${fac.name}">${fac.name}</p>
                                    </div>
                                    ${qtyInputHtml}
                                </div>
                            </label>
                        `;
                    });
                    facilitiesHtml += `</div>`;
                } else {
                    facilitiesHtml = `<p class="text-xs text-slate-400 italic bg-white p-3.5 rounded-2xl border border-slate-200/60">Venue ini tidak memiliki fasilitas pendukung tambahan.</p>`;
                }

                let gmapsHtml = '';
                if (venue.gmaps_url) {
                    gmapsHtml = `
                        <div class="mt-4">
                            <span class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Peta Lokasi</span>
                            <div class="w-full h-40 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                                ${venue.gmaps_url}
                            </div>
                        </div>
                    `;
                }

                panelEl.innerHTML = `
                    <div class="border-b border-slate-200/80 pb-3">
                        <h4 class="text-lg font-extrabold text-slate-900 tracking-tight font-heading">${venue.name}</h4>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-xl border border-emerald-200">Kapasitas: ${venue.capacity || 0} Orang</span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Fasilitas Tambahan</span>
                        ${facilitiesHtml}
                    </div>

                    <div>
                        <span class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Ruangan</span>
                        <p class="text-xs text-slate-600 bg-white p-3.5 rounded-2xl border border-slate-200/60 leading-relaxed">${venue.description || '-'}</p>
                    </div>

                    ${gmapsHtml}
                `;

                const iframe = panelEl.querySelector('iframe');
                if (iframe) {
                    iframe.setAttribute('width', '100%');
                    iframe.setAttribute('height', '100%');
                    iframe.className = "border-0 w-full h-full";
                }

                lucide.createIcons();
                refreshFacilityQuota();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('venueSelect').value) {
                updateVenueDetail();
            }
        });
    </script>
@endsection