<x-layouts.app title="Kelola Akun & Profil Guru">
    <!-- Ringkasan Cepat SDM Guru -->
    <div class="mb-6 grid grid-cols-3 gap-4">
        <div class="rounded-2xl border border-lime-200 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Total Tenaga Pendidik</div>
            <div class="mt-1 text-2xl font-extrabold text-[#4d9a27]">{{ $teachers->count() }} <span class="text-xs font-normal text-slate-400">Guru</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Tampil di Landing Page</div>
            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $teachers->where('show_on_landing', true)->count() }} <span class="text-xs font-normal text-slate-400">Profil</span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Memiliki Akun Login</div>
            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $teachers->whereNotNull('user_id')->count() }} <span class="text-xs font-normal text-slate-400">Akun</span></div>
        </div>
    </div>

    <div class="grid items-start gap-6 lg:grid-cols-12">
        <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-3.5 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm text-sm lg:col-span-4">
            @csrf
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#4d9a27]">SDM Pendidik</span>
                    <h2 class="text-base font-extrabold text-slate-900">Buat Akun &amp; Profil Guru</h2>
                </div>
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Nama Lengkap &amp; Gelar <span class="text-red-500">*</span></label>
                <input name="name" required placeholder="Ustadzah Siti Maryam, S.Pd." class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Email Login Guru <span class="text-red-500">*</span></label>
                <input type="email" name="email" required placeholder="maryam@sekolah.test" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2 focus:border-[#4d9a27] focus:bg-white focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">NIP / NUPTK</label>
                    <input name="nip" placeholder="Opsional" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Jabatan <span class="text-red-500">*</span></label>
                    <input name="position" required placeholder="Wali Kelas B1" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3 py-2 text-xs">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Bidang Keahlian</label>
                <input name="specialization" placeholder="Tahfidz Anak & Metode Iqra" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2">
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Pendidikan Terakhir</label>
                <input name="education" placeholder="S1 PGRA / PIAUD" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2">
            </div>

            <div>
                <label class="mb-1 block text-xs font-bold text-slate-700">Kata Sandi Awal <span class="text-red-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-300 bg-slate-50/60 px-3.5 py-2">
            </div>

            <label class="flex items-center gap-2 rounded-xl bg-[#f8faf5] p-3 text-xs font-semibold text-slate-700">
                <input type="checkbox" name="show_on_landing" value="1" checked class="rounded text-[#4d9a27]">
                <span>Tampilkan profil di Landing Page Publik</span>
            </label>

            <button class="w-full rounded-xl bg-[#4d9a27] py-3 text-xs font-extrabold text-white shadow-sm hover:bg-[#3f821f]">
                + Buat Akun &amp; Profil Guru
            </button>
        </form>

        <!-- Kolom Kanan: Kartu Tabel Guru -->
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm lg:col-span-8">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#2e5b22] px-6 py-4 text-white">
                <div>
                    <h2 class="text-sm font-extrabold sm:text-base">Direktori Tenaga Pendidik &amp; Status Akun</h2>
                    <p class="text-xs text-lime-200/90">Atur status aktif login guru serta visibilitas di beranda website</p>
                </div>
                <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-200">{{ $teachers->count() }} Pendidik</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3.5">Nama Pendidik</th>
                            <th class="px-5 py-3.5">Jabatan &amp; Keahlian</th>
                            <th class="px-5 py-3.5">Status Login</th>
                            <th class="px-5 py-3.5">Tampil Publik</th>
                            <th class="px-5 py-3.5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($teachers as $t)
                            <tr class="transition hover:bg-[#f8faf5]">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#4d9a27] to-[#2e5d1c] text-xs font-extrabold text-white shadow-sm">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($t->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $t->name }}</div>
                                            <div class="font-mono text-xs text-slate-400">NIP: {{ $t->nip ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs">
                                    <div class="font-bold text-slate-800">{{ $t->position }}</div>
                                    <div class="text-slate-500">{{ $t->specialization }}</div>
                                </td>
                                <td class="px-5 py-4 text-xs">
                                    @if ($t->user)
                                        <div class="mb-1 text-slate-600">{{ $t->user->email }}</div>
                                        <span class="rounded-full px-2.5 py-0.5 font-bold {{ $t->user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-700' }}">
                                            {{ $t->user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-500">Profil Publik</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-xs">
                                    <span class="rounded-full px-2.5 py-1 font-bold {{ $t->show_on_landing ? 'bg-lime-100 text-[#3f821f]' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $t->show_on_landing ? 'Tampil di Web' : 'Disembunyikan' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-2 text-xs font-bold">
                                        <form method="POST" action="{{ route('admin.teachers.landing', $t) }}">
                                            @csrf @method('PATCH')
                                            <button class="rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-slate-700 hover:border-[#4d9a27] hover:text-[#4d9a27]">
                                                {{ $t->show_on_landing ? 'Sembunyikan' : 'Tampilkan' }}
                                            </button>
                                        </form>
                                        @if ($t->user)
                                            <form method="POST" action="{{ route('admin.teachers.active', $t) }}">
                                                @csrf @method('PATCH')
                                                <button class="rounded-lg bg-amber-50 px-2.5 py-1 text-amber-700 hover:bg-amber-100">
                                                    {{ $t->user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
