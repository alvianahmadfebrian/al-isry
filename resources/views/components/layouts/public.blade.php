@props(['title' => null, 'settings' => []])
@php
    $settings = count($settings) ? $settings : \App\Models\SchoolSetting::allAsMap();
    $schoolName = $settings['school_name'] ?? config('app.name');
    $shortName = $settings['school_short_name'] ?? 'RA Al-Isry Bogor';
    $logoUrl = $settings['logo_url'] ?? '/images/logo-sekolah.png';
    $primaryColor = $settings['primary_color'] ?? '#4d9a27';
    $secondaryColor = $settings['secondary_color'] ?? '#142611';
    $accentColor = $settings['accent_color'] ?? '#84cc16';
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <title>{{ $title ? $title.' - '.$shortName : $schoolName.' — '.($settings['school_tagline'] ?? '') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --school-primary: {{ $primaryColor }};
            --school-secondary: {{ $secondaryColor }};
            --school-accent: {{ $accentColor }};
        }
        .bg-school-primary { background-color: var(--school-primary); }
        .text-school-primary { color: var(--school-primary); }
        .border-school-primary { border-color: var(--school-primary); }
        .bg-school-secondary { background-color: var(--school-secondary); }
        .bg-school-accent { background-color: var(--school-accent); }
        .text-school-accent { color: var(--school-accent); }
    </style>
</head>
<body class="min-h-screen bg-[#f8faf5] font-sans text-slate-800 antialiased selection:bg-[#4d9a27] selection:text-white">

    <!-- Top Info Bar -->
    <div class="bg-school-secondary text-xs text-lime-100/90">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 py-2 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-4">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $settings['email'] ?? 'info@ra-alisry-bogor.sch.id' }}
                </span>
                <span class="hidden items-center gap-1.5 sm:inline-flex">
                    <svg class="h-3.5 w-3.5 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $settings['phone'] ?? '(0251) 835-1234' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="rounded-full bg-lime-400/20 px-2.5 py-0.5 font-semibold text-lime-300">
                    Akreditasi {{ $settings['stat_accreditation'] ?? 'A (Unggul)' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <header class="sticky top-0 z-40 border-b border-lime-900/10 bg-white/95 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3.5">
                <img src="{{ $logoUrl }}" alt="Logo {{ $schoolName }}" class="h-12 w-12 rounded-full border border-lime-600/30 bg-white object-contain p-0.5 shadow-sm">
                <div>
                    <span class="block text-base font-extrabold tracking-tight text-slate-900 sm:text-lg">{{ $shortName }}</span>
                    <span class="block text-xs font-medium text-slate-500">Al Istiqomah Seroja Raya Yasmin &bull; Bogor</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 lg:flex">
                <a href="{{ route('home') }}#profil" class="transition hover:text-school-primary">Profil</a>
                <a href="{{ route('home') }}#program" class="transition hover:text-school-primary">Program Unggulan</a>
                <a href="{{ route('home') }}#ppdb" class="transition hover:text-school-primary">Info PPDB</a>
                <a href="{{ route('home') }}#berita" class="transition hover:text-school-primary">Berita</a>
                <a href="{{ route('home') }}#galeri" class="transition hover:text-school-primary">Galeri</a>
                <a href="{{ route('home') }}#pendidik" class="transition hover:text-school-primary">Pendidik</a>
                <a href="{{ route('home') }}#kontak" class="transition hover:text-school-primary">Kontak</a>
            </nav>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('ppdb.create') }}" class="hidden rounded-xl border border-lime-600/40 bg-lime-50 px-3.5 py-2 text-xs font-bold text-school-primary transition hover:bg-lime-100 sm:inline-flex">
                    Daftar PPDB Online
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-school-primary px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:opacity-95 sm:text-sm">
                        Dashboard ({{ auth()->user()->role->label() }})
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-school-primary px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:opacity-95 sm:text-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Login Portal
                    </a>
                @endauth
            </div>
        </div>

        <!-- Mobile Quick Nav -->
        <div class="flex items-center gap-4 overflow-x-auto border-t border-slate-100 px-4 py-2 text-xs font-semibold text-slate-600 lg:hidden">
            <a href="{{ route('home') }}#profil" class="shrink-0 hover:text-school-primary">Profil</a>
            <a href="{{ route('home') }}#program" class="shrink-0 hover:text-school-primary">Program</a>
            <a href="{{ route('home') }}#ppdb" class="shrink-0 hover:text-school-primary">Info PPDB</a>
            <a href="{{ route('home') }}#berita" class="shrink-0 hover:text-school-primary">Berita</a>
            <a href="{{ route('home') }}#galeri" class="shrink-0 hover:text-school-primary">Galeri</a>
            <a href="{{ route('home') }}#pendidik" class="shrink-0 hover:text-school-primary">Guru</a>
            <a href="{{ route('home') }}#kontak" class="shrink-0 hover:text-school-primary">Kontak</a>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer id="kontak" class="bg-school-secondary text-slate-300">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="space-y-4 lg:col-span-4">
                    <div class="flex items-center gap-3.5">
                        <img src="{{ $logoUrl }}" alt="Logo {{ $schoolName }}" class="h-12 w-12 rounded-full bg-white object-contain p-1">
                        <div>
                            <span class="block text-base font-bold text-white">{{ $shortName }}</span>
                            <span class="block text-xs text-lime-300">Al Istiqomah Seroja Raya Yasmin</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-300/90">
                        {{ $settings['school_tagline'] ?? '' }}
                    </p>
                    <div class="space-y-2 text-sm">
                        <p class="flex items-start gap-2.5">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $settings['address'] ?? '' }}</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 shrink-0 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $settings['phone'] ?? '' }}</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 shrink-0 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $settings['email'] ?? '' }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank" rel="noopener" class="rounded-lg bg-white/10 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-school-primary">Instagram</a>
                        <a href="{{ $settings['facebook_url'] ?? '#' }}" target="_blank" rel="noopener" class="rounded-lg bg-white/10 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-school-primary">Facebook</a>
                        <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener" class="rounded-lg bg-white/10 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-school-primary">YouTube</a>
                    </div>
                </div>

                <div class="space-y-3 lg:col-span-3">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-lime-300">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li><a href="{{ route('home') }}#profil" class="hover:text-lime-300">Sejarah, Visi &amp; Misi</a></li>
                        <li><a href="{{ route('home') }}#program" class="hover:text-lime-300">Program Pendidikan</a></li>
                        <li><a href="{{ route('home') }}#ppdb" class="hover:text-lime-300">Informasi PPDB</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-lime-300">Berita &amp; Pengumuman</a></li>
                        <li><a href="{{ route('home') }}#galeri" class="hover:text-lime-300">Galeri Kegiatan</a></li>
                        <li><a href="{{ route('home') }}#pendidik" class="hover:text-lime-300">Tenaga Pendidik</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-lime-300">Login Sistem Akademik</a></li>
                    </ul>
                </div>

                <div class="space-y-3 lg:col-span-5">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-lime-300">Lokasi Peta Sekolah</h3>
                    <div class="overflow-hidden rounded-xl border border-white/15 bg-slate-900 shadow-inner">
                        <iframe
                            title="Peta Lokasi {{ $schoolName }}"
                            src="{{ $settings['maps_embed_url'] ?? '' }}"
                            class="h-52 w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ $schoolName }}. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>
</body>
</html>
