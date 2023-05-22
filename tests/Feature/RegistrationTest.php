<?php

use Tests\TestCase;
use App\Models\RegistrationModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
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

    public function testFilter()
    {
        $registrationModel = new RegistrationModel();
        $registrationModel->createRegistration([
            'event' => 1,
            'start_date' => '2023-05-20',
            'end_date' => '2023-05-21',
            'name' => 'John Doe',
            'cpf' => '12345678910',
            'email' => 'johndoe@example.com',
        ]);

        $registrationModel->createRegistration([
            'event' => 1,
            'start_date' => '2023-05-22',
            'end_date' => '2023-05-23',
            'name' => 'Jane Smith',
            'cpf' => '9876543210',
            'email' => 'janesmith@example.com',
        ]);

        $registrationModel->createRegistration([
            'event' => 2,
            'start_date' => '2023-05-25',
            'end_date' => '2023-05-26',
            'name' => 'Alice Johnson',
            'cpf' => '5555555555',
            'email' => 'alicejohnson@example.com',
        ]);

        $request = new Request([
            'column' => 'name',
            'filter' => 'John',
            'eventId' => 1,
        ]);

        $response = $this->call('GET', '/api/registrations', $request->toArray());

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data'); // Verifique o número total de resultados, ajuste para o valor correto

        $responseData = $response->json();
        $this->assertCount(3, $responseData['data']);
    }
}
