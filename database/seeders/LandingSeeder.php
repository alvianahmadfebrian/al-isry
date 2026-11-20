<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\GalleryItem;
use App\Models\Major;
use App\Models\News;
use App\Models\SchoolSetting;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    public function run(): void
    {
        SchoolSetting::query()->delete();
        foreach (SchoolSetting::allAsMap() as $key => $value) {
            SchoolSetting::setValue($key, $value);
        }

        Major::query()->delete();
        $majors = [
            [
                'code' => 'TAHFIDZ',
                'name' => 'Tahfidz Juz Amma, Doa & Hadits Harian',
                'description' => 'Pembiasaan menghafal surat-surat pendek Al-Qur’an, doa sehari-hari, dan hadits pilihan dengan metode talaqqi & irama yang ceria.',
                'icon' => 'book',
                'is_featured' => true,
            ],
            [
                'code' => 'IBADAH',
                'name' => 'Pembiasaan Akhlak & Praktik Ibadah',
                'description' => 'Penanaman adab islami, praktik wudhu, sholat Dhuha berjamaah, manasik haji cilik, serta berbagi sedekah sejak dini.',
                'icon' => 'heart',
                'is_featured' => true,
            ],
            [
                'code' => 'CALISTUNG',
                'name' => 'Literasi Dasar & Sains Eksploratif',
                'description' => 'Pengenalan huruf hijaiyah (Iqra), keaksaraan awal, berhitung konsep benda, serta eksperimen sains sederhana berbasis bermain.',
                'icon' => 'sparkles',
                'is_featured' => true,
            ],
            [
                'code' => 'MOTORIK',
                'name' => 'Seni Kreativitas, Motorik & Kemandirian',
                'description' => 'Pengembangan motorik halus dan kasar melalui seni kriya, menggambar, gerak lagu islami, berkebun, dan kegiatan outbound.',
                'icon' => 'puzzle',
                'is_featured' => true,
            ],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate(['code' => $major['code']], $major);
        }

        $admin = User::query()->where('role', Role::Admin)->first() ?? User::query()->first();
        $guruUser = User::query()->where('email', 'guru@sekolah.test')->first();

        Teacher::query()->delete();
        $teachers = [
            [
                'user_id' => null,
                'nip' => '198204112008012001',
                'name' => 'Hj. Siti Aminah, S.Pd.I.',
                'position' => 'Kepala RA Al-Isry',
                'specialization' => 'Manajemen PAUD & Pendidikan Islam',
                'education' => 'S1 Pendidikan Agama Islam - UIN Jakarta',
                'photo_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Mengabdi lebih dari 15 tahun dalam dunia pendidikan anak usia dini berbasis karakter Qur’ani.',
                'show_on_landing' => true,
            ],
            [
                'user_id' => $guruUser?->id,
                'nip' => '199006182014032004',
                'name' => 'Ustadzah Nurul Hidayah, S.Pd.',
                'position' => 'Wali Kelas Kelompok B1',
                'specialization' => 'Tahfidz Anak & Metode Iqra',
                'education' => 'S1 PGRA / PIAUD - UIKA Bogor',
                'photo_url' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Berpengalaman membimbing tahfidz Juz Amma dan literasi awal anak secara menyenangkan.',
                'show_on_landing' => true,
            ],
            [
                'user_id' => null,
                'nip' => '199311052017012009',
                'name' => 'Ustadzah Rahmawati, S.Pd.',
                'position' => 'Wali Kelas Kelompok A1',
                'specialization' => 'Sensorik, Motorik & Seni Kreatif',
                'education' => 'S1 Pendidikan Anak Usia Dini - UNJ',
                'photo_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Fokus pada stimulasi motorik halus dan penguatan kemandirian anak usia 4–5 tahun.',
                'show_on_landing' => true,
            ],
            [
                'user_id' => null,
                'nip' => '199502222019032012',
                'name' => 'Ustadzah Dewi Kartika, S.Psi.',
                'position' => 'Guru Pendamping & Konselor Tumbuh Kembang',
                'specialization' => 'Psikologi Perkembangan Anak',
                'education' => 'S1 Psikologi Pendidikan',
                'photo_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Mendampingi observasi tumbuh kembang sosial-emosional siswa dan konsultasi parenting.',
                'show_on_landing' => true,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::updateOrCreate(['nip' => $teacher['nip']], $teacher);
        }

        News::query()->delete();
        $newsList = [
            [
                'author_id' => $admin?->id,
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) RA Al-Isry Bogor Tahun Ajaran 2026/2027 Resmi Dibuka',
                'slug' => 'ppdb-ra-al-isry-bogor-2026-2027-dibuka',
                'category' => 'Pengumuman',
                'excerpt' => 'RA Al-Isry (Al Istiqomah Seroja Raya Yasmin) Bogor membuka pendaftaran siswa baru Kelompok A dan Kelompok B.',
                'content' => "Alhamdulillah, Panitia Penerimaan Peserta Didik Baru (PPDB) RA Al-Isry (Al Istiqomah Seroja Raya Yasmin) Bogor resmi membuka pendaftaran untuk Tahun Ajaran 2026/2027.\n\nAyah dan Bunda dapat mendaftarkan putra-putrinya pada Kelompok A (usia 4–5 tahun) maupun Kelompok B (usia 5–6 tahun). Tersedia fasilitas ruang kelas ber-AC yang nyaman, area bermain edukatif, serta bimbingan tahfidz dan akhlak harian.\n\nSilakan kunjungi sekretariat kami di Jl. Seroja Raya, Taman Yasmin Bogor pada jam kerja untuk informasi lebih lanjut dan observasi lingkungan sekolah.",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'author_id' => $admin?->id,
                'title' => 'Kegiatan Peragaan Manasik Haji Cilik Siswa RA Al-Isry Berlangsung Khidmat & Ceria',
                'slug' => 'kegiatan-peragaan-manasik-haji-cilik',
                'category' => 'Berita',
                'excerpt' => 'Anak-anak belajar mengenal rukun Islam kelima melalui simulasi tawaf, sa’i, dan wukuf bersama para guru.',
                'content' => "Dalam rangka mengenalkan rukun Islam yang kelima sejak dini, seluruh peserta didik RA Al-Isry mengikuti kegiatan Peragaan Manasik Haji Cilik.\n\nDengan mengenakan pakaian ihram putih, anak-anak tampak antusias melafalkan kalimat talbiyah, mengelilingi replika Ka'bah, dan melakukan simulasi lempar jumrah dengan tertib.",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=900&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'author_id' => $admin?->id,
                'title' => 'Siswa RA Al-Isry Bogor Raih Juara Umum Lomba Tahfidz & Mewarnai Tingkat Kecamatan',
                'slug' => 'juara-lomba-tahfidz-dan-mewarnai-kecamatan',
                'category' => 'Prestasi',
                'excerpt' => 'Alhamdulillah, ananda berhasil membawa pulang piala Juara 1 Tahfidz Surat Pendek dan Juara 1 Mewarnai Kaligrafi.',
                'content' => "Kabar gembira datang dari ajang Gebyar Kreativitas Anak Raudhatul Athfal tingkat Kota Bogor. Perwakilan siswa RA Al-Isry berhasil meraih piala Juara 1 Lomba Tahfidz Juz Amma dan Juara 1 Mewarnai.\n\nPrestasi ini menjadi motivasi bagi seluruh anak didik untuk terus mencintai Al-Qur'an dan berani tampil percaya diri.",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=900&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(11),
            ],
            [
                'author_id' => $admin?->id,
                'title' => 'Parenting Islami: Sinergi Orang Tua dan Sekolah dalam Membentuk Karakter Anak',
                'slug' => 'parenting-islami-sinergi-orang-tua-dan-sekolah',
                'category' => 'Berita',
                'excerpt' => 'Pertemuan rutin wali murid membahas pola asuh positif dan pendampingan pembiasaan ibadah di rumah.',
                'content' => "RA Al-Isry menyelenggarakan seminar Parenting Islami bersama seluruh orang tua wali murid di aula Yayasan Al Istiqomah Seroja Raya Yasmin.\n\nKegiatan ini bertujuan menyamakan langkah antara pembiasaan baik di sekolah dengan pendampingan hangat dari Ayah dan Bunda di rumah.",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(17),
            ],
        ];

        foreach ($newsList as $item) {
            News::updateOrCreate(['slug' => $item['slug']], $item);
        }

        GalleryItem::query()->delete();
        $galleries = [
            [
                'title' => 'Setoran Hafalan Juz Amma & Iqra Pagi Hari',
                'category' => 'Keagamaan',
                'image_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=800&q=80',
                'description' => 'Anak-anak murojaah surat pendek bersama wali kelas sebelum memulai kegiatan.',
                'activity_date' => now()->subDays(5)->toDateString(),
                'is_published' => true,
            ],
            [
                'title' => 'Kreasi Seni Melukis & Motorik Halus',
                'category' => 'Kreativitas',
                'image_url' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80',
                'description' => 'Melatih koordinasi tangan dan imajinasi anak melalui media warna.',
                'activity_date' => now()->subDays(12)->toDateString(),
                'is_published' => true,
            ],
            [
                'title' => 'Praktik Sholat Dhuha Berjamaah',
                'category' => 'Ibadah',
                'image_url' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=800&q=80',
                'description' => 'Pembiasaan gerakan dan bacaan sholat sejak usia dini.',
                'activity_date' => now()->subDays(18)->toDateString(),
                'is_published' => true,
            ],
            [
                'title' => 'Eksplorasi Alam & Berkebun Cilik',
                'category' => 'Sains & Alam',
                'image_url' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=800&q=80',
                'description' => 'Mengenal tanaman, bunga seroja, dan cara merawat ciptaan Allah.',
                'activity_date' => now()->subDays(25)->toDateString(),
                'is_published' => true,
            ],
            [
                'title' => 'Senam Ceria & Permainan Motorik Kasar',
                'category' => 'Olahraga',
                'image_url' => 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?auto=format&fit=crop&w=800&q=80',
                'description' => 'Olahraga pagi bersama di halaman sekolah agar tubuh sehat dan bugar.',
                'activity_date' => now()->subDays(31)->toDateString(),
                'is_published' => true,
            ],
            [
                'title' => 'Pentas Akhirussanah & Wisuda Tahfidz Cilik',
                'category' => 'Prestasi',
                'image_url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80',
                'description' => 'Apresiasi hafalan dan penampilan berani anak-anak di hadapan orang tua.',
                'activity_date' => now()->subDays(40)->toDateString(),
                'is_published' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            GalleryItem::updateOrCreate(['title' => $gallery['title']], $gallery);
        }
    }
}
