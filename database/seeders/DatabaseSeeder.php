<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Registration;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EventSeeder::class,
            RegistrationSeeder::class,
        ]);
    }
}
