@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit contact') }}</div>

                <div class="card-body">
                    <!-- Add new contact -->
                    <form action="{{ route('contact.update', ['contact' => $data->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <label for="name">First name</label>
                        <input type="text" name="first_name" value="{{$data->first_name ? $data->first_name:''}}"><br><br>
                        <label for="last_name">Last name</label>
                        <input type="text" name="last_name"value="{{$data->last_name ? $data->last_name:''}}"><br><br>
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{$data->email ? $data->email:''}}"><br><br>
                        <label for="phone">Phone number</label>
                        <input type="text" name="phone_number" value="{{$data->phone_number?$data->phone_number:''}}"  oninput="validateNumber(this)"><br><br>
                        <label for="address">Street address</label>
                        <input type="text" name="street_address" value="{{$data->street_address ? $data->street_address:''}}"><br><br>
                        <label for="city">City</label>
                        <input type="text" name="city"value="{{$data->city ? $data->city:''}}"><br><br>
                        <label for="state">State</label>
                        <input type="text" name="state" value="{{$data->state ? $data->state:''}}"><br><br>
                        <label for="zipcode">Zip code</label>
                        <input type="text" name="zip_code" value="{{$data->zip_code ? $data->zip_code:''}}"  oninput="validateNumber(this)"><br><br>
                        <label for="dateofbirth">Date of birth</label>
                        <input type="date" name="date_of_birth" value="{{$data->date_of_birth ? $data->date_of_birth:''}}"><br><br>
                        <button type="submit">Update</button>
                    </form>
                    
                   

                </div>

                
                
            </div>
        </div>
    </div>
</div>
<script>
function validateNumber(input) {
    // Remove non-numeric characters using a regular expression
    input.value = input.value.replace(/[^0-9]/g, '');
}
</script>

@endsection

