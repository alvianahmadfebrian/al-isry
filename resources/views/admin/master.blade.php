<x-layouts.app title="Data Master Akademik">
    <!-- Banner Header Data Master -->
    <div class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#356922] p-6 text-white shadow-lg sm:p-7">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="inline-block rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">
                    Konfigurasi Dasar Kurikulum RA Al-Isry Bogor
                </span>
                <h2 class="mt-2 text-xl font-extrabold sm:text-2xl">Pusat Data Master Akademik</h2>
                <p class="mt-1 text-xs text-slate-200 sm:text-sm">
                    Kelola periode Tahun Ajaran aktif, Kelompok Rombongan Belajar (beserta Wali Kelas), serta Mata Pelajaran dan komposisi bobot penilaian otomatis.
                </p>
            </div>
            <div class="flex gap-3">
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-2.5 text-center backdrop-blur">
                    <div class="text-xl font-extrabold text-lime-300">{{ $academicYears->count() }}</div>
                    <div class="text-[10px] font-bold uppercase text-slate-200">Thn Ajaran</div>
                </div>
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-2.5 text-center backdrop-blur">
                    <div class="text-xl font-extrabold text-lime-300">{{ $classes->count() }}</div>
                    <div class="text-[10px] font-bold uppercase text-slate-200">Rombel</div>
                </div>
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-2.5 text-center backdrop-blur">
                    <div class="text-xl font-extrabold text-lime-300">{{ $subjects->count() }}</div>
                    <div class="text-[10px] font-bold uppercase text-slate-200">Mapel</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid items-start gap-6 lg:grid-cols-3">
        <!-- 1. Tahun Ajaran -->
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Master 01</span>
                <h2 class="text-base font-extrabold">Tahun Ajaran &amp; Semester</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('admin.academic-years.store') }}" class="space-y-3 text-sm">
                    @csrf
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Tahun Ajaran</label>
                        <input name="name" required placeholder="Contoh: 2026/2027" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Semester</label>
                        <select name="semester" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                            <option value="Ganjil">Semester Ganjil</option>
                            <option value="Genap">Semester Genap</option>
                        </select>
                    </div>
                    <label class="flex items-center gap-2 rounded-xl bg-[#f8faf5] p-2.5 text-xs font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#4d9a27]"> Jadikan Tahun Ajaran Aktif
                    </label>
                    <button class="w-full rounded-xl bg-[#4d9a27] py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">+ Tambah Tahun Ajaran</button>
                </form>

                <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100 pt-3 text-xs">
                    @foreach ($academicYears as $ay)
                        <div class="flex items-center justify-between py-2.5">
                            <div>
                                <span class="font-bold text-slate-900">{{ $ay->name }}</span>
                                <span class="text-slate-500">({{ $ay->semester }})</span>
                            </div>
                            @if ($ay->is_active)
                                <span class="rounded-full bg-lime-100 px-2.5 py-0.5 font-bold text-[#3f821f]">Aktif</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-500">Arsip</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2. Kelas / Kelompok Belajar -->
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Master 02</span>
                <h2 class="text-base font-extrabold">Kelompok / Rombel Kelas</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('admin.classes.store') }}" class="space-y-3 text-sm">
                    @csrf
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Nama Rombel Kelas</label>
                        <input name="name" required placeholder="Contoh: Kelompok A2 (Melati)" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="mb-1 block text-xs font-bold text-slate-700">Jenjang Kelompok</label>
                            <select name="level" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs">
                                <option value="Kelompok A">Kelompok A (4-5 Thn)</option>
                                <option value="Kelompok B">Kelompok B (5-6 Thn)</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-bold text-slate-700">Kapasitas</label>
                            <input type="number" name="capacity" value="20" required class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Wali Kelas</label>
                        <select name="homeroom_teacher_id" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 text-xs">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($teachers as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="w-full rounded-xl bg-[#4d9a27] py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">+ Tambah Kelas</button>
                </form>

                <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100 pt-3 text-xs">
                    @foreach ($classes as $cl)
                        <div class="flex items-center justify-between py-2.5">
                            <div>
                                <div class="font-bold text-slate-900">{{ $cl->name }}</div>
                                <div class="text-slate-500">Wali: {{ $cl->homeroomTeacher?->name ?? '-' }}</div>
                            </div>
                            <span class="rounded-full bg-lime-100 px-2.5 py-1 font-bold text-[#3f821f]">{{ $cl->students_count }}/{{ $cl->capacity }} Siswa</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 3. Mata Pelajaran & Bobot Nilai -->
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Master 03</span>
                <h2 class="text-base font-extrabold">Mata Pelajaran &amp; Bobot (%)</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('admin.subjects.store') }}" class="space-y-3 text-sm">
                    @csrf
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="mb-1 block text-xs font-bold text-slate-700">Kode</label>
                            <input name="code" required placeholder="PAI-01" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs">
                        </div>
                        <div class="col-span-2">
                            <label class="mb-1 block text-xs font-bold text-slate-700">Nama Bidang / Mapel</label>
                            <input name="name" required placeholder="Tahfidz & Iqra" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs">
                        </div>
                    </div>
                    <div class="rounded-2xl bg-[#f8faf5] p-3">
                        <div class="mb-2 text-[11px] font-bold text-slate-600">Komposisi Bobot Nilai Otomatis (%)</div>
                        <div class="grid grid-cols-4 gap-2 text-xs">
                            <div><label class="block text-[10px] text-slate-500">Tugas</label><input type="number" name="weight_tugas" value="20" class="w-full rounded-lg border bg-white px-2 py-1 font-bold"></div>
                            <div><label class="block text-[10px] text-slate-500">UH</label><input type="number" name="weight_uh" value="20" class="w-full rounded-lg border bg-white px-2 py-1 font-bold"></div>
                            <div><label class="block text-[10px] text-slate-500">UTS</label><input type="number" name="weight_uts" value="25" class="w-full rounded-lg border bg-white px-2 py-1 font-bold"></div>
                            <div><label class="block text-[10px] text-slate-500">UAS</label><input type="number" name="weight_uas" value="35" class="w-full rounded-lg border bg-white px-2 py-1 font-bold"></div>
                        </div>
                    </div>
                    <button class="w-full rounded-xl bg-[#4d9a27] py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">+ Tambah Mata Pelajaran</button>
                </form>

                <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100 pt-3 text-xs">
                    @foreach ($subjects as $sub)
                        <div class="py-2.5">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">{{ $sub->name }}</span>
                                <span class="rounded bg-slate-100 px-2 py-0.5 font-mono text-[11px] font-bold text-slate-600">{{ $sub->code }}</span>
                            </div>
                            <div class="mt-1 flex gap-1 text-[10px] font-bold">
                                <span class="rounded bg-lime-100 px-1.5 py-0.5 text-[#3f821f]">Tgs {{ $sub->weight_tugas }}%</span>
                                <span class="rounded bg-emerald-100 px-1.5 py-0.5 text-emerald-800">UH {{ $sub->weight_uh }}%</span>
                                <span class="rounded bg-blue-100 px-1.5 py-0.5 text-blue-800">UTS {{ $sub->weight_uts }}%</span>
                                <span class="rounded bg-amber-100 px-1.5 py-0.5 text-amber-800">UAS {{ $sub->weight_uas }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
