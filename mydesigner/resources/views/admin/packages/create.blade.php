@extends('layouts.admin')

@section('title', 'Packages')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Add New Package</h2>
            </div>
            <div class="col-md-6 text-right">Admin > Packages > Add New</div>
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
                        <form action="{{ route('admin.packages.store') }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Package Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="package_name" class="form-control" value="" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Team</label>
                                <div class="col-sm-9">
                                    @foreach ( $teams as $team )
                                       <div class="custom-control custom-checkbox"><input type="checkbox" name="teams[]" class="custom-control-input" value="{{ $team->id }}" id="team_{{ $team->id }}" /> <label class="custom-control-label" for="team_{{ $team->id }}">{{ $team->team_name }}</label></div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Amount</label>
                                <div class="col-sm-9">
                                    <input type="text" name="amount" class="form-control" value="" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-secondary" href="{{ route('admin.packages.index') }}">Back To List</a>
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
