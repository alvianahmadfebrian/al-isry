<x-layouts.app title="Dashboard Guru — Kelas & Jadwal Mengajar">
    <!-- Banner Profil Guru -->
    <div class="mb-6 rounded-3xl bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#356922] p-6 text-white shadow-lg sm:p-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="inline-block rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">
                    {{ $teacher->position ?? 'Guru Kelas' }}
                </span>
                <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">{{ $teacher->name }}</h2>
                <p class="mt-1 text-xs text-slate-200 sm:text-sm">
                    Bidang Keahlian: {{ $teacher->specialization ?? 'Pendidikan Anak Usia Dini' }} &bull; Mengampu {{ $assignments->count() }} Kelas / Mata Pelajaran
                </p>
            </div>
            <a href="{{ route('profile.edit') }}" class="rounded-xl border border-white/25 bg-white/10 px-4 py-2.5 text-xs font-bold text-white backdrop-blur hover:bg-white/20">
                Ubah Profil &amp; Sandi
            </a>
        </div>
    </div>

    <!-- Diagram Ringkas Pembelajaran Guru Berikon -->
    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-lime-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Kelas Diampu</div>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-[#4d9a27]">{{ $assignments->count() }} <span class="text-xs font-normal text-slate-400">Mapel</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Rata-Rata Nilai Kelas</div>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-slate-900">{{ $avgGrade ?: '-' }}</div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Total Presensi Hadir</div>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-emerald-700">{{ $attendanceStats['hadir'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Catatan</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Sakit / Izin</div>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-amber-600">{{ ($attendanceStats['sakit'] ?? 0) + ($attendanceStats['izin'] ?? 0) }}</div>
        </div>
    </div>

    <!-- Daftar Kelas & Mata Pelajaran yang Diampu -->
    <h2 class="mb-3 text-base font-extrabold text-slate-900">Kelas &amp; Mata Pelajaran yang Diampu</h2>
    <div class="grid gap-5 md:grid-cols-2">
        @forelse ($assignments as $as)
            <div class="flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:border-[#4d9a27]">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="rounded-xl bg-[#4d9a27] px-3 py-1 text-xs font-bold text-white">{{ $as->schoolClass?->name }}</span>
                        <span class="rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-[#3f821f]">{{ $as->schoolClass?->students->count() ?? 0 }} Siswa</span>
                    </div>
                    <h3 class="mt-3 text-lg font-extrabold text-slate-900">{{ $as->subject?->name }}</h3>
                    <div class="mt-3 space-y-1.5 rounded-2xl bg-[#f8faf5] p-3.5 text-xs text-slate-600">
                        @foreach ($as->schedules as $sch)
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">{{ $sch->day_of_week }}, {{ $sch->start_time }}–{{ $sch->end_time }}</span>
                                <span class="rounded bg-white px-2 py-0.5 text-[11px] font-semibold text-slate-500">{{ $sch->room ?? 'Ruang Kelas' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-2 border-t border-slate-100 pt-4 text-xs font-bold">
                    <a href="{{ route('guru.attendances', $as) }}" class="rounded-xl bg-[#4d9a27] px-3.5 py-2 text-white shadow-sm hover:bg-[#3f821f]">Input Absensi</a>
                    <a href="{{ route('guru.grades', $as) }}" class="rounded-xl bg-slate-800 px-3.5 py-2 text-white hover:bg-slate-900">Input Nilai</a>
                    <a href="{{ route('guru.materials', $as) }}" class="rounded-xl border border-slate-300 px-3.5 py-2 text-slate-700 hover:border-[#4d9a27]">Materi &amp; Tugas</a>
                    <a href="{{ route('guru.students', $as) }}" class="rounded-xl border border-slate-300 px-3.5 py-2 text-slate-700 hover:border-[#4d9a27]">Daftar Siswa</a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl bg-white p-8 text-center text-sm text-slate-500">
                Belum ada kelas yang di-plotting untuk akun guru ini. Hubungi Admin Sekolah.
            </div>
        @endforelse
    </div>

    <!-- Pengumuman Internal & Pengajuan RPP/Dokumen ke Kepsek -->
    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h2 class="border-b border-slate-100 pb-3 font-extrabold text-slate-900">Pengumuman Internal Sekolah</h2>
            <div class="mt-3 divide-y divide-slate-100 text-sm">
                @forelse ($announcements as $an)
                    <div class="py-3">
                        <div class="font-bold text-slate-900">{{ $an->title }}</div>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">{{ $an->content }}</p>
                        <div class="mt-1 text-[11px] text-slate-400">Oleh {{ $an->author?->name ?? 'Kepala Sekolah' }} &bull; {{ $an->created_at?->diffForHumans() }}</div>
                    </div>
                @empty
                    <p class="py-4 text-xs text-slate-500">Belum ada pengumuman internal.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h2 class="border-b border-slate-100 pb-3 font-extrabold text-slate-900">Ajukan Dokumen (RPPH / Modul Ajar) ke Kepala Sekolah</h2>
            <form method="POST" action="{{ route('guru.approvals.store') }}" class="mt-4 space-y-3 text-sm">
                @csrf
                <input name="title" required placeholder="Judul Dokumen (cth: RPPH Minggu ke-3 Tema Alam Semesta)" class="w-full rounded-xl border border-slate-300 px-3.5 py-2">
                <select name="document_type" class="w-full rounded-xl border border-slate-300 px-3.5 py-2">
                    <option value="RPP / Modul Ajar">RPP / Modul Ajar (RPPH)</option>
                    <option value="Pengajuan Nilai Remedial">Pengajuan Nilai / Evaluasi Perkembangan</option>
                    <option value="Proposal Kegiatan Kelas">Proposal Kegiatan Kelas</option>
                </select>
                <textarea name="description" rows="2" required placeholder="Ringkasan isi dokumen..." class="w-full rounded-xl border border-slate-300 p-3"></textarea>
                <button class="rounded-xl bg-[#4d9a27] px-5 py-2.5 text-xs font-bold text-white shadow-sm">Kirim Pengajuan</button>
            </form>

            <div class="mt-4 divide-y divide-slate-100 text-xs">
                @foreach ($myApprovals as $ap)
                    <div class="flex items-center justify-between py-2.5">
                        <div>
                            <div class="font-bold text-slate-800">{{ $ap->title }}</div>
                            @if ($ap->reviewer_notes)
                                <div class="text-slate-500">Catatan Kepsek: {{ $ap->reviewer_notes }}</div>
                            @endif
                        </div>
                        <span class="rounded-full px-2.5 py-1 font-bold {{ $ap->status === 'disetujui' ? 'bg-lime-100 text-lime-800' : ($ap->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                            {{ ucfirst($ap->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
