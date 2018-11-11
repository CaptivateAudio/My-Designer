@extends('layouts.admin')

@section('title', 'Design Request')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Design Request</h2>
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

                                <strong>{{ $design->id }}</strong>
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
                                <br>
                                @php
                                $user = $design->users()->wherePivot('type', 'user');
                                @endphp
                                @if( $user->count() )
                                    @php
                                        $user_account = $user->first()
                                    @endphp
                                    
                                    <p>Requested By: {{ $user_account->first_name }} {{ $user_account->last_name }}</p>
                                @endif

                                @php
                                $manager = $design->users()->wherePivot('type', 'manager');
                                @endphp
                                @if( $manager->count() )
                                    @php
                                        $manager_account = $manager->first()
                                    @endphp
                                    
                                    <p>Managed By: {{ $manager_account->first_name }} {{ $manager_account->last_name }}</p>
                                @endif

                                <p>Completion Date: 
                                @if( $design->completion_date )
                                    {{ $design->completion_date }}
                                @else
                                    n/a
                                @endif
                                </p>

                                @if( !empty( $design->details ) )
                                <p>@php echo nl2br($design->details) @endphp</p>
                                @endif
                            </div>      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
