@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Edit User</h1></div>

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="panel-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}

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

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Role</label>
                            <div class="col-sm-8">
                                <select name="role" class="form-control text-capitalize">
                                    @foreach ( $roles as $role )
                                        <option value="{{ $role->id }}" {{ ( $role->id == $user_role_id->id ) ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Team</label>
                            <div class="col-sm-8">
                                <select name="team" class="form-control">
                                    @if( $user_team_id == null )
                                        @foreach ( $teams as $team )
                                            <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                        @endforeach
                                    @else
                                        @foreach ( $teams as $team )
                                            <option value="{{ $team->id }}" {{ ( $team->id == $user_team_id->id ) ? 'selected' : '' }}>{{ $team->team_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
