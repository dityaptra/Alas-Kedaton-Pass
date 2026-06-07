<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'visitor_name',
        'visitor_phone',
        'visitor_email',
        'visit_date',
        'status',
        'payment_proof',
        'notes',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'visit_date'   => 'date',
            'confirmed_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Hitung total harga semua item dalam order ini
    public function getTotalAttribute(): int
    {
        return $this->items->sum(fn($item) => $item->price_snapshot * $item->quantity);
    }

    // Generate nomor order unik: AK-20260606-0001
    public static function generateOrderNumber(): string
    {
        $date  = now()->format('Ymd');
        $count = static::whereDate('created_at', today())->count() + 1;

        return 'AK-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // Cek apakah order ini sudah dikonfirmasi
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}