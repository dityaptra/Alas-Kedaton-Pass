<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            [
                'name'         => 'Asing Dewasa',
                'category'     => 'asing',
                'visitor_type' => 'dewasa',
                'description'  => 'Tiket masuk untuk wisatawan mancanegara dewasa.',
                'price'        => 30000,
            ],
            [
                'name'         => 'Asing Anak',
                'category'     => 'asing',
                'visitor_type' => 'anak',
                'description'  => 'Tiket masuk untuk wisatawan mancanegara anak-anak.',
                'price'        => 20000,
            ],
            [
                'name'         => 'Domestik Dewasa',
                'category'     => 'domestik',
                'visitor_type' => 'dewasa',
                'description'  => 'Tiket masuk untuk wisatawan nusantara dewasa.',
                'price'        => 20000,
            ],
            [
                'name'         => 'Domestik Anak',
                'category'     => 'domestik',
                'visitor_type' => 'anak',
                'description'  => 'Tiket masuk untuk wisatawan nusantara anak-anak.',
                'price'        => 15000,
            ],
            [
                'name'         => 'Lokal/Bali',
                'category'     => 'lokal',
                'visitor_type' => null,
                'description'  => 'Tiket masuk untuk warga Bali (KTP Bali).',
                'price'        => 10000,
            ],
        ];

        foreach ($tickets as $ticket) {
            TicketType::create([...$ticket, 'is_active' => true]);
        }
    }
}