<x-layouts.app title="Kelola Pendaftar PPDB Online">
    <!-- Ringkasan Statistik Pendaftar -->
    <div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-5">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Total Pendaftar</div>
            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $counts['total'] }}</div>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-4 shadow-sm">
            <div class="text-xs font-semibold text-amber-800">Menunggu Verifikasi</div>
            <div class="mt-1 text-2xl font-extrabold text-amber-700">{{ $counts['menunggu'] }}</div>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50/80 p-4 shadow-sm">
            <div class="text-xs font-semibold text-blue-800">Berkas Diverifikasi</div>
            <div class="mt-1 text-2xl font-extrabold text-blue-700">{{ $counts['diverifikasi'] }}</div>
        </div>
        <div class="rounded-2xl border border-lime-200 bg-lime-50/80 p-4 shadow-sm">
            <div class="text-xs font-semibold text-lime-800">Diterima</div>
            <div class="mt-1 text-2xl font-extrabold text-[#3f821f]">{{ $counts['diterima'] }}</div>
        </div>
        <div class="rounded-2xl border border-red-200 bg-red-50/80 p-4 shadow-sm">
            <div class="text-xs font-semibold text-red-800">Belum Diterima</div>
            <div class="mt-1 text-2xl font-extrabold text-red-700">{{ $counts['ditolak'] }}</div>
        </div>
    </div>

    <div class="mb-4 flex flex-wrap items-center justify-between gap-2 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Cari no. daftar / nama anak / WA..." class="rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 text-sm focus:border-[#4d9a27] focus:bg-white focus:outline-none">
            <select name="status" class="rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 text-sm focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                <option value="">Semua Status</option>
                <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu Verifikasi</option>
                <option value="diverifikasi" @selected(request('status') === 'diverifikasi')>Berkas Diverifikasi</option>
                <option value="diterima" @selected(request('status') === 'diterima')>Diterima</option>
                <option value="ditolak" @selected(request('status') === 'ditolak')>Belum Diterima</option>
            </select>
            <button class="rounded-xl bg-[#4d9a27] px-4 py-2 text-xs font-bold text-white">Filter Data</button>
        </form>
        <a href="{{ route('ppdb.create') }}" target="_blank" class="text-xs font-bold text-[#4d9a27] hover:underline">+ Buka Form PPDB Publik &rarr;</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
            <div>
                <h2 class="text-sm font-extrabold sm:text-base">Daftar Calon Peserta Didik Baru (PPDB Online)</h2>
                <p class="text-xs text-lime-200/90">Klik tombol Detail &amp; Verifikasi untuk memberikan keputusan penerimaan</p>
            </div>
            <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">{{ $registrations->total() }} Pendaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="p-4">No. Daftar</th>
                        <th class="p-4">Calon Peserta Didik</th>
                        <th class="p-4">Kelompok Pilihan</th>
                        <th class="p-4">Orang Tua &amp; WhatsApp</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($registrations as $item)
                        <tr class="transition hover:bg-[#f8faf5]">
                            <td class="p-4 font-mono text-xs font-extrabold text-slate-700">{{ $item->registration_number }}</td>
                            <td class="p-4">
                                <div class="font-bold text-slate-900">{{ $item->child_name }}</div>
                                <div class="text-xs text-slate-400">{{ $item->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; {{ $item->birth_place }}, {{ $item->birth_date?->format('d/m/Y') }}</div>
                            </td>
                            <td class="p-4 text-xs font-bold text-[#3f821f]">{{ $item->group_choice }}</td>
                            <td class="p-4 text-xs">
                                <div class="font-semibold text-slate-800">{{ $item->father_name }} / {{ $item->mother_name }}</div>
                                <div class="text-slate-500">{{ $item->parent_phone }}</div>
                            </td>
                            <td class="p-4">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $item->statusBadgeClass() }}">
                                    {{ $item->statusLabel() }}
                                </span>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('admin.ppdb.show', $item) }}" class="rounded-xl bg-[#4d9a27] px-3.5 py-1.5 text-xs font-bold text-white shadow-2xs hover:bg-[#3f821f]">
                                    Detail &amp; Verifikasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">Belum ada pendaftar PPDB.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $registrations->links() }}</div>
</x-layouts.app>
