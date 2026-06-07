@php
$config = [
    'pending'   => 'bg-amber-100 text-amber-700',
    'confirmed' => 'bg-green-100 text-green-700',
    'cancelled' => 'bg-red-100 text-red-700',
    'expired'   => 'bg-stone-100 text-stone-500',
];
$labels = [
    'pending'   => 'Pending',
    'confirmed' => 'Dikonfirmasi',
    'cancelled' => 'Dibatalkan',
    'expired'   => 'Kedaluwarsa',
];
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
             {{ $config[$status] ?? 'bg-stone-100 text-stone-500' }}">
    {{ $labels[$status] ?? $status }}
</span>