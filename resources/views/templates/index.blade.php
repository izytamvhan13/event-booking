@extends('layouts.admin')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .dashboard-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <div class="dashboard-font mx-auto max-w-7xl space-y-6">
        
        {{-- Hero Header Section --}}
        <div class="rounded-[32px] border border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-800 p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-1 text-[11px] font-extrabold uppercase tracking-wider text-emerald-100 backdrop-blur-md">
                        <i data-lucide="folder-down" class="w-3.5 h-3.5 text-emerald-300"></i>
                        <span>Pusat Unduhan</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Template Surat & Proposal
                    </h2>
                    <p class="mt-1 text-xs sm:text-sm text-slate-200/90 leading-relaxed max-w-2xl">
                        Unduh dokumen dan format resmi untuk melengkapi syarat pengajuan booking event Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-xs sm:text-sm font-bold text-emerald-900 shadow-sm backdrop-blur-md">
                <i data-lucide="check-circle-2" class="h-5 w-5 text-emerald-600 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Form Unggah Template (Khusus Admin) --}}
        @if(Auth::user()->role === 'admin')
            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 sm:p-8 shadow-xl shadow-slate-200/30">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Unggah Template Baru</h3>
                        <p class="text-xs text-slate-500">Tambahkan berkas acuan baru agar dapat diunduh oleh pemohon.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('templates.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Judul --}}
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-700">Judul Template</label>
                            <input type="text" name="title" required placeholder="Contoh: Surat Permohonan Booking"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-xs sm:text-sm font-semibold text-slate-800 outline-none transition-all focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200">
                        </div>

                        {{-- Jenis --}}
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-700">Jenis Dokumen</label>
                            <select name="type" required class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-xs sm:text-sm font-semibold text-slate-800 outline-none transition-all focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200">
                                <option value="surat_permohonan">Surat Permohonan</option>
                                <option value="proposal_event">Proposal Event</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        {{-- File Input --}}
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-700">File (.doc, .docx, .pdf)</label>
                            <input type="file" name="file" required accept=".doc,.docx,.pdf"
                                class="w-full text-xs text-slate-500 rounded-xl border border-slate-200 bg-slate-50/60 p-2 font-medium file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white hover:file:bg-emerald-700 focus:outline-none transition-all">
                        </div>
                    </div>

                    <div class="pt-2 text-right">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-xs sm:text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition-all hover:bg-emerald-700 active:scale-95">
                            <i data-lucide="upload" class="h-4 w-4"></i>
                            <span>Unggah Template</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Grid Template List --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($templates as $template)
                <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/30 flex flex-col justify-between hover:border-emerald-200 transition-all">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <i data-lucide="file-text" class="h-6 w-6"></i>
                            </div>
                            <span class="rounded-full bg-slate-100 border border-slate-200/60 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-600">
                                {{ str_replace('_', ' ', $template->type) }}
                            </span>
                        </div>

                        <h4 class="font-extrabold text-slate-900 text-sm sm:text-base leading-snug">{{ $template->title }}</h4>
                        <p class="text-xs font-semibold text-slate-400 mt-1 flex items-center gap-1">
                            <i data-lucide="paperclip" class="w-3.5 h-3.5"></i>
                            <span>Format siap pakai</span>
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2">
                        <a href="{{ route('templates.download', $template->id) }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-slate-900/10 transition-all hover:bg-slate-800 active:scale-95">
                            <i data-lucide="download" class="h-4 w-4"></i>
                            <span>Unduh</span>
                        </a>

                        @if(Auth::user()->role === 'admin')
                            <form method="POST" action="{{ route('templates.destroy', $template->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-rose-50 p-2.5 text-rose-600 hover:bg-rose-100 hover:border-rose-300 transition-all active:scale-95"
                                    title="Hapus Template">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-[28px] border border-dashed border-slate-300 bg-slate-50/50 p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                        <i data-lucide="folder-open" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-600">Belum ada template yang diunggah</p>
                    <p class="text-xs text-slate-400 mt-0.5">Template dokumen permohonan atau proposal akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection