<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_dashboards_for_all_four_roles_render_properly(): void
    {
        $this->seed(DatabaseSeeder::class);

        $super = User::where('email', 'superuser@sekolah.test')->firstOrFail();
        $admin = User::where('email', 'admin@sekolah.test')->firstOrFail();
        $kepsek = User::where('email', 'kepsek@sekolah.test')->firstOrFail();
        $guru = User::where('email', 'guru@sekolah.test')->firstOrFail();

        $this->actingAs($super)->get('/superuser')->assertOk()->assertSee('Dashboard Super User');
        $this->actingAs($super)->get('/superuser/pengaturan')->assertOk()->assertSee('Pengaturan Sistem Global');
        $this->actingAs($super)->get('/superuser/log-aktivitas')->assertOk()->assertSee('Activity Log Sistem');
        $this->actingAs($super)->get('/superuser/backup/unduh')->assertOk();

        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Dashboard Admin Sekolah');
        $this->actingAs($admin)->get('/admin/master')->assertOk()->assertSee('Data Master Akademik');
        $this->actingAs($admin)->get('/admin/siswa')->assertOk()->assertSee('Kelola Data Siswa');
        $this->actingAs($admin)->get('/admin/guru')->assertOk()->assertSee('Kelola Akun & Profil Guru');
        $this->actingAs($admin)->get('/admin/jadwal')->assertOk()->assertSee('Plotting Guru');
        $this->actingAs($admin)->get('/admin/konten-landing')->assertOk()->assertSee('Kelola Konten Landing Page');

        $this->actingAs($kepsek)->get('/kepsek')->assertOk()->assertSee('Dashboard Kepala Sekolah');
        $this->actingAs($kepsek)->get('/kepsek/laporan')->assertOk()->assertSee('Laporan Akademik');
        $this->actingAs($kepsek)->get('/kepsek/persetujuan')->assertOk()->assertSee('Persetujuan Dokumen');
        $this->actingAs($kepsek)->get('/kepsek/pengumuman')->assertOk()->assertSee('Pengumuman Internal');

        $this->actingAs($guru)->get('/guru')->assertOk()->assertSee('Dashboard Guru');
    }

    public function test_guru_can_input_grades_with_automatic_weight_calculation_and_cannot_access_unassigned_class(): void
    {
        $guruUser = User::factory()->guru()->create();
        $otherGuruUser = User::factory()->guru()->create();

        $teacher = Teacher::create(['user_id' => $guruUser->id, 'name' => 'Guru A', 'position' => 'Wali Kelas']);
        $otherTeacher = Teacher::create(['user_id' => $otherGuruUser->id, 'name' => 'Guru B', 'position' => 'Wali Kelas']);

        $class = SchoolClass::create(['name' => 'Kelompok B1', 'level' => 'Kelompok B', 'capacity' => 20]);
        $student = Student::create(['nis' => '9901', 'name' => 'Anak Cerdas', 'gender' => 'L', 'class_id' => $class->id]);

        $subject = Subject::create([
            'code' => 'MAP-1',
            'name' => 'Tahfidz',
            'weight_tugas' => 20,
            'weight_uh' => 20,
            'weight_uts' => 25,
            'weight_uas' => 35,
        ]);

        $assignment = TeacherAssignment::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
            'class_id' => $class->id,
        ]);

        $otherAssignment = TeacherAssignment::create([
            'teacher_id' => $otherTeacher->id,
            'subject_id' => $subject->id,
            'class_id' => $class->id,
        ]);

        $this->actingAs($guruUser)->post(route('guru.grades.store', $assignment), [
            'grades' => [
                $student->id => [
                    'tugas' => 80,
                    'uh' => 80,
                    'uts' => 80,
                    'uas' => 100,
                    'notes' => 'Sangat baik',
                ],
            ],
        ])->assertRedirect();

        // 80*0.2 + 80*0.2 + 80*0.25 + 100*0.35 = 16 + 16 + 20 + 35 = 87.00 (Predikat B)
        $this->assertDatabaseHas('grades', [
            'teacher_assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'final_score' => 87.00,
            'predicate' => 'B',
        ]);

        // Guru tidak boleh mengakses kelas milik guru lain
        $this->actingAs($guruUser)->get(route('guru.grades', $otherAssignment))->assertForbidden();

        // Guru dapat menyimpan dan memperbarui ulang absensi pada tanggal yang sama tanpa error unique constraint
        $today = now()->toDateString();
        $this->actingAs($guruUser)->post(route('guru.attendances.store', $assignment), [
            'date' => $today,
            'meeting_number' => 1,
            'statuses' => [$student->id => 'hadir'],
            'notes' => [$student->id => 'Hadir tepat waktu'],
        ])->assertRedirect();

        $this->actingAs($guruUser)->post(route('guru.attendances.store', $assignment), [
            'date' => $today,
            'meeting_number' => 1,
            'statuses' => [$student->id => 'sakit'],
            'notes' => [$student->id => 'Izin sakit demam'],
        ])->assertRedirect();

        $this->assertDatabaseHas('attendances', [
            'teacher_assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'status' => 'sakit',
        ]);

        // Tanggal yang belum terlewat (besok) tidak boleh ada radio yang terpilih dan tidak boleh disimpan
        $tomorrow = now()->addDay()->toDateString();
        $this->actingAs($guruUser)->get(route('guru.attendances', ['assignment' => $assignment->id, 'tanggal' => $tomorrow]))
            ->assertOk()
            ->assertSee('belum tiba');

        $this->actingAs($guruUser)->post(route('guru.attendances.store', $assignment), [
            'date' => $tomorrow,
            'meeting_number' => 2,
            'statuses' => [$student->id => 'hadir'],
        ])->assertSessionHasErrors('date');

        // Guru dapat mencetak absensi harian dan rekap bulanan
        $this->actingAs($guruUser)->get(route('guru.attendances.print-daily', ['assignment' => $assignment->id, 'tanggal' => $today]))
            ->assertOk()
            ->assertSee('Daftar Hadir Harian Peserta Didik')
            ->assertSee('Anak Cerdas');

        $this->actingAs($guruUser)->get(route('guru.attendances.print-monthly', ['assignment' => $assignment->id, 'bulan' => now()->format('Y-m')]))
            ->assertOk()
            ->assertSee('Rekapitulasi Kehadiran Bulanan Peserta Didik')
            ->assertSee('Anak Cerdas');
    }

    public function test_kepsek_can_approve_document_with_notes_and_cannot_modify_master_data(): void
    {
        $kepsek = User::factory()->kepalaSekolah()->create();
        $guru = User::factory()->guru()->create();

        $approval = Approval::create([
            'submitted_by' => $guru->id,
            'title' => 'RPPH Tema Diri Sendiri',
            'document_type' => 'RPP / Modul Ajar',
            'status' => 'menunggu',
        ]);

        $this->actingAs($kepsek)->patch(route('kepsek.approvals.decide', $approval), [
            'status' => 'disetujui',
            'reviewer_notes' => 'RPPH sudah lengkap dan disetujui.',
        ])->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'id' => $approval->id,
            'status' => 'disetujui',
            'reviewer_notes' => 'RPPH sudah lengkap dan disetujui.',
        ]);

        // Kepala sekolah tidak boleh mengubah data master admin
        $this->actingAs($kepsek)->post('/admin/master/kelas', ['name' => 'X'])->assertForbidden();
    }
}
