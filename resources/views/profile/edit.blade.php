<x-layouts.app title="Profil & Kata Sandi">
    <!-- Banner Profil Pengguna -->
    <div class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-r from-[#142611] via-[#1f3d1a] to-[#356922] p-6 text-white shadow-lg sm:p-8">
        <div class="flex flex-wrap items-center gap-5">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-lime-400/20 text-2xl font-extrabold text-lime-300 ring-2 ring-lime-400/40">
                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 2)) }}
            </div>
            <div>
                <span class="inline-block rounded-full bg-lime-400/20 px-3 py-0.5 text-xs font-bold text-lime-300">
                    {{ $user->role->label() }}
                </span>
                <h2 class="mt-1 text-xl font-extrabold sm:text-2xl">{{ $user->name }}</h2>
                <p class="text-xs text-slate-300 sm:text-sm">{{ $user->email }} &bull; Status Akun: <strong class="text-lime-300">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</strong></p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Kartu Informasi Profil -->
        <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 text-[#4d9a27]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Informasi Biodata Akun</h3>
                        <p class="text-xs text-slate-500">Perbarui nama lengkap dan alamat email yang digunakan untuk masuk.</p>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Nama Lengkap</label>
                    <input name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Alamat Email</label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-2xl bg-[#f8faf5] p-4 text-xs text-slate-600">
                    <span class="font-bold text-slate-800">Role Akses Saat Ini:</span> {{ $user->role->label() }}
                </div>
            </div>

            <div class="mt-6 border-t border-slate-100 pt-4">
                <button class="inline-flex items-center gap-2 rounded-xl bg-[#4d9a27] px-6 py-2.5 text-xs font-extrabold text-white shadow-sm transition hover:bg-[#3f821f]">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>

        <!-- Kartu Ganti Kata Sandi -->
        <form method="POST" action="{{ route('profile.password') }}" class="flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Keamanan & Kata Sandi</h3>
                        <p class="text-xs text-slate-500">Gunakan minimal 8 karakter kombinasi huruf dan angka.</p>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Kata Sandi Saat Ini</label>
                    <input name="current_password" type="password" required placeholder="Masukkan kata sandi lama" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('current_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Kata Sandi Baru</label>
                    <input name="password" type="password" required placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
                    <input name="password_confirmation" type="password" required placeholder="Ulangi kata sandi baru" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
                </div>
            </div>

            <div class="mt-6 border-t border-slate-100 pt-4">
                <button class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-2.5 text-xs font-extrabold text-white shadow-sm transition hover:bg-slate-800">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
