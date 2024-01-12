<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Contact;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Str;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = Auth::id();
        if ($request->ajax()) {           
            $data = Contact::where('user_id',$user_id)->orderby('id','desc')->latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('email'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['email'], $request->get('email')) ? true : false;
                    });
                }

                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))){
                            return true;
                        }else if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                            return true;
                        }

                        return false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('contact.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('This is an informational message.');
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $data = $request->all();
        // Remove the _token key from the array
        $data = collect($data)->except('_token')->all();

        try {
            $data['user_id'] = Auth::id();           
            $data['created_at'] = Carbon::now();
           
            Contact::create($data);
            
            // Log an info message
            Log::info('This is an informational message.');
            // Log an error message with additional context
            Log::error('An error occurred.', ['user_id' => 1, 'context' => 'Some additional information']);

            return redirect()->route('contact.index')->with('success', 'New contact added successfully!');
        } catch (\Exception $e) {
            // Handle the exception    
            // Log the exception
            //\Log::error($e);            
            return redirect()->route('contact.index')->with('error', 'An error occurred while storing data.');
        }
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
                
                return redirect()->route('contact.index')->with('success', $row_count. ' contacts uploaded successfully!');
            }

            return redirect()->route('contact.index')->with('error', 'File upload failed.');
        } catch (\Exception $e) {                       
            return redirect()->route('contact.index')->with('error',  'Error processing the CSV file: ' . $e->getMessage());
        }
    }


}
