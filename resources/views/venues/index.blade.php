@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    {{-- Header Section --}}
    <div class="rounded-[28px] border border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-700 p-6 text-white shadow-[0_16px_50px_rgba(15,23,42,0.16)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-100 backdrop-blur">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15">
                        <i data-lucide="compass" class="h-3.5 w-3.5 stroke-[2.2]"></i>
                    </span>
                    Eksplorasi
                </div>
                <h2 class="text-2xl font-semibold tracking-tight text-white">Jelajahi Venue</h2>
                <p class="mt-2 text-sm leading-6 text-slate-200">Lihat tempat yang tersedia beserta fasilitasnya sebelum mengajukan booking.</p>
            </div>
        </div>
    </div>

    {{-- Venue Grid / Empty State --}}
    @if($venues->isEmpty())
        <div class="rounded-[28px] border border-slate-200 bg-white p-12 text-center shadow-[0_12px_40px_rgba(15,23,42,0.06)]">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <i data-lucide="building-2" class="h-6 w-6"></i>
            </div>
            <p class="text-sm font-medium text-slate-500">Belum ada venue yang tersedia saat ini.</p>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($venues as $venue)
                <div class="group flex flex-col justify-between overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_12px_40px_rgba(15,23,42,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div>
                        {{-- Venue Photo --}}
                        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                            <div class="pointer-events-none absolute bottom-3 right-3 z-10 flex items-center gap-1.5 rounded-full bg-slate-900/70 px-3 py-1 text-[11px] font-medium text-white backdrop-blur">
                                <i data-lucide="expand" class="h-3 w-3"></i>
                                <span>Lihat Foto</span>
                            </div>

                            @if($venue->indoor_photo)
                                <img src="{{ asset('storage/' . $venue->indoor_photo) }}" alt="{{ $venue->name }}"
                                    class="h-full w-full object-cover transition duration-500 cursor-pointer group-hover:scale-105"
                                    onclick="showImage('{{ asset('storage/' . $venue->indoor_photo) }}')">
                            @elseif($venue->outdoor_photo)
                                <img src="{{ asset('storage/' . $venue->outdoor_photo) }}" alt="{{ $venue->name }}"
                                    class="h-full w-full object-cover transition duration-500 cursor-pointer group-hover:scale-105"
                                    onclick="showImage('{{ asset('storage/' . $venue->outdoor_photo) }}')">
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-slate-300">
                                    <i data-lucide="image" class="h-10 w-10"></i>
                                    <span class="text-xs text-slate-400">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-800">{{ $venue->name }}</h3>

                            @if($venue->capacity)
                                <p class="mt-1 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                                    <i data-lucide="users" class="h-3.5 w-3.5"></i>
                                    Kapasitas {{ $venue->capacity }} orang
                                </p>
                            @endif

                            @if($venue->description)
                                <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-slate-600">{{ $venue->description }}</p>
                            @endif

                            @if($venue->facilities->isNotEmpty())
                                <div class="mt-4 flex flex-wrap gap-1.5">
                                    @foreach($venue->facilities->take(3) as $facility)
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-medium text-emerald-700 border border-emerald-100">
                                            {{ $facility->name }}
                                        </span>
                                    @endforeach

                                    @if($venue->facilities->count() > 3)
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-500">
                                            +{{ $venue->facilities->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="p-6 pt-0">
                        <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                            <a href="{{ route('bookings.create', ['gacha_venue' => $venue->id]) }}"
                                class="flex-1 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2.5 text-center text-xs font-semibold text-white shadow-sm transition hover:opacity-90">
                                Booking Venue Ini
                            </a>

                            @if($venue->gmaps_url)
                                <a href="{{ $venue->gmaps_url }}" target="_blank" rel="noopener"
                                    class="flex h-9 w-9 items-center justify-center rounded-2xl border border-slate-200 text-slate-500 transition hover:bg-slate-50 hover:text-slate-800"
                                    title="Lokasi Google Maps">
                                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Modal Preview Foto --}}
<div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/80 p-4 backdrop-blur-sm">
    <div class="relative max-w-4xl">
        <button onclick="closeImage()" class="absolute -top-12 right-0 flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white transition hover:bg-white/30">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
        <img id="modalImage" src="" alt="Preview Venue" class="max-h-[85vh] max-w-full rounded-2xl object-contain shadow-2xl">
    </div>
</div>

<script>
    function showImage(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    }

    function closeImage() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
    }

    document.getElementById('imageModal').addEventListener('click', function (e) {
        if (e.target.id === 'imageModal') {
            closeImage();
        }
    });
</script>
@endsection