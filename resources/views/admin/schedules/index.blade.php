<x-layouts.app title="Plotting Guru Mengajar & Jadwal Pelajaran">
    <!-- Ringkasan Statistik Plotting -->
    <div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-lime-200 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Total Plotting Mengajar</div>
            <div class="mt-1 text-2xl font-extrabold text-[#4d9a27]">{{ $assignments->count() }} <span class="text-xs font-semibold text-slate-400">Penugasan</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Guru Terjadwal</div>
            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $teachers->count() }} <span class="text-xs font-semibold text-slate-400">Pendidik</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Bidang / Mapel</div>
            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $subjects->count() }} <span class="text-xs font-semibold text-slate-400">Mapel</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Kelompok Belajar</div>
            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $classes->count() }} <span class="text-xs font-semibold text-slate-400">Rombel</span></div>
        </div>
    </div>

    <div class="grid items-start gap-6 lg:grid-cols-12">
        <!-- Kolom Kiri: Form Tambah Plotting -->
        <form method="POST" action="{{ route('admin.schedules.store') }}" class="space-y-4 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm text-sm lg:col-span-4">
            @csrf
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Penugasan Mengajar</span>
                    <h2 class="text-base font-extrabold text-slate-900">Tambah Plotting &amp; Jadwal</h2>
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-slate-700">Guru Pengampu <span class="text-red-500">*</span></label>
                <select name="teacher_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5 font-medium focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                    @foreach ($teachers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-slate-700">Mata Pelajaran / Bidang <span class="text-red-500">*</span></label>
                <select name="subject_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5 font-medium focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                    @foreach ($subjects as $s)
                        <option value="{{ $s->id }}">{{ $s->code }} — {{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-slate-700">Kelompok / Rombel Kelas <span class="text-red-500">*</span></label>
                <select name="class_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5 font-medium focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                    @foreach ($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Hari</label>
                    <select name="day_of_week" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-2.5 py-2 text-xs font-semibold">
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Jam Mulai</label>
                    <input name="start_time" value="07:30" required class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs font-semibold">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Jam Selesai</label>
                    <input name="end_time" value="09:00" required class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs font-semibold">
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-slate-700">Ruang Belajar</label>
                <input name="room" placeholder="Contoh: Ruang Seroja B1" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
            </div>

            <button class="w-full rounded-xl bg-[#4d9a27] py-3 text-xs font-extrabold text-white shadow-sm transition hover:bg-[#3f821f]">
                + Simpan Plotting &amp; Jadwal
            </button>
        </form>

        <!-- Kolom Kanan: Kartu Tabel & Rekap Kalender Mingguan -->
        <div class="space-y-6 lg:col-span-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
                <!-- Header Card Kanan -->
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-lime-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-extrabold sm:text-base">Daftar Plotting Guru &amp; Jadwal Aktif</h2>
                            <p class="text-xs text-lime-200/90">Distribusi penugasan guru mata pelajaran di setiap kelompok kelas</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">
                        {{ $assignments->count() }} Plotting Aktif
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-200 bg-slate-50/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-3.5">Guru Pengampu</th>
                                <th class="px-5 py-3.5">Mata Pelajaran</th>
                                <th class="px-5 py-3.5">Rombel Kelas</th>
                                <th class="px-5 py-3.5">Jadwal Pertemuan Mingguan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($assignments as $as)
                                <tr class="transition hover:bg-[#f8faf5]">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#4d9a27] to-[#2e5d1c] text-xs font-extrabold text-white shadow-sm">
                                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($as->teacher?->name ?? 'G', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ $as->teacher?->name }}</div>
                                                <div class="text-xs text-slate-400">{{ $as->teacher?->position ?? 'Guru Kelas' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-block rounded-md bg-slate-100 px-2 py-0.5 font-mono text-[11px] font-bold text-slate-600">{{ $as->subject?->code }}</span>
                                        <div class="mt-0.5 font-bold text-slate-800">{{ $as->subject?->name }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-lime-100 px-3 py-1.5 text-xs font-extrabold text-[#3f821f]">
                                            <span class="h-2 w-2 rounded-full bg-[#4d9a27]"></span>
                                            {{ $as->schoolClass?->name }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-xs">
                                        <div class="flex flex-col gap-1.5">
                                            @foreach ($as->schedules as $sch)
                                                <div class="inline-flex items-center justify-between gap-2 rounded-xl border border-lime-900/10 bg-[#f8faf5] px-3 py-1.5">
                                                    <span class="font-extrabold text-[#4d9a27]">{{ $sch->day_of_week }}, {{ $sch->start_time }}–{{ $sch->end_time }}</span>
                                                    <span class="rounded-md bg-white px-2 py-0.5 text-[11px] font-semibold text-slate-500 shadow-2xs">{{ $sch->room ?? 'Kelas' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-8 text-center text-slate-500">Belum ada plotting mengajar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Visualisasi Matriks Jadwal Mingguan -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">DiagramSebaran Jadwal Hari Efektif (Senin – Jumat)</h3>
                        <p class="text-xs text-slate-500">Visualisasi kepadatan sesi pembelajaran per hari</p>
                    </div>
                    <span class="text-xs font-bold text-[#4d9a27]">Kalender Akademik Aktif</span>
                </div>

                @php
                    $allSchedules = $assignments->flatMap(fn ($a) => $a->schedules->map(fn ($s) => [
                        'day' => $s->day_of_week,
                        'time' => $s->start_time.'–'.$s->end_time,
                        'subject' => $a->subject?->name,
                        'class' => $a->schoolClass?->name,
                        'teacher' => $a->teacher?->name,
                    ]));
                @endphp

                <div class="grid gap-3 sm:grid-cols-5">
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayName)
                        @php
                            $dayItems = $allSchedules->where('day', $dayName);
                        @endphp
                        <div class="rounded-2xl border border-slate-200/70 bg-[#f8faf5] p-3">
                            <div class="flex items-center justify-between border-b border-lime-900/10 pb-2">
                                <span class="text-xs font-extrabold text-slate-900">{{ $dayName }}</span>
                                <span class="rounded-full bg-lime-200/70 px-2 py-0.5 text-[10px] font-bold text-[#3f821f]">{{ $dayItems->count() }} Sesi</span>
                            </div>
                            <div class="mt-2 space-y-2">
                                @forelse ($dayItems as $di)
                                    <div class="rounded-xl bg-white p-2.5 text-[11px] shadow-2xs">
                                        <div class="font-bold text-[#4d9a27]">{{ $di['time'] }}</div>
                                        <div class="mt-0.5 line-clamp-1 font-bold text-slate-800">{{ $di['subject'] }}</div>
                                        <div class="text-slate-400">{{ $di['class'] }}</div>
                                    </div>
                                @empty
                                    <div class="py-3 text-center text-[11px] text-slate-400">Tematik Mandiri</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
