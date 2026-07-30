<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::latest()->get();

        return view('templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:surat_permohonan,proposal_event,lainnya',
            'file' => 'required|file|mimes:doc,docx,pdf|max:10240',
        ]);

        $path = $request->file('file')->store('templates', 'public');

        DocumentTemplate::create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil diunggah.');
    }

    public function download(DocumentTemplate $template)
    {
        return Storage::disk('public')->download($template->file_path, $template->original_name);
    }

    public function destroy(DocumentTemplate $template)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        Storage::disk('public')->delete($template->file_path);
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus.');
    }
}