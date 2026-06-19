<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\TicketType;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

class HomeController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Beranda');
        SEOMeta::setDescription('Wisata alam hutan suci dengan ribuan kera dan pura bersejarah di Tabanan, Bali. Pesan tiket masuk secara online.');
        SEOMeta::setCanonical(route('home'));

        OpenGraph::setTitle('AlasKedatonPass - Tiket Wisata Alas Kedaton');
        OpenGraph::setDescription('Wisata alam hutan suci dengan ribuan kera dan pura bersejarah di Tabanan, Bali.');
        OpenGraph::setUrl(route('home'));

        $tickets  = TicketType::active()->get();
        $articles = Article::published()->limit(3)->get();

        return view('public.home', compact('tickets', 'articles'));
    }
}