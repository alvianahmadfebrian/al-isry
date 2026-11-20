@php($editing = $user->exists)
<x-layouts.app :title="$editing ? 'Ubah Akun Pengguna' : 'Tambah Akun Pengguna Baru'">
    <div class="mb-4">
        <a href="{{ route('superuser.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#4d9a27] hover:underline">
            &larr; Kembali ke Daftar Akun
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-12">
        <form method="POST" action="{{ $editing ? route('superuser.users.update', $user) : route('superuser.users.store') }}" class="space-y-5 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 lg:col-span-8">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-lg font-extrabold text-slate-900">{{ $editing ? 'Formulir Perubahan Data Akun' : 'Formulir Pembuatan Akun Baru' }}</h2>
                <p class="text-xs text-slate-500">Pastikan role yang dipilih sesuai dengan wewenang tugas di sekolah.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Nama Lengkap Pengguna <span class="text-red-500">*</span></label>
                    <input name="name" value="{{ old('name', $user->name) }}" required placeholder="Contoh: Ustadzah Siti Rahma, S.Pd." class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Alamat Email Login <span class="text-red-500">*</span></label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}" required placeholder="nama@sekolah.test" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                    <input name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812xxxxxxxx" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Level Role Akses <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none" @disabled($editing && $user->is(auth()->user()))>
                        @foreach ($roles as $role)
                            <option value="{{ $role->value }}" @selected(old('role', $user->role?->value ?? 'guru') === $role->value)>{{ $role->label() }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Kata Sandi {{ $editing ? '(Kosongkan jika tidak diganti)' : '*' }}</label>
                    <input name="password" type="password" {{ $editing ? '' : 'required' }} placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <label class="flex items-center gap-2.5 rounded-2xl bg-[#f8faf5] p-3.5 text-xs font-semibold text-slate-700">
                <input type="checkbox" name="is_active" value="1" class="rounded text-[#4d9a27]" @checked(old('is_active', $user->is_active))>
                <span>Aktifkan akun ini agar dapat masuk ke dalam sistem</span>
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-4">
                <button class="rounded-xl bg-[#4d9a27] px-6 py-2.5 text-xs font-extrabold text-white shadow-sm transition hover:bg-[#3f821f]">
                    Simpan Data Akun
                </button>
                <a href="{{ route('superuser.users.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>

        <div class="space-y-4 lg:col-span-4">
            <div class="rounded-3xl bg-gradient-to-br from-[#142611] to-[#284d1e] p-6 text-white shadow-lg">
                <span class="rounded-full bg-lime-400/20 px-3 py-1 text-xs font-bold text-lime-300">Hak Akses Role</span>
                <h3 class="mt-3 text-base font-extrabold">Panduan Pembagian Role</h3>
                <ul class="mt-3 space-y-2.5 text-xs leading-relaxed text-slate-200">
                    <li><strong class="text-lime-300">Super User:</strong> Akses penuh seluruh sistem, pengaturan global, akun, log, dan backup.</li>
                    <li><strong class="text-lime-300">Admin:</strong> Mengelola data master, siswa, guru, jadwal, verifikasi PPDB, dan berita landing page.</li>
                    <li><strong class="text-lime-300">Kepala Sekolah:</strong> Melihat rekap akademik & kehadiran, menyetujui RPP/dokumen, dan membuat pengumuman internal.</li>
                    <li><strong class="text-lime-300">Guru:</strong> Mengisi absensi, menghitung nilai otomatis, mengunggah materi & tugas pada kelas yang diampu.</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
