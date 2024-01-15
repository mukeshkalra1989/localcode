@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Get the authenticated user --}}
                    <?php $user = auth()->user(); ?>

                    {{-- Get the roles of the user --}}
                    <?php $roles = $user->roles; ?>

                    {{-- Check if the user has a specific role --}}
                    @if ($roles->contains('name', 'Super Admin'))
                        <p>{{ __('You are logged in! as Super Admin') }}</p>
                    @endif

                    @if ($roles->contains('name', 'Admin'))
                        <p>{{ __('You are logged in! as Admin') }}</p>
                    @endif

                    @if ($roles->contains('name', 'User'))
                        <p>{{ __('You are logged in! as User') }}</p>
                    @endif

                    <p>This is your application dashboard.</p>
                    @canany(['create-role', 'edit-role', 'delete-role'])
                        <!--a class="btn btn-primary" href="{{ route('roles.index') }}">
                            <i class="bi bi-person-fill-gear"></i> Manage Roles</a-->
                    @endcanany
                    @canany(['create-user', 'edit-user', 'delete-user'])
                        <!--a class="btn btn-success" href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i> Manage Users</a-->
                    @endcanany
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
