<x-layouts.app title="Backup & Export Data">
    <div class="grid gap-6 lg:grid-cols-12">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 lg:col-span-8">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-lime-100 text-[#4d9a27]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Cadangkan Seluruh Data Sistem Sekolah</h2>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500 sm:text-sm">
                        Unduh salinan lengkap database meliputi pengaturan identitas sekolah, tahun ajaran, rombel kelas, mata pelajaran, profil guru, siswa aktif, serta data pendaftar PPDB dalam format <code>.json</code> terstruktur.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach ($summary as $label => $total)
                    <div class="rounded-2xl border border-lime-900/10 bg-[#f8faf5] p-4">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ str_replace('_', ' ', $label) }}</div>
                        <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $total }}</div>
                        <div class="text-[11px] text-[#4d9a27]">Baris data siap ekspor</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5">
                <span class="text-xs text-slate-400">Setiap pengunduhan dicatat otomatis ke dalam Activity Log sistem.</span>
                <a href="{{ route('superuser.backup.download') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#4d9a27] px-6 py-3 text-xs font-extrabold text-white shadow-sm transition hover:bg-[#3f821f]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Backup Data (.json)
                </a>
            </div>
        </div>

        <div class="rounded-3xl bg-gradient-to-br from-[#142611] to-[#284d1e] p-6 text-white shadow-lg lg:col-span-4">
            <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">Keamanan Data</span>
            <h3 class="mt-3 text-base font-extrabold">Panduan Backup Berkala</h3>
            <ul class="mt-4 space-y-3 text-xs leading-relaxed text-slate-200">
                <li class="flex gap-2">
                    <span class="font-bold text-lime-400">1.</span>
                    <span>Lakukan pengunduhan backup minimal satu kali setiap akhir pekan atau setelah periode input nilai rapor selesai.</span>
                </li>
                <li class="flex gap-2">
                    <span class="font-bold text-lime-400">2.</span>
                    <span>Simpan berkas <code>.json</code> di penyimpanan awan (Google Drive yayasan) atau perangkat eksternal yang aman.</span>
                </li>
                <li class="flex gap-2">
                    <span class="font-bold text-lime-400">3.</span>
                    <span>Kata sandi pengguna terenkripsi (hashed) dan tidak disertakan dalam teks terbuka demi keamanan.</span>
                </li>
            </ul>
        </div>
    </div>
</x-layouts.app>
