<?php

namespace App\Http\Controllers;

use App\Models\FeedTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedTimeController extends Controller
{
    public function getAll() {
        $url = 'http://192.168.100.148:80/arduino'; // Replace with the actual IP and endpoint

        // Define the data to send
        $data =  FeedTime::all();

        // Send the POST request
        Http::post($url, $data);

        return response()->json(['message' => 'Data sent!'], 200);
    }

    public function setTime(string $time) {
        
    }
}
