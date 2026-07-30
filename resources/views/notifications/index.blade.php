@extends('layouts.admin')

@section('content')
    <style>
        .dashboard-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Animation Keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

    <div class="dashboard-font mx-auto max-w-5xl space-y-6">
        
        {{-- Header Section --}}
        <div class="rounded-[28px] border border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-800 p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-100 backdrop-blur-md">
                        <i data-lucide="bell" class="w-3.5 h-3.5 text-emerald-300"></i>
                        <span>Pemberitahuan</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                        Semua Notifikasi
                    </h2>
                    <p class="mt-1 text-xs sm:text-sm text-slate-200/90 leading-relaxed max-w-xl">
                        Riwayat lengkap pemberitahuan dan aktivitas terbaru yang masuk ke akun Anda.
                    </p>
                </div>

                @if($notifications->count() > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST" class="shrink-0">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-4 py-2.5 text-xs font-bold text-white shadow-sm backdrop-blur-md transition-all hover:bg-white hover:text-slate-900 active:scale-95">
                            <i data-lucide="check-check" class="w-4 h-4"></i>
                            <span>Tandai semua dibaca</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Notification List Card --}}
        <div class="overflow-hidden rounded-[28px] border border-slate-200/80 bg-white shadow-xl shadow-slate-200/40">
            <div class="divide-y divide-slate-100">
                @forelse($notifications as $index => $notification)
                    <div 
                        class="animate-fade-in-up flex items-start gap-4 p-5 transition-all duration-200 hover:bg-slate-50/80 hover:translate-x-1 {{ $notification->read_at ? 'bg-white' : 'bg-emerald-50/40' }}"
                        style="animation-delay: {{ $index * 50 }}ms;">
                        
                        {{-- Icon Indicator --}}
                        <div class="relative mt-0.5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl transition-all {{ $notification->read_at ? 'bg-slate-100 text-slate-400' : 'bg-emerald-100 text-emerald-700 shadow-sm' }}">
                                <i data-lucide="bell" class="h-4 w-4"></i>
                            </div>
                            
                            {{-- Pulse Dot for Unread --}}
                            @if(!$notification->read_at)
                                <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 border-2 border-white"></span>
                                </span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-relaxed">
                                {{ $notification->data['message'] ?? '-' }}
                            </p>
                            <div class="mt-1.5 flex items-center gap-2">
                                <i data-lucide="clock" class="h-3 w-3 text-slate-400"></i>
                                <span class="text-[11px] font-medium text-slate-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="shrink-0">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3.5 py-2 text-xs font-bold text-emerald-800 transition-all hover:bg-emerald-100 hover:border-emerald-300 active:scale-95 shadow-sm">
                                    <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                    <span>Tandai dibaca</span>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-slate-100 text-slate-300">
                                <i data-lucide="bell-off" class="h-7 w-7"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">Belum Ada Notifikasi</p>
                                <p class="mt-0.5 text-xs text-slate-400">Semua pemberitahuan baru akan muncul di sini.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
@endsection