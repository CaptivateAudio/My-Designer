@extends('layouts.admin')

@section('title', 'Dashboard')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Dashboard</h2>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div id="admin-content-wrap">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header"><strong>Quick Links</strong></div>

                    <div class="card-body">

                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a class="btn btn-primary btn-block" href="{{ url('/') }}"><i class="fas fa-home"></i> HOME</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-primary btn-block" href="{{ route('account.show') }}"><i class="fas fa-user"></i> ACCOUNT</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-primary btn-block" href="{{ route('user.packages.list') }}"><i class="fas fa-palette"></i> PACKAGES</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-primary btn-block" href="{{ route('user.designs.requests') }}"><i class="fas fa-palette"></i> DESIGNS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mb-4 mt-4">
            <div class="col-md-4">

                <div class="card">
                    <div class="card-header"><strong>Designs for Pick-up</strong></div>

                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                        <div class="row mt-4">
                            <div class="col-md-12"><a href="{{ route('user.packages.list') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="card">
                    <div class="card-header"><strong>Ongoing Designs</strong></div>

                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                        <div class="row mt-4">
                            <div class="col-md-12"><a href="{{ route('user.designs.requests') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="card">
                    <div class="card-header"><strong>Design Archive</strong></div>

                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                        <div class="row mt-4">
                            <div class="col-md-12"><a href="{{ route('user.designs.requests') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
