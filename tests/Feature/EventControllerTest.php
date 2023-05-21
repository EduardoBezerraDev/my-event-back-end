<?php

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    public function testIndex()
    {
        $fakeResponse = [
            [
                "id" => 2,
                "name" => "Evento de programação backend php",
                "start_date" => "2023-05-21",
                "end_date" => "2023-05-23",
                "status" => true
            ]
        ];

        Http::fake([
            'https://demo.ws.itarget.com.br/event.php' => Http::response($fakeResponse),
        ]);

        $response = $this->get('/api/events');

        $response->assertStatus(200)
            ->assertJson($fakeResponse);
    }
}
