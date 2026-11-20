<x-layouts.public :title="$article->title" :settings="$settings">
    <article class="py-12 sm:py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-school-primary hover:underline">
                &larr; Kembali ke Daftar Berita
            </a>

            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                <span class="rounded-full bg-blue-100 px-3 py-1 font-semibold text-school-primary">{{ $article->category }}</span>
                <span>{{ ($article->published_at ?? $article->created_at)?->translatedFormat('d F Y') }}</span>
                @if ($article->author)
                    <span>&bull; Oleh {{ $article->author->name }}</span>
                @endif
            </div>

            <h1 class="mt-3 text-2xl font-extrabold leading-snug text-slate-900 sm:text-4xl">
                {{ $article->title }}
            </h1>

            @if ($article->thumbnail_url)
                <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 shadow-sm">
                    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="max-h-[440px] w-full object-cover">
                </div>
            @endif

            <div class="prose prose-slate mt-8 max-w-none space-y-4 text-base leading-relaxed text-slate-700">
                @foreach (array_filter(preg_split('/\r\n|\r|\n/', $article->content)) as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            @if ($relatedNews->isNotEmpty())
                <div class="mt-14 border-t border-slate-200 pt-10">
                    <h2 class="text-lg font-bold text-slate-900">Berita Lainnya</h2>
                    <div class="mt-5 grid gap-5 sm:grid-cols-3">
                        @foreach ($relatedNews as $other)
                            <a href="{{ route('news.show', $other->slug) }}" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-300">
                                <span class="text-xs font-semibold text-school-primary">{{ $other->category }}</span>
                                <h3 class="mt-1 line-clamp-2 text-sm font-bold text-slate-900">{{ $other->title }}</h3>
                                <span class="mt-2 block text-xs text-slate-400">{{ ($other->published_at ?? $other->created_at)?->translatedFormat('d M Y') }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>
</x-layouts.public>
