<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PpdbManagementController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = PpdbRegistration::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('kelompok'), fn ($q) => $q->where('group_choice', $request->string('kelompok')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(fn ($w) => $w
                    ->where('child_name', 'like', $term)
                    ->orWhere('registration_number', 'like', $term)
                    ->orWhere('parent_phone', 'like', $term)
                    ->orWhere('father_name', 'like', $term)
                    ->orWhere('mother_name', 'like', $term));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'total' => PpdbRegistration::count(),
            'menunggu' => PpdbRegistration::where('status', 'menunggu')->count(),
            'diverifikasi' => PpdbRegistration::where('status', 'diverifikasi')->count(),
            'diterima' => PpdbRegistration::where('status', 'diterima')->count(),
            'ditolak' => PpdbRegistration::where('status', 'ditolak')->count(),
        ];

        return view('admin.ppdb.index', [
            'registrations' => $registrations,
            'counts' => $counts,
        ]);
    }

    public function show(PpdbRegistration $ppdb): View
    {
        return view('admin.ppdb.show', [
            'registration' => $ppdb,
        ]);
    }

    public function updateStatus(Request $request, PpdbRegistration $ppdb): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['menunggu', 'diverifikasi', 'diterima', 'ditolak'])],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $ppdb->update([
            'status' => $data['status'],
            'admin_notes' => $data['admin_notes'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('status', 'Status pendaftaran PPDB berhasil diperbarui.');
    }

    public function destroy(PpdbRegistration $ppdb): RedirectResponse
    {
        $ppdb->delete();

        return redirect()->route('admin.ppdb.index')->with('status', 'Data pendaftar berhasil dihapus.');
    }
}
