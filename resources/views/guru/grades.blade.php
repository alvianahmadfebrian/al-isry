<x-layouts.app :title="'Input Nilai — '.$assignment->schoolClass->name.' ('.$assignment->subject->name.')'">
    @if (isset($assignments) && $assignments->count() > 1)
        <div class="mb-4 flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-3 shadow-sm">
            <span class="px-2 text-xs font-extrabold uppercase text-slate-400">Pilih Kelas &amp; Mapel:</span>
            @foreach ($assignments as $item)
                <a href="{{ route('guru.grades', $item) }}" class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition {{ $item->id === $assignment->id ? 'bg-[#4d9a27] text-white shadow-2xs' : 'bg-[#f8faf5] text-slate-700 hover:bg-lime-100' }}">
                    {{ $item->schoolClass->name }} — {{ $item->subject->name }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
        <a href="{{ route('guru.dashboard') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">&larr; Kembali ke Dashboard Guru</a>
        <div class="rounded-xl bg-lime-100 px-3.5 py-1.5 text-xs font-bold text-[#3f821f]">
            Bobot Otomatis: Tugas {{ $assignment->subject->weight_tugas }}% &bull; UH {{ $assignment->subject->weight_uh }}% &bull; UTS {{ $assignment->subject->weight_uts }}% &bull; UAS {{ $assignment->subject->weight_uas }}%
        </div>
    </div>

    <form method="POST" action="{{ route('guru.grades.store', $assignment) }}" class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="p-3.5">NIS</th>
                        <th class="p-3.5">Nama Peserta Didik</th>
                        <th class="p-3.5">Tugas</th>
                        <th class="p-3.5">UH</th>
                        <th class="p-3.5">UTS</th>
                        <th class="p-3.5">UAS</th>
                        <th class="p-3.5">Nilai Akhir</th>
                        <th class="p-3.5">Predikat</th>
                        <th class="p-3.5">Catatan Perkembangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($assignment->schoolClass->students as $st)
                        @php($gr = $existing->get($st->id))
                        <tr class="hover:bg-slate-50/70">
                            <td class="p-3.5 font-mono text-xs font-bold text-slate-600">{{ $st->nis }}</td>
                            <td class="p-3.5 font-bold text-slate-900">{{ $st->name }}</td>
                            <td class="p-3.5"><input type="number" step="0.01" min="0" max="100" name="grades[{{ $st->id }}][tugas]" value="{{ $gr?->tugas ?? 85 }}" class="w-20 rounded-xl border border-slate-300 px-2.5 py-1.5 text-center font-bold focus:border-[#4d9a27] focus:outline-none"></td>
                            <td class="p-3.5"><input type="number" step="0.01" min="0" max="100" name="grades[{{ $st->id }}][uh]" value="{{ $gr?->uh ?? 85 }}" class="w-20 rounded-xl border border-slate-300 px-2.5 py-1.5 text-center font-bold focus:border-[#4d9a27] focus:outline-none"></td>
                            <td class="p-3.5"><input type="number" step="0.01" min="0" max="100" name="grades[{{ $st->id }}][uts]" value="{{ $gr?->uts ?? 85 }}" class="w-20 rounded-xl border border-slate-300 px-2.5 py-1.5 text-center font-bold focus:border-[#4d9a27] focus:outline-none"></td>
                            <td class="p-3.5"><input type="number" step="0.01" min="0" max="100" name="grades[{{ $st->id }}][uas]" value="{{ $gr?->uas ?? 85 }}" class="w-20 rounded-xl border border-slate-300 px-2.5 py-1.5 text-center font-bold focus:border-[#4d9a27] focus:outline-none"></td>
                            <td class="p-3.5 font-extrabold text-[#4d9a27]">{{ $gr?->final_score ?? '-' }}</td>
                            <td class="p-3.5"><span class="rounded-lg bg-lime-100 px-2.5 py-1 text-xs font-extrabold text-[#3f821f]">{{ $gr?->predicate ?? '-' }}</span></td>
                            <td class="p-3.5"><input name="grades[{{ $st->id }}][notes]" value="{{ $gr?->notes }}" placeholder="Catatan perkembangan" class="w-full rounded-xl border border-slate-300 px-3 py-1.5 text-xs focus:border-[#4d9a27] focus:outline-none"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 border-t border-slate-100 pt-4">
            <button class="rounded-xl bg-[#4d9a27] px-6 py-3 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                Hitung Otomatis &amp; Simpan Nilai
            </button>
        </div>
    </form>
</x-layouts.app>
