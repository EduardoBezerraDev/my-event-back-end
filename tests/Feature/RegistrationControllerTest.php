<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Registration;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreValidationFails()
    {
        $response = $this->post('/api/registrations', []);

        $response
            ->assertStatus(422)
            ->assertJson([
                'event' => ['The event field is required.'],
                'startDate' => ['The start date field is required.'],
                'endDate' => ['The end date field is required.'],
                'name' => ['The name field is required.'],
                'cpf' => ['The cpf field is required.'],
                'email' => ['The email field is required.'],
            ]);
    }

    public function testStoreSuccess()
    {
        $requestData = [
            'event' => 1,
            'startDate' => '2023-05-20',
            'endDate' => '2023-05-21',
            'name' => 'John Doe',
            'cpf' => '12345678910',
            'email' => 'johndoe@example.com',
        ];

        $response = $this->post('/api/registrations', $requestData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Inscrição realizada com sucesso.',
            ]);

        $this->assertDatabaseHas('registrations', [
            'event' => 1,
            'name' => 'John Doe',
            'cpf' => '12345678910',
            'email' => 'johndoe@example.com',
        ]);
    }

    public function testFilterRegistrations()
    {
        $registrations = [
            [
                'event' => 1,
                'start_date' => '2023-05-20',
                'end_date' => '2023-05-21',
                'name' => 'John Doe',
                'cpf' => '12345678910',
                'email' => 'johndoe@example.com',
            ]
        ];

        foreach ($registrations as $registrationData) {
            Registration::create($registrationData);
        }

        $response = $this->get('/api/registrations?event=1');

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
