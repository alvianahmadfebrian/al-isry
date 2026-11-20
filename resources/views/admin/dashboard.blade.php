<x-layouts.app title="Dashboard Admin Sekolah">
    <!-- Banner Sambutan Admin -->
    <div class="mb-6 rounded-3xl bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#356922] p-6 text-white shadow-lg sm:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-start gap-4">
                <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-lime-300/30 bg-white/10 text-lime-300 backdrop-blur sm:flex">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Panel Administrasi Akademik &amp; PPDB
                    </span>
                    <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">Halo, {{ auth()->user()->name }}!</h2>
                    <p class="mt-1 max-w-2xl text-xs text-slate-200 sm:text-sm">
                        Kelola data master tahun ajaran, siswa, guru, plotting jadwal mengajar, verifikasi pendaftar PPDB online, serta pembaruan berita dan galeri website publik.
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-[#84cc16] px-4 py-2.5 text-xs font-extrabold text-slate-950 shadow transition hover:brightness-105">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Tambah Siswa
                </a>
                <a href="{{ route('admin.ppdb.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-white/25 bg-white/10 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-white/20">
                    <svg class="h-4 w-4 text-lime-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Verifikasi PPDB ({{ $stats['ppdb_waiting'] }})
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas Berikon -->
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-lime-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Siswa Aktif</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-[#4d9a27]">{{ $stats['students'] }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] font-medium text-slate-400">
                <svg class="h-3.5 w-3.5 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Terdaftar di seluruh kelompok
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Tenaga Pendidik</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['teachers'] }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] font-medium text-slate-400">
                <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Guru kelas &amp; pendamping
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500">Rombel &amp; Mapel</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['classes'] }} <span class="text-base font-bold text-slate-400">/ {{ $stats['subjects'] }} Mapel</span></div>
            <div class="mt-1 flex items-center gap-1 text-[11px] font-medium text-slate-400">
                <svg class="h-3.5 w-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                Kelompok belajar aktif
            </div>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="text-xs font-bold text-amber-800">Pendaftar PPDB</div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-200/80 text-amber-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
            </div>
            <div class="mt-2 text-3xl font-extrabold text-amber-700">{{ $stats['ppdb_total'] }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] font-bold text-amber-800">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $stats['ppdb_waiting'] }} menunggu verifikasi
            </div>
        </div>
    </div>

    <!-- DIAGRAM VISUALISASI DATA ADMIN -->
    <div class="mt-6 grid gap-6 lg:grid-cols-12">
        <!-- Diagram 1: Donut Chart Komposisi Gender & Bar Chart Kapasitas Kelas -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-7">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Diagram Akademik</span>
                        <h2 class="text-base font-extrabold text-slate-900">Keterisian Rombel &amp; Komposisi Gender Siswa</h2>
                    </div>
                </div>
                <span class="rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-[#3f821f]">Total {{ $stats['students'] }} Siswa</span>
            </div>

            @php
                $totalG = max(1, $genderStats['L'] + $genderStats['P']);
                $pctL = round(($genderStats['L'] / $totalG) * 100);
                $pctP = 100 - $pctL;
            @endphp

            <div class="mt-5 grid items-center gap-6 sm:grid-cols-12">
                <!-- Donut Chart Gender -->
                <div class="flex flex-col items-center sm:col-span-5">
                    <div class="relative flex h-36 w-36 items-center justify-center rounded-full shadow-inner"
                         style="background: conic-gradient(#4d9a27 0% {{ $pctL }}%, #f59e0b {{ $pctL }}% 100%);">
                        <div class="flex h-24 w-24 flex-col items-center justify-center rounded-full bg-white text-center shadow">
                            <span class="text-xl font-extrabold text-slate-900">{{ $stats['students'] }}</span>
                            <span class="text-[10px] font-bold uppercase text-slate-400">Peserta Didik</span>
                        </div>
                    </div>
                    <div class="mt-3 flex gap-4 text-xs font-bold">
                        <span class="inline-flex items-center gap-1.5 text-slate-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#4d9a27]"></span> Laki-laki: {{ $genderStats['L'] }} ({{ $pctL }}%)
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-slate-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> Perempuan: {{ $genderStats['P'] }} ({{ $pctP }}%)
                        </span>
                    </div>
                </div>

                <!-- Bar Progress per Kelas -->
                <div class="space-y-4 sm:col-span-7">
                    @foreach ($classes as $c)
                        @php
                            $fill = $c->capacity > 0 ? min(100, round(($c->students_count / $c->capacity) * 100)) : 0;
                        @endphp
                        <div class="rounded-2xl border border-lime-900/10 bg-[#f8faf5] p-3.5">
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-lime-100 text-[#4d9a27]">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                                    </span>
                                    <div>
                                        <span class="font-extrabold text-slate-900">{{ $c->name }}</span>
                                        <span class="block text-[11px] text-slate-500">Wali: {{ $c->homeroomTeacher?->name ?? '-' }}</span>
                                    </div>
                                </div>
                                <span class="rounded-lg bg-lime-100 px-2.5 py-1 font-extrabold text-[#3f821f]">{{ $c->students_count }}/{{ $c->capacity }} ({{ $fill }}%)</span>
                            </div>
                            <div class="mt-2.5 h-3 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-gradient-to-r from-[#4d9a27] to-[#84cc16]" style="width: {{ max($fill, 8) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Diagram 2: Funnel / Status Pendaftaran PPDB Online -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Diagram PPDB</span>
                        <h2 class="text-base font-extrabold text-slate-900">Progres Seleksi PPDB Online</h2>
                    </div>
                </div>
                <a href="{{ route('admin.ppdb.index') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">Detail &rarr;</a>
            </div>

            @php
                $totalPpdb = max(1, $stats['ppdb_total']);
                $ppdbBars = [
                    ['label' => 'Menunggu Verifikasi', 'count' => $ppdbStats['menunggu'], 'bar' => 'bg-amber-500', 'badge' => 'bg-amber-100 text-amber-800', 'dot' => 'bg-amber-500'],
                    ['label' => 'Berkas Diverifikasi', 'count' => $ppdbStats['diverifikasi'], 'bar' => 'bg-blue-500', 'badge' => 'bg-blue-100 text-blue-800', 'dot' => 'bg-blue-500'],
                    ['label' => 'Siswa Diterima', 'count' => $ppdbStats['diterima'], 'bar' => 'bg-[#4d9a27]', 'badge' => 'bg-lime-100 text-[#3f821f]', 'dot' => 'bg-[#4d9a27]'],
                    ['label' => 'Belum Diterima', 'count' => $ppdbStats['ditolak'], 'bar' => 'bg-red-500', 'badge' => 'bg-red-100 text-red-700', 'dot' => 'bg-red-500'],
                ];
            @endphp

            <div class="mt-4 space-y-3.5">
                @foreach ($ppdbBars as $pb)
                    @php
                        $w = round(($pb['count'] / $totalPpdb) * 100);
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="inline-flex items-center gap-2 font-bold text-slate-700">
                                <span class="h-2 w-2 rounded-full {{ $pb['dot'] }}"></span>
                                {{ $pb['label'] }}
                            </span>
                            <span class="rounded-full px-2.5 py-0.5 font-extrabold {{ $pb['badge'] }}">{{ $pb['count'] }} Pendaftar</span>
                        </div>
                        <div class="mt-1.5 h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full {{ $pb['bar'] }}" style="width: {{ max($w, 6) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Navigasi Modul Admin Lengkap dengan Ikon -->
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- 1. Data Master -->
        <a href="{{ route('admin.master') }}" class="group flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-lime-100 text-[#4d9a27] transition group-hover:bg-[#4d9a27] group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500 group-hover:bg-lime-100 group-hover:text-[#3f821f]">Modul 01</span>
                </div>
                <div class="mt-4 text-base font-extrabold text-slate-900 group-hover:text-[#4d9a27]">1. Data Master Akademik</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Kelola tahun ajaran, kelompok kelas, mata pelajaran, dan bobot nilai.</p>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-[#4d9a27]">
                <span>Buka Data Master</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>

        <!-- 2. Data Siswa -->
        <a href="{{ route('admin.students.index') }}" class="group flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 transition group-hover:bg-[#4d9a27] group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500 group-hover:bg-lime-100 group-hover:text-[#3f821f]">Modul 02</span>
                </div>
                <div class="mt-4 text-base font-extrabold text-slate-900 group-hover:text-[#4d9a27]">2. Data Siswa, Import CSV &amp; Kartu</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Tambah siswa, import massal CSV, dan cetak kartu pelajar berlogo.</p>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-[#4d9a27]">
                <span>Kelola Data Siswa</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>

        <!-- 3. Akun & Profil Guru -->
        <a href="{{ route('admin.teachers.index') }}" class="group flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 transition group-hover:bg-[#4d9a27] group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500 group-hover:bg-lime-100 group-hover:text-[#3f821f]">Modul 03</span>
                </div>
                <div class="mt-4 text-base font-extrabold text-slate-900 group-hover:text-[#4d9a27]">3. Akun &amp; Profil Guru</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Buat akun login guru, nonaktifkan, dan atur tampil di landing page.</p>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-[#4d9a27]">
                <span>Kelola Akun Guru</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>

        <!-- 4. Plotting Guru & Jadwal -->
        <a href="{{ route('admin.schedules.index') }}" class="group flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100 text-purple-700 transition group-hover:bg-[#4d9a27] group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500 group-hover:bg-lime-100 group-hover:text-[#3f821f]">Modul 04</span>
                </div>
                <div class="mt-4 text-base font-extrabold text-slate-900 group-hover:text-[#4d9a27]">4. Plotting Guru &amp; Jadwal</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Atur penugasan guru mengajar mapel di kelas beserta jam pelajaran.</p>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-[#4d9a27]">
                <span>Atur Jadwal Pelajaran</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>

        <!-- 5. Verifikasi PPDB -->
        <a href="{{ route('admin.ppdb.index') }}" class="group flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700 transition group-hover:bg-[#4d9a27] group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[11px] font-bold text-amber-800">{{ $stats['ppdb_waiting'] }} Baru</span>
                </div>
                <div class="mt-4 text-base font-extrabold text-slate-900 group-hover:text-[#4d9a27]">5. Verifikasi Pendaftar PPDB</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Verifikasi formulir pendaftaran siswa baru yang masuk dari website.</p>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-[#4d9a27]">
                <span>Verifikasi Pendaftar</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>

        <!-- 6. Konten Landing Page (CMS) -->
        <a href="{{ route('admin.cms.index') }}" class="group flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-rose-700 transition group-hover:bg-[#4d9a27] group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500 group-hover:bg-lime-100 group-hover:text-[#3f821f]">Modul 06</span>
                </div>
                <div class="mt-4 text-base font-extrabold text-slate-900 group-hover:text-[#4d9a27]">6. Konten Landing Page (CMS)</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Kelola berita, pengumuman, foto galeri kegiatan, dan profil sekolah.</p>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-[#4d9a27]">
                <span>Kelola Berita &amp; Galeri</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>
    </div>
</x-layouts.app>
