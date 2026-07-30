@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">
        
        {{-- Header Banner Section --}}
        <div class="rounded-[28px] border border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-700 p-6 sm:p-8 text-white shadow-[0_16px_50px_rgba(15,23,42,0.16)] print:hidden relative overflow-hidden">
            <div class="relative z-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-100 backdrop-blur">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15">
                            <i data-lucide="file-text" class="h-3.5 w-3.5 stroke-[2.2]"></i>
                        </span>
                        Laporan
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">Laporan Pemesanan Venue</h2>
                    <p class="mt-2 text-sm leading-relaxed text-slate-200">Rekapitulasi seluruh data penggunaan venue berdasarkan periode bulan dan tahun.</p>
                </div>
                
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs font-semibold text-emerald-700 shadow-[0_10px_30px_rgba(255,255,255,0.15)] transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-50">
                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="printer" class="h-4 w-4"></i>
                    </span>
                    Cetak Laporan / PDF
                </button>
            </div>

            {{-- Background Ornaments --}}
            <div class="pointer-events-none absolute -right-10 -top-10 h-52 w-52 rounded-full bg-white/5 blur-2xl"></div>
            <div class="pointer-events-none absolute right-20 -bottom-10 h-40 w-40 rounded-full bg-emerald-400/10 blur-xl"></div>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('laporan.index') }}"
            class="flex flex-wrap items-end gap-3 rounded-[28px] border border-slate-200 bg-white p-5 shadow-[0_12px_40px_rgba(15,23,42,0.06)] print:hidden">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-700">Pilih Bulan</label>
                <select name="month" class="w-44 rounded-2xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-xs text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ (isset($month) && $month == $i) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-700">Pilih Tahun</label>
                <select name="year" class="w-36 rounded-2xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-xs text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                        <option value="{{ $y }}" {{ (isset($year) && $year == $y) ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-slate-800">
                <i data-lucide="filter" class="h-3.5 w-3.5"></i>
                Tampilkan Data
            </button>
        </form>

        {{-- Table Report Container --}}
        <div class="rounded-[28px] border border-slate-200 bg-white p-6 sm:p-8 shadow-[0_12px_40px_rgba(15,23,42,0.06)] print:p-0 print:shadow-none print:border-none">
            
            {{-- Print Header --}}
            <div class="hidden print:block text-center mb-6 border-b border-black/20 pb-4">
                <h1 class="text-xl font-bold uppercase tracking-wider text-black">Laporan Penggunaan Venue</h1>
                <p class="text-sm text-slate-700 mt-1">Periode: {{ date('F', mktime(0, 0, 0, $month ?? date('m'), 1)) }} {{ $year ?? date('Y') }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} oleh {{ Auth::user()->name }}</p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs sm:text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 print:bg-slate-200 print:border-black">
                        <tr>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black text-center w-12">No</th>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black">Nama Event</th>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black">Pemohon</th>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black">Venue</th>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black">Fasilitas</th>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black">Waktu Pelaksanaan</th>
                            <th class="p-3.5 font-semibold text-slate-700 border print:border-black text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bookings as $index => $booking)
                            <tr class="align-top hover:bg-slate-50 transition">
                                <td class="p-3.5 border print:border-black text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                                <td class="p-3.5 border print:border-black font-bold text-slate-800">{{ $booking->event_name }}</td>
                                <td class="p-3.5 border print:border-black text-slate-600">{{ $booking->user->name ?? '-' }}</td>
                                <td class="p-3.5 border print:border-black text-slate-700 font-medium">{{ $booking->venue->name ?? '-' }}</td>
                                <td class="p-3.5 border print:border-black">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($booking->facilities as $facility)
                                            <span class="rounded-md border border-slate-200 bg-slate-100 px-2 py-0.5 text-[10px] text-slate-600 print:border-none print:bg-transparent print:p-0">
                                                {{ $facility->name }}
                                            </span>
                                        @empty
                                            <span class="text-slate-400 text-xs">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="p-3.5 border print:border-black text-xs leading-5 text-slate-600">
                                    <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}</span>
                                    <span class="block text-[10px] text-slate-400">s/d</span>
                                    <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="p-3.5 border print:border-black text-center">
                                    @php
                                        $statusText = match($booking->status ?? '') {
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                            default => 'Pending',
                                        };
                                        $statusClass = match($booking->status ?? '') {
                                            'approved' => 'bg-emerald-50 border border-emerald-100 text-emerald-700',
                                            'rejected' => 'bg-red-50 border border-red-100 text-red-700',
                                            default => 'bg-amber-50 border border-amber-100 text-amber-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-xs font-medium text-slate-400 border print:border-black">
                                    Tidak ada data event pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Print Signature Footer --}}
            <div class="hidden print:flex justify-end mt-16">
                <div class="text-center w-64">
                    <p class="mb-16 text-sm">Mengetahui, Pimpinan</p>
                    <p class="font-bold text-sm border-b border-black pb-1">_________________________</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CSS Custom khusus Print --}}
    <style>
        @media print {
            body {
                background-color: white !important;
                font-size: 11px !important;
            }
            aside, header, footer, nav {
                display: none !important;
            }
            .mx-auto {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
@endsection