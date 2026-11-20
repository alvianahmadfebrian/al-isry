<x-layouts.app title="Persetujuan Dokumen Akademik (RPP / Modul Ajar / Remedial)">
    <div class="space-y-4">
        @forelse ($approvals as $ap)
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <span class="rounded-lg bg-lime-100 px-3 py-1 text-xs font-bold text-[#3f821f]">{{ $ap->document_type }}</span>
                        <h2 class="mt-2 text-lg font-extrabold text-slate-900">{{ $ap->title }}</h2>
                        <p class="mt-0.5 text-xs text-slate-500">
                            Diajukan oleh: <strong>{{ $ap->submitter?->name }}</strong> &bull; {{ $ap->created_at?->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="rounded-full px-3.5 py-1 text-xs font-bold {{ $ap->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800' : ($ap->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                        Status: {{ ucfirst($ap->status) }}
                    </span>
                </div>

                <div class="mt-4 rounded-2xl bg-[#f8faf5] p-4 text-sm leading-relaxed text-slate-700">
                    {{ $ap->description }}
                </div>

                <form method="POST" action="{{ route('kepsek.approvals.decide', $ap) }}" class="mt-5 flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-center">
                    @csrf @method('PATCH')
                    <input name="reviewer_notes" value="{{ $ap->reviewer_notes }}" placeholder="Tulis catatan atau revisi Kepala Sekolah..." class="flex-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs focus:border-[#4d9a27] focus:outline-none">
                    <div class="flex gap-2">
                        <button name="status" value="disetujui" class="rounded-xl bg-[#4d9a27] px-5 py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                            Setujui Dokumen
                        </button>
                        <button name="status" value="ditolak" class="rounded-xl bg-red-600 px-5 py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-red-700">
                            Tolak / Revisi
                        </button>
                    </div>
                </form>
            </div>
        @empty
            <div class="rounded-3xl bg-white p-10 text-center text-slate-500">Belum ada pengajuan dokumen.</div>
        @endforelse
    </div>
</x-layouts.app>
