<x-layouts.app title="Kelola Data Siswa & Cetak Kartu">
    <div class="grid gap-6 lg:grid-cols-12">
        <!-- Form Tambah & Import CSV -->
        <div class="space-y-6 lg:col-span-4">
            <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-3.5 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm text-sm">
                @csrf
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Pendaftaran Internal</span>
                    <h2 class="text-base font-extrabold text-slate-900">Tambah Peserta Didik Baru</h2>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Nomor Induk Siswa (NIS) <span class="text-red-500">*</span></label>
                    <input name="nis" required placeholder="Contoh: 2026009" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 focus:border-[#4d9a27] focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Nama Lengkap Anak <span class="text-red-500">*</span></label>
                    <input name="name" required placeholder="Nama lengkap sesuai Akta" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 focus:border-[#4d9a27] focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Jenis Kelamin</label>
                        <select name="gender" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Rombel Kelas</label>
                        <select name="class_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs">
                            @foreach ($classes as $cl)
                                <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Tempat Lahir</label>
                        <input name="birth_place" placeholder="Bogor" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs">
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Nama Orang Tua / Wali</label>
                    <input name="parent_name" placeholder="Nama Ayah / Ibu" class="w-full rounded-xl border border-slate-300 px-3.5 py-2">
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Nomor WhatsApp Orang Tua</label>
                    <input name="parent_phone" placeholder="0812xxxxxxxx" class="w-full rounded-xl border border-slate-300 px-3.5 py-2">
                </div>

                <button class="w-full rounded-xl bg-[#4d9a27] py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    + Simpan Data Siswa
                </button>
            </form>

            <form method="POST" action="{{ route('admin.students.import') }}" enctype="multipart/form-data" class="space-y-3.5 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm text-sm">
                @csrf
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Import Massal</span>
                    <h2 class="text-base font-extrabold text-slate-900">Unggah Berkas CSV Siswa</h2>
                </div>
                <p class="rounded-xl bg-[#f8faf5] p-3 text-xs leading-relaxed text-slate-600">
                    Format urutan kolom CSV:<br>
                    <code class="font-bold text-[#4d9a27]">nis,nama,L/P,tempat_lahir,YYYY-MM-DD,nama_ortu,no_wa</code>
                </p>
                <select name="class_id" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-xs font-semibold">
                    @foreach ($classes as $cl)
                        <option value="{{ $cl->id }}">Tempatkan ke: {{ $cl->name }}</option>
                    @endforeach
                </select>
                <input type="file" name="csv_file" accept=".csv,.txt" required class="w-full rounded-xl border border-dashed border-slate-300 p-2.5 text-xs">
                <button class="w-full rounded-xl bg-slate-900 py-2.5 text-xs font-extrabold text-white hover:bg-slate-800">
                    Unggah &amp; Import CSV
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Siswa -->
        <div class="lg:col-span-8">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-2 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <form method="GET" class="flex flex-wrap gap-2">
                    <input name="q" value="{{ request('q') }}" placeholder="Cari nama atau NIS siswa..." class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#4d9a27] focus:outline-none">
                    <select name="class_id" class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#4d9a27] focus:outline-none">
                        <option value="">Semua Kelompok Kelas</option>
                        @foreach ($classes as $cl)
                            <option value="{{ $cl->id }}" @selected((int) request('class_id') === $cl->id)>{{ $cl->name }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-bold text-white">Filter</button>
                </form>
                <span class="rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-[#3f821f]">Total: {{ $students->total() }} Siswa</span>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
                    <div>
                        <h2 class="text-sm font-extrabold sm:text-base">Daftar Peserta Didik Aktif</h2>
                        <p class="text-xs text-lime-200/90">Data induk siswa RA Al-Isry Bogor beserta akses cetak kartu pelajar</p>
                    </div>
                    <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">{{ $students->total() }} Siswa</span>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="p-4">NIS</th>
                            <th class="p-4">Nama Peserta Didik</th>
                            <th class="p-4">Kelompok</th>
                            <th class="p-4">Orang Tua &amp; WA</th>
                            <th class="p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($students as $st)
                            <tr class="hover:bg-slate-50/70">
                                <td class="p-4 font-mono text-xs font-extrabold text-slate-700">{{ $st->nis }}</td>
                                <td class="p-4">
                                    <div class="font-bold text-slate-900">{{ $st->name }}</div>
                                    <div class="text-xs text-slate-400">
                                        {{ $st->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; {{ $st->birth_place ?? 'Bogor' }}, {{ $st->birth_date?->format('d/m/Y') ?? '-' }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="rounded-full bg-lime-100 px-2.5 py-1 text-xs font-bold text-[#3f821f]">{{ $st->schoolClass?->name ?? '-' }}</span>
                                </td>
                                <td class="p-4 text-xs">
                                    <div class="font-semibold text-slate-800">{{ $st->parent_name ?? '-' }}</div>
                                    <div class="text-slate-400">{{ $st->parent_phone }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2 text-xs font-bold">
                                        <a href="{{ route('admin.students.card', $st) }}" class="rounded-lg bg-lime-100 px-2.5 py-1 text-[#3f821f] hover:bg-lime-200">Cetak Kartu</a>
                                        <form method="POST" action="{{ route('admin.students.destroy', $st) }}" onsubmit="return confirm('Hapus siswa ini?')">
                                            @csrf @method('DELETE')
                                            <button class="rounded-lg bg-red-50 px-2.5 py-1 text-red-600 hover:bg-red-100">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-slate-500">Belum ada data siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            <div class="mt-4">{{ $students->links() }}</div>
        </div>
    </div>
</x-layouts.app>
