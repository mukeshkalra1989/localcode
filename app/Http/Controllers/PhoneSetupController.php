<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhoneSetupController extends Controller
{
    public function index()
    {
        return view('phonesetup.index');
    }

    public function authenticate(Request $request)
    {
        $apiKey = $request->input('api_key');

        // Add your TextGrid authentication logic here
        $response = Http::get('https://textgrid.example.com/api/authenticate', [
            'api_key' => $apiKey,
        ]);

        if ($response->successful()) {
            // Authentication successful
            // Store the API key in the session or database for future use
            session(['textgrid_api_key' => $apiKey]);

            return redirect('/phone-setup')->with('success', 'TextGrid integration successful!');
        } else {
            // Authentication failed
            return redirect('/phone-setup')->with('error', 'TextGrid integration failed. Please check your API key.');
        }
    }
}
