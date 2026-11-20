<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/logo-sekolah.png">
    <title>{{ $title ?? 'Dashboard' }} - RA Al-Isry Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(77, 154, 39, 0.28); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(77, 154, 39, 0.55); }
    </style>
</head>
<body class="min-h-screen bg-[#f2f6ee] font-sans text-slate-800 antialiased selection:bg-[#4d9a27] selection:text-white">
@php
    $user = auth()->user();
    $navClass = fn (string ...$patterns) => request()->routeIs(...$patterns)
        ? 'group relative flex items-center gap-3 rounded-2xl bg-gradient-to-r from-[#4d9a27] via-[#438921] to-[#357018] px-3.5 py-2.5 text-xs font-extrabold text-white shadow-md shadow-[#4d9a27]/30 ring-1 ring-lime-300/30'
        : 'group flex items-center gap-3 rounded-2xl px-3.5 py-2.5 text-xs font-semibold text-slate-300/90 transition-all duration-150 hover: translate-x-0.5 hover:bg-white/10 hover:text-white';
    $iconWrapClass = fn (string ...$patterns) => request()->routeIs(...$patterns)
        ? 'flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/20 text-lime-200 shadow-inner'
        : 'flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/5 text-slate-400 transition group-hover:bg-lime-400/15 group-hover:text-lime-300';
@endphp

<div class="flex min-h-screen flex-col lg:flex-row">
    <!-- Sidebar Modern -->
    <aside class="relative flex flex-col justify-between overflow-hidden border-r border-emerald-950/30 bg-gradient-to-b from-[#0b1809] via-[#12240f] to-[#172e13] text-slate-200 lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:shrink-0">
        <!-- Dekorasi Cahaya Halus di Sidebar -->
        <div class="pointer-events-none absolute -top-24 -left-24 h-56 w-56 rounded-full bg-lime-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-10 -right-20 h-48 w-48 rounded-full bg-emerald-500/10 blur-3xl"></div>

        <div class="relative z-10 overflow-y-auto p-5">
            <!-- Brand Header -->
            <a href="{{ route('home') }}" class="group flex items-center gap-3.5 rounded-2xl border border-lime-300/15 bg-gradient-to-br from-white/10 to-white/5 p-3.5 shadow-lg backdrop-blur-md transition hover:border-lime-300/30 hover:from-white/15">
                <div class="relative shrink-0">
                    <img src="/images/logo-sekolah.png" alt="Logo RA Al-Isry" class="h-12 w-12 rounded-full border-2 border-lime-400/60 bg-white object-contain p-0.5 shadow-md">
                    <span class="absolute -right-0.5 -bottom-0.5 h-3 w-3 rounded-full border-2 border-[#12240f] bg-lime-400"></span>
                </div>
                <div class="min-w-0">
                    <div class="truncate text-sm font-extrabold tracking-tight text-white group-hover:text-lime-200">RA Al-Isry Bogor</div>
                    <div class="truncate text-[11px] font-medium text-lime-300/90">Al Istiqomah Seroja Raya</div>
                    <span class="mt-0.5 inline-block rounded bg-lime-400/20 px-1.5 py-0.2 text-[9px] font-bold uppercase tracking-wider text-lime-300">Akreditasi A</span>
                </div>
            </a>

            <!-- Menu Navigasi -->
            <nav class="mt-6 space-y-5">
                <!-- Menu Utama -->
                <div>
                    <div class="mb-2 flex items-center gap-2 px-3 text-[10px] font-extrabold uppercase tracking-widest text-lime-400/80">
                        <span class="h-1 w-1 rounded-full bg-lime-400"></span>
                        <span>Menu Utama</span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="{{ $navClass('superuser.dashboard', 'admin.dashboard', 'kepsek.dashboard', 'guru.dashboard') }}">
                            <span class="{{ $iconWrapClass('superuser.dashboard', 'admin.dashboard', 'kepsek.dashboard', 'guru.dashboard') }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </span>
                            <span>Beranda Dashboard</span>
                        </a>
                    </div>
                </div>

                @if ($user->role === \App\Enums\Role::SuperUser)
                    <div>
                        <div class="mb-2 flex items-center gap-2 px-3 text-[10px] font-extrabold uppercase tracking-widest text-lime-400/80">
                            <span class="h-1 w-1 rounded-full bg-lime-400"></span>
                            <span>Sistem &amp; Super User</span>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('superuser.users.index') }}" class="{{ $navClass('superuser.users.*') }}">
                                <span class="{{ $iconWrapClass('superuser.users.*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <span>Kelola Akun Pengguna</span>
                            </a>
                            <a href="{{ route('superuser.settings') }}" class="{{ $navClass('superuser.settings*') }}">
                                <span class="{{ $iconWrapClass('superuser.settings*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <span>Pengaturan Sistem</span>
                            </a>
                            <a href="{{ route('superuser.logs') }}" class="{{ $navClass('superuser.logs') }}">
                                <span class="{{ $iconWrapClass('superuser.logs') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <span>Activity Log</span>
                            </a>
                            <a href="{{ route('superuser.backup') }}" class="{{ $navClass('superuser.backup*') }}">
                                <span class="{{ $iconWrapClass('superuser.backup*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <span>Backup &amp; Export Data</span>
                            </a>
                        </div>
                    </div>
                @endif

                @if (in_array($user->role, [\App\Enums\Role::SuperUser, \App\Enums\Role::Admin], true))
                    <div>
                        <div class="mb-2 flex items-center gap-2 px-3 text-[10px] font-extrabold uppercase tracking-widest text-lime-400/80">
                            <span class="h-1 w-1 rounded-full bg-lime-400"></span>
                            <span>Administrasi Sekolah</span>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.master') }}" class="{{ $navClass('admin.master') }}">
                                <span class="{{ $iconWrapClass('admin.master') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </span>
                                <span>Data Master Akademik</span>
                            </a>
                            <a href="{{ route('admin.students.index') }}" class="{{ $navClass('admin.students.*') }}">
                                <span class="{{ $iconWrapClass('admin.students.*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                </span>
                                <span>Data Siswa &amp; Kartu</span>
                            </a>
                            <a href="{{ route('admin.teachers.index') }}" class="{{ $navClass('admin.teachers.*') }}">
                                <span class="{{ $iconWrapClass('admin.teachers.*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </span>
                                <span>Data &amp; Akun Guru</span>
                            </a>
                            <a href="{{ route('admin.schedules.index') }}" class="{{ $navClass('admin.schedules.*') }}">
                                <span class="{{ $iconWrapClass('admin.schedules.*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </span>
                                <span>Plotting &amp; Jadwal</span>
                            </a>
                            <a href="{{ route('admin.ppdb.index') }}" class="{{ $navClass('admin.ppdb.*') }}">
                                <span class="{{ $iconWrapClass('admin.ppdb.*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </span>
                                <span>Verifikasi PPDB Online</span>
                            </a>
                            <a href="{{ route('admin.cms.index') }}" class="{{ $navClass('admin.cms.*') }}">
                                <span class="{{ $iconWrapClass('admin.cms.*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </span>
                                <span>Konten Landing Page</span>
                            </a>
                        </div>
                    </div>
                @endif

                @if (in_array($user->role, [\App\Enums\Role::SuperUser, \App\Enums\Role::KepalaSekolah], true))
                    <div>
                        <div class="mb-2 flex items-center gap-2 px-3 text-[10px] font-extrabold uppercase tracking-widest text-lime-400/80">
                            <span class="h-1 w-1 rounded-full bg-lime-400"></span>
                            <span>Kepala Sekolah</span>
                        </div>
                        <div class="space-y-1">
                            @if ($user->role === \App\Enums\Role::SuperUser)
                                <a href="{{ route('kepsek.dashboard') }}" class="{{ $navClass('kepsek.dashboard') }}">
                                    <span class="{{ $iconWrapClass('kepsek.dashboard') }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    </span>
                                    <span>Ringkasan Kepsek</span>
                                </a>
                            @endif
                            <a href="{{ route('kepsek.reports') }}" class="{{ $navClass('kepsek.reports') }}">
                                <span class="{{ $iconWrapClass('kepsek.reports') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <span>Laporan Akademik</span>
                            </a>
                            <a href="{{ route('kepsek.approvals') }}" class="{{ $navClass('kepsek.approvals*') }}">
                                <span class="{{ $iconWrapClass('kepsek.approvals*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <span>Persetujuan Dokumen</span>
                            </a>
                            <a href="{{ route('kepsek.announcements') }}" class="{{ $navClass('kepsek.announcements*') }}">
                                <span class="{{ $iconWrapClass('kepsek.announcements*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </span>
                                <span>Pengumuman Internal</span>
                            </a>
                        </div>
                    </div>
                @endif

                @if ($user->role === \App\Enums\Role::Guru)
                    <div>
                        <div class="mb-2 flex items-center gap-2 px-3 text-[10px] font-extrabold uppercase tracking-widest text-lime-400/80">
                            <span class="h-1 w-1 rounded-full bg-lime-400"></span>
                            <span>Pembelajaran Guru</span>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('guru.dashboard') }}" class="{{ $navClass('guru.dashboard') }}">
                                <span class="{{ $iconWrapClass('guru.dashboard') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </span>
                                <span>Kelas &amp; Jadwal Mengajar</span>
                            </a>
                            <a href="{{ route('guru.attendances.index') }}" class="{{ $navClass('guru.attendances*') }}">
                                <span class="{{ $iconWrapClass('guru.attendances*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </span>
                                <span>Input Absensi Siswa</span>
                            </a>
                            <a href="{{ route('guru.grades.index') }}" class="{{ $navClass('guru.grades*') }}">
                                <span class="{{ $iconWrapClass('guru.grades*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </span>
                                <span>Input Nilai &amp; Bobot</span>
                            </a>
                            <a href="{{ route('guru.materials.index') }}" class="{{ $navClass('guru.materials*', 'guru.tasks*') }}">
                                <span class="{{ $iconWrapClass('guru.materials*', 'guru.tasks*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </span>
                                <span>Materi &amp; Tugas Kelas</span>
                            </a>
                            <a href="{{ route('guru.students.index') }}" class="{{ $navClass('guru.students*') }}">
                                <span class="{{ $iconWrapClass('guru.students*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <span>Daftar Siswa Kelas</span>
                            </a>
                            <a href="{{ route('guru.approvals.index') }}" class="{{ $navClass('guru.approvals*') }}">
                                <span class="{{ $iconWrapClass('guru.approvals*') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <span>Pengajuan RPPH &amp; Info</span>
                            </a>
                        </div>
                    </div>
                @endif

                @stack('menu')

                <!-- Pengaturan Akun Pribadi -->
                <div>
                    <div class="mb-2 flex items-center gap-2 px-3 text-[10px] font-extrabold uppercase tracking-widest text-lime-400/80">
                        <span class="h-1 w-1 rounded-full bg-lime-400"></span>
                        <span>Pengaturan Akun</span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('profile.edit') }}" class="{{ $navClass('profile.*') }}">
                            <span class="{{ $iconWrapClass('profile.*') }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span>Profil &amp; Kata Sandi</span>
                        </a>
                        <a href="{{ route('home') }}" class="group flex items-center gap-3 rounded-2xl px-3.5 py-2.5 text-xs font-semibold text-slate-300/90 transition hover:bg-white/10 hover:text-white">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/5 text-slate-400 transition group-hover:bg-lime-400/15 group-hover:text-lime-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </span>
                            <span>Lihat Website Publik</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- User Footer Card -->
        <div class="relative z-10 border-t border-white/10 bg-black/30 p-4 backdrop-blur-md">
            <div class="flex items-center justify-between gap-2">
                <div class="flex min-w-0 items-center gap-2.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#4d9a27] to-[#84cc16] text-xs font-extrabold text-slate-950 shadow">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="truncate text-xs font-extrabold text-white">{{ $user->name }}</div>
                        <div class="truncate text-[11px] font-medium text-lime-300">{{ $user->role->label() }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button title="Keluar" class="rounded-xl border border-red-400/25 bg-red-500/15 px-3 py-1.5 text-xs font-extrabold text-red-200 transition hover:bg-red-500 hover:text-white">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Area Konten Utama -->
    <div class="flex flex-1 flex-col">
        <!-- Top Header Bar -->
        <header class="sticky top-0 z-30 border-b border-emerald-950/10 bg-white/85 px-4 py-3.5 shadow-2xs backdrop-blur-md md:px-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="hidden h-9 w-1.5 rounded-full bg-gradient-to-b from-[#4d9a27] to-[#84cc16] sm:block"></div>
                    <div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider text-[#4d9a27]">
                            Sistem Informasi Manajemen &bull; {{ $user->role->label() }}
                        </div>
                        <h1 class="text-xl font-extrabold tracking-tight text-slate-900 sm:text-2xl">{{ $title ?? 'Dashboard' }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('ppdb.create') }}" target="_blank" class="hidden items-center gap-1.5 rounded-xl border border-lime-600/30 bg-lime-50/80 px-3 py-1.5 text-xs font-bold text-[#3f821f] transition hover:bg-lime-100 md:inline-flex">
                        <span>Form PPDB Publik</span>
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    <span class="hidden rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 sm:inline-flex">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-[#4d9a27] to-[#3f821f] px-3.5 py-1.5 text-xs font-extrabold text-white shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                        Login: {{ $user->role->label() }}
                    </span>
                </div>
            </div>
        </header>

        <!-- Isi Halaman -->
        <main class="flex-1 p-4 md:p-8">
            @if (session('status'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-lime-300 bg-lime-50 p-4 text-sm font-bold text-lime-950 shadow-sm">
                    <svg class="h-5 w-5 shrink-0 text-[#4d9a27]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-xs text-red-800 shadow-sm">
                    <div class="mb-1 font-bold">Periksa kembali isian berikut:</div>
                    <ul class="list-disc space-y-0.5 pl-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
