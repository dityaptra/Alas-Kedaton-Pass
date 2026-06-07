<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        SEOMeta::setTitle('Pesan Tiket');
        SEOMeta::setDescription('Pesan tiket masuk Wisata Alas Kedaton secara online. Isi data pemesan dan pilih jenis tiket yang sesuai.');
        SEOMeta::setCanonical(route('orders.create'));

        OpenGraph::setTitle('Pesan Tiket — AlasKedatonPass');
        OpenGraph::setDescription('Pesan tiket masuk Wisata Alas Kedaton secara online.');
        OpenGraph::setUrl(route('orders.create'));

        $tickets = TicketType::active()->get();

        return view('public.orders.create', compact('tickets'));
    }

    public function store(Request $request)
    {
        // tidak berubah, sama seperti sebelumnya
        $validated = $request->validate([
            'visitor_name'             => 'required|string|max:255',
            'visitor_phone'            => 'required|string|max:20',
            'visitor_email'            => 'required|email|max:255',
            'visit_date'               => 'required|date|after_or_equal:today',
            'tickets'                  => 'required|array|min:1',
            'tickets.*.ticket_type_id' => 'required|exists:ticket_types,id',
            'tickets.*.quantity'       => 'required|integer|min:1|max:50',
        ], [
            'visitor_name.required'     => 'Nama lengkap wajib diisi.',
            'visitor_phone.required'    => 'Nomor WhatsApp wajib diisi.',
            'visitor_email.required'    => 'Alamat email wajib diisi.',
            'visitor_email.email'       => 'Format email tidak valid.',
            'visit_date.required'       => 'Tanggal kunjungan wajib diisi.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan tidak boleh kurang dari hari ini.',
            'tickets.required'          => 'Pilih minimal satu jenis tiket.',
            'tickets.*.quantity.min'    => 'Jumlah tiket minimal 1.',
            'tickets.*.quantity.max'    => 'Jumlah tiket maksimal 50 per jenis.',
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'order_number'  => Order::generateOrderNumber(),
                'visitor_name'  => $validated['visitor_name'],
                'visitor_phone' => $validated['visitor_phone'],
                'visitor_email' => $validated['visitor_email'],
                'visit_date'    => $validated['visit_date'],
                'status'        => 'pending',
            ]);

            foreach ($validated['tickets'] as $item) {
                $ticketType = TicketType::findOrFail($item['ticket_type_id']);
                OrderItem::create([
                    'order_id'       => $order->id,
                    'ticket_type_id' => $ticketType->id,
                    'quantity'       => $item['quantity'],
                    'price_snapshot' => $ticketType->price,
                ]);
            }

            return $order;
        });

        return redirect()->route('orders.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        SEOMeta::setTitle('Pesanan Berhasil');
        SEOMeta::robots('noindex, nofollow'); // halaman ini tidak perlu diindeks Google

        $order    = Order::with('items.ticketType')
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        $waNumber = env('WHATSAPP_NUMBER', '6281234567890');

        return view('public.orders.success', compact('order', 'waNumber'));
    }

    public function checkForm()
    {
        SEOMeta::setTitle('Cek Status Pesanan');
        SEOMeta::setDescription('Cek status pesanan tiket Wisata Alas Kedaton menggunakan nomor order dan nomor WhatsApp kamu.');
        SEOMeta::setCanonical(route('orders.check'));

        OpenGraph::setTitle('Cek Status Pesanan — AlasKedatonPass');
        OpenGraph::setUrl(route('orders.check'));

        return view('public.orders.check');
    }

    public function checkStatus(Request $request)
    {
        // tidak berubah
        $request->validate([
            'order_number'  => 'required|string',
            'visitor_phone' => 'required|string',
        ], [
            'order_number.required'  => 'Nomor order wajib diisi.',
            'visitor_phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $order = Order::with('items.ticketType')
            ->where('order_number', $request->order_number)
            ->where('visitor_phone', $request->visitor_phone)
            ->first();

        if (!$order) {
            return back()->withErrors([
                'not_found' => 'Order tidak ditemukan. Periksa kembali nomor order dan nomor WhatsApp kamu.',
            ]);
        }

        return view('public.orders.status', compact('order'));
    }
}