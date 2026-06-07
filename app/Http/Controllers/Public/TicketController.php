<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TicketType;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

class TicketController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Harga Tiket Masuk');
        SEOMeta::setDescription('Harga tiket masuk Wisata Alas Kedaton. Tersedia tiket untuk wisatawan asing, domestik, dan warga lokal Bali. Mulai dari Rp 10.000.');
        SEOMeta::setCanonical(route('tickets.index'));

        OpenGraph::setTitle('Harga Tiket Masuk — AlasKedatonPass');
        OpenGraph::setDescription('Harga tiket masuk Wisata Alas Kedaton mulai Rp 10.000.');
        OpenGraph::setUrl(route('tickets.index'));

        $tickets = TicketType::active()->get();

        return view('public.tickets.index', compact('tickets'));
    }
}