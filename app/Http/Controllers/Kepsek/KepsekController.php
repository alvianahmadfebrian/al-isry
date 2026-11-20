<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Approval;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\PpdbRegistration;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KepsekController extends Controller
{
    public function dashboard(): View
    {
        $today = now()->toDateString();
        $todayAttendances = Attendance::whereDate('date', $today)->get();
        $presentCount = $todayAttendances->where('status', 'hadir')->count();
        $totalToday = $todayAttendances->count();
        $attendanceRate = $totalToday > 0 ? round(($presentCount / $totalToday) * 100, 1) : 100.0;

        $classes = SchoolClass::with(['homeroomTeacher'])
            ->withCount('students')
            ->orderBy('name')
            ->get()
            ->map(function (SchoolClass $class) {
                $avgScore = Grade::whereHas('student', fn ($q) => $q->where('class_id', $class->id))
                    ->avg('final_score');
                $class->setAttribute('average_score', round((float) $avgScore, 2));

                return $class;
            });

        $pendingApprovals = Approval::with('submitter')->where('status', 'menunggu')->latest()->get();
        $announcements = Announcement::with('author')->latest()->limit(5)->get();

        $attendanceBreakdown = [
            'hadir' => Attendance::where('status', 'hadir')->count(),
            'sakit' => Attendance::where('status', 'sakit')->count(),
            'izin' => Attendance::where('status', 'izin')->count(),
            'alpa' => Attendance::where('status', 'alpa')->count(),
        ];

        $predicateBreakdown = [
            'A' => Grade::where('predicate', 'A')->count(),
            'B' => Grade::where('predicate', 'B')->count(),
            'C' => Grade::where('predicate', 'C')->count(),
            'D' => Grade::where('predicate', 'D')->count(),
        ];

        return view('kepsek.dashboard', [
            'studentCount' => Student::count(),
            'teacherCount' => Teacher::count(),
            'classCount' => SchoolClass::count(),
            'ppdbCount' => PpdbRegistration::count(),
            'attendanceRate' => $attendanceRate,
            'attendanceBreakdown' => $attendanceBreakdown,
            'predicateBreakdown' => $predicateBreakdown,
            'classes' => $classes,
            'pendingApprovals' => $pendingApprovals,
            'announcements' => $announcements,
        ]);
    }

    public function reports(): View
    {
        $classes = SchoolClass::with([
            'homeroomTeacher',
            'students.grades.teacherAssignment.subject',
            'students.attendances',
        ])->orderBy('name')->get();

        return view('kepsek.reports', ['classes' => $classes]);
    }

    public function printAttendanceReport(Request $request): View
    {
        $monthInput = $request->string('bulan', now()->format('Y-m'))->toString();
        try {
            $period = \Illuminate\Support\Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth();
        } catch (\Throwable) {
            $period = now()->startOfMonth();
        }

        $classes = SchoolClass::with([
            'homeroomTeacher',
            'students.attendances' => fn ($q) => $q->whereYear('date', $period->year)->whereMonth('date', $period->month),
            'students.grades',
        ])->orderBy('name')->get();

        return view('kepsek.print-report', [
            'classes' => $classes,
            'period' => $period,
            'monthInput' => $period->format('Y-m'),
            'settings' => \App\Models\SchoolSetting::allAsMap(),
        ]);
    }

    public function approvals(): View
    {
        $approvals = Approval::with(['submitter', 'reviewer'])->latest()->get();

        return view('kepsek.approvals', ['approvals' => $approvals]);
    }

    public function decideApproval(Request $request, Approval $approval): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['disetujui', 'ditolak'])],
            'reviewer_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $approval->update([
            'status' => $data['status'],
            'reviewer_notes' => $data['reviewer_notes'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        ActivityLog::record('Persetujuan Dokumen', 'Kepala Sekolah mengubah status dokumen "'.$approval->title.'" menjadi '.$data['status'].'.');

        return back()->with('status', 'Keputusan dokumen berhasil disimpan.');
    }

    public function announcements(): View
    {
        $announcements = Announcement::with('author')->latest()->get();

        return view('kepsek.announcements', ['announcements' => $announcements]);
    }

    public function storeAnnouncement(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'audience' => ['required', Rule::in(['semua', 'guru', 'staf'])],
            'is_pinned' => ['boolean'],
        ]);

        Announcement::create([
            'author_id' => $request->user()->id,
            'title' => $data['title'],
            'content' => $data['content'],
            'audience' => $data['audience'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        ActivityLog::record('Pengumuman Internal', 'Membuat pengumuman internal: '.$data['title']);

        return back()->with('status', 'Pengumuman internal berhasil diterbitkan.');
    }
}
