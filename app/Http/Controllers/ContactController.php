<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Contact;
use Carbon\Carbon;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        return view('contact.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /***
     * Upload contacts via CSV
     */
    public function uploadcsv(Request $request)
    {
        try {
            // Validate that the uploaded file is a CSV file
            $request->validate([
                'file' => 'required|mimes:csv,txt|max:2048',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileContents = file($file->getPathname());

                $csvData = [];
                $row_count = 0;
                foreach ($fileContents as $line) {
                    if($row_count != 0) {
                        $data = str_getcsv($line);
                        $dataObj = [
                            'user_id' => Auth::id(),
                            'name' => $data[0],
                            'phone_number' => $data[1],
                            'email' => $data[2],
                            'street_address' => $data[3],
                            'city' => $data[4],
                            'state' => $data[5],
                            'zip_code' => $data[6],
                            'date_of_birth' => Carbon::createFromFormat('m/d/Y', $data[7])->toDateString(),
                            'created_at' =>Carbon::now(),
                        ];
                        $csvData[] = $dataObj;
                    }
                    $row_count++;
                }
                
                
                // Process the $csvData array as needed
                Contact::insert($csvData);
               
                return redirect('/contact')->with('success', 'File uploaded successfully!');
            }

            return redirect('/contact')->with('error', 'File upload failed.');
        } catch (\Exception $e) {
           
            // Handle exceptions, log errors, and provide appropriate feedback to the user
            return redirect('/contact')->with('error', 'Error processing the CSV file: ' . $e->getMessage());
        }
    }


}
