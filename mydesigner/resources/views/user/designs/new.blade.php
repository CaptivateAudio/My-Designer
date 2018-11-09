@extends('layouts.admin')

@section('title', 'Design Request')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Design Request | {{ $package->package_name }}</h2>
            </div>
            <div class="col-md-6 text-right">User > Design Request</div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('design.store') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="package_id" class="form-control" value="{{ $package->id }}" />

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Price</label>
                                        <div class="col-sm-9">
                                            {{ number_format($package->amount, 2) }}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Details</label>
                                        <div class="col-sm-9">
                                            <textarea name="details" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
