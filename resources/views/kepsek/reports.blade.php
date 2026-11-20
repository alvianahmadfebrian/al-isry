<x-layouts.app title="Laporan Akademik & Kehadiran Seluruh Kelas (Read-Only)">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
        <div>
            <h2 class="text-sm font-extrabold text-slate-900">Cetak Rekap Kehadiran &amp; Nilai Bulanan</h2>
            <p class="text-xs text-slate-500">Pilih bulan laporan untuk mencetak rekap seluruh kelompok belajar</p>
        </div>
        <form method="GET" action="{{ route('kepsek.reports.print') }}" target="_blank" class="flex items-center gap-2">
            <input type="month" name="bulan" value="{{ now()->format('Y-m') }}" class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold">
            <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-extrabold text-white shadow-2xs hover:bg-[#3f821f]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan Bulanan
            </button>
        </form>
    </div>

    <div class="space-y-6">
        @foreach ($classes as $cl)
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#f8faf5] to-white px-6 py-4">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Rekapitulasi Rombel</span>
                        <h2 class="text-lg font-extrabold text-slate-900">{{ $cl->name }} ({{ $cl->level }})</h2>
                        <p class="text-xs text-slate-500">Wali Kelas: <strong>{{ $cl->homeroomTeacher?->name ?? '-' }}</strong></p>
                    </div>
                    <span class="rounded-full bg-lime-100 px-3.5 py-1 text-xs font-bold text-[#3f821f]">{{ $cl->students->count() }} Peserta Didik</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="p-4">NIS</th>
                                <th class="p-4">Nama Peserta Didik</th>
                                <th class="p-4">Kehadiran (Hadir)</th>
                                <th class="p-4">Sakit / Izin</th>
                                <th class="p-4">Rata-Rata Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($cl->students as $st)
                                @php
                                    $hadir = $st->attendances->where('status', 'hadir')->count();
                                    $sakitIzin = $st->attendances->whereIn('status', ['sakit', 'izin'])->count();
                                    $avg = $st->grades->avg('final_score');
                                @endphp
                                <tr class="hover:bg-slate-50/70">
                                    <td class="p-4 font-mono text-xs font-bold text-slate-600">{{ $st->nis }}</td>
                                    <td class="p-4 font-bold text-slate-900">{{ $st->name }}</td>
                                    <td class="p-4">
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-800">{{ $hadir }} Pertemuan</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800">{{ $sakitIzin }} Hari</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="rounded-xl bg-lime-100 px-3 py-1 font-extrabold text-[#3f821f]">
                                            {{ $avg ? number_format($avg, 2) : '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.app>
