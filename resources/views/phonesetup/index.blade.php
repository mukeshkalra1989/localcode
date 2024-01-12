@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Phone Setup') }}</div>

                <div class="card-body">
                     @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                     <form method="post" action="/phone-setup">
                        @csrf
                        <div class="form-group">
                            <label for="api_key">TextGrid API Key:</label>
                            <input type="text" name="api_key" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Authenticate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection