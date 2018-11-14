@extends('layouts.admin')

@section('title', 'Account Settings')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Account Settings</h2>
            </div>
            <div class="col-md-6 text-right"><span class="text-capitalize">{{ Auth::user()->roles->first()->role_name }}</span> > Account Settings</div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div id="admin-content-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

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

                <form method="post" action="{{ route('account.update') }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('patch') }}

                        <div class="card">
                            <div class="card-header">Edit Account</div>

                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">New Password <i>(Optional)</i></label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Confrim New Password</label>
                                    <div class="col-sm-9">
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
                                    <label class="col-sm-3 col-form-label">Avatar</label>
                                    <div class="col-sm-9">
                                        <p>
                                            @php
                                                if( ! empty ($user->avatar ) ) :
                                                    $avatar_url = URL::to('/').'/uploads/'.$current_user_id.'/avatar/'. $user->attachments->first()['filename'];
                                                else :
                                                    $avatar_url = asset('images/user.jpg');
                                                endif;
                                            @endphp
                                            <img id="user-avatar" class="img-fluid" src="{{ $avatar_url }}" width="150" height="150">
                                        </p>
                                        <p><input id="user-avatar-upload" type="file" name="avatar" class="form-control" value="" /></p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" />
                                    </div>
                                </div>

                            </div>
                            
                        </div>

                        <p>&nbsp;</p>

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                            </div>
                        </div>

                    </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#user-avatar').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#user-avatar-upload").change(function(){ readURL(this); });
    });
</script>
@endsection
