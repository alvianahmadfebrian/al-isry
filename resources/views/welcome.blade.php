<x-layouts.public :settings="$settings">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-school-secondary text-white">
        <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 18% 22%, var(--school-primary), transparent 45%), radial-gradient(circle at 82% 65%, var(--school-accent), transparent 40%);"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-12">
                <div class="space-y-6 lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-lime-400/30 bg-lime-400/10 px-3.5 py-1.5 text-xs font-semibold text-lime-300 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-lime-400"></span>
                        {{ $settings['ppdb_status'] ?? 'PPDB Tahun Ajaran Baru Dibuka' }}
                    </div>

                    <h1 class="text-3xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                        {{ $settings['school_name'] }}
                    </h1>

                    <p class="text-lg font-medium text-lime-200 sm:text-xl">
                        “{{ $settings['school_tagline'] }}”
                    </p>

                    <p class="max-w-2xl text-sm leading-relaxed text-slate-200/90 sm:text-base">
                        {{ $settings['hero_subtitle'] }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="{{ route('ppdb.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-school-accent px-6 py-3.5 text-sm font-bold text-slate-950 shadow-lg transition hover:brightness-105">
                            Daftar PPDB Online
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('ppdb.check') }}" class="inline-flex items-center gap-2 rounded-xl border border-lime-300/35 bg-white/10 px-5 py-3.5 text-sm font-semibold text-lime-200 backdrop-blur transition hover:bg-white/20">
                            Cek Status PPDB
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/25 bg-white/10 px-5 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/25 bg-white/10 px-5 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                                Login Sistem
                            </a>
                        @endauth
                    </div>

                    <!-- Statistik Ringkas -->
                    <div class="grid grid-cols-2 gap-4 pt-6 sm:grid-cols-4">
                        <div class="rounded-xl border border-white/15 bg-white/5 p-3.5">
                            <div class="text-2xl font-extrabold text-lime-300">{{ $settings['stat_students'] ?? '120+' }}</div>
                            <div class="text-xs text-slate-300">Peserta Didik</div>
                        </div>
                        <div class="rounded-xl border border-white/15 bg-white/5 p-3.5">
                            <div class="text-2xl font-extrabold text-lime-300">{{ $settings['stat_teachers'] ?? '14' }}</div>
                            <div class="text-xs text-slate-300">Pendidik &amp; Staf</div>
                        </div>
                        <div class="rounded-xl border border-white/15 bg-white/5 p-3.5">
                            <div class="text-2xl font-extrabold text-lime-300">{{ $settings['stat_achievements'] ?? '45+' }}</div>
                            <div class="text-xs text-slate-300">Prestasi Siswa</div>
                        </div>
                        <div class="rounded-xl border border-white/15 bg-white/5 p-3.5">
                            <div class="text-2xl font-extrabold text-lime-300">{{ $settings['stat_accreditation'] ?? 'A' }}</div>
                            <div class="text-xs text-slate-300">Status Akreditasi</div>
                        </div>
                    </div>
                </div>

                <!-- Visual Card dengan Logo Resmi -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <div class="overflow-hidden rounded-3xl border border-lime-300/20 bg-white/10 p-6 shadow-2xl backdrop-blur-md">
                            <div class="flex flex-col items-center rounded-2xl bg-white p-6 text-center text-slate-900 shadow-inner">
                                <img
                                    src="{{ $settings['logo_url'] ?? '/images/logo-sekolah.png' }}"
                                    alt="Logo {{ $settings['school_name'] }}"
                                    class="h-44 w-44 object-contain sm:h-52 sm:w-52">
                                <div class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-school-primary">
                                    &#9733; Yayasan Al Istiqomah Seroja Raya Yasmin &#9733;
                                </div>
                                <h2 class="mt-2 text-lg font-extrabold text-slate-900">RA AL-ISRY BOGOR</h2>
                                <p class="mt-1 text-xs leading-relaxed text-slate-600">
                                    Pendidikan Anak Usia Dini Berciri Khas Islam yang Ramah Anak, Ceria, dan Berakhlak Mulia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Profil Sekolah: Sejarah, Visi, Misi -->
    <section id="profil" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="text-xs font-bold uppercase tracking-widest text-school-primary">Tentang Kami</span>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Profil {{ $settings['school_short_name'] ?? $settings['school_name'] }}</h2>
                <p class="mt-3 text-sm text-slate-600 sm:text-base">Mengenal lebih dekat perjalanan sejarah, visi ke depan, serta misi pendidikan sekolah kami.</p>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-3">
                <!-- Sejarah Singkat -->
                <div class="rounded-2xl border border-lime-900/10 bg-white p-7 shadow-sm">
                    <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-lime-100 text-school-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Sejarah Singkat</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        {{ $settings['history'] }}
                    </p>
                </div>

                <!-- Visi -->
                <div class="rounded-2xl border border-lime-900/10 bg-white p-7 shadow-sm">
                    <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-lime-100 text-school-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Visi Sekolah</h3>
                    <blockquote class="mt-3 rounded-xl border border-lime-200 bg-lime-50/60 p-4 text-sm font-medium italic leading-relaxed text-slate-700">
                        “{{ $settings['vision'] }}”
                    </blockquote>
                </div>

                <!-- Misi -->
                <div class="rounded-2xl border border-lime-900/10 bg-white p-7 shadow-sm">
                    <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-lime-100 text-school-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Misi Pendidikan</h3>
                    <ul class="mt-3 space-y-2.5 text-sm text-slate-600">
                        @foreach (array_filter(preg_split('/\r\n|\r|\n/', $settings['missions'] ?? '')) as $mission)
                            <li class="flex items-start gap-2.5">
                                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-school-primary"></span>
                                <span>{{ $mission }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Program / Keunggulan -->
    <section id="program" class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-school-primary">Kurikulum &amp; Pembiasaan</span>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Program Unggulan Sekolah</h2>
                </div>
                <p class="max-w-xl text-sm text-slate-600">Setiap program dirancang untuk menstimulasi aspek nilai agama, motorik, kognitif, bahasa, dan sosial-emosional anak secara menyeluruh.</p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($majors as $major)
                    <div class="group flex flex-col justify-between rounded-2xl border border-lime-900/10 bg-[#f8faf5] p-6 transition hover:-translate-y-0.5 hover:border-school-primary hover:bg-white hover:shadow-md">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="rounded-lg bg-school-primary px-2.5 py-1 text-xs font-bold text-white">{{ $major->code }}</span>
                                <span class="text-xs font-semibold text-lime-700">&#9733; Unggulan</span>
                            </div>
                            <h3 class="mt-4 text-base font-bold text-slate-900 group-hover:text-school-primary">{{ $major->name }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $major->description }}</p>
                        </div>
                        <div class="mt-5 border-t border-lime-900/10 pt-3 text-xs font-semibold text-school-primary">
                            Belajar Aktif, Kreatif &amp; Islami
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-sm text-slate-500">Belum ada data program unggulan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section Info PPDB -->
    <section id="ppdb" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-school-secondary text-white shadow-xl">
                <div class="grid gap-8 p-8 sm:p-10 lg:grid-cols-12 lg:items-center">
                    <div class="space-y-4 lg:col-span-7">
                        <span class="inline-block rounded-full bg-lime-400/20 px-3 py-1 text-xs font-semibold text-lime-300">
                            Penerimaan Peserta Didik Baru (PPDB)
                        </span>
                        <h2 class="text-2xl font-bold sm:text-3xl">{{ $settings['ppdb_status'] }}</h2>
                        <p class="text-sm leading-relaxed text-slate-200/90 sm:text-base">{{ $settings['ppdb_info'] }}</p>

                        <div class="grid gap-4 pt-2 sm:grid-cols-2">
                            <div class="rounded-xl border border-white/15 bg-white/5 p-4">
                                <div class="text-xs text-lime-300">Periode Pendaftaran</div>
                                <div class="mt-1 font-semibold text-white">{{ $settings['ppdb_period'] }}</div>
                            </div>
                            <div class="rounded-xl border border-white/15 bg-white/5 p-4">
                                <div class="text-xs text-lime-300">Kuota Penerimaan</div>
                                <div class="mt-1 font-semibold text-white">{{ $settings['ppdb_quota'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-white/5 p-6 lg:col-span-5">
                        <h3 class="text-base font-bold text-lime-300">Syarat Pendaftaran Siswa Baru</h3>
                        <ul class="mt-4 space-y-2.5 text-sm text-slate-100">
                            @foreach (array_filter(preg_split('/\r\n|\r|\n/', $settings['ppdb_requirements'] ?? '')) as $req)
                                <li class="flex items-start gap-2.5">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $req }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-6 space-y-2.5">
                            <a href="{{ route('ppdb.create') }}" class="block w-full rounded-xl bg-school-accent py-3 text-center text-sm font-bold text-slate-950 transition hover:brightness-105">
                                Isi Formulir Pendaftaran Online
                            </a>
                            <a href="{{ route('ppdb.check') }}" class="block w-full rounded-xl border border-white/20 bg-white/5 py-2.5 text-center text-xs font-semibold text-lime-200 transition hover:bg-white/10">
                                Sudah Mendaftar? Cek Status Pendaftaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Berita & Pengumuman Terbaru -->
    <section id="berita" class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-school-primary">Kabar Terkini</span>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Berita &amp; Pengumuman Terbaru</h2>
                </div>
                <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-school-primary hover:underline">
                    Lihat Semua Berita
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($latestNews as $item)
                    <article class="group flex flex-col overflow-hidden rounded-2xl border border-lime-900/10 bg-white shadow-sm transition hover:shadow-md">
                        <a href="{{ route('news.show', $item->slug) }}" class="relative block h-48 overflow-hidden bg-slate-100">
                            @if ($item->thumbnail_url)
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @endif
                            <span class="absolute top-3 left-3 rounded-full bg-school-primary px-3 py-1 text-xs font-semibold text-white shadow">
                                {{ $item->category }}
                            </span>
                        </a>
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div>
                                <div class="text-xs text-slate-400">
                                    {{ ($item->published_at ?? $item->created_at)?->translatedFormat('d F Y') }}
                                </div>
                                <h3 class="mt-2 line-clamp-2 text-base font-bold text-slate-900 group-hover:text-school-primary">
                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                </h3>
                                <p class="mt-2 line-clamp-3 text-sm text-slate-600">
                                    {{ $item->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                                </p>
                            </div>
                            <div class="mt-4 pt-2">
                                <a href="{{ route('news.show', $item->slug) }}" class="inline-flex items-center gap-1 text-xs font-bold text-school-primary hover:underline">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full text-center text-sm text-slate-500">Belum ada berita atau pengumuman yang dipublikasikan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section Galeri Kegiatan -->
    <section id="galeri" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="text-xs font-bold uppercase tracking-widest text-school-primary">Dokumentasi</span>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Galeri Kegiatan Sekolah</h2>
                <p class="mt-2 text-sm text-slate-600">Potret keceriaan belajar, pembiasaan ibadah, motorik kreatif, dan prestasi anak didik kami.</p>
            </div>

            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($galleryItems as $photo)
                    <figure class="group relative overflow-hidden rounded-2xl border border-lime-900/10 bg-white shadow-sm">
                        <div class="h-60 overflow-hidden bg-slate-100">
                            <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        </div>
                        <figcaption class="p-4">
                            <div class="flex items-center justify-between text-xs text-slate-400">
                                <span class="font-semibold text-school-primary">{{ $photo->category ?? 'Kegiatan' }}</span>
                                @if ($photo->activity_date)
                                    <span>{{ $photo->activity_date->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>
                            <div class="mt-1 font-bold text-slate-900">{{ $photo->title }}</div>
                            @if ($photo->description)
                                <p class="mt-1 text-xs text-slate-600">{{ $photo->description }}</p>
                            @endif
                        </figcaption>
                    </figure>
                @empty
                    <p class="col-span-full text-center text-sm text-slate-500">Belum ada foto galeri kegiatan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section Tenaga Pendidik -->
    <section id="pendidik" class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="text-xs font-bold uppercase tracking-widest text-school-primary">Pendidik Kami</span>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Tenaga Pendidik Pilihan</h2>
                <p class="mt-2 text-sm text-slate-600">Didukung oleh pendidik sabar, penyayang, dan berpengalaman di bidang pendidikan anak usia dini.</p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($teachers as $teacher)
                    <div class="overflow-hidden rounded-2xl border border-lime-900/10 bg-[#f8faf5] text-center shadow-sm transition hover:bg-white hover:shadow-md">
                        <div class="h-56 w-full overflow-hidden bg-slate-200">
                            @if ($teacher->photo_url)
                                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-3xl font-bold text-slate-400">
                                    {{ \Illuminate\Support\Str::substr($teacher->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-slate-900">{{ $teacher->name }}</h3>
                            <p class="mt-0.5 text-xs font-semibold text-school-primary">{{ $teacher->position ?? 'Guru Kelas' }}</p>
                            @if ($teacher->specialization)
                                <p class="mt-1 text-xs text-slate-500">Bidang: {{ $teacher->specialization }}</p>
                            @endif
                            @if ($teacher->education)
                                <p class="mt-1 text-xs text-slate-400">{{ $teacher->education }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-sm text-slate-500">Belum ada data tenaga pendidik yang ditampilkan.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.public>
