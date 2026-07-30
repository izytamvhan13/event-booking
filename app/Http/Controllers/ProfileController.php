<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], [], [
            'name' => 'nama',
            'email' => 'email',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success_profile', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')->with('success_profile', 'Password berhasil diperbarui.');
    }
    
    public function updatePhoto(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
    ]);

    $user = auth()->user();

    // Hapus foto lama jika ada
    if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
        Storage::disk('public')->delete($user->profile_photo);
    }

    // Simpan foto baru ke folder storage/app/public/profile-photos
    $path = $request->file('profile_photo')->store('profile-photos', 'public');

    // Update path foto di database
    $user->update([
        'profile_photo' => $path
    ]);

    return back()->with('success_photo', 'Foto profil berhasil diperbarui!');
}

public function deletePhoto()
{
    $user = auth()->user();

    // Hapus file fisik dari storage jika ada
    if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
        Storage::disk('public')->delete($user->profile_photo);
    }

    // Set kolom profile_photo menjadi null di database
    $user->update([
        'profile_photo' => null
    ]);

    return back()->with('success_photo', 'Foto profil berhasil dihapus, kembali ke inisial huruf.');
}
}
