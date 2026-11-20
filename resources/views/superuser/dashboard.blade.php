<x-layouts.app title="Dashboard Super User">
    <!-- Hero Banner Sambutan -->
    <div class="relative mb-6 overflow-hidden rounded-3xl bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#356922] p-6 text-white shadow-lg sm:p-8">
        <div class="relative z-10 flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">
                    &#9733; Tahun Ajaran Aktif: {{ $activeYear ? $activeYear->name.' ('.$activeYear->semester.')' : '2026/2027 (Ganjil)' }}
                </span>
                <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="mt-1 max-w-2xl text-xs text-slate-200 sm:text-sm">
                    Panel kontrol utama RA Al-Isry Bogor. Pantau diagram analitik sekolah, distribusi pengguna, kapasitas kelas, dan riwayat sistem secara real-time.
                </p>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('superuser.users.create') }}" class="rounded-xl bg-[#84cc16] px-4 py-2.5 text-xs font-extrabold text-slate-950 shadow transition hover:brightness-105">
                    + Buat Akun Baru
                </a>
                <a href="{{ route('superuser.settings') }}" class="rounded-xl border border-white/25 bg-white/10 px-4 py-2.5 text-xs font-bold text-white backdrop-blur transition hover:bg-white/20">
                    Pengaturan Sekolah
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Utama Berikon -->
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Total Akun</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-slate-900">{{ $stats['users'] }}</div>
        </div>

        <div class="rounded-2xl border border-lime-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Total Siswa</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-lime-100 text-[#4d9a27]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-[#4d9a27]">{{ $stats['students'] }}</div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Pendidik</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-slate-900">{{ $stats['teachers'] }}</div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Rombel Kelas</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-slate-900">{{ $stats['classes'] }}</div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Mapel</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 text-purple-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-slate-900">{{ $stats['subjects'] }}</div>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-800">PPDB Baru</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-200/70 text-amber-900">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                </span>
            </div>
            <div class="mt-2 text-2xl font-extrabold text-amber-700">{{ $stats['ppdb_pending'] }}</div>
        </div>
    </div>

    <!-- BAGIAN DIAGRAM ANALITIK VISUAL -->
    <div class="mt-6 grid gap-6 lg:grid-cols-12">
        <!-- Diagram 1: Bar Chart Kapasitas & Keterisian Siswa per Kelas -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Diagram Rombel</span>
                    <h2 class="text-base font-extrabold text-slate-900">Keterisian Siswa per Kelas</h2>
                </div>
                <span class="rounded-full bg-lime-100 px-2.5 py-0.5 text-xs font-bold text-[#3f821f]">{{ $stats['students'] }} Siswa</span>
            </div>

            <div class="mt-5 space-y-4">
                @foreach ($classSummary as $cls)
                    @php
                        $pct = $cls->capacity > 0 ? min(100, round(($cls->students_count / $cls->capacity) * 100)) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800">{{ $cls->name }}</span>
                            <span class="font-bold text-[#4d9a27]">{{ $cls->students_count }} / {{ $cls->capacity }} Siswa ({{ $pct }}%)</span>
                        </div>
                        <div class="mt-1.5 h-3.5 w-full overflow-hidden rounded-full bg-slate-100 p-0.5">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#4d9a27] to-[#84cc16]" style="width: {{ max($pct, 8) }}%"></div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4 rounded-2xl bg-[#f8faf5] p-3.5 text-xs text-slate-600">
                    <div class="font-bold text-slate-800">Ringkasan Rekap Absensi Sistem:</div>
                    <div class="mt-2 grid grid-cols-4 gap-2 text-center">
                        <div class="rounded-xl bg-white p-2 shadow-2xs">
                            <div class="text-sm font-extrabold text-[#4d9a27]">{{ $attendanceSummary['Hadir'] }}</div>
                            <div class="text-[10px] text-slate-400">Hadir</div>
                        </div>
                        <div class="rounded-xl bg-white p-2 shadow-2xs">
                            <div class="text-sm font-extrabold text-amber-600">{{ $attendanceSummary['Sakit'] }}</div>
                            <div class="text-[10px] text-slate-400">Sakit</div>
                        </div>
                        <div class="rounded-xl bg-white p-2 shadow-2xs">
                            <div class="text-sm font-extrabold text-blue-600">{{ $attendanceSummary['Izin'] }}</div>
                            <div class="text-[10px] text-slate-400">Izin</div>
                        </div>
                        <div class="rounded-xl bg-white p-2 shadow-2xs">
                            <div class="text-sm font-extrabold text-red-600">{{ $attendanceSummary['Alpa'] }}</div>
                            <div class="text-[10px] text-slate-400">Alpa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagram 2: Distribusi Role Akun & Grafik Vertikal Komposisi Data -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-7">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Visualisasi Data Sistem</span>
                    <h2 class="text-base font-extrabold text-slate-900">Diagram Perbandingan Entitas &amp; Role Pengguna</h2>
                </div>
                <span class="text-xs font-semibold text-slate-400">Live Database</span>
            </div>

            @php
                $maxBar = max(1, $stats['students'], $stats['teachers'], $stats['users'], $stats['subjects'], $stats['classes']);
                $bars = [
                    ['label' => 'Siswa', 'val' => $stats['students'], 'color' => 'from-[#4d9a27] to-[#84cc16]'],
                    ['label' => 'Guru', 'val' => $stats['teachers'], 'color' => 'from-emerald-600 to-teal-400'],
                    ['label' => 'Akun', 'val' => $stats['users'], 'color' => 'from-blue-600 to-cyan-400'],
                    ['label' => 'Mapel', 'val' => $stats['subjects'], 'color' => 'from-purple-600 to-indigo-400'],
                    ['label' => 'Kelas', 'val' => $stats['classes'], 'color' => 'from-amber-500 to-yellow-400'],
                ];
            @endphp

            <div class="mt-5 grid gap-6 sm:grid-cols-12 sm:items-end">
                <!-- Grafik Batang Vertikal -->
                <div class="flex h-44 items-end justify-around gap-3 rounded-2xl bg-[#f8faf5] p-4 sm:col-span-7">
                    @foreach ($bars as $b)
                        @php
                            $h = max(18, round(($b['val'] / $maxBar) * 120));
                        @endphp
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="text-xs font-extrabold text-slate-800">{{ $b['val'] }}</span>
                            <div class="w-9 rounded-t-xl bg-gradient-to-t {{ $b['color'] }} shadow-sm" style="height: {{ $h }}px"></div>
                            <span class="text-[11px] font-bold text-slate-500">{{ $b['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Distribusi Role Pengguna -->
                <div class="space-y-2.5 sm:col-span-5">
                    <div class="text-xs font-extrabold text-slate-800">Komposisi Role Akun ({{ $stats['users'] }})</div>
                    @foreach ($roleDistribution as $roleLabel => $cnt)
                        @php
                            $rPct = $stats['users'] > 0 ? round(($cnt / $stats['users']) * 100) : 0;
                        @endphp
                        <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-2.5">
                            <div class="flex justify-between text-xs">
                                <span class="font-bold text-slate-700">{{ $roleLabel }}</span>
                                <span class="font-extrabold text-[#4d9a27]">{{ $cnt }} ({{ $rPct }}%)</span>
                            </div>
                            <div class="mt-1 h-1.5 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-[#4d9a27]" style="width: {{ max($rPct, 10) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modul Akses Cepat Super User -->
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('superuser.users.index') }}" class="group flex flex-col justify-between rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27] transition group-hover:bg-[#4d9a27] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="mt-3 font-extrabold text-slate-900 group-hover:text-[#4d9a27]">Kelola Seluruh Akun</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Tambah, ubah, nonaktifkan akun Admin, Kepala Sekolah, dan Guru.</p>
            </div>
            <span class="mt-4 text-xs font-bold text-[#4d9a27]">Buka Modul &rarr;</span>
        </a>

        <a href="{{ route('superuser.settings') }}" class="group flex flex-col justify-between rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27] transition group-hover:bg-[#4d9a27] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                </div>
                <div class="mt-3 font-extrabold text-slate-900 group-hover:text-[#4d9a27]">Pengaturan Sistem Global</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Atur nama sekolah, warna tema web, kontak, dan periode PPDB.</p>
            </div>
            <span class="mt-4 text-xs font-bold text-[#4d9a27]">Buka Modul &rarr;</span>
        </a>

        <a href="{{ route('superuser.logs') }}" class="group flex flex-col justify-between rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27] transition group-hover:bg-[#4d9a27] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="mt-3 font-extrabold text-slate-900 group-hover:text-[#4d9a27]">Activity Log Sistem</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Pantau riwayat aktivitas pengguna di seluruh sistem secara real-time.</p>
            </div>
            <span class="mt-4 text-xs font-bold text-[#4d9a27]">Buka Modul &rarr;</span>
        </a>

        <a href="{{ route('superuser.backup') }}" class="group flex flex-col justify-between rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#4d9a27] hover:shadow-md">
            <div>
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27] transition group-hover:bg-[#4d9a27] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </div>
                <div class="mt-3 font-extrabold text-slate-900 group-hover:text-[#4d9a27]">Backup &amp; Export Data</div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Unduh salinan cadangan seluruh database sekolah dalam format JSON.</p>
            </div>
            <span class="mt-4 text-xs font-bold text-[#4d9a27]">Buka Modul &rarr;</span>
        </a>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <!-- Log Aktivitas Terbaru -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-extrabold text-slate-900">Aktivitas Sistem Terbaru</h2>
                <a href="{{ route('superuser.logs') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="mt-3 divide-y divide-slate-100 text-sm">
                @forelse ($recentLogs as $log)
                    <div class="py-3">
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span class="rounded-md bg-lime-100 px-2 py-0.5 font-bold text-[#3f821f]">{{ $log->action }}</span>
                            <span>{{ $log->created_at?->diffForHumans() }}</span>
                        </div>
                        <div class="mt-1 font-medium text-slate-800">{{ $log->description }}</div>
                        <div class="mt-0.5 text-xs text-slate-400">Oleh: {{ $log->user?->name ?? 'Sistem' }}</div>
                    </div>
                @empty
                    <p class="py-4 text-xs text-slate-500">Belum ada catatan aktivitas.</p>
                @endforelse
            </div>
        </div>

        <!-- Daftar Akun Terbaru -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-extrabold text-slate-900">Akun Pengguna Terdaftar</h2>
                <a href="{{ route('superuser.users.index') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">Kelola Akun &rarr;</a>
            </div>
            <div class="mt-3 divide-y divide-slate-100 text-sm">
                @foreach ($recentUsers as $u)
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-lime-100 text-xs font-extrabold text-[#4d9a27]">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($u->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">{{ $u->name }}</div>
                                <div class="text-xs text-slate-500">{{ $u->email }}</div>
                            </div>
                        </div>
                        <span class="rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-[#3f821f]">{{ $u->role->label() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
