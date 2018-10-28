@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="row">
                    <div class="col-md-8"><div class="panel-heading"><h1>Users</h1></div></div>
                    <div class="col-md-4"><p class="text-right"><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a></p></div>
                </div>

                <div class="panel-body">

                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table id="usersTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Team</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles()->where('user_id', $user->id)->first()->role_name }}</td>
                                <td>
                                    @php
                                        $team = $user->teams()->where('user_id', $user->id)->first();
                                        if( $team != null ):
                                            echo $team->team_name;
                                        endif
                                    @endphp
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
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
                                    <td colspan="6">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready( function () {
    jQuery('#usersTable').DataTable();
} );
</script>

@endsection
