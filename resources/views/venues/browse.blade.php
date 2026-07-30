@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-slate-800">Jelajahi Venue</h1>
        <p class="mt-1 text-sm text-slate-500">Lihat venue yang tersedia sebelum mengajukan booking.</p>
    </div>

    @if($venues->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
            Belum ada venue yang tersedia saat ini.
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($venues as $venue)
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    {{-- Venue Photo Container --}}
                    <div class="relative h-40 w-full bg-slate-100">
                        <div class="absolute bottom-2 right-2 z-10 flex items-center gap-1 rounded-lg bg-black/60 px-2 py-1 text-[10px] text-white pointer-events-none">
                            <i data-lucide="expand" class="h-3 w-3"></i>
                            <span>Lihat Foto</span>
                        </div>

                        @if($venue->indoor_photo)
                            <img src="{{ asset('storage/' . $venue->indoor_photo) }}" alt="{{ $venue->name }}"
                                class="h-full w-full object-cover cursor-pointer"
                                onclick="showImage('{{ asset('storage/' . $venue->indoor_photo) }}')">
                        @elseif($venue->outdoor_photo)
                            <img src="{{ asset('storage/' . $venue->outdoor_photo) }}" alt="{{ $venue->name }}"
                                class="h-full w-full object-cover cursor-pointer"
                                onclick="showImage('{{ asset('storage/' . $venue->outdoor_photo) }}')">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-300">
                                <i data-lucide="image" class="h-10 w-10"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Venue Details --}}
                    <div class="p-5">
                        <h3 class="text-base font-semibold text-slate-800">{{ $venue->name }}</h3>

                        @if($venue->capacity)
                            <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                                <i data-lucide="users" class="h-3.5 w-3.5"></i>
                                Kapasitas {{ $venue->capacity }} orang
                            </p>
                        @endif

                        @if($venue->description)
                            <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $venue->description }}</p>
                        @endif

                        @if($venue->facilities->isNotEmpty())
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach($venue->facilities->take(3) as $facility)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">
                                        {{ $facility->name }}
                                    </span>
                                @endforeach

                                @if($venue->facilities->count() > 3)
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-500">
                                        +{{ $venue->facilities->count() - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="mt-4 flex items-center gap-2">
                            <a href="{{ route('bookings.create', ['gacha_venue' => $venue->id]) }}"
                                class="flex-1 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-3 py-2 text-center text-xs font-semibold text-white shadow-sm transition hover:opacity-90">
                                Booking Venue Ini
                            </a>

                            @if($venue->gmaps_url)
                                <a href="{{ $venue->gmaps_url }}" target="_blank" rel="noopener"
                                    class="flex items-center justify-center rounded-xl border border-slate-200 px-3 py-2 text-slate-500 transition hover:bg-slate-50"
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

    {{-- Modal Preview Foto --}}
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 p-4">
        <div class="relative">
            <button onclick="closeImage()" class="absolute -top-10 right-0 text-white text-4xl hover:text-gray-300">
                &times;
            </button>
            <img id="modalImage" src="" alt="Preview Venue" class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-xl object-contain">
        </div>
    </div>

    {{-- Script Modal --}}
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