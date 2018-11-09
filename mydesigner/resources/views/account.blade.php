@extends('layouts.admin')

@section('title', 'Account')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Account</h2>
            </div>
            <div class="col-md-6 text-right"><span class="text-capitalize">{{ Auth::user()->roles->first()->role_name }}</span> > Account</div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div id="admin-content-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Account</div>

                    <div class="card-body">
    					<p>Email: {{ $user->email }}</p>
                    </div>
    				
                </div>

                <p>&nbsp;</p>

                <div class="card">
                    <div class="card-header">Profile</div>

                    <div class="card-body">
                        <p>First Name: {{ $user->first_name }}</p>
                        <p>Last Name: {{ $user->last_name }}</p>
                    </div>
                    
                </div>

                <p>&nbsp;</p>


                <p><a class="btn btn-primary" href="{{ url('/edit-account') }}">{{ __('Edit') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
