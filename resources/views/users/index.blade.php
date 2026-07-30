@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="rounded-[28px] border border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-700 p-6 text-white shadow-[0_16px_50px_rgba(15,23,42,0.16)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-100 backdrop-blur">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </span>
                    Pengguna
                </div>
                <h2 class="text-2xl font-semibold tracking-tight text-white">Kelola Pengguna (Users)</h2>
                <p class="mt-2 text-sm leading-6 text-slate-200">Manajemen hak akses, penambahan admin, pimpinan, atau pengguna baru.</p>
            </div>
            @if(Auth::user()->role === 'admin')
                <button onclick="openModal('modalTambahUser')" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 shadow-[0_10px_30px_rgba(255,255,255,0.15)] transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-50">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </span>
                    Tambah User
                </button>
            @endif
        </div>
    </div>

@if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded text-sm font-medium">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded text-sm font-medium">
        {{ $errors->first() }}
    </div>
@endif

<div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_12px_40px_rgba(15,23,42,0.06)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 font-semibold text-gray-700 w-16 text-center">No</th>
                    <th class="p-4 font-semibold text-gray-700">Nama Lengkap</th>
                    <th class="p-4 font-semibold text-gray-700">Email</th>
                    <th class="p-4 font-semibold text-gray-700">Role / Hak Akses</th>
                    
                    @if(Auth::user()->role === 'admin')
                        <th class="p-4 font-semibold text-gray-700 text-center w-32">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $index => $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-center text-gray-500">{{ $index + 1 }}</td>
                    <td class="p-4 text-gray-800 font-bold">{{ $user->name }}</td>
                    <td class="p-4 text-gray-600">{{ $user->email }}</td>
                    <td class=""</td>
                        @if($user->role == 'admin')
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Admin</span>
                        @elseif($user->role == 'pimpinan')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Pimpinan</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold uppercase">User Biasa</span>
                        @endif
                    </td>
                    
                    @if(Auth::user()->role === 'admin')
                    <td class="p-4 text-center space-x-1">
                        <button onclick="openModal('modalEdit{{ $user->id }}')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        
                        @if(auth()->id() !== $user->id)
                        <button onclick="openModal('modalHapus{{ $user->id }}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        @endif
                    </td>
                    @endif
                </tr>

                @if(Auth::user()->role === 'admin')
                <div id="modalEdit{{ $user->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="closeModal('modalEdit{{ $user->id }}')"></div>
                        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">Edit Data Pengguna</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded p-2 focus:ring-1 focus:ring-emerald-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded p-2 focus:ring-1 focus:ring-emerald-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Hak Akses</label>
                                        <select name="role" class="w-full border border-gray-300 rounded p-2 focus:ring-1 focus:ring-emerald-500" required>
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="pimpinan" {{ $user->role == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                        </select>
                                    </div>
                                    <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Reset Password (Opsional)</label>
                                        <input type="text" name="password" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-1 focus:ring-emerald-500" placeholder="Kosongkan jika tidak ingin diubah">
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
                                    <button type="button" onclick="closeModal('modalEdit{{ $user->id }}')" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 font-medium">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 font-medium">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modalHapus{{ $user->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="closeModal('modalHapus{{ $user->id }}')"></div>
                        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-sm text-center">
                            <div class="p-6">
                                <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 mx-auto flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Pengguna?</h3>
                                <p class="text-sm text-gray-500 mb-6">Anda yakin ingin menghapus akun <strong>{{ $user->name }}</strong>?</p>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="flex justify-center space-x-2">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="closeModal('modalHapus{{ $user->id }}')" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 font-medium w-full">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium w-full">Ya, Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}" class="p-8 text-center text-gray-500">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(Auth::user()->role === 'admin')
<div id="modalTambahUser" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="closeModal('modalTambahUser')"></div>
        <div class="relative w-full max-w-md overflow-hidden rounded-[28px] bg-white shadow-[0_18px_45px_rgba(15,23,42,0.16)]">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/20">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Tambah Pengguna Baru</h3>
                            <p class="text-sm text-emerald-50">Buat akun dengan role yang sesuai</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 bg-white p-6">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required minlength="6">
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Role / Hak Akses <span class="text-red-500">*</span></label>
                        <select name="role" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            <option value="user">User Biasa</option>
                            <option value="admin">Admin</option>
                            <option value="pimpinan">Pimpinan</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-slate-200 bg-slate-50 px-6 py-4">
                    <button type="button" onclick="closeModal('modalTambahUser')" class="rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">Batal</button>
                    <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    function openModal(modalId) { document.getElementById(modalId).classList.remove('hidden'); }
    function closeModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }
</script>
@endsection