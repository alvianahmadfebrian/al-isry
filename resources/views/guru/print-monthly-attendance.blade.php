<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/logo-sekolah.png">
    <title>Rekap Absensi Bulanan — {{ $assignment->schoolClass->name }} ({{ $period->translatedFormat('F Y') }})</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; }
            @page { size: landscape; margin: 12mm; }
        }
    </style>
</head>
<body class="bg-slate-100 p-4 font-sans text-slate-900 md:p-8">
    <!-- Toolbar Tombol Cetak -->
    <div class="no-print mx-auto mb-6 flex max-w-6xl flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <a href="{{ route('guru.attendances', $assignment) }}" class="text-xs font-bold text-[#4d9a27] hover:underline">
            &larr; Kembali ke Halaman Input Absensi
        </a>
        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-700">Pilih Bulan:</label>
                <input type="month" name="bulan" value="{{ $monthInput }}" class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold">
                <button class="rounded-xl bg-slate-800 px-3 py-1.5 text-xs font-bold text-white">Tampilkan</button>
            </form>
            <button onclick="window.print()" type="button" class="inline-flex items-center gap-1.5 rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-extrabold text-white shadow">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Rekap Bulanan
            </button>
        </div>
    </div>

    <!-- Lembar Cetak Bulanan -->
    <div class="mx-auto max-w-6xl rounded-2xl border border-slate-300 bg-white p-8 shadow-sm print:border-0 print:p-0 print:shadow-none">
        <!-- Kop Surat Sekolah -->
        <div class="flex items-center gap-4 border-b-4 border-double border-slate-900 pb-4">
            <img src="/images/logo-sekolah.png" alt="Logo" class="h-20 w-20 object-contain">
            <div class="flex-1 text-center">
                <div class="text-xs font-bold uppercase tracking-widest text-[#3f821f]">Yayasan Al Istiqomah Seroja Raya Yasmin</div>
                <h1 class="text-xl font-extrabold uppercase tracking-tight text-slate-900">{{ $settings['school_name'] ?? 'RA Al-Isry Bogor' }}</h1>
                <p class="text-xs text-slate-600">{{ $settings['address'] ?? 'Jl. Seroja Raya, Taman Yasmin, Kota Bogor' }} &bull; Telp: {{ $settings['phone'] ?? '-' }}</p>
            </div>
        </div>

        <div class="my-5 text-center">
            <h2 class="text-base font-extrabold uppercase underline">Rekapitulasi Kehadiran Bulanan Peserta Didik</h2>
            <p class="mt-0.5 text-xs font-bold text-slate-600">Periode Bulan: {{ $period->translatedFormat('F Y') }}</p>
        </div>

        <div class="mb-4 grid grid-cols-2 gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3.5 text-xs sm:grid-cols-4">
            <div>
                <span class="block text-slate-500">Kelompok / Kelas</span>
                <strong class="text-slate-900">{{ $assignment->schoolClass->name }}</strong>
            </div>
            <div>
                <span class="block text-slate-500">Bidang / Mata Pelajaran</span>
                <strong class="text-slate-900">{{ $assignment->subject->name }}</strong>
            </div>
            <div>
                <span class="block text-slate-500">Guru Pengampu</span>
                <strong class="text-slate-900">{{ $assignment->teacher?->name ?? auth()->user()->name }}</strong>
            </div>
            <div>
                <span class="block text-slate-500">Jumlah Hari Pertemuan</span>
                <strong class="text-slate-900">{{ $meetingDates->count() }} Pertemuan</strong>
            </div>
        </div>

        <!-- Tabel Matriks Bulanan -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-slate-400 text-left text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-800">
                        <th rowspan="2" class="border border-slate-400 px-2.5 py-2 text-center">No</th>
                        <th rowspan="2" class="border border-slate-400 px-2.5 py-2">NIS</th>
                        <th rowspan="2" class="border border-slate-400 px-3 py-2">Nama Peserta Didik</th>
                        <th rowspan="2" class="border border-slate-400 px-2 py-2 text-center">L/P</th>
                        @if ($meetingDates->isNotEmpty())
                            <th colspan="{{ $meetingDates->count() }}" class="border border-slate-400 px-2 py-1 text-center">Tanggal Pertemuan ({{ $period->translatedFormat('M Y') }})</th>
                        @endif
                        <th colspan="4" class="border border-slate-400 px-2 py-1 text-center">Total Rekap Bulan Ini</th>
                        <th rowspan="2" class="border border-slate-400 px-2.5 py-2 text-center">% Hadir</th>
                    </tr>
                    <tr class="bg-slate-50 text-[11px] text-slate-700">
                        @foreach ($meetingDates as $md)
                            <th class="border border-slate-400 px-2 py-1 text-center font-mono">{{ \Carbon\Carbon::parse($md)->format('d') }}</th>
                        @endforeach
                        <th class="border border-slate-400 bg-lime-50 px-2 py-1 text-center font-bold text-[#3f821f]">H</th>
                        <th class="border border-slate-400 bg-amber-50 px-2 py-1 text-center font-bold text-amber-800">S</th>
                        <th class="border border-slate-400 bg-blue-50 px-2 py-1 text-center font-bold text-blue-800">I</th>
                        <th class="border border-slate-400 bg-red-50 px-2 py-1 text-center font-bold text-red-700">A</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignment->schoolClass->students as $index => $st)
                        @php
                            $stMap = $byStudentAndDate[$st->id] ?? [];
                            $hCount = collect($stMap)->filter(fn ($v) => $v === 'hadir')->count();
                            $sCount = collect($stMap)->filter(fn ($v) => $v === 'sakit')->count();
                            $iCount = collect($stMap)->filter(fn ($v) => $v === 'izin')->count();
                            $aCount = collect($stMap)->filter(fn ($v) => $v === 'alpa')->count();
                            $totalMeet = max(1, $meetingDates->count());
                            $pct = $meetingDates->isNotEmpty() ? round(($hCount / $totalMeet) * 100) : 0;
                        @endphp
                        <tr>
                            <td class="border border-slate-400 px-2.5 py-1.5 text-center">{{ $index + 1 }}</td>
                            <td class="border border-slate-400 px-2.5 py-1.5 font-mono">{{ $st->nis }}</td>
                            <td class="border border-slate-400 px-3 py-1.5 font-bold">{{ $st->name }}</td>
                            <td class="border border-slate-400 px-2 py-1.5 text-center">{{ $st->gender }}</td>
                            @foreach ($meetingDates as $md)
                                @php
                                    $code = match ($stMap[$md] ?? null) {
                                        'hadir' => 'H',
                                        'sakit' => 'S',
                                        'izin' => 'I',
                                        'alpa' => 'A',
                                        default => '-',
                                    };
                                @endphp
                                <td class="border border-slate-400 px-2 py-1.5 text-center font-bold">{{ $code }}</td>
                            @endforeach
                            <td class="border border-slate-400 px-2 py-1.5 text-center font-bold">{{ $hCount }}</td>
                            <td class="border border-slate-400 px-2 py-1.5 text-center font-bold">{{ $sCount }}</td>
                            <td class="border border-slate-400 px-2 py-1.5 text-center font-bold">{{ $iCount }}</td>
                            <td class="border border-slate-400 px-2 py-1.5 text-center font-bold">{{ $aCount }}</td>
                            <td class="border border-slate-400 px-2.5 py-1.5 text-center font-extrabold">{{ $meetingDates->isNotEmpty() ? $pct.'%' : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-wrap items-start justify-between gap-6 text-xs">
            <div class="text-slate-600">
                <strong>Keterangan Kode:</strong> H = Hadir &bull; S = Sakit &bull; I = Izin &bull; A = Alpa (Tanpa Keterangan)
            </div>
            <div class="pr-6 text-center">
                <div>Bogor, {{ now()->translatedFormat('d F Y') }}</div>
                <div class="mt-1 font-semibold">Guru Pengampu / Wali Kelas,</div>
                <div class="mt-14 font-bold underline">{{ $assignment->teacher?->name ?? auth()->user()->name }}</div>
                <div class="text-[11px] text-slate-500">NIP: {{ $assignment->teacher?->nip ?? '-' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
