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
                // Filter for email
                if (!empty($request->get('email'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['email'], $request->get('email')) ? true : false;
                    });
                }

                // Filter for Phone number
                if (!empty($request->get('phone'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['phone_number'], $request->get('phone')) ? true : false;
                    });
                }

                // Filter for Contact name
                if (!empty($request->get('contact_name'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        $contact_name =  Str::lower($row['first_name']. ' '.$row['last_name']);
                        return Str::contains($contact_name,  Str::lower($request->get('contact_name'))) ? true : false;
                    });
                }
                
                // Filter for custom fields
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        $contact_name =  Str::lower($row['first_name']. ' '.$row['last_name']);
                        
                        if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))){
                            return true;
                        } else if (Str::contains($contact_name, Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains($row['phone_number'], Str::lower($request->get('search')))) {
                            return true;
                        }

                        return false;
                    });
                }
            })
            ->addColumn('name', function($row){               
                return $row['first_name']. ' '.$row['last_name'];
            })
            ->addColumn('action', function($row){
                $rowid = $row['id'];
                $viewbtn = '<a href="'. route("contact.show", ["contact" => $rowid]).'" class="view btn btn-primary btn-sm">View</a>';
                $editbtn = '<a href="'. route("contact.edit", ["contact" => $rowid]).'" class="edit btn btn-primary btn-sm">Edit</a>';
                return $viewbtn. ' '.$editbtn;
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
       // Log::info('This is an informational message.');
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
            // Check contact already exists or not
            $dataOb[0] = $data['first_name'];
            $dataOb[1] = $data['last_name'];
            $dataOb[2] = $data['phone_number'];
            $dataOb[3] = $data['email'];
                       
            Contact::create($data);          
            
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
        try {
            $data = Contact::where('id', $id)->first();
        
            if (!$data) {
                return redirect()->route('contact.index')->with('error', 'Something went wrong');
            }
        
            return view('contact.show', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route('contact.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = Contact::where('id', $id)->first();
        
            if (!$data) {
                return redirect()->route('contact.index')->with('error', 'Something went wrong');
            }
        
            return view('contact.edit', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route('contact.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, string $id)
    {
        $data = $request->all();
       
        // Remove the _token key from the array
        $data = collect($data)->except('_token')->all();

        try {
            
            $data['updated_at'] = Carbon::now();
           
            // Find the contact by ID
            $contact = Contact::findOrFail($id);
            
            $contact->update($data);
            
            return redirect()->route('contact.index')->with('success', 'Contact updated successfully!');
        } catch (\Exception $e) {
            // Handle the exception    
            // Log the exception
            //\Log::error($e);            
            return redirect()->route('contact.index')->with('error', 'An error occurred while storing data.');
        }
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
                $success_count = 0;
                $error_count = 0;
                foreach ($fileContents as $line) {
                    if($row_count != 0) {
                        $data = str_getcsv($line);

                        //check data already exists or not
                        $check = $this->checkcontact(Auth::id(), $data);

                        if($check == 0) {
                            $dataObj = [
                                'user_id' => Auth::id(),
                                'first_name' => $data[0],
                                'last_name' => $data[1],
                                'phone_number' => $data[2],
                                'email' => $data[3],
                                'street_address' => $data[4],
                                'city' => $data[5],
                                'state' => $data[6],
                                'zip_code' => $data[7],
                                'date_of_birth' => Carbon::createFromFormat('m/d/Y', $data[8])->toDateString(),
                                'created_at' =>Carbon::now(),
                            ];
                            $csvData[] = $dataObj;
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                    }
                    $row_count++;
                }
                
                
                // Process the $csvData array as needed
                Contact::insert($csvData);

                $error_msg = '';
                if($error_count > 0) {
                    $error_msg = $error_count .' Unsuccessfully. because contact already exists!';
                }

                if($success_count == 0) {
                    return redirect()->route('contact.index')->with('error', $error_msg);                
                }
                return redirect()->route('contact.index')->with('success', $success_count. ' contacts uploaded successfully!.'. $error_msg);
            }

            return redirect()->route('contact.index')->with('error', 'File upload failed.');
        } catch (\Exception $e) {                       
            return redirect()->route('contact.index')->with('error',  'Error processing the CSV file: ' . $e->getMessage());
        }
    }

    // Check contact already exist
    public function checkcontact($user_id, $data) {
        return Contact::where('user_id', Auth::id())
         ->where(function ($query) use ($data) {
             $query->orWhere('first_name', $data[0])
                 ->orWhere('last_name', $data[1])
                 ->orWhere('phone_number', $data[2])
                 ->orWhere('email', $data[3]);
         })
         ->count('id');
    }


}
