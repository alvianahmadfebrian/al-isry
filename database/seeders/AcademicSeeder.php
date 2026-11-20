<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\AcademicYear;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Approval;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Material;
use App\Models\PpdbRegistration;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $activeYear = AcademicYear::updateOrCreate(
            ['name' => '2026/2027', 'semester' => 'Ganjil'],
            ['is_active' => true, 'start_date' => '2026-07-13', 'end_date' => '2026-12-18']
        );

        AcademicYear::updateOrCreate(
            ['name' => '2025/2026', 'semester' => 'Genap'],
            ['is_active' => false, 'start_date' => '2026-01-05', 'end_date' => '2026-06-20']
        );

        $guruUser = User::where('email', 'guru@sekolah.test')->first();
        $kepsekUser = User::where('email', 'kepsek@sekolah.test')->first();

        $guruUtama = Teacher::where('user_id', $guruUser?->id)->first()
            ?? Teacher::first();

        $guruLain = Teacher::where('id', '!=', $guruUtama?->id)->first() ?? $guruUtama;

        $classB1 = SchoolClass::updateOrCreate(
            ['name' => 'Kelompok B1 (Seroja)'],
            [
                'level' => 'Kelompok B',
                'homeroom_teacher_id' => $guruUtama?->id,
                'academic_year_id' => $activeYear->id,
                'capacity' => 20,
            ]
        );

        $classA1 = SchoolClass::updateOrCreate(
            ['name' => 'Kelompok A1 (Yasmin)'],
            [
                'level' => 'Kelompok A',
                'homeroom_teacher_id' => $guruLain?->id,
                'academic_year_id' => $activeYear->id,
                'capacity' => 20,
            ]
        );

        $subjectsData = [
            ['code' => 'PAI-01', 'name' => 'Nilai Agama, Akhlak & Praktik Ibadah', 'weight_tugas' => 20, 'weight_uh' => 20, 'weight_uts' => 25, 'weight_uas' => 35],
            ['code' => 'THF-02', 'name' => 'Tahfidz Juz Amma, Doa & Hadits', 'weight_tugas' => 25, 'weight_uh' => 25, 'weight_uts' => 20, 'weight_uas' => 30],
            ['code' => 'LIT-03', 'name' => 'Literasi Dasar, Iqra & Berhitung', 'weight_tugas' => 20, 'weight_uh' => 20, 'weight_uts' => 25, 'weight_uas' => 35],
            ['code' => 'MOT-04', 'name' => 'Motorik, Seni Kreatif & Kemandirian', 'weight_tugas' => 30, 'weight_uh' => 20, 'weight_uts' => 20, 'weight_uas' => 30],
        ];

        $subjects = [];
        foreach ($subjectsData as $s) {
            $subjects[$s['code']] = Subject::updateOrCreate(['code' => $s['code']], $s);
        }

        $studentsB1 = [
            ['nis' => '2026001', 'name' => 'Muhammad Arkan Alfatih', 'gender' => 'L', 'birth_place' => 'Bogor', 'birth_date' => '2020-05-14', 'parent_name' => 'Hendra Saputra', 'parent_phone' => '081280001111'],
            ['nis' => '2026002', 'name' => 'Aisyah Humaira Zahra', 'gender' => 'P', 'birth_place' => 'Bogor', 'birth_date' => '2020-08-21', 'parent_name' => 'Ahmad Fauzi', 'parent_phone' => '081280002222'],
            ['nis' => '2026003', 'name' => 'Zaidan Alfarizi Putra', 'gender' => 'L', 'birth_place' => 'Depok', 'birth_date' => '2020-03-09', 'parent_name' => 'Budi Santoso', 'parent_phone' => '081280003333'],
            ['nis' => '2026004', 'name' => 'Khadijah Yasmin Azzahra', 'gender' => 'P', 'birth_place' => 'Bogor', 'birth_date' => '2020-11-02', 'parent_name' => 'Lukman Hakim', 'parent_phone' => '081280004444'],
            ['nis' => '2026005', 'name' => 'Raffa Aditya Pratama', 'gender' => 'L', 'birth_place' => 'Jakarta', 'birth_date' => '2020-07-19', 'parent_name' => 'Dedi Kurniawan', 'parent_phone' => '081280005555'],
        ];

        $studentsA1 = [
            ['nis' => '2026006', 'name' => 'Nadhira Thafana Putri', 'gender' => 'P', 'birth_place' => 'Bogor', 'birth_date' => '2021-04-12', 'parent_name' => 'Reza Rahardian', 'parent_phone' => '081280006666'],
            ['nis' => '2026007', 'name' => 'Alvino Ghaisan Rabbani', 'gender' => 'L', 'birth_place' => 'Bogor', 'birth_date' => '2021-09-25', 'parent_name' => 'Fajar Nugroho', 'parent_phone' => '081280007777'],
            ['nis' => '2026008', 'name' => 'Syafiqah Maryam Kamilah', 'gender' => 'P', 'birth_place' => 'Bogor', 'birth_date' => '2021-06-30', 'parent_name' => 'Ilham Ramadhan', 'parent_phone' => '081280008888'],
        ];

        foreach ($studentsB1 as $st) {
            Student::updateOrCreate(['nis' => $st['nis']], array_merge($st, ['class_id' => $classB1->id, 'address' => 'Taman Yasmin Bogor', 'status' => 'aktif']));
        }
        foreach ($studentsA1 as $st) {
            Student::updateOrCreate(['nis' => $st['nis']], array_merge($st, ['class_id' => $classA1->id, 'address' => 'Jl. Seroja Raya Bogor', 'status' => 'aktif']));
        }

        if ($guruUtama) {
            $as1 = TeacherAssignment::updateOrCreate([
                'teacher_id' => $guruUtama->id,
                'subject_id' => $subjects['THF-02']->id,
                'class_id' => $classB1->id,
            ], ['academic_year_id' => $activeYear->id]);

            $as2 = TeacherAssignment::updateOrCreate([
                'teacher_id' => $guruUtama->id,
                'subject_id' => $subjects['LIT-03']->id,
                'class_id' => $classB1->id,
            ], ['academic_year_id' => $activeYear->id]);

            Schedule::query()->whereIn('teacher_assignment_id', [$as1->id, $as2->id])->delete();
            Schedule::create(['teacher_assignment_id' => $as1->id, 'day_of_week' => 'Senin', 'start_time' => '07:30', 'end_time' => '08:45', 'room' => 'Ruang Seroja B1']);
            Schedule::create(['teacher_assignment_id' => $as1->id, 'day_of_week' => 'Rabu', 'start_time' => '07:30', 'end_time' => '08:45', 'room' => 'Ruang Seroja B1']);
            Schedule::create(['teacher_assignment_id' => $as2->id, 'day_of_week' => 'Selasa', 'start_time' => '08:45', 'end_time' => '10:00', 'room' => 'Ruang Seroja B1']);
            Schedule::create(['teacher_assignment_id' => $as2->id, 'day_of_week' => 'Kamis', 'start_time' => '08:45', 'end_time' => '10:00', 'room' => 'Ruang Seroja B1']);

            $today = now()->toDateString();
            foreach (Student::where('class_id', $classB1->id)->get() as $index => $student) {
                Attendance::query()
                    ->where('teacher_assignment_id', $as1->id)
                    ->where('student_id', $student->id)
                    ->whereDate('date', $today)
                    ->delete();

                Attendance::create([
                    'teacher_assignment_id' => $as1->id,
                    'student_id' => $student->id,
                    'date' => $today,
                    'meeting_number' => 1,
                    'status' => 'hadir',
                    'notes' => 'Hadir tepat waktu',
                ]);

                $base = 84 + ($index * 2);
                $final = $subjects['THF-02']->calculateFinalScore($base, $base + 2, $base + 1, $base + 3);
                Grade::updateOrCreate(
                    ['teacher_assignment_id' => $as1->id, 'student_id' => $student->id],
                    [
                        'tugas' => $base,
                        'uh' => $base + 2,
                        'uts' => $base + 1,
                        'uas' => $base + 3,
                        'final_score' => $final,
                        'predicate' => Subject::predicateFor($final),
                        'notes' => 'Hafalan surat pendek sangat lancar.',
                    ]
                );
            }

            Material::updateOrCreate(
                ['teacher_assignment_id' => $as1->id, 'title' => 'Panduan Murojaah Surat An-Naba s.d. Al-Humazah'],
                ['description' => 'Modul panduan irama murojaah harian anak Kelompok B1 di sekolah dan di rumah.']
            );

            Assignment::updateOrCreate(
                ['teacher_assignment_id' => $as1->id, 'title' => 'Murojaah Surat Al-Ma’un & Doa Kedua Orang Tua'],
                ['description' => 'Anak melafalkan bersama Ayah/Bunda di rumah sebelum tidur.', 'due_date' => now()->addDays(5)->toDateString()]
            );
        }

        if ($guruLain) {
            $asA1 = TeacherAssignment::updateOrCreate([
                'teacher_id' => $guruLain->id,
                'subject_id' => $subjects['MOT-04']->id,
                'class_id' => $classA1->id,
            ], ['academic_year_id' => $activeYear->id]);

            Schedule::query()->where('teacher_assignment_id', $asA1->id)->delete();
            Schedule::create(['teacher_assignment_id' => $asA1->id, 'day_of_week' => 'Senin', 'start_time' => '08:00', 'end_time' => '09:30', 'room' => 'Ruang Yasmin A1']);
        }

        Announcement::updateOrCreate(
            ['title' => 'Rapat Koordinasi Kurikulum & Evaluasi Bulanan Guru RA Al-Isry'],
            [
                'author_id' => $kepsekUser?->id,
                'content' => 'Diharapkan seluruh wali kelas dan guru pendamping hadir pada rapat evaluasi pembelajaran dan persiapan kegiatan puncak tema hari Jumat pukul 11.00 WIB di Ruang Guru.',
                'audience' => 'semua',
                'is_pinned' => true,
            ]
        );

        Approval::updateOrCreate(
            ['title' => 'RPPH Semester Ganjil — Tema Tanaman & Bunga Seroja'],
            [
                'submitted_by' => $guruUser?->id,
                'document_type' => 'RPP / Modul Ajar',
                'description' => 'Rencana Pelaksanaan Pembelajaran Harian (RPPH) Kelompok B1 selama 2 pekan beserta lembar observasi.',
                'status' => 'menunggu',
            ]
        );

        PpdbRegistration::updateOrCreate(
            ['registration_number' => 'PPDB-2026-0001'],
            [
                'child_name' => 'Fatimah Az-Zahra',
                'nickname' => 'Fatimah',
                'gender' => 'P',
                'birth_place' => 'Bogor',
                'birth_date' => '2021-03-17',
                'nik' => '3271045703210002',
                'group_choice' => 'Kelompok A (4-5 Tahun)',
                'father_name' => 'Ridwan Kamiludin',
                'father_occupation' => 'Wiraswasta',
                'mother_name' => 'Siti Nurbaya',
                'mother_occupation' => 'Guru',
                'parent_phone' => '081299001122',
                'parent_email' => 'ridwan@wali.test',
                'address' => 'Jl. Seroja Raya No. 18, Taman Yasmin, Kota Bogor',
                'status' => 'menunggu',
            ]
        );

        ActivityLog::updateOrCreate(
            ['action' => 'Inisialisasi Sistem', 'description' => 'Data awal RA Al-Isry Bogor berhasil dimuat ke dalam database.'],
            ['user_id' => $kepsekUser?->id, 'ip_address' => '127.0.0.1']
        );
    }
}
