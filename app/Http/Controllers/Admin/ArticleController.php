<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status'    => 'required|in:draft,published',
        ], [
            'title.required'   => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
            'thumbnail.image'  => 'File harus berupa gambar.',
            'thumbnail.mimes'  => 'Format gambar harus JPG, PNG, atau WebP.',
            'thumbnail.max'    => 'Ukuran gambar maksimal 1MB.',
            'status.required'  => 'Status artikel wajib dipilih.',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        Article::create([
            'user_id'      => Auth::id(),
            'title'        => $validated['title'],
            'slug'         => Str::slug($validated['title']) . '-' . time(),
            'content'      => $validated['content'],
            'thumbnail'    => $thumbnailPath,
            'status'       => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status'    => 'required|in:draft,published',
        ], [
            'title.required'   => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
            'thumbnail.image'  => 'File harus berupa gambar.',
            'thumbnail.mimes'  => 'Format gambar harus JPG, PNG, atau WebP.',
            'thumbnail.max'    => 'Ukuran gambar maksimal 1MB.',
            'status.required'  => 'Status artikel wajib dipilih.',
        ]);

        $thumbnailPath = $article->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        $article->update([
            'title'        => $validated['title'],
            'slug'         => Str::slug($validated['title']) . '-' . $article->id,
            'content'      => $validated['content'],
            'thumbnail'    => $thumbnailPath,
            'status'       => $validated['status'],
            'published_at' => $validated['status'] === 'published'
                ? ($article->published_at ?? now())
                : null,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
