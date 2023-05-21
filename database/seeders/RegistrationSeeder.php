<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registration;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        Registration::create([
            'start_date' => '2023-05-22',
            'end_date' => '2023-05-22',
            'event' => 1,
            'name' => 'Eduardo',
            'cpf' => '12345678902',
            'email' => 'joao@example.com',
            'id' => 1,
        ]);

        Registration::create([
            'start_date' => '2023-05-18',
            'end_date' => '2023-05-18',
            'event' => 2,
            'name' => 'Maria',
            'cpf' => '98765432103',
            'email' => 'maria@example.com',
            'id' => 2,
        ]);

        Registration::create([
            'start_date' => '2023-05-22',
            'end_date' => '2023-05-22',
            'event' => 3,
            'name' => 'Pedro',
            'cpf' => '45678912302',
            'email' => 'pedro@example.com',
            'id' => 3,
        ]);
    }
}
