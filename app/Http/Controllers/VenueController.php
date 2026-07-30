<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::with('facilities')->latest()->get();
        $all_facilities = Facility::all();
        return view('venues.index', compact('venues', 'all_facilities'));
    }

    public function browse()
    {
        $venues = Venue::with('facilities')->latest()->get();
        return view('venues.browse', compact('venues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'gmaps_url' => 'nullable|string',
            'facilities' => 'array|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['facilities', 'photo']);

        if ($request->hasFile('photo')) {
            $data['indoor_photo'] = $request->file('photo')->store('venues', 'public');
        }

        $venue = Venue::create($data);

        if ($request->has('facilities')) {
            $venue->facilities()->attach($request->facilities);
        }

        return redirect()->back()->with('success', 'Venue baru berhasil ditambahkan!');
    }

    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'gmaps_url' => 'nullable|string',
            'facilities' => 'array|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['facilities', 'photo']);

        if ($request->hasFile('photo')) {
            if ($venue->indoor_photo && Storage::disk('public')->exists($venue->indoor_photo)) {
                Storage::disk('public')->delete($venue->indoor_photo);
            }
            $data['indoor_photo'] = $request->file('photo')->store('venues', 'public');
        }

        $venue->update($data);

        if ($request->has('facilities')) {
            $venue->facilities()->sync($request->facilities);
        } else  {
            $venue->facilities()->detach();
        }  

        return redirect()->back()->with('success', 'Data venue berhasil diperbarui!');
    }

    public function destroy(Venue $venue)
    {
        if ($venue->indoor_photo && Storage::disk('public')->exists($venue->indoor_photo)) {
            Storage::disk('public')->delete($venue->indoor_photo);
        }

        $venue->delete();

        return redirect()->back()->with('success', 'Venue berhasil dihapus dari sistem!');
    }
}