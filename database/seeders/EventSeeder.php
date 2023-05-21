<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        Event::create([
            'name' => 'Evento de nodeJs',
            'start_date' => '2023-05-20',
            'end_date' => '2023-05-22',
            'status' => true,
        ]);

        Event::create([
            'name' => 'Evento de React',
            'start_date' => '2023-06-10',
            'end_date' => '2023-06-12',
            'status' => true,
        ]);

        Event::create([
            'name' => 'Evento de PHP',
            'start_date' => '2023-07-05',
            'end_date' => '2023-07-07',
            'status' => false,
        ]);
    }
}
