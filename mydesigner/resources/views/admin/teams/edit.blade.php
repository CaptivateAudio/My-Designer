@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Edit Team</h1></div>

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
@endsection
