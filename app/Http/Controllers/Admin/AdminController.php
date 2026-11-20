<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ActivityLog;
use App\Models\GalleryItem;
use App\Models\Major;
use App\Models\News;
use App\Models\PpdbRegistration;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\SchoolSetting;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'classes' => SchoolClass::count(),
            'subjects' => Subject::count(),
            'ppdb_total' => PpdbRegistration::count(),
            'ppdb_waiting' => PpdbRegistration::where('status', 'menunggu')->count(),
            'news' => News::count(),
            'gallery' => GalleryItem::count(),
        ];

        $classes = SchoolClass::with(['homeroomTeacher', 'academicYear'])
            ->withCount('students')
            ->orderBy('name')
            ->get();

        $genderStats = [
            'L' => Student::where('gender', 'L')->count(),
            'P' => Student::where('gender', 'P')->count(),
        ];

        $ppdbStats = [
            'menunggu' => PpdbRegistration::where('status', 'menunggu')->count(),
            'diverifikasi' => PpdbRegistration::where('status', 'diverifikasi')->count(),
            'diterima' => PpdbRegistration::where('status', 'diterima')->count(),
            'ditolak' => PpdbRegistration::where('status', 'ditolak')->count(),
        ];

        $latestPpdb = PpdbRegistration::latest()->limit(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'classes' => $classes,
            'genderStats' => $genderStats,
            'ppdbStats' => $ppdbStats,
            'latestPpdb' => $latestPpdb,
        ]);
    }

    public function master(): View
    {
        return view('admin.master', [
            'academicYears' => AcademicYear::orderByDesc('is_active')->orderByDesc('name')->get(),
            'classes' => SchoolClass::with(['homeroomTeacher', 'academicYear'])->withCount('students')->orderBy('name')->get(),
            'subjects' => Subject::orderBy('code')->get(),
            'majors' => Major::orderBy('code')->get(),
            'teachers' => Teacher::orderBy('name')->get(),
        ]);
    }

    public function storeAcademicYear(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'semester' => ['required', Rule::in(['Ganjil', 'Genap'])],
            'is_active' => ['boolean'],
        ]);

        if ($request->boolean('is_active')) {
            AcademicYear::query()->update(['is_active' => false]);
        }

        AcademicYear::create([
            'name' => $data['name'],
            'semester' => $data['semester'],
            'is_active' => $request->boolean('is_active'),
        ]);

        ActivityLog::record('Data Master', 'Menambahkan tahun ajaran '.$data['name'].' ('.$data['semester'].').');

        return back()->with('status', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function storeClass(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'level' => ['required', 'string', 'max:50'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $activeYear = AcademicYear::where('is_active', true)->first();
        $data['academic_year_id'] = $activeYear?->id;

        SchoolClass::create($data);
        ActivityLog::record('Data Master', 'Menambahkan kelas '.$data['name'].'.');

        return back()->with('status', 'Kelas berhasil ditambahkan.');
    }

    public function storeSubject(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:subjects,code'],
            'name' => ['required', 'string', 'max:255'],
            'weight_tugas' => ['required', 'integer', 'min:0', 'max:100'],
            'weight_uh' => ['required', 'integer', 'min:0', 'max:100'],
            'weight_uts' => ['required', 'integer', 'min:0', 'max:100'],
            'weight_uas' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        Subject::create($data);
        ActivityLog::record('Data Master', 'Menambahkan mata pelajaran '.$data['name'].'.');

        return back()->with('status', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function students(Request $request): View
    {
        $students = Student::with('schoolClass')
            ->when($request->filled('class_id'), fn ($q) => $q->where('class_id', $request->integer('class_id')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(fn ($w) => $w->where('name', 'like', $term)->orWhere('nis', 'like', $term));
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.students.index', [
            'students' => $students,
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function storeStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nis' => ['required', 'string', 'max:30', 'unique:students,nis'],
            'nisn' => ['nullable', 'string', 'max:30'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'class_id' => ['required', 'exists:classes,id'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        Student::create($data);
        ActivityLog::record('Data Siswa', 'Menambahkan siswa '.$data['name'].' (NIS '.$data['nis'].').');

        return back()->with('status', 'Data siswa berhasil ditambahkan.');
    }

    public function importStudentsCsv(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        $imported = 0;

        if ($handle !== false) {
            $rowNumber = 0;
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if ($rowNumber === 1 && isset($row[0]) && Str::lower(trim($row[0])) === 'nis') {
                    continue;
                }
                if (count($row) < 2 || blank($row[0]) || blank($row[1])) {
                    continue;
                }

                Student::updateOrCreate(
                    ['nis' => trim($row[0])],
                    [
                        'name' => trim($row[1]),
                        'gender' => in_array(strtoupper(trim($row[2] ?? 'L')), ['L', 'P'], true) ? strtoupper(trim($row[2])) : 'L',
                        'birth_place' => trim($row[3] ?? 'Bogor'),
                        'birth_date' => ! empty($row[4]) ? trim($row[4]) : '2021-01-01',
                        'parent_name' => trim($row[5] ?? ''),
                        'parent_phone' => trim($row[6] ?? ''),
                        'class_id' => $request->integer('class_id'),
                        'status' => 'aktif',
                    ]
                );
                $imported++;
            }
            fclose($handle);
        }

        ActivityLog::record('Import Siswa', "Mengimpor {$imported} siswa dari berkas CSV.");

        return back()->with('status', "Berhasil mengimpor {$imported} data siswa dari CSV.");
    }

    public function studentCard(Student $student): View
    {
        $student->load('schoolClass');

        return view('admin.students.card', [
            'student' => $student,
            'settings' => SchoolSetting::allAsMap(),
        ]);
    }

    public function destroyStudent(Student $student): RedirectResponse
    {
        $student->delete();

        return back()->with('status', 'Data siswa berhasil dihapus.');
    }

    public function teachers(): View
    {
        $teachers = Teacher::with('user')->orderBy('name')->get();

        return view('admin.teachers.index', ['teachers' => $teachers]);
    }

    public function storeTeacher(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nip' => ['nullable', 'string', 'max:40', 'unique:teachers,nip'],
            'position' => ['required', 'string', 'max:100'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'education' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8'],
            'show_on_landing' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => Role::Guru,
            'is_active' => true,
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'nip' => $data['nip'] ?? null,
            'name' => $data['name'],
            'position' => $data['position'],
            'specialization' => $data['specialization'] ?? null,
            'education' => $data['education'] ?? null,
            'show_on_landing' => $request->boolean('show_on_landing'),
        ]);

        ActivityLog::record('Kelola Guru', 'Membuat akun & profil guru '.$data['name'].'.');

        return back()->with('status', 'Akun dan profil guru berhasil dibuat.');
    }

    public function toggleTeacherLanding(Teacher $teacher): RedirectResponse
    {
        $teacher->update(['show_on_landing' => ! $teacher->show_on_landing]);

        return back()->with('status', 'Status tampil di landing page berhasil diperbarui.');
    }

    public function toggleTeacherActive(Teacher $teacher): RedirectResponse
    {
        if ($teacher->user) {
            $teacher->user->update(['is_active' => ! $teacher->user->is_active]);
        }

        return back()->with('status', 'Status aktif akun guru berhasil diperbarui.');
    }

    public function schedules(): View
    {
        $assignments = TeacherAssignment::with(['teacher', 'subject', 'schoolClass', 'schedules'])
            ->orderByDesc('id')
            ->get();

        return view('admin.schedules.index', [
            'assignments' => $assignments,
            'teachers' => Teacher::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'day_of_week' => ['required', 'string', 'max:20'],
            'start_time' => ['required', 'string', 'max:10'],
            'end_time' => ['required', 'string', 'max:10'],
            'room' => ['nullable', 'string', 'max:50'],
        ]);

        $activeYear = AcademicYear::where('is_active', true)->first();

        $assignment = TeacherAssignment::firstOrCreate([
            'teacher_id' => $data['teacher_id'],
            'subject_id' => $data['subject_id'],
            'class_id' => $data['class_id'],
        ], [
            'academic_year_id' => $activeYear?->id,
        ]);

        Schedule::create([
            'teacher_assignment_id' => $assignment->id,
            'day_of_week' => $data['day_of_week'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'room' => $data['room'] ?? null,
        ]);

        ActivityLog::record('Jadwal & Plotting', 'Menambahkan plotting mengajar dan jadwal pelajaran.');

        return back()->with('status', 'Plotting mengajar dan jadwal berhasil disimpan.');
    }

    public function cms(): View
    {
        return view('admin.cms.index', [
            'settings' => SchoolSetting::allAsMap(),
            'newsList' => News::latest()->get(),
            'galleries' => GalleryItem::latest()->get(),
        ]);
    }

    public function updateProfileCms(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'history' => ['required', 'string'],
            'vision' => ['required', 'string'],
            'missions' => ['required', 'string'],
        ]);

        foreach ($data as $key => $value) {
            SchoolSetting::setValue($key, $value);
        }

        return back()->with('status', 'Profil sejarah, visi, dan misi berhasil diperbarui.');
    }

    public function storeNews(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:40'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'thumbnail_url' => ['nullable', 'url', 'max:500'],
        ]);

        News::create([
            'author_id' => $request->user()->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(4)),
            'category' => $data['category'],
            'excerpt' => $data['excerpt'] ?? Str::limit($data['content'], 120),
            'content' => $data['content'],
            'thumbnail_url' => $data['thumbnail_url'] ?: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=80',
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('status', 'Berita berhasil dipublikasikan ke landing page.');
    }

    public function destroyNews(News $news): RedirectResponse
    {
        $news->delete();

        return back()->with('status', 'Berita berhasil dihapus.');
    }

    public function storeGallery(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'image_url' => ['required', 'url', 'max:500'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        GalleryItem::create([
            'title' => $data['title'],
            'category' => $data['category'],
            'image_url' => $data['image_url'],
            'description' => $data['description'] ?? null,
            'activity_date' => now()->toDateString(),
            'is_published' => true,
        ]);

        return back()->with('status', 'Foto galeri berhasil ditambahkan.');
    }
}
