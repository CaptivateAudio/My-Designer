@extends('layouts.admin')

@section('title', 'Packages')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Packages</h2>
            </div>
            <div class="col-md-6 text-right">Admin > Packages</div>
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

                    <div class="row mb-4">
                        <div class="col-md-12"><a href="{{ route('admin.packages.create') }}" class="btn btn-primary">+ Add New</a></div>
                    </div>

                    <div class="panel-body">

                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Package Name</th>
                                    <th>Amount</th>
                                    <th>Team</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($packages as $package)
                                <tr>
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->package_name }}</td>
                                    <td>{{ number_format($package->amount, 2) }}</td>
                                    <td>
                                        @php
                                            $assigned_teams = $package->teams()->get()->pluck('team_name')->toArray();
                                        @endphp

                                        @foreach( $assigned_teams as $v )
                                            {{ $v }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-outline-primary">Edit</a>
                                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST"
                                              style="display: inline"
                                              onsubmit="return confirm('Are you sure?');">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No packages found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
