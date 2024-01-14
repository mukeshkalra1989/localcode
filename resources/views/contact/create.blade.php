@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add contact') }}</div>

                <div class="card-body">                   

                    <!-- Add new contact -->
                    <form action="{{ route('contact.store') }}" method="post">
                        @csrf                       
                        <label for="name">First name</label>
                        <input type="text" name="first_name" placeholder="first name" value="{{ old('first_name') }}"><br><br>
                        <label for="last_name">Last name</label>
                        <input type="text" name="last_name" placeholder="last_name" value="{{ old('last_name') }}"><br><br>
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="exampole@example.com" value="{{ old('email') }}"><br><br>
                        <label for="phone">Phone number</label>
                        <input type="text" name="phone_number" placeholder="1234567890" value="{{ old('phone_number') }}" oninput="validateNumber(this)"><br><br>
                        <label for="address">Street address</label>
                        <input type="text" name="street_address" placeholder="contact address" value="{{ old('street_address') }}"><br><br>
                        <label for="city">City</label>
                        <input type="text" name="city" placeholder="city" value="{{ old('city') }}"><br><br>
                        <label for="state">State</label>
                        <input type="text" name="state" placeholder="state" value="{{ old('state') }}"><br><br>
                        <label for="zipcode">Zip code</label>
                        <input type="text" name="zip_code" placeholder="1234" value="{{ old('zip_code') }}" oninput="validateNumber(this)"><br><br>
                        <label for="dateofbirth">Date of birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"><br><br>
                        <button type="submit">Add</button>
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

