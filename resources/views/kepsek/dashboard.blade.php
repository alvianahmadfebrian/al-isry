<x-layouts.app title="Dashboard Kepala Sekolah">
    <!-- Banner Sambutan Kepala Sekolah -->
    <div class="mb-6 rounded-3xl bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#356922] p-6 text-white shadow-lg sm:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <span class="inline-block rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">
                    Panel Monitoring Eksekutif &amp; Supervisi Akademik
                </span>
                <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">Selamat Bertugas, {{ auth()->user()->name }}</h2>
                <p class="mt-1 max-w-2xl text-xs text-slate-200 sm:text-sm">
                    Pantau diagram kehadiran harian siswa, grafik capaian nilai rata-rata per kelompok kelas, berikan persetujuan dokumen RPPH guru, dan terbitkan pengumuman internal.
                </p>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('kepsek.approvals') }}" class="rounded-xl bg-[#84cc16] px-4 py-2.5 text-xs font-extrabold text-slate-950 shadow">
                    Review Dokumen ({{ $pendingApprovals->count() }})
                </a>
                <a href="{{ route('kepsek.announcements') }}" class="rounded-xl border border-white/25 bg-white/10 px-4 py-2.5 text-xs font-bold text-white">
                    + Pengumuman Internal
                </a>
            </div>
        </div>
    </div>

    <!-- Ringkasan Eksekutif Berikon -->
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-lime-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Total Peserta Didik</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-[#4d9a27]">{{ $studentCount }}</div>
            <div class="mt-1 text-[11px] text-slate-400">Siswa aktif terdaftar</div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Tenaga Pendidik</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $teacherCount }}</div>
            <div class="mt-1 text-[11px] text-slate-400">Guru &amp; wali kelompok</div>
        </div>
        <div class="rounded-2xl border border-lime-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Kehadiran Hari Ini</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-[#4d9a27]">{{ $attendanceRate }}%</div>
            <div class="mt-1 text-[11px] text-slate-400">Persentase siswa hadir</div>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-amber-800">Menunggu Persetujuan</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-200/80 text-amber-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-amber-700">{{ $pendingApprovals->count() }} <span class="text-sm font-bold">Dokumen</span></div>
            <div class="mt-1 text-[11px] text-amber-800">RPPH / Evaluasi guru</div>
        </div>
    </div>

    <!-- DIAGRAM ANALITIK KEPALA SEKOLAH -->
    <div class="mt-6 grid gap-6 lg:grid-cols-12">
        <!-- Diagram 1: Bar Chart Rata-Rata Nilai Akhir per Kelas -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-7">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Grafik Akademik</span>
                    <h2 class="text-base font-extrabold text-slate-900">Diagram Rata-Rata Nilai &amp; Sebaran Predikat</h2>
                </div>
                <a href="{{ route('kepsek.reports') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">Laporan Lengkap &rarr;</a>
            </div>

            <div class="mt-4 space-y-4">
                @foreach ($classes as $cl)
                    @php
                        $score = (float) ($cl->average_score ?: 0);
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs">
                            <div>
                                <span class="font-extrabold text-slate-900">{{ $cl->name }}</span>
                                <span class="ml-1 text-slate-400">({{ $cl->students_count }} Siswa &bull; Wali: {{ $cl->homeroomTeacher?->name ?? '-' }})</span>
                            </div>
                            <span class="rounded-lg bg-lime-100 px-2.5 py-0.5 font-extrabold text-[#3f821f]">Rata-rata: {{ $score ?: '-' }}</span>
                        </div>
                        <div class="mt-1.5 h-3.5 w-full overflow-hidden rounded-full bg-slate-100 p-0.5">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#4d9a27] to-[#84cc16]" style="width: {{ max((int) $score, 10) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 grid grid-cols-4 gap-3 border-t border-slate-100 pt-4 text-center">
                <div class="rounded-2xl bg-lime-50 p-3">
                    <div class="text-lg font-extrabold text-[#3f821f]">{{ $predicateBreakdown['A'] ?? 0 }}</div>
                    <div class="text-[11px] font-bold text-slate-600">Predikat A (Sangat Baik)</div>
                </div>
                <div class="rounded-2xl bg-blue-50 p-3">
                    <div class="text-lg font-extrabold text-blue-700">{{ $predicateBreakdown['B'] ?? 0 }}</div>
                    <div class="text-[11px] font-bold text-slate-600">Predikat B (Baik)</div>
                </div>
                <div class="rounded-2xl bg-amber-50 p-3">
                    <div class="text-lg font-extrabold text-amber-700">{{ $predicateBreakdown['C'] ?? 0 }}</div>
                    <div class="text-[11px] font-bold text-slate-600">Predikat C (Cukup)</div>
                </div>
                <div class="rounded-2xl bg-red-50 p-3">
                    <div class="text-lg font-extrabold text-red-700">{{ $predicateBreakdown['D'] ?? 0 }}</div>
                    <div class="text-[11px] font-bold text-slate-600">Predikat D (Perlu Bimbingan)</div>
                </div>
            </div>
        </div>

        <!-- Diagram 2: Donut Chart Kehadiran Siswa -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Diagram Presensi</span>
                <h2 class="text-base font-extrabold text-slate-900">Rasio Kehadiran Peserta Didik</h2>
            </div>

            <div class="mt-5 flex flex-col items-center">
                <div class="relative flex h-40 w-40 items-center justify-center rounded-full shadow-inner"
                     style="background: conic-gradient(#4d9a27 0% {{ $attendanceRate }}%, #e2e8f0 {{ $attendanceRate }}% 100%);">
                    <div class="flex h-28 w-28 flex-col items-center justify-center rounded-full bg-white text-center shadow">
                        <span class="text-2xl font-extrabold text-[#4d9a27]">{{ $attendanceRate }}%</span>
                        <span class="text-[10px] font-bold uppercase text-slate-400">Hadir Hari Ini</span>
                    </div>
                </div>

                <div class="mt-5 grid w-full grid-cols-2 gap-2.5 text-xs">
                    <div class="flex items-center justify-between rounded-xl bg-[#f8faf5] px-3 py-2">
                        <span class="font-semibold text-slate-600">Hadir</span>
                        <strong class="text-[#4d9a27]">{{ $attendanceBreakdown['hadir'] ?? 0 }}</strong>
                    </div>
                    <div class="flex items-center justify-between rounded-xl bg-[#f8faf5] px-3 py-2">
                        <span class="font-semibold text-slate-600">Sakit</span>
                        <strong class="text-amber-600">{{ $attendanceBreakdown['sakit'] ?? 0 }}</strong>
                    </div>
                    <div class="flex items-center justify-between rounded-xl bg-[#f8faf5] px-3 py-2">
                        <span class="font-semibold text-slate-600">Izin</span>
                        <strong class="text-blue-600">{{ $attendanceBreakdown['izin'] ?? 0 }}</strong>
                    </div>
                    <div class="flex items-center justify-between rounded-xl bg-[#f8faf5] px-3 py-2">
                        <span class="font-semibold text-slate-600">Alpa</span>
                        <strong class="text-red-600">{{ $attendanceBreakdown['alpa'] ?? 0 }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <!-- Dokumen Menunggu Persetujuan -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-extrabold text-slate-900">Dokumen Menunggu Persetujuan</h2>
                <a href="{{ route('kepsek.approvals') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">Kelola Persetujuan &rarr;</a>
            </div>
            <div class="mt-3 divide-y divide-slate-100 text-sm">
                @forelse ($pendingApprovals as $ap)
                    <div class="py-3">
                        <div class="flex items-center justify-between">
                            <span class="rounded-md bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800">{{ $ap->document_type }}</span>
                            <span class="text-xs text-slate-400">Oleh: {{ $ap->submitter?->name }}</span>
                        </div>
                        <div class="mt-1.5 font-bold text-slate-900">{{ $ap->title }}</div>
                        <p class="mt-0.5 text-xs text-slate-600">{{ $ap->description }}</p>
                    </div>
                @empty
                    <p class="py-4 text-xs text-slate-500">Tidak ada dokumen yang menunggu persetujuan.</p>
                @endforelse
            </div>
        </div>

        <!-- Pengumuman Internal -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-extrabold text-slate-900">Pengumuman Internal Guru &amp; Staf</h2>
                <a href="{{ route('kepsek.announcements') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">+ Buat Pengumuman &rarr;</a>
            </div>
            <div class="mt-3 divide-y divide-slate-100 text-sm">
                @forelse ($announcements as $an)
                    <div class="py-3">
                        <div class="font-bold text-slate-900">{{ $an->title }}</div>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">{{ $an->content }}</p>
                        <div class="mt-1 text-[11px] text-slate-400">Target: {{ ucfirst($an->audience) }} &bull; {{ $an->created_at?->diffForHumans() }}</div>
                    </div>
                @empty
                    <p class="py-4 text-xs text-slate-500">Belum ada pengumuman internal.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
