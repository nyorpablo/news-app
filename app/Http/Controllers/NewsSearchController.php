<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class NewsSearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $searchTerm = $request->input('searchTerm');
            $apiKey = 'test';
            $apiUrl = "https://content.guardianapis.com/search?q={$searchTerm}&api-key={$apiKey}";

            $client = new Client();
            $response = $client->get($apiUrl);
            $data = json_decode($response->getBody(), true);

            return response()->json($data['response']['results']);
        } catch (Exception $e) {
            // Log the exception for debugging
            \Log::error($e->getMessage());

            // Return a 500 response with an error message
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
