<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class EventModel
{
    public function getAllEvents()
    {
        $response = Http::get('https://demo.ws.itarget.com.br/event.php');

        return $response->json();
    }
}
