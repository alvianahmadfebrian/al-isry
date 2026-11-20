<x-layouts.app :title="'Daftar Siswa — '.$assignment->schoolClass->name">
    @if (isset($assignments) && $assignments->count() > 1)
        <div class="mb-4 flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-3 shadow-sm">
            <span class="px-2 text-xs font-extrabold uppercase text-slate-400">Pilih Kelas &amp; Mapel:</span>
            @foreach ($assignments as $item)
                <a href="{{ route('guru.students', $item) }}" class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition {{ $item->id === $assignment->id ? 'bg-[#4d9a27] text-white shadow-2xs' : 'bg-[#f8faf5] text-slate-700 hover:bg-lime-100' }}">
                    {{ $item->schoolClass->name }} — {{ $item->subject->name }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('guru.dashboard') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">&larr; Kembali ke Dashboard Guru</a>
        <span class="rounded-full bg-lime-100 px-3.5 py-1 text-xs font-bold text-[#3f821f]">Total: {{ $assignment->schoolClass->students->count() }} Siswa</span>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="p-4">NIS</th>
                    <th class="p-4">Nama Lengkap Peserta Didik</th>
                    <th class="p-4">Jenis Kelamin</th>
                    <th class="p-4">Tempat, Tanggal Lahir</th>
                    <th class="p-4">Orang Tua &amp; WhatsApp</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($assignment->schoolClass->students as $st)
                    <tr class="hover:bg-slate-50/70">
                        <td class="p-4 font-mono text-xs font-bold text-slate-600">{{ $st->nis }}</td>
                        <td class="p-4 font-bold text-slate-900">{{ $st->name }}</td>
                        <td class="p-4">{{ $st->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="p-4 text-xs">{{ $st->birth_place ?? 'Bogor' }}, {{ $st->birth_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="p-4 text-xs">
                            <div class="font-semibold text-slate-800">{{ $st->parent_name ?? '-' }}</div>
                            <div class="text-slate-500">{{ $st->parent_phone ?? '-' }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
