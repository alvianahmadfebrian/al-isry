<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon', 50)->nullable();
            $table->boolean('is_featured')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nip', 40)->nullable()->unique();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('specialization')->nullable();
            $table->string('education')->nullable();
            $table->string('photo_url')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('show_on_landing')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 40)->default('Berita')->index();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('thumbnail_url')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category', 50)->nullable()->index();
            $table->string('image_url');
            $table->text('description')->nullable();
            $table->date('activity_date')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('news');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('school_settings');
    }
};
