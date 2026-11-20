<x-layouts.app :title="'Materi & Tugas — '.$assignment->schoolClass->name.' ('.$assignment->subject->name.')'">
    @if (isset($assignments) && $assignments->count() > 1)
        <div class="mb-4 flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-3 shadow-sm">
            <span class="px-2 text-xs font-extrabold uppercase text-slate-400">Pilih Kelas &amp; Mapel:</span>
            @foreach ($assignments as $item)
                <a href="{{ route('guru.materials', $item) }}" class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition {{ $item->id === $assignment->id ? 'bg-[#4d9a27] text-white shadow-2xs' : 'bg-[#f8faf5] text-slate-700 hover:bg-lime-100' }}">
                    {{ $item->schoolClass->name }} — {{ $item->subject->name }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('guru.dashboard') }}" class="text-xs font-bold text-[#4d9a27] hover:underline">&larr; Kembali ke Dashboard Guru</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Upload Materi -->
        <div class="space-y-4 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">Modul Pembelajaran</span>
                <h2 class="text-base font-extrabold text-slate-900">Unggah Materi Kelas</h2>
            </div>

            <form method="POST" action="{{ route('guru.materials.store', $assignment) }}" class="space-y-3.5 text-sm">
                @csrf
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Judul Materi <span class="text-red-500">*</span></label>
                    <input name="title" required placeholder="Contoh: Modul Menghafal Surat An-Naba" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 focus:border-[#4d9a27] focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Ringkasan / Panduan Materi</label>
                    <textarea name="description" rows="2" placeholder="Ringkasan materi pembelajaran..." class="w-full rounded-xl border border-slate-300 p-3 focus:border-[#4d9a27] focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Tautan Berkas / Video (Opsional)</label>
                    <input name="file_url" placeholder="https://..." class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5">
                </div>
                <button class="rounded-xl bg-[#4d9a27] px-5 py-2.5 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">+ Unggah Materi</button>
            </form>

            <div class="divide-y divide-slate-100 border-t border-slate-100 pt-3 text-sm">
                @forelse ($assignment->materials as $m)
                    <div class="py-3">
                        <div class="font-bold text-slate-900">{{ $m->title }}</div>
                        <p class="mt-0.5 text-xs text-slate-600">{{ $m->description }}</p>
                    </div>
                @empty
                    <p class="py-4 text-xs text-slate-500">Belum ada materi untuk kelas ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Buat Tugas -->
        <div class="space-y-4 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Penugasan Anak</span>
                <h2 class="text-base font-extrabold text-slate-900">Buat Tugas / Aktivitas Siswa</h2>
            </div>

            <form method="POST" action="{{ route('guru.tasks.store', $assignment) }}" class="space-y-3.5 text-sm">
                @csrf
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Judul Tugas <span class="text-red-500">*</span></label>
                    <input name="title" required placeholder="Contoh: Praktik Doa Sebelum Tidur Bersama Orang Tua" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 focus:border-[#4d9a27] focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Petunjuk Kegiatan</label>
                    <textarea name="description" rows="2" placeholder="Petunjuk untuk siswa & orang tua..." class="w-full rounded-xl border border-slate-300 p-3 focus:border-[#4d9a27] focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Batas Waktu Pengumpulan</label>
                    <input type="date" name="due_date" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5">
                </div>
                <button class="rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-extrabold text-white hover:bg-slate-800">+ Buat Tugas</button>
            </form>

            <div class="divide-y divide-slate-100 border-t border-slate-100 pt-3 text-sm">
                @forelse ($assignment->assignments as $task)
                    <div class="py-3">
                        <div class="font-bold text-slate-900">{{ $task->title }}</div>
                        <p class="mt-0.5 text-xs text-slate-600">{{ $task->description }}</p>
                        @if ($task->due_date)
                            <span class="mt-1 inline-block rounded bg-amber-100 px-2 py-0.5 text-[11px] font-bold text-amber-800">Tenggat: {{ $task->due_date->format('d/m/Y') }}</span>
                        @endif
                    </div>
                @empty
                    <p class="py-4 text-xs text-slate-500">Belum ada tugas untuk kelas ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
