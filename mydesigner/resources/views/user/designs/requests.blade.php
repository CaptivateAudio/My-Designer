@extends('layouts.admin')

@section('title', 'Design Requests')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Design Requests</h2>
            </div>
            <div class="col-md-6 text-right">User > Design Requests</div>
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
                            @foreach($designs as $design)
                                <div class="col-md-4 mt-4 mb-4">
                                    <div class="card">
                                        <div class="card-header"><strong>{{ $design->id }} | {{ $design->package()->first()->package_name }}</strong>
                                            <div class="h2 float-right">
                                                @switch($design->status)
                                                    @case('request')
                                                        <span class="badge badge-secondary">{{ $design->status }}</span>
                                                    @break

                                                    @case('in-progress')
                                                        <span class="badge badge-info">{{ $design->status }}</span>
                                                    @break

                                                    @case('approved')
                                                        <span class="badge badge-success">{{ $design->status }}</span>
                                                    @break

                                                    @case('rejected')
                                                        <span class="badge badge-dark">{{ $design->status }}</span>
                                                    @break

                                                    @case('cancelled')
                                                        <span class="badge badge-light">{{ $design->status }}</span>
                                                    @break

                                                    @default
                                                        <span class="badge badge-warning">{{ $design->status }}</span>
                                                    @break
                                                @endswitch
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <p>{{ $design->details }}</p>
                                            <p>{{ $design->completion_date }}</p>
                                            <p class="text-center">
                                                <a href="{{ route('user.designs.requests.view', $design->id) }}"><button class="btn btn-outline-secondary">View Design Request</button></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>      
                            @endforeach

                            @if($designs->count() == 0)
                                <div class="col-md-12">
                                    No results found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
