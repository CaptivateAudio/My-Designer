@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
@endsection
