<x-layouts.app :title="'Kartu Pelajar — '.$student->name">
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}" class="text-sm font-semibold text-[#4d9a27] hover:underline">&larr; Kembali ke Daftar Siswa</a>
        <button onclick="window.print()" type="button" class="rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-bold text-white">Cetak Kartu Siswa</button>
    </div>

    <div class="mx-auto max-w-md overflow-hidden rounded-3xl border-2 border-[#4d9a27] bg-white shadow-lg">
        <div class="flex items-center gap-3 bg-[#142611] p-5 text-white">
            <img src="/images/logo-sekolah.png" alt="Logo" class="h-14 w-14 rounded-full bg-white object-contain p-1">
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-lime-300">Kartu Identitas Peserta Didik</div>
                <div class="text-sm font-extrabold">{{ $settings['school_short_name'] ?? 'RA Al-Isry Bogor' }}</div>
                <div class="text-[11px] text-slate-300">Al Istiqomah Seroja Raya Yasmin</div>
            </div>
        </div>

        <div class="space-y-2.5 p-6 text-sm">
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Nomor Induk (NIS)</span><strong class="font-mono">{{ $student->nis }}</strong></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Nama Lengkap</span><strong>{{ $student->name }}</strong></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Jenis Kelamin</span><span>{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Tempat, Tgl Lahir</span><span>{{ $student->birth_place ?? 'Bogor' }}, {{ $student->birth_date?->format('d/m/Y') ?? '-' }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Kelompok / Kelas</span><strong class="text-[#4d9a27]">{{ $student->schoolClass?->name ?? '-' }}</strong></div>
            <div class="flex justify-between"><span class="text-slate-500">Orang Tua / Wali</span><span>{{ $student->parent_name ?? '-' }}</span></div>
        </div>

        <div class="bg-lime-50 px-6 py-3 text-center text-[11px] font-semibold text-[#4d9a27]">
            Berlaku Selama Menjadi Peserta Didik Aktif {{ $settings['school_short_name'] ?? 'RA Al-Isry Bogor' }}
        </div>
    </div>
</x-layouts.app>
