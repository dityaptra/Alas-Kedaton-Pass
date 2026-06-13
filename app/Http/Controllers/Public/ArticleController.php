<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
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

        $sort   = $request->get('sort', 'newest');
        $search = $request->get('search', '');

        $articles = Article::published()
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($sort === 'oldest', fn($q) => $q->oldest('published_at'))
            ->paginate(9)
            ->withQueryString();

        return view('public.articles.index', compact('articles', 'sort', 'search'));
    }

    public function show(string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $article->load('comments');

        // Ambil 3 artikel lain secara acak, exclude artikel yang sedang dibaca
        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

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

        return view('public.articles.show', compact('article', 'related'));
    }

    public function storeComment(Request $request, string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'content' => 'required|string|max:1000',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'content.required' => 'Komentar tidak boleh kosong.',
            'content.max'      => 'Komentar maksimal 1000 karakter.',
        ]);

        Comment::create([
            'article_id' => $article->id,
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'content'    => $validated['content'],
        ]);

        return back()->with('comment_success', 'Komentar berhasil dikirim.');
    }
}
