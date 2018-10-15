@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('account.update') }}">
                    @csrf
                    {{ method_field('patch') }}

                    <div class="card">
                        <div class="card-header">Edit Account</div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">New Password <i>(Optional)</i></label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Confrim New Password</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password_confirmation" class="form-control" />
                                </div>
                            </div>

                        </div>
        				
                    </div>

                    <p>&nbsp;</p>

                    <div class="card">
                        <div class="card-header">Edit Profile</div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">First Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Last Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" />
                                </div>
                            </div>

                        </div>
                        
                    </div>

                    <p>&nbsp;</p>


                    <p><button class="btn btn-primary" type="submit">Save Changes</button></p>

                </form>
        </div>
    </div>
</div>
@endsection
