<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    public function index()
    {
        $response = Http::get('https://demo.ws.itarget.com.br/event.php');

        $events = $response->json();

        return response()->json($events);
    }
}
