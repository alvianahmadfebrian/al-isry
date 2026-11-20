<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value'])]
class SchoolSetting extends Model
{
    /**
     * Ambil seluruh pengaturan sekolah sebagai array key => value dengan nilai default.
     *
     * @return array<string, string>
     */
    public static function allAsMap(): array
    {
        $defaults = [
            'school_name' => 'RA Al-Isry (Al Istiqomah Seroja Raya Yasmin) Bogor',
            'school_short_name' => 'RA Al-Isry Bogor',
            'logo_url' => '/images/logo-sekolah.png',
            'school_tagline' => 'Membentuk Generasi Qur’ani, Cerdas, Ceria, dan Berakhlakul Karimah Sejak Usia Dini',
            'hero_subtitle' => 'Lembaga pendidikan Raudhatul Athfal (RA) di kawasan Taman Yasmin Bogor yang memadukan pembelajaran berbasis nilai-nilai Islam, pembiasaan akhlak mulia, tahfidz Juz Amma, dan stimulasi tumbuh kembang anak secara menyenangkan.',
            'primary_color' => '#4d9a27',
            'secondary_color' => '#142611',
            'accent_color' => '#84cc16',
            'history' => 'Didirikan di bawah naungan Yayasan Al Istiqomah Seroja Raya Yasmin Bogor, RA Al-Isry hadir sebagai wadah pendidikan anak usia dini berciri khas Islam yang aman, nyaman, dan penuh kasih sayang. Sejak berdiri, RA Al-Isry berkomitmen mendampingi tumbuh kembang fitrah anak melalui metode belajar sambil bermain yang kreatif dan islami.',
            'vision' => 'Terwujudnya generasi muslim usia dini yang beriman, berakhlak mulia, sehat, cerdas, mandiri, kreatif, dan cinta Al-Qur’an.',
            'missions' => "Menanamkan keimanan dan ketakwaan melalui pembiasaan ibadah harian, doa, dan adab islami.\nMembimbing hafalan surat-surat pendek (Juz Amma), hadits pilihan, dan bacaan sholat dengan metode menyenangkan.\nMengembangkan potensi motorik, kognitif, bahasa, sosial-emosional, dan kemandirian anak sesuai tahapan usia.\nMenjalin kerja sama harmonis antara guru, orang tua, dan lingkungan sekitar dalam mendidik anak.",
            'ppdb_status' => 'Dibuka Penerimaan Siswa Baru — Tahun Ajaran 2026/2027',
            'ppdb_quota' => '60 Siswa Baru (Kelompok A & Kelompok B)',
            'ppdb_period' => 'Januari – Juli 2026',
            'ppdb_info' => 'Pendaftaran peserta didik baru Kelompok A (usia 4–5 tahun) dan Kelompok B (usia 5–6 tahun) dapat dilakukan langsung di sekretariat RA Al-Isry Seroja Raya Yasmin Bogor.',
            'ppdb_requirements' => "Usia minimal 4 tahun (Kelompok A) atau 5 tahun (Kelompok B) pada bulan Juli\nFotokopi Akta Kelahiran (2 lembar)\nFotokopi Kartu Keluarga & KTP Orang Tua (2 lembar)\nPas foto berwarna ukuran 3x4 (4 lembar)\nMengisi formulir pendaftaran peserta didik baru",
            'stat_students' => '120+',
            'stat_teachers' => '14',
            'stat_achievements' => '45+',
            'stat_accreditation' => 'A (Unggul)',
            'address' => 'Jl. Seroja Raya, Taman Yasmin, Kota Bogor, Jawa Barat',
            'phone' => '(0251) 835-1234 / 0812-8899-7766',
            'email' => 'info@ra-alisry-bogor.sch.id',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'youtube_url' => 'https://youtube.com',
            'maps_embed_url' => 'https://www.openstreetmap.org/export/embed.html?bbox=106.755%2C-6.575%2C106.785%2C-6.550&layer=mapnik',
        ];

        $stored = static::query()->pluck('value', 'key')->all();

        return array_replace($defaults, array_filter($stored, fn ($v) => $v !== null && $v !== ''));
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
