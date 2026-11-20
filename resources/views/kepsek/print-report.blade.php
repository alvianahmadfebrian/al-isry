<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/logo-sekolah.png">
    <title>Cetak Laporan Bulanan Seluruh Kelas — {{ $period->translatedFormat('F Y') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; }
        }
    </style>
</head>
<body class="bg-slate-100 p-4 font-sans text-slate-900 md:p-8">
    <div class="no-print mx-auto mb-6 flex max-w-5xl flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <a href="{{ route('kepsek.reports') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">&larr; Kembali ke Laporan Kepsek</a>
        <button onclick="window.print()" type="button" class="inline-flex items-center gap-1.5 rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-extrabold text-white shadow">
            Cetak Laporan Sekarang
        </button>
    </div>

    <div class="mx-auto max-w-5xl space-y-8 rounded-2xl border border-slate-300 bg-white p-8 shadow-sm print:border-0 print:p-0 print:shadow-none">
        <div class="flex items-center gap-4 border-b-4 border-double border-slate-900 pb-4">
            <img src="/images/logo-sekolah.png" alt="Logo" class="h-20 w-20 object-contain">
            <div class="flex-1 text-center">
                <div class="text-xs font-bold uppercase tracking-widest text-[#3f821f]">Yayasan Al Istiqomah Seroja Raya Yasmin</div>
                <h1 class="text-xl font-extrabold uppercase tracking-tight text-slate-900">{{ $settings['school_name'] ?? 'RA Al-Isry Bogor' }}</h1>
                <p class="text-xs text-slate-600">{{ $settings['address'] ?? 'Jl. Seroja Raya, Taman Yasmin, Kota Bogor' }} &bull; Telp: {{ $settings['phone'] ?? '-' }}</p>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-base font-extrabold uppercase underline">Laporan Rekapitulasi Kehadiran &amp; Nilai Bulanan Seluruh Kelas</h2>
            <p class="text-xs font-bold text-slate-600">Periode Bulan: {{ $period->translatedFormat('F Y') }}</p>
        </div>

        @foreach ($classes as $cl)
            <div>
                <div class="mb-2 flex items-center justify-between text-xs font-bold">
                    <span>Kelompok: {{ $cl->name }} ({{ $cl->level }})</span>
                    <span>Wali Kelas: {{ $cl->homeroomTeacher?->name ?? '-' }}</span>
                </div>
                <table class="w-full border-collapse border border-slate-400 text-left text-xs">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="border border-slate-400 px-3 py-1.5 text-center">No</th>
                            <th class="border border-slate-400 px-3 py-1.5">NIS</th>
                            <th class="border border-slate-400 px-3 py-1.5">Nama Peserta Didik</th>
                            <th class="border border-slate-400 px-3 py-1.5 text-center">Hadir</th>
                            <th class="border border-slate-400 px-3 py-1.5 text-center">Sakit</th>
                            <th class="border border-slate-400 px-3 py-1.5 text-center">Izin</th>
                            <th class="border border-slate-400 px-3 py-1.5 text-center">Alpa</th>
                            <th class="border border-slate-400 px-3 py-1.5 text-center">Rata-Rata Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cl->students as $idx => $st)
                            @php
                                $avg = $st->grades->avg('final_score');
                            @endphp
                            <tr>
                                <td class="border border-slate-400 px-3 py-1.5 text-center">{{ $idx + 1 }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 font-mono">{{ $st->nis }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 font-bold">{{ $st->name }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 text-center">{{ $st->attendances->where('status', 'hadir')->count() }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 text-center">{{ $st->attendances->where('status', 'sakit')->count() }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 text-center">{{ $st->attendances->where('status', 'izin')->count() }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 text-center">{{ $st->attendances->where('status', 'alpa')->count() }}</td>
                                <td class="border border-slate-400 px-3 py-1.5 text-center font-bold">{{ $avg ? number_format($avg, 2) : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</body>
</html>
