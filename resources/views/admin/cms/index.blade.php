<x-layouts.app title="Kelola Konten Landing Page (CMS)">
    <div class="grid items-start gap-6 lg:grid-cols-2">
        <!-- Profil Sejarah, Visi & Misi -->
        <form method="POST" action="{{ route('admin.cms.profile') }}" class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm text-sm">
            @csrf @method('PUT')
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Identitas Publik</span>
                <h2 class="text-base font-extrabold">Sejarah, Visi &amp; Misi Sekolah</h2>
            </div>

            <div class="space-y-4 p-6 sm:p-8">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Sejarah Singkat Sekolah</label>
                    <textarea name="history" rows="3" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 p-3 focus:border-[#4d9a27] focus:bg-white focus:outline-none">{{ $settings['history'] }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Visi Sekolah</label>
                    <textarea name="vision" rows="2" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 p-3 focus:border-[#4d9a27] focus:bg-white focus:outline-none">{{ $settings['vision'] }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Misi Pendidikan (Satu baris per butir misi)</label>
                    <textarea name="missions" rows="4" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 p-3 focus:border-[#4d9a27] focus:bg-white focus:outline-none">{{ $settings['missions'] }}</textarea>
                </div>
                <button class="rounded-xl bg-[#4d9a27] px-6 py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    Simpan Profil Sekolah
                </button>
            </div>
        </form>

        <!-- Form Publikasi Berita -->
        <form method="POST" action="{{ route('admin.cms.news.store') }}" class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm text-sm">
            @csrf
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Publikasi Artikel</span>
                <h2 class="text-base font-extrabold">Terbitkan Berita / Pengumuman Baru</h2>
            </div>

            <div class="space-y-4 p-6 sm:p-8">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Judul Berita / Pengumuman <span class="text-red-500">*</span></label>
                    <input name="title" required placeholder="Judul informasi resmi..." class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Kategori</label>
                        <select name="category" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                            <option value="Berita">Berita</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Prestasi">Prestasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">URL Gambar Thumbnail</label>
                        <input name="thumbnail_url" placeholder="https://... (Opsional)" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Isi Lengkap Berita <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="4" required placeholder="Tulis isi berita atau pengumuman..." class="w-full rounded-xl border border-slate-300 bg-slate-50/60 p-3 focus:border-[#4d9a27] focus:bg-white focus:outline-none"></textarea>
                </div>

                <button class="rounded-xl bg-[#4d9a27] px-6 py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    + Publikasikan ke Beranda
                </button>
            </div>
        </form>
    </div>

    <!-- Daftar Berita & Galeri -->
    <div class="mt-6 grid items-start gap-6 lg:grid-cols-2">
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Katalog Berita</span>
                    <h2 class="text-base font-extrabold">Daftar Berita Terpublikasi</h2>
                </div>
                <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">{{ $newsList->count() }} Artikel</span>
            </div>

            <div class="divide-y divide-slate-100 p-6 text-sm">
                @foreach ($newsList as $n)
                    <div class="flex items-center justify-between gap-3 py-3 first:pt-0 last:pb-0">
                        <div>
                            <a href="{{ route('news.show', $n->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-[#4d9a27]">{{ $n->title }}</a>
                            <div class="mt-0.5 text-xs text-slate-400">
                                <span class="rounded bg-lime-100 px-2 py-0.5 font-bold text-[#3f821f]">{{ $n->category }}</span> &bull; {{ $n->published_at?->format('d/m/Y') }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.cms.news.destroy', $n) }}">
                            @csrf @method('DELETE')
                            <button class="rounded-lg bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600 hover:bg-red-100">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <form method="POST" action="{{ route('admin.cms.gallery.store') }}" class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm text-sm">
            @csrf
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Dokumentasi Visual</span>
                <h2 class="text-base font-extrabold">Tambah Foto Galeri Kegiatan</h2>
            </div>

            <div class="space-y-4 p-6 sm:p-8">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input name="title" required placeholder="Contoh: Praktik Sholat Dhuha Berjamaah" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Kategori Kegiatan <span class="text-red-500">*</span></label>
                    <input name="category" required placeholder="Contoh: Keagamaan / Kreativitas / Olahraga" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">URL Gambar Foto <span class="text-red-500">*</span></label>
                    <input name="image_url" required placeholder="https://images.unsplash.com/..." class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Deskripsi Singkat</label>
                    <input name="description" placeholder="Keterangan dokumentasi kegiatan" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                </div>

                <button class="rounded-xl bg-[#4d9a27] px-6 py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    + Tambah ke Galeri
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
