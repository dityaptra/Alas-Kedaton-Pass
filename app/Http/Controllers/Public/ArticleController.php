<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        SEOMeta::setTitle('Berita & Informasi');
        SEOMeta::setDescription('Berita dan informasi terkini seputar Wisata Alas Kedaton, Tabanan, Bali.');
        SEOMeta::setCanonical(route('articles.index'));

        OpenGraph::setTitle('Berita & Informasi — AlasKedatonPass');
        OpenGraph::setDescription('Berita dan informasi terkini seputar Wisata Alas Kedaton.');
        OpenGraph::setUrl(route('articles.index'));

        $sort = $request->get('sort', 'newest');

        $articles = Article::published()
            ->when($sort === 'oldest', fn($q) => $q->oldest('published_at'))
            ->paginate(9);

        return view('public.articles.index', compact('articles', 'sort'));
    }

    public function show(string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Ambil 160 karakter pertama konten sebagai description
        $description = Str::limit(strip_tags($article->content), 160);

        SEOMeta::setTitle($article->title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(route('articles.show', $article->slug));

        OpenGraph::setTitle($article->title . ' — AlasKedatonPass');
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(route('articles.show', $article->slug));
        OpenGraph::setType('article');

        if ($article->thumbnail) {
            OpenGraph::addImage(Storage::url($article->thumbnail));
        }

        return view('public.articles.show', compact('article'));
    }
}