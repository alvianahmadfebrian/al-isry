<x-layouts.app title="Pengumuman Internal Guru & Staf">
    <div class="grid gap-6 lg:grid-cols-12">
        <form method="POST" action="{{ route('kepsek.announcements.store') }}" class="space-y-4 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm text-sm sm:p-8 lg:col-span-5">
            @csrf
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Komunikasi Internal</span>
                <h2 class="text-base font-extrabold text-slate-900">Buat Pengumuman Baru</h2>
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input name="title" required placeholder="Contoh: Rapat Evaluasi Bulanan Guru" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 focus:border-[#4d9a27] focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Sasaran Penerima</label>
                <select name="audience" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5">
                    <option value="semua">Seluruh Guru &amp; Staf</option>
                    <option value="guru">Khusus Guru</option>
                    <option value="staf">Khusus Staf Administrasi</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="content" rows="4" required placeholder="Tulis rincian informasi atau instruksi..." class="w-full rounded-xl border border-slate-300 p-3 focus:border-[#4d9a27] focus:outline-none"></textarea>
            </div>

            <label class="flex items-center gap-2 rounded-xl bg-[#f8faf5] p-3 text-xs font-semibold text-slate-700">
                <input type="checkbox" name="is_pinned" value="1" checked class="rounded text-[#4d9a27]">
                <span>Sematkan di bagian atas dashboard guru</span>
            </label>

            <button class="w-full rounded-xl bg-[#4d9a27] py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                Terbitkan Pengumuman
            </button>
        </form>

        <div class="space-y-4 lg:col-span-7">
            @forelse ($announcements as $an)
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <span class="rounded-full bg-lime-100 px-3 py-0.5 font-bold uppercase text-[#3f821f]">Target: {{ $an->audience }}</span>
                        <span>{{ $an->created_at?->format('d M Y, H:i') }}</span>
                    </div>
                    <h3 class="mt-2 text-base font-extrabold text-slate-900">{{ $an->title }}</h3>
                    <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $an->content }}</p>
                </div>
            @empty
                <div class="rounded-3xl bg-white p-10 text-center text-slate-500">Belum ada pengumuman internal.</div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
