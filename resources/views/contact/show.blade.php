@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('View contact') }}</div>

                <div class="card-body">
                    
                    Conatc Name : {{$data->first_name}} {{$data->last_name}} <br>
                    Email : {{$data->email}} <br>
                    Phone number : {{$data->phone_number}} <br>
                    Street address : {{$data->street_address}} <br>
                    City : {{$data->city}} <br>
                    State : {{$data->state}} <br>
                    Zip Code : {{$data->zip_code}} <br>
                    Date of birth : {{$data->date_of_birth}} <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection