<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    public function index()
    {
        $ticketTypes = TicketType::latest()->get();

        return view('admin.ticket-types.index', compact('ticketTypes'));
    }

    public function create()
    {
        return view('admin.ticket-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:asing,domestik,lokal',
            'visitor_type' => 'nullable|in:dewasa,anak',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'is_active'    => 'boolean',
        ]);

        TicketType::create($validated);

        return redirect()->route('admin.ticket-types.index')
            ->with('success', 'Jenis tiket berhasil ditambahkan.');
    }

    public function edit(TicketType $ticketType)
    {
        return view('admin.ticket-types.edit', compact('ticketType'));
    }

    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:asing,domestik,lokal',
            'visitor_type' => 'nullable|in:dewasa,anak',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'is_active'    => 'boolean',
        ]);

        $ticketType->update($validated);

        return redirect()->route('admin.ticket-types.index')
            ->with('success', 'Jenis tiket berhasil diperbarui.');
    }

    public function destroy(TicketType $ticketType)
    {
        // Cegah hapus jika masih ada order yang mereferensikan tiket ini
        if ($ticketType->orderItems()->exists()) {
            return back()->with('error', 'Tiket ini tidak bisa dihapus karena sudah ada order yang menggunakannya. Nonaktifkan saja.');
        }

        $ticketType->delete();

        return back()->with('success', 'Jenis tiket berhasil dihapus.');
    }
}