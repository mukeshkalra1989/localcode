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
                        <label for="name">Name of contact</label>
                        <input type="text" name="name" placeholder="Name of contact" value="{{ old('name') }}">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="exampole@example.com" value="{{ old('email') }}">
                        <label for="phone">Phone number</label>
                        <input type="text" name="phone_number" placeholder="1234567890" value="{{ old('phone_number') }}">
                        <label for="address">Street address</label>
                        <input type="text" name="street_address" placeholder="contact address" value="{{ old('street_address') }}">
                        <label for="city">City</label>
                        <input type="text" name="city" placeholder="city" value="{{ old('city') }}">
                        <label for="state">State</label>
                        <input type="text" name="state" placeholder="state" value="{{ old('state') }}">
                        <label for="zipcode">Zip code</label>
                        <input type="text" name="zip_code" placeholder="1234" value="{{ old('zip_code') }}">
                        <label for="dateofbirth">Date of birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        <button type="submit">Add</button>
                    </form>
                    
                   

                </div>

                
                
            </div>
        </div>
    </div>
</div>


@endsection

