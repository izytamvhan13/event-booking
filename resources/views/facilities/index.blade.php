@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .dashboard-font {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Modern Modal Transitions */
    .modal-backdrop {
        transition: opacity 0.25s ease-out;
    }
    
    .modal-card {
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
</style>

<div class="dashboard-font mx-auto max-w-7xl space-y-6">

    {{-- Banner Header --}}
    <div class="relative overflow-hidden rounded-[32px] border border-white/10 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 p-6 sm:p-8 text-white shadow-2xl shadow-emerald-950/20">
        <div class="pointer-events-none absolute -right-12 -top-12 h-56 w-56 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute right-1/3 -bottom-10 h-40 w-40 rounded-full bg-teal-400/15 blur-2xl"></div>

        <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2.5 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3.5 py-1 text-xs font-bold uppercase tracking-widest text-emerald-300 backdrop-blur-md">
                    <i data-lucide="box" class="h-3.5 w-3.5 text-emerald-400"></i>
                    Master Data
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white font-heading">Kelola Data Fasilitas</h2>
                <p class="mt-1.5 text-xs sm:text-sm text-slate-300">Master data perlengkapan dan fasilitas pendukung yang dapat ditambahkan ke Venue.</p>
            </div>
            
            <button onclick="openModal('modalTambahFasilitas')" class="group inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-300 px-5 py-3 text-xs font-extrabold text-slate-950 shadow-xl shadow-emerald-500/20 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                <i data-lucide="plus-circle" class="h-4 w-4 transition-transform group-hover:rotate-90"></i>
                <span>Tambah Fasilitas</span>
            </button>
        </div>
    </div>

    {{-- Flash Alert --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-900 shadow-sm">
            <i data-lucide="check-circle-2" class="h-5 w-5 text-emerald-600 shrink-0"></i>
            <p class="text-xs font-bold">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-[32px] border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-extrabold">
                        <th class="py-4 px-6 text-center w-16">No</th>
                        <th class="py-4 px-6 w-28">Foto</th>
                        <th class="py-4 px-6">Nama Fasilitas</th>
                        <th class="py-4 px-6 text-center w-36">Stok</th>
                        <th class="py-4 px-6 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($facilities as $index => $facility)
                        <tr class="group hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-6 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                @if($facility->photo)
                                    <img src="{{ asset('storage/' . $facility->photo) }}" alt="{{ $facility->name }}" class="h-12 w-12 rounded-2xl object-cover border border-slate-200 shadow-sm transition-transform group-hover:scale-105">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 border border-slate-200/60">
                                        <i data-lucide="image-off" class="h-5 w-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-extrabold text-slate-900 text-sm group-hover:text-emerald-700 transition-colors">{{ $facility->name }}</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if(($facility->quantity ?? 0) > 0)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 px-3 py-1 text-xs font-bold text-emerald-700">
                                        <i data-lucide="layers" class="h-3 w-3"></i> {{ $facility->quantity }} Unit
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 border border-slate-200 px-3 py-1 text-[11px] font-bold text-slate-500">
                                        <i data-lucide="infinity" class="h-3 w-3"></i> Tak Terbatas
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button onclick="openModal('modalEdit{{ $facility->id }}')" class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition hover:bg-emerald-50 hover:text-emerald-600 active:scale-95" title="Edit">
                                        <i data-lucide="edit-3" class="h-4 w-4"></i>
                                    </button>
                                    <button onclick="openModal('modalHapus{{ $facility->id }}')" class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition hover:bg-rose-50 hover:text-rose-600 active:scale-95" title="Hapus">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit Fasilitas --}}
                        <div id="modalEdit{{ $facility->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-md opacity-0 modal-backdrop">
                            <div class="modal-card relative w-full max-w-md overflow-hidden rounded-[32px] bg-white shadow-2xl border border-slate-100 scale-95 opacity-0">
                                <form action="{{ route('facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-900 px-6 py-5 text-white flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-300">Pembaruan Master Data</span>
                                            <h3 class="text-base font-bold font-heading mt-0.5">Edit Fasilitas</h3>
                                        </div>
                                        <button type="button" onclick="closeModal('modalEdit{{ $facility->id }}')" class="rounded-full bg-white/10 p-1.5 text-slate-300 hover:bg-white/20 hover:text-white transition active:scale-95">
                                            <i data-lucide="x" class="h-4 w-4"></i>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 focus-within:bg-white focus-within:border-emerald-500 transition">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama Fasilitas <span class="text-rose-500">*</span></label>
                                            <input type="text" name="name" value="{{ $facility->name }}" class="w-full bg-transparent text-sm font-bold text-slate-800 focus:outline-none" required>
                                        </div>
                                        <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 focus-within:bg-white focus-within:border-emerald-500 transition">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Jumlah Stok</label>
                                            <input type="number" name="quantity" min="0" value="{{ $facility->quantity }}" class="w-full bg-transparent text-sm font-bold text-slate-800 focus:outline-none">
                                            <p class="text-[11px] text-slate-400 mt-2 leading-relaxed">Isi 0 jika tidak dibatasi jumlahnya (misal: proyektor tunggal). Isi angka jika stok dapat dibagi (misal: kursi/meja).</p>
                                        </div>
                                        <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Upload Foto Baru (Opsional)</label>
                                            <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                                        </div>
                                    </div>
                                    <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 flex justify-end gap-2">
                                        <button type="button" onclick="closeModal('modalEdit{{ $facility->id }}')" class="rounded-2xl border border-slate-300 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-100 active:scale-95">Batal</button>
                                        <button type="submit" class="rounded-2xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-emerald-700 active:scale-95">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Modal Hapus Fasilitas --}}
                        <div id="modalHapus{{ $facility->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-md opacity-0 modal-backdrop">
                            <div class="modal-card relative w-full max-w-sm overflow-hidden rounded-[32px] bg-white p-6 text-center shadow-2xl border border-slate-100 scale-95 opacity-0">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 mb-4 shadow-sm">
                                    <i data-lucide="alert-triangle" class="h-7 w-7"></i>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900 font-heading">Hapus Fasilitas?</h3>
                                <p class="text-xs text-slate-500 mt-1 mb-6">Tindakan ini tidak bisa dibatalkan. Menghapus <strong>{{ $facility->name }}</strong> dari master data.</p>
                                <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="flex items-center gap-3">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="closeModal('modalHapus{{ $facility->id }}')" class="w-1/2 rounded-2xl border border-slate-300 bg-white py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-100 active:scale-95">Batal</button>
                                    <button type="submit" class="w-1/2 rounded-2xl bg-rose-600 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-rose-700 active:scale-95">Ya, Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                                    <i data-lucide="box" class="h-6 w-6"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-600">Belum Ada Data Fasilitas</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol di atas untuk menambahkan fasilitas baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Fasilitas --}}
<div id="modalTambahFasilitas" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-md opacity-0 modal-backdrop">
    <div class="modal-card relative w-full max-w-md overflow-hidden rounded-[32px] bg-white shadow-2xl border border-slate-100 scale-95 opacity-0">
        <form action="{{ route('facilities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-900 px-6 py-5 text-white flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-300">Master Data Baru</span>
                    <h3 class="text-base font-bold font-heading mt-0.5">Tambah Fasilitas Baru</h3>
                </div>
                <button type="button" onclick="closeModal('modalTambahFasilitas')" class="rounded-full bg-white/10 p-1.5 text-slate-300 hover:bg-white/20 hover:text-white transition active:scale-95">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 focus-within:bg-white focus-within:border-emerald-500 transition">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama Fasilitas <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" class="w-full bg-transparent text-sm font-bold text-slate-800 focus:outline-none" required placeholder="Contoh: Proyektor LCD 4K">
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 focus-within:bg-white focus-within:border-emerald-500 transition">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Jumlah Stok</label>
                    <input type="number" name="quantity" min="0" value="0" class="w-full bg-transparent text-sm font-bold text-slate-800 focus:outline-none">
                    <p class="text-[11px] text-slate-400 mt-2 leading-relaxed">Isi 0 jika fasilitas tunggal. Isi angka jika berupa aset yang dibagikan dalam jumlah banyak.</p>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Upload Foto</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                    <p class="mt-2 text-[11px] text-slate-400">Format: JPG, PNG. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalTambahFasilitas')" class="rounded-2xl border border-slate-300 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-100 active:scale-95">Batal</button>
                <button type="submit" class="rounded-2xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-emerald-700 active:scale-95">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        const card = modal.querySelector('.modal-card');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            if(card) {
                card.classList.remove('opacity-0', 'scale-95');
                card.classList.add('opacity-100', 'scale-100');
            }
        });
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const card = modal.querySelector('.modal-card');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        if(card) {
            card.classList.remove('opacity-100', 'scale-100');
            card.classList.add('opacity-0', 'scale-95');
        }

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
</script>
@endsection