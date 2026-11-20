<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\SchoolSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PpdbController extends Controller
{
    public function create(): View
    {
        return view('landing.ppdb-form', [
            'settings' => SchoolSetting::allAsMap(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'child_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'nik' => ['nullable', 'string', 'max:25'],
            'religion' => ['nullable', 'string', 'max:30'],
            'group_choice' => ['required', Rule::in(['Kelompok A (4-5 Tahun)', 'Kelompok B (5-6 Tahun)'])],
            'father_name' => ['required', 'string', 'max:255'],
            'father_occupation' => ['nullable', 'string', 'max:100'],
            'mother_name' => ['required', 'string', 'max:255'],
            'mother_occupation' => ['nullable', 'string', 'max:100'],
            'parent_phone' => ['required', 'string', 'max:30'],
            'parent_email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'health_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['registration_number'] = PpdbRegistration::generateNumber();
        $data['religion'] = $data['religion'] ?? 'Islam';
        $data['status'] = 'menunggu';

        $registration = PpdbRegistration::create($data);

        return redirect()
            ->route('ppdb.show', $registration->registration_number)
            ->with('status', 'Pendaftaran berhasil dikirim! Simpan nomor pendaftaran Anda.');
    }

    public function show(string $number): View
    {
        $registration = PpdbRegistration::query()
            ->where('registration_number', $number)
            ->firstOrFail();

        return view('landing.ppdb-show', [
            'settings' => SchoolSetting::allAsMap(),
            'registration' => $registration,
        ]);
    }

    public function check(Request $request): View
    {
        $registration = null;
        $searched = $request->filled('nomor');

        if ($searched) {
            $registration = PpdbRegistration::query()
                ->where('registration_number', trim((string) $request->string('nomor')))
                ->first();
        }

        return view('landing.ppdb-check', [
            'settings' => SchoolSetting::allAsMap(),
            'registration' => $registration,
            'searched' => $searched,
        ]);
    }
}
