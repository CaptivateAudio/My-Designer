@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="row">
                    <div class="col-md-8"><div class="panel-heading"><h1>Packages</h1></div></div>
                    <div class="col-md-4"><p class="text-right"><a href="{{ route('admin.packages.create') }}" class="btn btn-primary">Add New Package</a></p></div>
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
                                        $team = $package->teams()->where('package_id', $package->id)->first();
                                        if( $team != null ):
                                            echo $team->team_name;
                                        endif
                                    @endphp
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
@endsection
