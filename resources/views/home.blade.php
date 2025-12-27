@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <h1>Admin Portal</h1>
                    <p>Welcome, {{ auth()->user()->name }}</p>

                    <ul>
                        <li><a href="https://hrmis.local/login/sso">Open HRMIS</a></li>
                        <li><a href="https://fleet.local/login/sso">Open Fleet</a></li>
                        <li><a href="https://stores.local/login/sso">Open Stores</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
