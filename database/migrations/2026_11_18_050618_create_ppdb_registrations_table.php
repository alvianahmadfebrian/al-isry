<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 30)->unique();
            $table->string('child_name');
            $table->string('nickname', 100)->nullable();
            $table->string('gender', 1); // L / P
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('nik', 25)->nullable();
            $table->string('religion', 30)->default('Islam');
            $table->string('group_choice', 30)->default('Kelompok A'); // Kelompok A / Kelompok B
            $table->string('father_name');
            $table->string('father_occupation', 100)->nullable();
            $table->string('mother_name');
            $table->string('mother_occupation', 100)->nullable();
            $table->string('parent_phone', 30);
            $table->string('parent_email')->nullable();
            $table->text('address');
            $table->text('health_notes')->nullable();
            $table->string('status', 30)->default('menunggu')->index(); // menunggu, diverifikasi, diterima, ditolak
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
