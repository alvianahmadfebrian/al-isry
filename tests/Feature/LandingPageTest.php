<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\SchoolSetting;
use App\Models\Teacher;
use Database\Seeders\LandingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_all_main_sections(): void
    {
        $this->seed(LandingSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('RA Al-Isry')
            ->assertSee('Daftar PPDB Online')
            ->assertSee('Sejarah Singkat')
            ->assertSee('Visi Sekolah')
            ->assertSee('Misi Pendidikan')
            ->assertSee('Program Unggulan')
            ->assertSee('Berita & Pengumuman Terbaru', false)
            ->assertSee('Galeri Kegiatan Sekolah')
            ->assertSee('Tenaga Pendidik Pilihan');
    }

    public function test_only_teachers_marked_show_on_landing_are_displayed(): void
    {
        Teacher::create([
            'name' => 'Guru Tampil Publik',
            'position' => 'Guru Matematika',
            'show_on_landing' => true,
        ]);
        Teacher::create([
            'name' => 'Guru Internal Saja',
            'position' => 'Guru Biologi',
            'show_on_landing' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Guru Tampil Publik')
            ->assertDontSee('Guru Internal Saja');
    }

    public function test_news_detail_page_is_accessible_and_unpublished_returns_404(): void
    {
        $published = News::create([
            'title' => 'Berita Publikasi Resmi',
            'slug' => 'berita-publikasi-resmi',
            'category' => 'Berita',
            'content' => 'Isi lengkap berita publikasi resmi sekolah.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $draft = News::create([
            'title' => 'Draft Rahasia',
            'slug' => 'draft-rahasia',
            'category' => 'Berita',
            'content' => 'Isi draft.',
            'is_published' => false,
        ]);

        $this->get('/berita/'.$published->slug)
            ->assertOk()
            ->assertSee('Berita Publikasi Resmi')
            ->assertSee('Isi lengkap berita publikasi resmi sekolah.');

        $this->get('/berita/'.$draft->slug)->assertNotFound();
    }

    public function test_custom_theme_color_from_school_settings_is_applied(): void
    {
        SchoolSetting::setValue('primary_color', '#059669');

        $this->get('/')
            ->assertOk()
            ->assertSee('--school-primary: #059669', false);
    }
}
