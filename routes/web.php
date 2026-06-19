<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TicketTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\OrderController;
use App\Http\Controllers\Public\TicketController;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Article;

// ============================================================
// PUBLIC ROUTES
// ============================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tiket', [TicketController::class, 'index'])->name('tickets.index');

Route::get('/pesan', [OrderController::class, 'create'])->name('orders.create');
Route::post('/pesan', [OrderController::class, 'store'])->name('orders.store');
Route::get('/pesan/sukses/{orderNumber}', [OrderController::class, 'success'])
    ->name('orders.success');

Route::get('/cek-pesanan', [OrderController::class, 'checkForm'])
    ->name('orders.check');
Route::post('/cek-pesanan', [OrderController::class, 'checkStatus'])
    ->name('orders.check.status');

Route::get('/berita', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/berita/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::post('/berita/{slug}/komentar', [ArticleController::class, 'storeComment'])
    ->name('articles.comment.store');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))
            ->setPriority(1.0)
            ->setChangeFrequency('weekly'))
        ->add(Url::create(route('tickets.index'))
            ->setPriority(0.9)
            ->setChangeFrequency('monthly'))
        ->add(Url::create(route('articles.index'))
            ->setPriority(0.8)
            ->setChangeFrequency('daily'))
        ->add(Url::create(route('orders.create'))
            ->setPriority(0.7)
            ->setChangeFrequency('monthly'));

    Article::published()->each(function ($article) use ($sitemap) {
        $sitemap->add(
            Url::create(route('articles.show', $article->slug))
                ->setLastModificationDate($article->updated_at)
                ->setPriority(0.6)
                ->setChangeFrequency('monthly')
        );
    });

    return $sitemap->toResponse(request());
});

// ============================================================
// ADMIN ROUTES
// ============================================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (guest admin saja yang bisa akses)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post')
            ->middleware('throttle:5,1');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Order & Tiket — hanya admin
        Route::middleware('role:admin')->group(function () {
            Route::get('/orders', [AdminOrderController::class, 'index'])
                ->name('orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
                ->name('orders.show');
            Route::post('/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])
                ->name('orders.confirm');
            Route::post('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])
                ->name('orders.cancel');
            Route::post('/orders/{order}/proof', [AdminOrderController::class, 'uploadProof'])
                ->name('orders.proof');

            Route::resource('ticket-types', TicketTypeController::class)
                ->names('ticket-types');

            Route::resource('users', UserController::class)
                ->except(['show'])
                ->names('users');
        });

        // Artikel - admin dan editor
        Route::resource('articles', AdminArticleController::class)
            ->except(['show'])
            ->names('articles');

        Route::get('/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])
            ->name('comments.index');
        Route::delete('/comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])
            ->name('comments.destroy');
    });
});
