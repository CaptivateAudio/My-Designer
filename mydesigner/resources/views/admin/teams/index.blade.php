@extends('layouts.admin')

@section('title', 'Teams')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Teams</h2>
            </div>
            <div class="col-md-6 text-right">Admin > Teams</div>
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
                        <div class="col-md-12"><a href="{{ route('admin.teams.create') }}" class="btn btn-primary">+ Add New</a></div>
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
                                    <th>Team Name</th>
                                    <th>Users</th>
                                    <th>Packages</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($teams as $team)
                                <tr>
                                    <td>{{ $team->id }}</td>
                                    <td>{{ $team->team_name }}</td>
                                    <td>{{ $team->users()->where('team_id', $team->id)->count() }}</td>
                                    <td>{{ $team->packages()->where('team_id', $team->id)->count() }}</td>
                                    <td>
                                        <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-outline-primary">Edit</a>
                                        <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST"
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
                                        <td colspan="5">No teams found.</td>
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
