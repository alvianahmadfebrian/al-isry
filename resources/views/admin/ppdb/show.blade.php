<x-layouts.app :title="'Detail Pendaftar '.$registration->registration_number">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <a href="{{ route('admin.ppdb.index') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">&larr; Kembali ke Daftar PPDB</a>
        <a href="{{ route('ppdb.show', $registration->registration_number) }}" target="_blank" class="rounded-xl border border-slate-300 bg-white px-3.5 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50">
            Lihat Kartu Bukti Publik &rarr;
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-12">
        <div class="space-y-5 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 lg:col-span-7">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <div class="text-xs text-slate-400">Nomor Pendaftaran</div>
                    <div class="font-mono text-xl font-extrabold text-slate-900">{{ $registration->registration_number }}</div>
                </div>
                <span class="rounded-full px-3.5 py-1 text-xs font-bold {{ $registration->statusBadgeClass() }}">
                    {{ $registration->statusLabel() }}
                </span>
            </div>

            <div class="grid gap-4 text-sm sm:grid-cols-2">
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Nama Lengkap Anak</span><strong class="text-slate-900">{{ $registration->child_name }}</strong></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Nama Panggilan</span><strong class="text-slate-900">{{ $registration->nickname ?? '-' }}</strong></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Jenis Kelamin</span><span>{{ $registration->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Tempat, Tanggal Lahir</span><span>{{ $registration->birth_place }}, {{ $registration->birth_date?->translatedFormat('d F Y') }}</span></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">NIK Anak</span><span class="font-mono">{{ $registration->nik ?? '-' }}</span></div>
                <div class="rounded-2xl bg-lime-100/70 p-3.5"><span class="block text-xs text-lime-800">Pilihan Kelompok</span><strong class="text-[#3f821f]">{{ $registration->group_choice }}</strong></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Nama Ayah &amp; Pekerjaan</span><span>{{ $registration->father_name }} ({{ $registration->father_occupation ?? '-' }})</span></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Nama Ibu &amp; Pekerjaan</span><span>{{ $registration->mother_name }} ({{ $registration->mother_occupation ?? '-' }})</span></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">No. WhatsApp Orang Tua</span><strong class="text-slate-900">{{ $registration->parent_phone }}</strong></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5"><span class="block text-xs text-slate-400">Email Orang Tua</span><span>{{ $registration->parent_email ?? '-' }}</span></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5 sm:col-span-2"><span class="block text-xs text-slate-400">Alamat Lengkap</span><span>{{ $registration->address }}</span></div>
                <div class="rounded-2xl bg-[#f8faf5] p-3.5 sm:col-span-2"><span class="block text-xs text-slate-400">Catatan Kesehatan / Khusus</span><span>{{ $registration->health_notes ?? 'Tidak ada catatan khusus' }}</span></div>
            </div>
        </div>

        <div class="space-y-5 lg:col-span-5">
            <form method="POST" action="{{ route('admin.ppdb.status', $registration) }}" class="space-y-4 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                @csrf @method('PATCH')
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Keputusan Panitia</span>
                    <h2 class="text-base font-extrabold text-slate-900">Verifikasi &amp; Status Penerimaan</h2>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Status Pendaftaran</label>
                    <select name="status" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-semibold focus:border-[#4d9a27] focus:outline-none">
                        <option value="menunggu" @selected($registration->status === 'menunggu')>Menunggu Verifikasi</option>
                        <option value="diverifikasi" @selected($registration->status === 'diverifikasi')>Berkas Diverifikasi</option>
                        <option value="diterima" @selected($registration->status === 'diterima')>Diterima</option>
                        <option value="ditolak" @selected($registration->status === 'ditolak')>Belum Diterima</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Catatan Panitia (Tampil di halaman cek status orang tua)</label>
                    <textarea name="admin_notes" rows="4" placeholder="Contoh: Berkas lengkap, silakan hadir observasi pada hari Sabtu pukul 08.00 WIB." class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:border-[#4d9a27] focus:outline-none">{{ old('admin_notes', $registration->admin_notes) }}</textarea>
                </div>

                <button class="w-full rounded-xl bg-[#4d9a27] py-3 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    Simpan Keputusan PPDB
                </button>
            </form>

            <form method="POST" action="{{ route('admin.ppdb.destroy', $registration) }}" onsubmit="return confirm('Hapus data pendaftar ini?')" class="rounded-3xl border border-red-200 bg-red-50/50 p-6">
                @csrf @method('DELETE')
                <div class="mb-3 text-xs text-red-700">Tindakan ini akan menghapus permanen data pendaftar dari sistem.</div>
                <button class="w-full rounded-xl bg-red-600 py-2.5 text-xs font-extrabold text-white hover:bg-red-700">Hapus Data Pendaftar</button>
            </form>
        </div>
    </div>
</x-layouts.app>
