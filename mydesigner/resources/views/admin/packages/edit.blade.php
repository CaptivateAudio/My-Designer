@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Edit Package</h1></div>

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
                    <form action="{{ route('admin.packages.update', $package->id) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Package Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="package_name" class="form-control" value="{{ $package->package_name }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Team</label>
                            <div class="col-sm-8">
                                @foreach ( $teams as $team )
                                    <div class="custom-control custom-checkbox">
                                    @if( in_array($team->id, $assigned_teams) )
                                        <input type="checkbox" name="teams[]" class="custom-control-input" value="{{ $team->id }}" id="team_{{ $team->id }}" checked="checked" /> <label class="custom-control-label" for="team_{{ $team->id }}">{{ $team->team_name }}</label>
                                    @else
                                        <input type="checkbox" name="teams[]" class="custom-control-input" value="{{ $team->id }}" id="team_{{ $team->id }}" /> <label class="custom-control-label" for="team_{{ $team->id }}">{{ $team->team_name }}</label>
                                    @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Amount</label>
                            <div class="col-sm-8">
                                <input type="text" name="amount" class="form-control" value="{{ $package->amount }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-secondary" href="{{ route('admin.packages.index') }}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
