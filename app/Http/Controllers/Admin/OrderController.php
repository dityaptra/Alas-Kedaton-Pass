<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $orders = Order::with('items')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load('items.ticketType');

        return view('admin.orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        if (!$order->isPending()) {
            return back()->with('error', 'Order ini tidak bisa dikonfirmasi.');
        }

        $order->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Kirim e-ticket via email — akan kita implementasi nanti
        // Mail::to($order->visitor_email)->send(new ETicketMail($order));

        return back()->with('success', 'Order berhasil dikonfirmasi. E-ticket akan dikirim ke email pemesan.');
    }

    public function cancel(Order $order)
    {
        if ($order->status === 'confirmed') {
            return back()->with('error', 'Order yang sudah dikonfirmasi tidak bisa dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order berhasil dibatalkan.');
    }

    public function uploadProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'payment_proof.required' => 'File bukti bayar wajib dipilih.',
            'payment_proof.mimes'    => 'Format file harus JPG, PNG, atau PDF.',
            'payment_proof.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $path = $request->file('payment_proof')
            ->store('payment-proofs', 'public');

        $order->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}