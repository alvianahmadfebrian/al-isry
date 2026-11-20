<x-layouts.public title="Berita &amp; Pengumuman" :settings="$settings">
    <section class="bg-school-secondary py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold sm:text-3xl">Berita &amp; Pengumuman Sekolah</h1>
            <p class="mt-2 text-sm text-slate-300">Kumpulan informasi resmi, prestasi siswa, dan agenda akademik {{ $settings['school_name'] }}.</p>

            <form method="GET" action="{{ route('news.index') }}" class="mt-6 flex flex-wrap gap-2">
                <input name="q" value="{{ request('q') }}" placeholder="Cari judul berita..." class="w-full rounded-xl border border-white/15 bg-white/10 px-4 py-2.5 text-sm text-white placeholder-slate-400 sm:w-72">
                <select name="kategori" class="rounded-xl border border-white/15 bg-slate-800 px-4 py-2.5 text-sm text-white">
                    <option value="">Semua Kategori</option>
                    @foreach (['Berita', 'Pengumuman', 'Prestasi'] as $cat)
                        <option value="{{ $cat }}" @selected(request('kategori') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                <button class="rounded-xl bg-school-primary px-5 py-2.5 text-sm font-semibold text-white">Filter</button>
            </form>
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($news as $item)
                    <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <a href="{{ route('news.show', $item->slug) }}" class="relative block h-48 overflow-hidden bg-slate-100">
                            @if ($item->thumbnail_url)
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                            @endif
                            <span class="absolute top-3 left-3 rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold text-white">
                                {{ $item->category }}
                            </span>
                        </a>
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div>
                                <div class="text-xs text-slate-400">{{ ($item->published_at ?? $item->created_at)?->translatedFormat('d F Y') }}</div>
                                <h2 class="mt-2 text-base font-bold text-slate-900">
                                    <a href="{{ route('news.show', $item->slug) }}" class="hover:text-school-primary">{{ $item->title }}</a>
                                </h2>
                                <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $item->excerpt }}</p>
                            </div>
                            <a href="{{ route('news.show', $item->slug) }}" class="mt-4 inline-block text-xs font-bold text-school-primary hover:underline">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full py-12 text-center text-slate-500">Tidak ada berita yang ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $news->links() }}
            </div>
        </div>
    </section>
</x-layouts.public>
