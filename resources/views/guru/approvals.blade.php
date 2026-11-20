<x-layouts.app title="Pengajuan Dokumen RPPH & Pengumuman Internal">
    <div class="grid items-start gap-6 lg:grid-cols-12">
        <!-- Form Pengajuan Dokumen -->
        <form method="POST" action="{{ route('guru.approvals.store') }}" class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm text-sm lg:col-span-5">
            @csrf
            <div class="border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Supervisi Akademik</span>
                <h2 class="text-base font-extrabold">Ajukan Dokumen ke Kepala Sekolah</h2>
            </div>

            <div class="space-y-4 p-6">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input name="title" required placeholder="Contoh: RPPH Minggu ke-3 Tema Alam Semesta" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Jenis Dokumen</label>
                    <select name="document_type" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2.5">
                        <option value="RPP / Modul Ajar">RPP / Modul Ajar (RPPH)</option>
                        <option value="Pengajuan Nilai Remedial">Pengajuan Nilai / Evaluasi Perkembangan</option>
                        <option value="Proposal Kegiatan Kelas">Proposal Kegiatan Kelas</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Ringkasan Isi Dokumen <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="3" required placeholder="Jelaskan ringkasan kegiatan atau tujuan pembelajaran..." class="w-full rounded-xl border border-slate-300 bg-slate-50/60 p-3 focus:border-[#4d9a27] focus:bg-white focus:outline-none"></textarea>
                </div>

                <button class="w-full rounded-xl bg-[#4d9a27] py-3 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                    + Kirim Pengajuan ke Kepala Sekolah
                </button>
            </div>
        </form>

        <!-- Riwayat Pengajuan & Pengumuman -->
        <div class="space-y-6 lg:col-span-7">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-[#142611] to-[#284d1e] px-6 py-4 text-white">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-lime-300">Status Persetujuan</span>
                        <h2 class="text-base font-extrabold">Riwayat Pengajuan Dokumen Saya</h2>
                    </div>
                    <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">{{ $myApprovals->count() }} Dokumen</span>
                </div>

                <div class="divide-y divide-slate-100 p-6 text-sm">
                    @forelse ($myApprovals as $ap)
                        <div class="py-3 first:pt-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <span class="rounded bg-lime-100 px-2.5 py-0.5 text-xs font-bold text-[#3f821f]">{{ $ap->document_type }}</span>
                                <span class="rounded-full px-3 py-0.5 text-xs font-bold {{ $ap->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800' : ($ap->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                    {{ ucfirst($ap->status) }}
                                </span>
                            </div>
                            <div class="mt-1.5 font-extrabold text-slate-900">{{ $ap->title }}</div>
                            <p class="mt-0.5 text-xs text-slate-600">{{ $ap->description }}</p>
                            @if ($ap->reviewer_notes)
                                <div class="mt-2 rounded-xl bg-[#f8faf5] p-2.5 text-xs text-slate-700">
                                    <strong class="text-[#4d9a27]">Catatan Kepala Sekolah:</strong> {{ $ap->reviewer_notes }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="py-4 text-center text-xs text-slate-500">Belum ada pengajuan dokumen.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h2 class="border-b border-slate-100 pb-3 font-extrabold text-slate-900">Papan Pengumuman Internal Sekolah</h2>
                <div class="mt-3 divide-y divide-slate-100 text-sm">
                    @forelse ($announcements as $an)
                        <div class="py-3">
                            <div class="font-bold text-slate-900">{{ $an->title }}</div>
                            <p class="mt-1 text-xs leading-relaxed text-slate-600">{{ $an->content }}</p>
                            <div class="mt-1 text-[11px] text-slate-400">Oleh {{ $an->author?->name ?? 'Kepala Sekolah' }} &bull; {{ $an->created_at?->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="py-4 text-xs text-slate-500">Belum ada pengumuman internal.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
