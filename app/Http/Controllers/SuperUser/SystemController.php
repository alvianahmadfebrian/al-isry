<?php

namespace App\Http\Controllers\SuperUser;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\PpdbRegistration;
use App\Models\SchoolClass;
use App\Models\SchoolSetting;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SystemController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'users' => User::count(),
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'classes' => SchoolClass::count(),
            'subjects' => Subject::count(),
            'ppdb_pending' => PpdbRegistration::where('status', 'menunggu')->count(),
        ];

        $roleDistribution = [
            'Super User' => User::where('role', Role::SuperUser)->count(),
            'Admin' => User::where('role', Role::Admin)->count(),
            'Kepala Sekolah' => User::where('role', Role::KepalaSekolah)->count(),
            'Guru' => User::where('role', Role::Guru)->count(),
        ];

        $classSummary = SchoolClass::withCount('students')->orderBy('name')->get();

        $attendanceSummary = [
            'Hadir' => Attendance::where('status', 'hadir')->count(),
            'Sakit' => Attendance::where('status', 'sakit')->count(),
            'Izin' => Attendance::where('status', 'izin')->count(),
            'Alpa' => Attendance::where('status', 'alpa')->count(),
        ];

        $recentLogs = ActivityLog::with('user')->latest()->limit(8)->get();
        $recentUsers = User::latest()->limit(5)->get();
        $activeYear = AcademicYear::where('is_active', true)->first();

        return view('superuser.dashboard', [
            'stats' => $stats,
            'roleDistribution' => $roleDistribution,
            'classSummary' => $classSummary,
            'attendanceSummary' => $attendanceSummary,
            'recentLogs' => $recentLogs,
            'recentUsers' => $recentUsers,
            'activeYear' => $activeYear,
        ]);
    }

    public function settings(): View
    {
        return view('superuser.settings', [
            'settings' => SchoolSetting::allAsMap(),
            'academicYears' => AcademicYear::orderByDesc('name')->get(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'school_short_name' => ['required', 'string', 'max:100'],
            'school_tagline' => ['required', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'max:20'],
            'secondary_color' => ['required', 'string', 'max:20'],
            'accent_color' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:500'],
            'ppdb_status' => ['required', 'string', 'max:255'],
            'ppdb_period' => ['required', 'string', 'max:255'],
            'ppdb_quota' => ['required', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            SchoolSetting::setValue($key, $value);
        }

        ActivityLog::record('Pengaturan Sistem', 'Memperbarui pengaturan global sekolah & tema warna.');

        return back()->with('status', 'Pengaturan sistem berhasil disimpan.');
    }

    public function logs(): View
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);

        return view('superuser.logs', ['logs' => $logs]);
    }

    public function backup(): View
    {
        $summary = [
            'users' => User::count(),
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'classes' => SchoolClass::count(),
            'subjects' => Subject::count(),
            'ppdb_registrations' => PpdbRegistration::count(),
        ];

        return view('superuser.backup', ['summary' => $summary]);
    }

    public function downloadBackup(): Response
    {
        $payload = [
            'exported_at' => now()->toIso8601String(),
            'school_settings' => SchoolSetting::allAsMap(),
            'academic_years' => AcademicYear::all(),
            'classes' => SchoolClass::all(),
            'subjects' => Subject::all(),
            'teachers' => Teacher::all(),
            'students' => Student::all(),
            'ppdb_registrations' => PpdbRegistration::all(),
        ];

        ActivityLog::record('Backup Data', 'Mengunduh berkas backup JSON seluruh data sekolah.');

        $filename = 'backup-ra-alisry-'.now()->format('Ymd-His').'.json';

        return response(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
