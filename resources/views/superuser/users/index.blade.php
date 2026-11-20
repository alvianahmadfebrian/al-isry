<x-layouts.app title="Kelola Akun">
    <!-- Filter & Tombol Tambah -->
    <div class="mb-6 flex flex-col gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm md:flex-row md:items-center md:justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 text-sm focus:border-[#4d9a27] focus:bg-white focus:outline-none">
            <select name="role" class="rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 text-sm focus:border-[#4d9a27] focus:bg-white focus:outline-none">
                <option value="">Semua Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->value }}" @selected(request('role') === $role->value)>{{ $role->label() }}</option>
                @endforeach
            </select>
            <button class="rounded-xl bg-slate-800 px-4 py-2 text-xs font-bold text-white transition hover:bg-slate-900">Filter</button>
        </form>
        <a href="{{ route('superuser.users.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#4d9a27] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#3f821f]">
            + Tambah Akun Baru
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
            <div>
                <h2 class="text-sm font-extrabold sm:text-base">Direktori Seluruh Akun Pengguna</h2>
                <p class="text-xs text-lime-200/90">Manajemen akses Super User, Admin, Kepala Sekolah, dan Guru</p>
            </div>
            <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">{{ $users->total() }} Akun</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="p-4">Pengguna</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role Akses</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($users as $u)
                    <tr class="transition hover:bg-[#f8faf5]">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#4d9a27] to-[#2e5d1c] text-xs font-extrabold text-white shadow-sm">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($u->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $u->name }}</div>
                                    @if ($u->phone)
                                        <div class="text-xs text-slate-400">{{ $u->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-slate-600">{{ $u->email }}</td>
                        <td class="p-4">
                            <span class="rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-[#3f821f]">{{ $u->role->label() }}</span>
                        </td>
                        <td class="p-4">
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $u->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-700' }}">
                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                                <a href="{{ route('superuser.users.edit', $u) }}" class="rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-slate-700 hover:border-[#4d9a27] hover:text-[#4d9a27]">Ubah</a>
                                @unless ($u->is(auth()->user()))
                                    <form method="POST" action="{{ route('superuser.users.toggle', $u) }}">
                                        @csrf @method('PATCH')
                                        <button class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1 text-amber-700 hover:bg-amber-100">
                                            {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('superuser.users.destroy', $u) }}" onsubmit="return confirm('Hapus akun {{ $u->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg border border-red-200 bg-red-50 px-2.5 py-1 text-red-600 hover:bg-red-100">Hapus</button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-8 text-center text-slate-500">Belum ada akun.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</x-layouts.app>
