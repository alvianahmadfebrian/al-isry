<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/logo-sekolah.png">
    <title>Masuk - RA Al-Isry Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#142611] via-[#1e3a19] to-[#2e5d1c] p-4">
<form method="POST" action="{{ route('login') }}" class="w-full max-w-md space-y-4 rounded-2xl bg-white p-8 shadow-2xl">
    @csrf
    <div class="flex flex-col items-center text-center">
        <img src="/images/logo-sekolah.png" alt="Logo RA Al-Isry Bogor" class="h-20 w-20 object-contain">
        <h1 class="mt-3 text-xl font-extrabold text-slate-900">Portal Sistem Akademik</h1>
        <p class="text-xs font-medium text-slate-500">RA Al-Isry (Al Istiqomah Seroja Raya Yasmin) Bogor</p>
    </div>

    <div>
        <label for="email" class="mb-1 block text-xs font-semibold text-slate-700">Alamat Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
        @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password" class="mb-1 block text-xs font-semibold text-slate-700">Kata Sandi</label>
        <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#4d9a27] focus:outline-none">
        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <label class="flex items-center gap-2 text-xs text-slate-600">
        <input type="checkbox" name="remember" class="rounded text-[#4d9a27]"> Ingat saya di perangkat ini
    </label>

    <button class="w-full rounded-xl bg-[#4d9a27] py-2.5 text-sm font-bold text-white shadow transition hover:bg-[#3f821f]">
        Masuk ke Sistem
    </button>

    <a href="{{ route('home') }}" class="block text-center text-xs font-semibold text-slate-500 hover:text-[#4d9a27]">
        &larr; Kembali ke Beranda Sekolah
    </a>
</form>
</body>
</html>
