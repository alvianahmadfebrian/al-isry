<x-layouts.app title="Pengaturan Sistem Global">
    <form method="POST" action="{{ route('superuser.settings.update') }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid gap-6 lg:grid-cols-12">
            <!-- Kolom Kiri: Identitas & Kontak -->
            <div class="space-y-6 lg:col-span-8">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                    <div class="mb-5 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <img src="/images/logo-sekolah.png" alt="Logo" class="h-12 w-12 rounded-full border border-lime-500/30 object-contain p-0.5">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Identitas Utama Sekolah</h2>
                            <p class="text-xs text-slate-500">Ditampilkan pada header, hero beranda, kartu siswa, dan bukti PPDB.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Nama Lengkap Sekolah</label>
                            <input name="school_name" value="{{ old('school_name', $settings['school_name']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Nama Singkat Sekolah</label>
                            <input name="school_short_name" value="{{ old('school_short_name', $settings['school_short_name'] ?? 'RA Al-Isry Bogor') }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Tagline / Motto</label>
                            <input name="school_tagline" value="{{ old('school_tagline', $settings['school_tagline']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Email Resmi Sekolah</label>
                            <input type="email" name="email" value="{{ old('email', $settings['email']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                            <input name="phone" value="{{ old('phone', $settings['phone']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Alamat Lengkap Sekolah</label>
                            <input name="address" value="{{ old('address', $settings['address']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Pengaturan Informasi PPDB -->
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h2 class="text-base font-extrabold text-slate-900">Konfigurasi Penerimaan Peserta Didik Baru (PPDB)</h2>
                        <p class="text-xs text-slate-500">Mengatur informasi status gelombang, jadwal periode, dan daya tampung di halaman depan.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="sm:col-span-3">
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Judul Status Banner PPDB</label>
                            <input name="ppdb_status" value="{{ old('ppdb_status', $settings['ppdb_status']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Periode Pendaftaran</label>
                            <input name="ppdb_period" value="{{ old('ppdb_period', $settings['ppdb_period']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Kuota / Daya Tampung</label>
                            <input name="ppdb_quota" value="{{ old('ppdb_quota', $settings['ppdb_quota']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Tema Warna -->
            <div class="space-y-6 lg:col-span-4">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                    <div class="mb-4 border-b border-slate-100 pb-3">
                        <h2 class="text-base font-extrabold text-slate-900">Skema Warna Tema Website</h2>
                        <p class="text-xs text-slate-500">Disesuaikan dengan warna hijau logo RA Al-Isry Bogor.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Warna Utama (Primary Hex)</label>
                            <div class="flex items-center gap-2">
                                <span class="h-9 w-9 shrink-0 rounded-xl border shadow-inner" style="background-color: {{ $settings['primary_color'] }}"></span>
                                <input name="primary_color" value="{{ old('primary_color', $settings['primary_color']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 font-mono text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Warna Sekunder / Gelap (Secondary Hex)</label>
                            <div class="flex items-center gap-2">
                                <span class="h-9 w-9 shrink-0 rounded-xl border shadow-inner" style="background-color: {{ $settings['secondary_color'] }}"></span>
                                <input name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 font-mono text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-slate-700">Warna Aksen Sorotan (Accent Hex)</label>
                            <div class="flex items-center gap-2">
                                <span class="h-9 w-9 shrink-0 rounded-xl border shadow-inner" style="background-color: {{ $settings['accent_color'] }}"></span>
                                <input name="accent_color" value="{{ old('accent_color', $settings['accent_color']) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 font-mono text-sm">
                            </div>
                        </div>
                    </div>

                    <button class="mt-6 w-full rounded-xl bg-[#4d9a27] py-3 text-xs font-extrabold text-white shadow-sm transition hover:bg-[#3f821f]">
                        Simpan Seluruh Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layouts.app>
