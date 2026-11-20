<x-layouts.public title="Formulir Pendaftaran PPDB" :settings="$settings">
    <section class="bg-school-secondary py-12 text-white">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <span class="inline-block rounded-full bg-lime-400/20 px-3 py-1 text-xs font-semibold text-lime-300">
                        {{ $settings['ppdb_status'] ?? 'PPDB Online' }}
                    </span>
                    <h1 class="mt-2 text-2xl font-extrabold sm:text-3xl">Formulir Pendaftaran Peserta Didik Baru</h1>
                    <p class="mt-1 text-sm text-slate-300">{{ $settings['school_name'] }}</p>
                </div>
                <a href="{{ route('ppdb.check') }}" class="inline-flex items-center gap-2 self-start rounded-xl border border-lime-300/30 bg-white/10 px-4 py-2.5 text-xs font-bold text-lime-200 backdrop-blur transition hover:bg-white/20">
                    Sudah Daftar? Cek Status PPDB &rarr;
                </a>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-12">
                <!-- Form Utama -->
                <form method="POST" action="{{ route('ppdb.store') }}" class="space-y-8 rounded-2xl border border-lime-900/10 bg-white p-6 shadow-sm sm:p-8 lg:col-span-8">
                    @csrf

                    <!-- Bagian 1: Data Calon Peserta Didik -->
                    <div>
                        <div class="border-b border-slate-200 pb-3">
                            <h2 class="text-lg font-bold text-slate-900">1. Data Calon Peserta Didik (Anak)</h2>
                            <p class="text-xs text-slate-500">Isi sesuai Akta Kelahiran dan Kartu Keluarga.</p>
                        </div>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Nama Lengkap Anak <span class="text-red-500">*</span></label>
                                <input name="child_name" value="{{ old('child_name') }}" required placeholder="Contoh: Muhammad Arkan Alfatih" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('child_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Nama Panggilan</label>
                                <input name="nickname" value="{{ old('nickname') }}" placeholder="Contoh: Arkan" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('nickname')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="gender" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                                </select>
                                @error('gender')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input name="birth_place" value="{{ old('birth_place') }}" required placeholder="Contoh: Bogor" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('birth_place')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('birth_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">NIK Anak (Opsional)</label>
                                <input name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK sesuai KK" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Pilihan Kelompok Belajar <span class="text-red-500">*</span></label>
                                <select name="group_choice" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                    <option value="Kelompok A (4-5 Tahun)" @selected(old('group_choice') === 'Kelompok A (4-5 Tahun)')>Kelompok A (Usia 4–5 Tahun)</option>
                                    <option value="Kelompok B (5-6 Tahun)" @selected(old('group_choice') === 'Kelompok B (5-6 Tahun)')>Kelompok B (Usia 5–6 Tahun)</option>
                                </select>
                                @error('group_choice')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Catatan Kesehatan / Alergi / Kebutuhan Khusus (Jika ada)</label>
                                <input name="health_notes" value="{{ old('health_notes') }}" placeholder="Kosongkan jika tidak ada" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('health_notes')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 2: Data Orang Tua / Wali -->
                    <div>
                        <div class="border-b border-slate-200 pb-3">
                            <h2 class="text-lg font-bold text-slate-900">2. Data Orang Tua / Wali</h2>
                            <p class="text-xs text-slate-500">Pastikan nomor WhatsApp aktif untuk konfirmasi jadwal observasi &amp; verifikasi berkas.</p>
                        </div>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Nama Lengkap Ayah <span class="text-red-500">*</span></label>
                                <input name="father_name" value="{{ old('father_name') }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('father_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Pekerjaan Ayah</label>
                                <input name="father_occupation" value="{{ old('father_occupation') }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Nama Lengkap Ibu <span class="text-red-500">*</span></label>
                                <input name="mother_name" value="{{ old('mother_name') }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('mother_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Pekerjaan Ibu</label>
                                <input name="mother_occupation" value="{{ old('mother_occupation') }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">No. WhatsApp / Telepon Aktif <span class="text-red-500">*</span></label>
                                <input name="parent_phone" value="{{ old('parent_phone') }}" required placeholder="Contoh: 081288997766" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('parent_phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Email Orang Tua (Opsional)</label>
                                <input type="email" name="parent_email" value="{{ old('parent_email') }}" placeholder="ayahbunda@email.com" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                                @error('parent_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Alamat Lengkap Tempat Tinggal <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="3" required placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">{{ old('address') }}</textarea>
                                @error('address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-4">
                        <p class="text-xs text-slate-500">Dengan mengirim formulir ini, data akan masuk ke sistem PPDB {{ $settings['school_short_name'] ?? 'RA Al-Isry' }}.</p>
                        <button class="rounded-xl bg-school-primary px-6 py-3 text-sm font-bold text-white shadow transition hover:opacity-95">
                            Kirim Pendaftaran Sekarang
                        </button>
                    </div>
                </form>

                <!-- Info Samping -->
                <aside class="space-y-6 lg:col-span-4">
                    <div class="rounded-2xl border border-lime-900/10 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-bold text-slate-900">Alur Pendaftaran Online</h3>
                        <ol class="mt-4 space-y-3 text-xs leading-relaxed text-slate-600">
                            <li class="flex gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-school-primary font-bold text-white">1</span>
                                <span>Isi dan kirim formulir pendaftaran online pada halaman ini.</span>
                            </li>
                            <li class="flex gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-school-primary font-bold text-white">2</span>
                                <span>Simpan atau cetak <strong>Bukti &amp; Nomor Pendaftaran</strong> yang muncul setelah formulir dikirim.</span>
                            </li>
                            <li class="flex gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-school-primary font-bold text-white">3</span>
                                <span>Panitia PPDB akan memverifikasi data dan menghubungi nomor WhatsApp orang tua.</span>
                            </li>
                            <li class="flex gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-school-primary font-bold text-white">4</span>
                                <span>Pantau status penerimaan kapan saja melalui halaman <a href="{{ route('ppdb.check') }}" class="font-bold text-school-primary underline">Cek Status PPDB</a>.</span>
                            </li>
                        </ol>
                    </div>

                    <div class="rounded-2xl border border-lime-900/10 bg-lime-50/70 p-6">
                        <h3 class="text-sm font-bold text-slate-900">Berkas yang Dibawa Saat Verifikasi</h3>
                        <ul class="mt-3 space-y-2 text-xs text-slate-700">
                            @foreach (array_filter(preg_split('/\r\n|\r|\n/', $settings['ppdb_requirements'] ?? '')) as $req)
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-school-primary"></span>
                                    <span>{{ $req }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.public>
