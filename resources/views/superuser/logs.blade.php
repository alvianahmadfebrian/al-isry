<x-layouts.app title="Activity Log Sistem">
    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
            <div>
                <h2 class="text-sm font-extrabold sm:text-base">Rekam Jejak Aktivitas Pengguna (Audit Trail)</h2>
                <p class="text-xs text-lime-200/90">Mencatat perubahan pengaturan, data master, absensi, nilai, persetujuan dokumen, dan unduhan backup</p>
            </div>
            <span class="rounded-full bg-lime-400/20 px-3.5 py-1 text-xs font-bold text-lime-200">Total: {{ $logs->total() }} Aktivitas</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="p-4">Waktu Kejadian</th>
                        <th class="p-4">Pelaku / Akun</th>
                        <th class="p-4">Modul Aksi</th>
                        <th class="p-4">Rincian Aktivitas</th>
                        <th class="p-4">Alamat IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr class="transition hover:bg-[#f8faf5]">
                            <td class="p-4 text-xs text-slate-500">
                                <div class="font-bold text-slate-700">{{ $log->created_at?->format('d M Y, H:i') }}</div>
                                <div>{{ $log->created_at?->diffForHumans() }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-slate-900">{{ $log->user?->name ?? 'Sistem Otomatis' }}</div>
                                <div class="text-xs text-slate-400">{{ $log->user?->email ?? '-' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="rounded-lg bg-lime-100 px-2.5 py-1 text-xs font-bold text-[#3f821f]">{{ $log->action }}</span>
                            </td>
                            <td class="p-4 font-medium text-slate-700">{{ $log->description }}</td>
                            <td class="p-4 font-mono text-xs text-slate-400">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-slate-500">Belum ada riwayat aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
</x-layouts.app>
