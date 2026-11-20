<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\Major;
use App\Models\News;
use App\Models\SchoolSetting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $settings = SchoolSetting::allAsMap();

        $majors = Major::query()
            ->where('is_featured', true)
            ->orderBy('id')
            ->get();

        $latestNews = News::query()
            ->with('author')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $galleryItems = GalleryItem::query()
            ->where('is_published', true)
            ->orderByDesc('activity_date')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $teachers = Teacher::query()
            ->where('show_on_landing', true)
            ->orderBy('id')
            ->limit(8)
            ->get();

        return view('welcome', [
            'settings' => $settings,
            'majors' => $majors,
            'latestNews' => $latestNews,
            'galleryItems' => $galleryItems,
            'teachers' => $teachers,
        ]);
    }

    public function newsIndex(Request $request): View
    {
        $settings = SchoolSetting::allAsMap();

        $news = News::query()
            ->with('author')
            ->where('is_published', true)
            ->when($request->filled('kategori'), fn ($q) => $q->where('category', $request->string('kategori')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(fn ($w) => $w->where('title', 'like', $term)->orWhere('excerpt', 'like', $term));
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('landing.news-index', [
            'settings' => $settings,
            'news' => $news,
        ]);
    }

    public function newsShow(string $slug): View
    {
        $settings = SchoolSetting::allAsMap();

        $article = News::query()
            ->with('author')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedNews = News::query()
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('landing.news-show', [
            'settings' => $settings,
            'article' => $article,
            'relatedNews' => $relatedNews,
        ]);
    }
}
