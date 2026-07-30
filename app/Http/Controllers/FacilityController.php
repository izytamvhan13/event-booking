<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $facilities = Facility::latest()->get();
        return view('facilities.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('facilities', 'public');
        }

        Facility::create([
            'name' => $request->name,
            'photo' => $photoPath,
            'quantity' => $request->quantity ?? 0,
        ]);

        return redirect()->back()->with('success', 'Fasilitas baru berhasil ditambahkan!');
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $facility->name = $request->name;
        $facility->quantity = $request->quantity ?? 0;

        if ($request->hasFile('photo')) {
            if ($facility->photo && Storage::disk('public')->exists($facility->photo)) {
                Storage::disk('public')->delete($facility->photo);
            }
            $facility->photo = $request->file('photo')->store('facilities', 'public');
        }

        $facility->save();

        return redirect()->back()->with('success', 'Data fasilitas berhasil diperbarui!');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->photo && Storage::disk('public')->exists($facility->photo)) {
            Storage::disk('public')->delete($facility->photo);
        }
        
        $facility->delete();

        return redirect()->back()->with('success', 'Fasilitas berhasil dihapus!');
    }
}