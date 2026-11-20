<x-layouts.app :title="'Absensi Siswa — '.$assignment->schoolClass->name.' ('.$assignment->subject->name.')'">
    @if (isset($assignments) && $assignments->count() > 1)
        <div class="mb-4 flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-3 shadow-sm">
            <span class="px-2 text-xs font-extrabold uppercase text-slate-400">Pilih Kelas &amp; Mapel:</span>
            @foreach ($assignments as $item)
                <a href="{{ route('guru.attendances', ['assignment' => $item->id, 'tanggal' => $date]) }}" class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition {{ $item->id === $assignment->id ? 'bg-[#4d9a27] text-white shadow-2xs' : 'bg-[#f8faf5] text-slate-700 hover:bg-lime-100' }}">
                    {{ $item->schoolClass->name }} — {{ $item->subject->name }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
        <div class="flex flex-wrap items-center gap-2 text-sm">
            <form method="GET" class="flex flex-wrap items-center gap-2">
                <label class="text-xs font-bold text-slate-700">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $date }}" class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold">
                <button class="rounded-xl bg-[#4d9a27] px-3.5 py-1.5 text-xs font-bold text-white">Tampilkan</button>
            </form>

            <a href="{{ route('guru.attendances.print-daily', ['assignment' => $assignment->id, 'tanggal' => $date]) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl border border-lime-600/40 bg-lime-50 px-3.5 py-1.5 text-xs font-extrabold text-[#3f821f] transition hover:bg-lime-100">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Absensi Harian
            </a>
        </div>

        <form method="GET" action="{{ route('guru.attendances.print-monthly', $assignment) }}" target="_blank" class="flex flex-wrap items-center gap-2 text-sm">
            <label class="text-xs font-bold text-slate-700">Rekap Bulan:</label>
            <input type="month" name="bulan" value="{{ \Carbon\Carbon::parse($date)->format('Y-m') }}" class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold">
            <button class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-3.5 py-1.5 text-xs font-extrabold text-white transition hover:bg-slate-800">
                <svg class="h-4 w-4 text-lime-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Rekap Bulanan
            </button>
        </form>
    </div>

    @if ($isFuture ?? false)
        <div class="mb-5 flex items-center gap-3 rounded-2xl border border-amber-300 bg-amber-50 p-4 text-xs font-bold text-amber-900 shadow-2xs">
            <svg class="h-5 w-5 shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Hari/tanggal pertemuan ini (<strong>{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</strong>) belum tiba. Seluruh pilihan status kehadiran masih kosong dan baru dapat diisi saat tanggal pertemuan tiba.</span>
        </div>
    @elseif ($existing->isEmpty())
        <div class="mb-5 flex items-center gap-3 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-xs font-bold text-blue-900 shadow-2xs">
            <svg class="h-5 w-5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Belum ada rekaman absensi tersimpan pada tanggal ini. Status default disiapkan ke <strong>Hadir</strong> — silakan sesuaikan lalu klik <strong>Simpan Absensi Pertemuan</strong>.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('guru.attendances.store', $assignment) }}" class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Rekap Kehadiran Harian</span>
                <div class="text-base font-extrabold">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</div>
            </div>
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-lime-200">Pertemuan Ke-</label>
                <input type="number" name="meeting_number" value="{{ $existing->first()?->meeting_number ?? '' }}" placeholder="1" min="1" @disabled($isFuture ?? false) class="w-20 rounded-xl border border-white/20 bg-white/10 px-3 py-1.5 text-center text-xs font-extrabold text-white placeholder-slate-300 disabled:opacity-50">
            </div>
        </div>

        <div class="overflow-x-auto p-6">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="p-4">NIS</th>
                        <th class="p-4">Nama Peserta Didik</th>
                        <th class="p-4">Status Kehadiran</th>
                        <th class="p-4">Catatan Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($assignment->schoolClass->students as $st)
                        @php
                            $att = $existing->get($st->id);
                            $selectedStatus = ($isFuture ?? false)
                                ? $att?->status
                                : ($att?->status ?? 'hadir');
                        @endphp
                        <tr class="hover:bg-slate-50/70 {{ ($isFuture ?? false) ? 'opacity-65' : '' }}">
                            <td class="p-4 font-mono text-xs font-bold text-slate-600">{{ $st->nis }}</td>
                            <td class="p-4 font-bold text-slate-900">{{ $st->name }}</td>
                            <td class="p-4">
                                <div class="flex flex-wrap gap-3 text-xs font-semibold">
                                    @foreach (['hadir' => 'Hadir', 'sakit' => 'Sakit', 'izin' => 'Izin', 'alpa' => 'Alpa'] as $val => $lbl)
                                        <label class="inline-flex items-center gap-1.5 rounded-lg border px-2.5 py-1 transition {{ $selectedStatus === $val ? 'border-blue-500 bg-blue-50/70 text-blue-900 font-bold' : 'border-slate-200 text-slate-600' }} {{ ($isFuture ?? false) ? 'cursor-not-allowed' : 'cursor-pointer hover:border-[#4d9a27]' }}">
                                            <input type="radio" name="statuses[{{ $st->id }}]" value="{{ $val }}" @checked($selectedStatus === $val) @disabled($isFuture ?? false)>
                                            <span>{{ $lbl }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="p-4">
                                <input name="notes[{{ $st->id }}]" value="{{ ($isFuture ?? false) ? '' : $att?->notes }}" placeholder="{{ ($isFuture ?? false) ? 'Belum dapat diisi' : 'Catatan kehadiran (opsional)' }}" @disabled($isFuture ?? false) class="w-full rounded-xl border border-slate-300 px-3 py-1.5 text-xs focus:border-[#4d9a27] focus:outline-none disabled:bg-slate-100">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50/60 px-6 py-4">
            @if ($isFuture ?? false)
                <span class="text-xs font-bold text-amber-700">Tombol simpan dikunci karena tanggal pertemuan belum tiba.</span>
                <button type="button" disabled class="cursor-not-allowed rounded-xl bg-slate-300 px-6 py-2.5 text-xs font-extrabold text-slate-500">
                    Belum Dapat Disimpan
                </button>
            @else
                <span class="text-xs text-slate-500">Pastikan status kehadiran seluruh peserta didik sudah sesuai.</span>
                <button class="rounded-xl bg-[#4d9a27] px-6 py-3 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    Simpan Absensi Pertemuan
                </button>
            @endif
        </div>
    </form>
</x-layouts.app>
