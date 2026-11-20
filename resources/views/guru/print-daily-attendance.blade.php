<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/logo-sekolah.png">
    <title>Cetak Absensi Harian — {{ $assignment->schoolClass->name }} ({{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; }
        }
    </style>
</head>
<body class="bg-slate-100 p-4 font-sans text-slate-900 md:p-8">
    <!-- Toolbar Tombol Cetak -->
    <div class="no-print mx-auto mb-6 flex max-w-4xl flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <a href="{{ route('guru.attendances', ['assignment' => $assignment->id, 'tanggal' => $date]) }}" class="text-xs font-bold text-[#4d9a27] hover:underline">
            &larr; Kembali ke Halaman Input Absensi
        </a>
        <div class="flex items-center gap-2">
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="tanggal" value="{{ $date }}" class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold">
                <button class="rounded-xl bg-slate-800 px-3 py-1.5 text-xs font-bold text-white">Ganti Tanggal</button>
            </form>
            <button onclick="window.print()" type="button" class="inline-flex items-center gap-1.5 rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-extrabold text-white shadow">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Lembar Cetak A4 -->
    <div class="mx-auto max-w-4xl rounded-2xl border border-slate-300 bg-white p-8 shadow-sm print:border-0 print:p-0 print:shadow-none">
        <!-- Kop Surat Sekolah -->
        <div class="flex items-center gap-4 border-b-4 border-double border-slate-900 pb-4">
            <img src="/images/logo-sekolah.png" alt="Logo" class="h-20 w-20 object-contain">
            <div class="flex-1 text-center">
                <div class="text-xs font-bold uppercase tracking-widest text-[#3f821f]">Yayasan Al Istiqomah Seroja Raya Yasmin</div>
                <h1 class="text-xl font-extrabold uppercase tracking-tight text-slate-900">{{ $settings['school_name'] ?? 'RA Al-Isry Bogor' }}</h1>
                <p class="text-xs text-slate-600">{{ $settings['address'] ?? 'Jl. Seroja Raya, Taman Yasmin, Kota Bogor' }} &bull; Telp: {{ $settings['phone'] ?? '-' }}</p>
            </div>
        </div>

        <!-- Judul & Meta Pertemuan -->
        <div class="my-5 text-center">
            <h2 class="text-base font-extrabold uppercase underline">Daftar Hadir Harian Peserta Didik</h2>
        </div>

        <div class="mb-5 grid grid-cols-2 gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs sm:grid-cols-4">
            <div>
                <span class="block text-slate-500">Kelompok / Kelas</span>
                <strong class="text-slate-900">{{ $assignment->schoolClass->name }}</strong>
            </div>
            <div>
                <span class="block text-slate-500">Bidang / Mata Pelajaran</span>
                <strong class="text-slate-900">{{ $assignment->subject->name }}</strong>
            </div>
            <div>
                <span class="block text-slate-500">Hari, Tanggal</span>
                <strong class="text-slate-900">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</strong>
            </div>
            <div>
                <span class="block text-slate-500">Pertemuan Ke-</span>
                <strong class="text-slate-900">{{ $existing->first()?->meeting_number ?? '-' }}</strong>
            </div>
        </div>

        <!-- Tabel Kehadiran Harian -->
        <table class="w-full border-collapse border border-slate-400 text-left text-xs">
            <thead>
                <tr class="bg-slate-100 text-slate-800">
                    <th class="border border-slate-400 px-3 py-2 text-center">No</th>
                    <th class="border border-slate-400 px-3 py-2">NIS</th>
                    <th class="border border-slate-400 px-3 py-2">Nama Peserta Didik</th>
                    <th class="border border-slate-400 px-3 py-2 text-center">L/P</th>
                    <th class="border border-slate-400 px-3 py-2 text-center">Status Kehadiran</th>
                    <th class="border border-slate-400 px-3 py-2">Keterangan / Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counts = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'belum' => 0];
                @endphp
                @foreach ($assignment->schoolClass->students as $index => $st)
                    @php
                        $att = $existing->get($st->id);
                        $stStatus = $att?->status;
                        if ($stStatus && isset($counts[$stStatus])) {
                            $counts[$stStatus]++;
                        } else {
                            $counts['belum']++;
                        }
                    @endphp
                    <tr>
                        <td class="border border-slate-400 px-3 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono">{{ $st->nis }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-bold">{{ $st->name }}</td>
                        <td class="border border-slate-400 px-3 py-2 text-center">{{ $st->gender }}</td>
                        <td class="border border-slate-400 px-3 py-2 text-center font-bold uppercase">
                            {{ $stStatus ? ucfirst($stStatus) : '-' }}
                        </td>
                        <td class="border border-slate-400 px-3 py-2">{{ $att?->notes ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Ringkasan & Tanda Tangan -->
        <div class="mt-5 flex flex-wrap items-start justify-between gap-6 text-xs">
            <div class="rounded-xl border border-slate-300 p-3">
                <div class="mb-1 font-bold text-slate-800">Rekapitulasi Kehadiran:</div>
                <div class="flex flex-wrap gap-4">
                    <span>Hadir: <strong>{{ $counts['hadir'] }}</strong></span>
                    <span>Sakit: <strong>{{ $counts['sakit'] }}</strong></span>
                    <span>Izin: <strong>{{ $counts['izin'] }}</strong></span>
                    <span>Alpa: <strong>{{ $counts['alpa'] }}</strong></span>
                    @if ($counts['belum'] > 0)
                        <span>Belum Diisi: <strong>{{ $counts['belum'] }}</strong></span>
                    @endif
                </div>
            </div>

            <div class="pr-6 text-center">
                <div>Bogor, {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</div>
                <div class="mt-1 font-semibold">Guru Pengampu / Wali Kelas,</div>
                <div class="mt-14 font-bold underline">{{ $assignment->teacher?->name ?? auth()->user()->name }}</div>
                <div class="text-[11px] text-slate-500">NIP: {{ $assignment->teacher?->nip ?? '-' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
