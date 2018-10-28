@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center mb-4 mt-4">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header"><strong>Welcome to your Dashboard!</strong></div>

                <div class="card-body">

                    <div class="row align-items-center">
                        <div class="col-md-2"><img src="https://placeholdit.co//i/150x150?&bg=cccccc&fc=999999&text=PHOTO"></div>
                        <div class="col-md-10">

                            <h5>Quick Links:</h5>

                            <div class="row">
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ url('/') }}"><i class="fas fa-home"></i> HOME</a>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ url('/account') }}"><i class="fas fa-user"></i> ACCOUNT</a>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> USERS</a>
                                </div>

                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ route('admin.packages.index') }}"><i class="fas fa-box"></i> PACKAGES</a>
                                </div>

                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ url('/designs') }}"><i class="fas fa-paint-brush"></i> DESIGNS</a>
                                </div>

                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ url('/history') }}"><i class="fas fa-clock"></i> HISTORY</a>
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
                <div class="card-header"><strong>Users</strong></div>

                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <div class="row mt-4">
                        <div class="col-md-6"><a href="{{ route('admin.users.create') }}" class="btn btn-outline-secondary btn-sm btn-block"><i class="fas fa-plus"></i> Add New</a></div>
                        <div class="col-md-6"><a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header"><strong>Teams</strong></div>

                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <div class="row mt-4">
                        <div class="col-md-6"><a href="{{ route('admin.teams.create') }}" class="btn btn-outline-secondary btn-sm btn-block"><i class="fas fa-plus"></i> Add New</a></div>
                        <div class="col-md-6"><a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header"><strong>Packages</strong></div>

                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <div class="row mt-4">
                        <div class="col-md-6"><a href="{{ route('admin.packages.create') }}" class="btn btn-outline-secondary btn-sm btn-block"><i class="fas fa-plus"></i> Add New</a></div>
                        <div class="col-md-6"><a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header"><strong>Designs</strong></div>

                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <div class="row mt-4">
                        <div class="col-md-6"><a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm btn-block"> <i class="fas fa-plus"></i> Add New</a></div>
                        <div class="col-md-6"><a href="{{ url('/designs') }}" class="btn btn-outline-secondary btn-sm btn-block">View All</a></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
