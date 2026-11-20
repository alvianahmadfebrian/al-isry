<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Approval;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Material;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GuruController extends Controller
{
    private function currentTeacher(Request $request): Teacher
    {
        $user = $request->user();

        return Teacher::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'position' => 'Guru Kelas',
                'specialization' => 'Tematik & Pembiasaan',
                'show_on_landing' => false,
            ]
        );
    }

    /**
     * @return Collection<int, TeacherAssignment>
     */
    private function teacherAssignments(Request $request): Collection
    {
        $teacher = $this->currentTeacher($request);

        return TeacherAssignment::with(['subject', 'schoolClass.students', 'schedules'])
            ->where('teacher_id', $teacher->id)
            ->orderBy('id')
            ->get();
    }

    private function ownedAssignment(Request $request, TeacherAssignment $assignment): TeacherAssignment
    {
        $teacher = $this->currentTeacher($request);

        if ((int) $assignment->teacher_id !== (int) $teacher->id) {
            abort(403, 'Anda hanya dapat mengakses kelas dan mata pelajaran yang Anda ampu.');
        }

        return $assignment->load(['subject', 'schoolClass.students', 'schedules']);
    }

    public function dashboard(Request $request): View
    {
        $teacher = $this->currentTeacher($request);
        $assignments = $this->teacherAssignments($request);

        $announcements = Announcement::with('author')
            ->whereIn('audience', ['semua', 'guru'])
            ->orderByDesc('is_pinned')
            ->latest()
            ->limit(5)
            ->get();

        $myApprovals = Approval::where('submitted_by', $request->user()->id)->latest()->limit(5)->get();

        $assignmentIds = $assignments->pluck('id');
        $attendanceStats = [
            'hadir' => Attendance::whereIn('teacher_assignment_id', $assignmentIds)->where('status', 'hadir')->count(),
            'sakit' => Attendance::whereIn('teacher_assignment_id', $assignmentIds)->where('status', 'sakit')->count(),
            'izin' => Attendance::whereIn('teacher_assignment_id', $assignmentIds)->where('status', 'izin')->count(),
            'alpa' => Attendance::whereIn('teacher_assignment_id', $assignmentIds)->where('status', 'alpa')->count(),
        ];
        $avgGrade = round((float) Grade::whereIn('teacher_assignment_id', $assignmentIds)->avg('final_score'), 2);

        return view('guru.dashboard', [
            'teacher' => $teacher,
            'assignments' => $assignments,
            'attendanceStats' => $attendanceStats,
            'avgGrade' => $avgGrade,
            'announcements' => $announcements,
            'myApprovals' => $myApprovals,
        ]);
    }

    public function attendancesIndex(Request $request): View
    {
        $assignments = $this->teacherAssignments($request);
        $selected = $assignments->firstWhere('id', $request->integer('assignment_id')) ?? $assignments->first();

        if (! $selected) {
            return view('guru.empty', ['title' => 'Input & Rekap Absensi Siswa']);
        }

        return $this->attendances($request, $selected);
    }

    public function gradesIndex(Request $request): View
    {
        $assignments = $this->teacherAssignments($request);
        $selected = $assignments->firstWhere('id', $request->integer('assignment_id')) ?? $assignments->first();

        if (! $selected) {
            return view('guru.empty', ['title' => 'Input & Perhitungan Nilai Siswa']);
        }

        return $this->grades($request, $selected);
    }

    public function materialsIndex(Request $request): View
    {
        $assignments = $this->teacherAssignments($request);
        $selected = $assignments->firstWhere('id', $request->integer('assignment_id')) ?? $assignments->first();

        if (! $selected) {
            return view('guru.empty', ['title' => 'Materi & Tugas Kelas']);
        }

        return $this->materials($request, $selected);
    }

    public function studentsIndex(Request $request): View
    {
        $assignments = $this->teacherAssignments($request);
        $selected = $assignments->firstWhere('id', $request->integer('assignment_id')) ?? $assignments->first();

        if (! $selected) {
            return view('guru.empty', ['title' => 'Daftar Siswa Kelas Diampu']);
        }

        return $this->students($request, $selected);
    }

    public function approvalsIndex(Request $request): View
    {
        $myApprovals = Approval::where('submitted_by', $request->user()->id)->latest()->get();
        $announcements = Announcement::with('author')
            ->whereIn('audience', ['semua', 'guru'])
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();

        return view('guru.approvals', [
            'myApprovals' => $myApprovals,
            'announcements' => $announcements,
        ]);
    }

    public function attendances(Request $request, TeacherAssignment $assignment): View
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $assignments = $this->teacherAssignments($request);
        $date = $request->string('tanggal', now()->toDateString())->toString();
        $isFuture = \Illuminate\Support\Carbon::parse($date)->startOfDay()->gt(now()->startOfDay());

        $existing = Attendance::where('teacher_assignment_id', $assignment->id)
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('guru.attendances', [
            'assignment' => $assignment,
            'assignments' => $assignments,
            'date' => $date,
            'isFuture' => $isFuture,
            'existing' => $existing,
        ]);
    }

    public function storeAttendances(Request $request, TeacherAssignment $assignment): RedirectResponse
    {
        $assignment = $this->ownedAssignment($request, $assignment);

        $data = $request->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'meeting_number' => ['required', 'integer', 'min:1', 'max:200'],
            'statuses' => ['required', 'array'],
            'statuses.*' => ['required', Rule::in(['hadir', 'sakit', 'izin', 'alpa'])],
            'notes' => ['nullable', 'array'],
            'notes.*' => ['nullable', 'string', 'max:255'],
        ], [
            'date.before_or_equal' => 'Absensi belum dapat diisi untuk tanggal yang belum tiba.',
        ]);

        $dateString = \Illuminate\Support\Carbon::parse($data['date'])->toDateString();

        foreach ($assignment->schoolClass->students as $student) {
            $status = $data['statuses'][$student->id] ?? 'hadir';
            $note = $data['notes'][$student->id] ?? null;

            $attendance = Attendance::query()
                ->where('teacher_assignment_id', $assignment->id)
                ->where('student_id', $student->id)
                ->whereDate('date', $dateString)
                ->first();

            if ($attendance) {
                $attendance->update([
                    'meeting_number' => $data['meeting_number'],
                    'status' => $status,
                    'notes' => $note,
                ]);
            } else {
                Attendance::create([
                    'teacher_assignment_id' => $assignment->id,
                    'student_id' => $student->id,
                    'date' => $dateString,
                    'meeting_number' => $data['meeting_number'],
                    'status' => $status,
                    'notes' => $note,
                ]);
            }
        }

        ActivityLog::record('Absensi Siswa', 'Menginput absensi kelas '.$assignment->schoolClass->name.' mapel '.$assignment->subject->name.'.');

        return redirect()
            ->route('guru.attendances', ['assignment' => $assignment->id, 'tanggal' => $data['date']])
            ->with('status', 'Absensi pertemuan berhasil disimpan.');
    }

    public function printDailyAttendance(Request $request, TeacherAssignment $assignment): View
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $assignment->load('teacher');
        $date = $request->string('tanggal', now()->toDateString())->toString();

        $existing = Attendance::where('teacher_assignment_id', $assignment->id)
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('guru.print-daily-attendance', [
            'assignment' => $assignment,
            'date' => $date,
            'existing' => $existing,
            'settings' => \App\Models\SchoolSetting::allAsMap(),
        ]);
    }

    public function printMonthlyAttendance(Request $request, TeacherAssignment $assignment): View
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $assignment->load('teacher');
        $monthInput = $request->string('bulan', now()->format('Y-m'))->toString();

        try {
            $period = \Illuminate\Support\Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth();
        } catch (\Throwable) {
            $period = now()->startOfMonth();
        }

        $records = Attendance::where('teacher_assignment_id', $assignment->id)
            ->whereYear('date', $period->year)
            ->whereMonth('date', $period->month)
            ->orderBy('date')
            ->get();

        $meetingDates = $records
            ->map(fn (Attendance $a) => $a->date->toDateString())
            ->unique()
            ->values();

        $byStudentAndDate = [];
        foreach ($records as $rec) {
            $byStudentAndDate[$rec->student_id][$rec->date->toDateString()] = $rec->status;
        }

        return view('guru.print-monthly-attendance', [
            'assignment' => $assignment,
            'period' => $period,
            'monthInput' => $period->format('Y-m'),
            'meetingDates' => $meetingDates,
            'byStudentAndDate' => $byStudentAndDate,
            'records' => $records,
            'settings' => \App\Models\SchoolSetting::allAsMap(),
        ]);
    }

    public function grades(Request $request, TeacherAssignment $assignment): View
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $assignments = $this->teacherAssignments($request);

        $existing = Grade::where('teacher_assignment_id', $assignment->id)
            ->get()
            ->keyBy('student_id');

        return view('guru.grades', [
            'assignment' => $assignment,
            'assignments' => $assignments,
            'existing' => $existing,
        ]);
    }

    public function storeGrades(Request $request, TeacherAssignment $assignment): RedirectResponse
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $subject = $assignment->subject;

        $data = $request->validate([
            'grades' => ['required', 'array'],
            'grades.*.tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'grades.*.uh' => ['required', 'numeric', 'min:0', 'max:100'],
            'grades.*.uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'grades.*.uas' => ['required', 'numeric', 'min:0', 'max:100'],
            'grades.*.notes' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($assignment->schoolClass->students as $student) {
            if (! isset($data['grades'][$student->id])) {
                continue;
            }
            $row = $data['grades'][$student->id];
            $tugas = (float) $row['tugas'];
            $uh = (float) $row['uh'];
            $uts = (float) $row['uts'];
            $uas = (float) $row['uas'];

            $final = $subject->calculateFinalScore($tugas, $uh, $uts, $uas);
            $predicate = Subject::predicateFor($final);

            Grade::updateOrCreate(
                [
                    'teacher_assignment_id' => $assignment->id,
                    'student_id' => $student->id,
                ],
                [
                    'tugas' => $tugas,
                    'uh' => $uh,
                    'uts' => $uts,
                    'uas' => $uas,
                    'final_score' => $final,
                    'predicate' => $predicate,
                    'notes' => $row['notes'] ?? null,
                ]
            );
        }

        ActivityLog::record('Input Nilai', 'Memperbarui nilai kelas '.$assignment->schoolClass->name.' mapel '.$subject->name.'.');

        return back()->with('status', 'Nilai siswa berhasil dihitung otomatis sesuai bobot dan disimpan.');
    }

    public function materials(Request $request, TeacherAssignment $assignment): View
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $assignment->load(['materials', 'assignments']);
        $assignments = $this->teacherAssignments($request);

        return view('guru.materials', [
            'assignment' => $assignment,
            'assignments' => $assignments,
        ]);
    }

    public function storeMaterial(Request $request, TeacherAssignment $assignment): RedirectResponse
    {
        $assignment = $this->ownedAssignment($request, $assignment);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'file_url' => ['nullable', 'string', 'max:500'],
        ]);

        Material::create([
            'teacher_assignment_id' => $assignment->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_url' => $data['file_url'] ?? null,
        ]);

        return back()->with('status', 'Materi pembelajaran berhasil diunggah.');
    }

    public function storeTask(Request $request, TeacherAssignment $assignment): RedirectResponse
    {
        $assignment = $this->ownedAssignment($request, $assignment);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['nullable', 'date'],
        ]);

        Assignment::create([
            'teacher_assignment_id' => $assignment->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'due_date' => $data['due_date'] ?? null,
        ]);

        return back()->with('status', 'Tugas kegiatan siswa berhasil ditambahkan.');
    }

    public function students(Request $request, TeacherAssignment $assignment): View
    {
        $assignment = $this->ownedAssignment($request, $assignment);
        $assignments = $this->teacherAssignments($request);

        return view('guru.students', [
            'assignment' => $assignment,
            'assignments' => $assignments,
        ]);
    }

    public function storeApproval(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'document_type' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        Approval::create([
            'submitted_by' => $request->user()->id,
            'title' => $data['title'],
            'document_type' => $data['document_type'],
            'description' => $data['description'],
            'status' => 'menunggu',
        ]);

        return back()->with('status', 'Pengajuan dokumen berhasil dikirim ke Kepala Sekolah.');
    }
}
