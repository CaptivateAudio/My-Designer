@extends('layouts.admin')

@section('title', 'Design Requests')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Design Requests</h2>
            </div>
            <div class="col-md-6 text-right">Admin > Design Requests</div>
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

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>Amount</th>
                                <th>Manager</th>
                                <th>Designer</th>
                                <th>User</th>
                                <th>Completion Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($designs as $design)
                            <tr>
                                <td>{{ $design->id }}</td>
                                <td>{{ $design->package_name }}</td>
                                <td>{{ number_format($design->amount, 2) }}</td>

                                <td>
                                @php
                                $designer = $design->users()->wherePivot('type', 'designer');
                                @endphp
                                @if( $designer->count() )
                                    @php
                                        $designer_account = $designer->first()
                                    @endphp
                                    
                                    {{ $designer_account->first_name }} {{ $designer_account->last_name }}
                                @endif
                                </td>

                                <td>
                                @php
                                $manager = $design->users()->wherePivot('type', 'manager');
                                @endphp
                                @if( $manager->count() )
                                    @php
                                        $manager_account = $manager->first()
                                    @endphp
                                    
                                    {{ $manager_account->first_name }} {{ $manager_account->last_name }}
                                @endif
                                </td>

                                <td>
                                @php
                                $user = $design->users()->wherePivot('type', 'user');
                                @endphp
                                @if( $user->count() )
                                    @php
                                        $user_account = $user->first()
                                    @endphp
                                    
                                    {{ $user_account->first_name }} {{ $user_account->last_name }}
                                @endif
                                </td>

                                <td>{{ $design->completion_date }}</td>

                                @switch($design->status)
                                    @case('request')
                                        <td class="h3"><span class="badge badge-secondary">{{ $design->status }}</span></td>
                                    @break

                                    @case('in-progress')
                                        <td class="h3"><span class="badge badge-info">{{ $design->status }}</span></td>
                                    @break

                                    @case('approved')
                                        <td class="h3"><span class="badge badge-success">{{ $design->status }}</span></td>
                                    @break

                                    @case('rejected')
                                        <td class="h3"><span class="badge badge-dark">{{ $design->status }}</span></td>
                                    @break

                                    @case('cancelled')
                                        <td class="h3"><span class="badge badge-light">{{ $design->status }}</span></td>
                                    @break

                                    @default
                                        <td class="h3"><span class="badge badge-warning">{{ $design->status }}</span></td>
                                    @break
                                @endswitch

                                <td><a href="{{ route('admin.designs.requests.view', $design->id) }}" class="btn btn-outline-primary">View</a></td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9">No design requests found.</td>
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
