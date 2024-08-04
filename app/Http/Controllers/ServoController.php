<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServoController extends Controller
{
    public function setLevel(Request $request, $level) {

        $levels = Level::where('is_active', 1)->get();
        foreach($levels as $levelRecord) {
            $levelRecord->is_active = 0;
            $levelRecord->save();
        }

        $level = Level::where('level', $level)->get();
        $level[0]->is_active = 1;
        $level[0]->save();

        $url = 'http://192.168.100.148:80/arduino/setlevel';
        $data = [
            'set' => 'level:' . $level[0]->level
        ];
    
        // Prepare the data string for the HTTP request
        $content = json_encode($data);
    
        // Parse the URL to get the host and path
        $urlParts = parse_url($url);
        $host = $urlParts['host'];
        $path = $urlParts['path'];
        $port = $urlParts['port'] ?? 80;  // Default to port 80 if not specified
    
        // Create the HTTP headers
        $headers = "POST $path HTTP/1.1\r\n";
        $headers .= "Host: $host\r\n";
        $headers .= "Content-Type: application/json\r\n";
        $headers .= "Content-Length: " . strlen($content) . "\r\n";
        $headers .= "Connection: close\r\n\r\n";
        $headers .= $content;
    
        // Set a timeout for the socket connection
        $timeout = 2;  // 2 seconds timeout
    
        // Open a socket connection to the server
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
    
        if ($fp) {
            // Set the socket to non-blocking mode
            stream_set_blocking($fp, 0);
    
            // Send the HTTP request headers
            fwrite($fp, $headers);
    
            // Close the connection immediately
            fclose($fp);
    
            Log::info('Request sent successfully');
        } else {
            Log::error('Failed to send request', ['error' => "$errstr ($errno)"]);
        }
    
        // Immediately return a response without waiting for the request to complete
        return response()->json(['message' => 'Data sent!'], 200);
    }

    public function open(Request $request) {
        $url = 'http://192.168.100.148:80/arduino/open';
        $data = [
            'command' => 'command:open'
        ];
    
        // Prepare the data string for the HTTP request
        $content = json_encode($data);
    
        // Parse the URL to get the host and path
        $urlParts = parse_url($url);
        $host = $urlParts['host'];
        $path = $urlParts['path'];
        $port = $urlParts['port'] ?? 80;  // Default to port 80 if not specified
    
        // Create the HTTP headers
        $headers = "POST $path HTTP/1.1\r\n";
        $headers .= "Host: $host\r\n";
        $headers .= "Content-Type: application/json\r\n";
        $headers .= "Content-Length: " . strlen($content) . "\r\n";
        $headers .= "Connection: close\r\n\r\n";
        $headers .= $content;
    
        // Set a timeout for the socket connection
        $timeout = 2;  // 2 seconds timeout
    
        // Open a socket connection to the server
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
    
        if ($fp) {
            // Set the socket to non-blocking mode
            stream_set_blocking($fp, 0);
    
            // Send the HTTP request headers
            fwrite($fp, $headers);
    
            // Close the connection immediately
            fclose($fp);
    
            Log::info('Request sent successfully');
        } else {
            Log::error('Failed to send request', ['error' => "$errstr ($errno)"]);
        }
    
        // Immediately return a response without waiting for the request to complete
        return response()->json(['message' => 'Data sent!'], 200);
    }
}
