@extends('layouts.admin')

@section('title', 'Teams')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Edit Team</h2>
            </div>
            <div class="col-md-6 text-right">Admin > Teams > Edit</div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div id="admin-content-wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
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
                        <form action="{{ route('admin.teams.update', $team->id) }}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Team Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="team_name" class="form-control" value="{{ $team->team_name }}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-secondary" href="{{ route('admin.teams.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
