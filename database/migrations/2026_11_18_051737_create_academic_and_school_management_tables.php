<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // 2026/2027
            $table->string('semester', 20)->default('Ganjil'); // Ganjil / Genap
            $table->boolean('is_active')->default(false)->index();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Kelompok A1, Kelompok B1
            $table->string('level', 50)->default('Kelompok A'); // Kelompok A / Kelompok B
            $table->foreignId('major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->unsignedSmallInteger('capacity')->default(25);
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('weight_tugas')->default(20);
            $table->unsignedTinyInteger('weight_uh')->default(20);
            $table->unsignedTinyInteger('weight_uts')->default(25);
            $table->unsignedTinyInteger('weight_uas')->default(35);
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 30)->unique();
            $table->string('nisn', 30)->nullable();
            $table->string('name');
            $table->string('gender', 1)->default('L'); // L / P
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->string('parent_name')->nullable();
            $table->string('parent_phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('status', 20)->default('aktif')->index(); // aktif, lulus, pindah
            $table->timestamps();
        });

        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->timestamps();

            $table->unique(['teacher_id', 'subject_id', 'class_id'], 'teacher_subject_class_unique');
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_assignment_id')->constrained('teacher_assignments')->cascadeOnDelete();
            $table->string('day_of_week', 20)->index(); // Senin, Selasa, Rabu, Kamis, Jumat, Sabtu
            $table->string('start_time', 10); // 07:30
            $table->string('end_time', 10);   // 08:30
            $table->string('room', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_assignment_id')->constrained('teacher_assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('date')->index();
            $table->unsignedSmallInteger('meeting_number')->default(1);
            $table->string('status', 15)->default('hadir')->index(); // hadir, sakit, izin, alpa
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['teacher_assignment_id', 'student_id', 'date'], 'attendance_unique_per_day');
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_assignment_id')->constrained('teacher_assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->decimal('tugas', 5, 2)->default(0);
            $table->decimal('uh', 5, 2)->default(0);
            $table->decimal('uts', 5, 2)->default(0);
            $table->decimal('uas', 5, 2)->default(0);
            $table->decimal('final_score', 5, 2)->default(0);
            $table->string('predicate', 5)->default('B');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['teacher_assignment_id', 'student_id'], 'grade_unique_per_student');
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_assignment_id')->constrained('teacher_assignments')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_url')->nullable();
            $table->timestamps();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_assignment_id')->constrained('teacher_assignments')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->string('file_url')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('audience', 30)->default('semua')->index(); // semua, guru, staf
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('document_type', 50)->default('RPP / Modul Ajar'); // RPP / Modul Ajar, Pengajuan Nilai Remedial, Kegiatan
            $table->text('description')->nullable();
            $table->string('file_url')->nullable();
            $table->string('status', 20)->default('menunggu')->index(); // menunggu, disetujui, ditolak
            $table->text('reviewer_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 100)->index();
            $table->string('description');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('approvals');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('teacher_assignments');
        Schema::dropIfExists('students');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('academic_years');
    }
};
