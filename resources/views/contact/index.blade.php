@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Contacts') }}</div>

                <div class="card-body">
                    <form action="{{ route('uploadcsv') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="file">Choose CSV File:</label>
                        <input type="file" name="file" id="file">
                        <button type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
