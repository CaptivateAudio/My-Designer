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

                    @php
                        $in_progress_count = Auth::user()->designs()->where('status', 'in-progress')->count();
                    @endphp
                    @if( $in_progress_count >= 3 )
                        <div class="alert alert-info" role="alert">
                            <p>You already have {{ $in_progress_count }} in-progress design requests. Please complete it to pick more designs.</p>
                        </div>
                    @endif

                    <div class="panel-body">
                        <div class="row">
                            @foreach($designs as $design)
                                <div class="col-md-4 mt-4 mb-4">
                                    <div class="card">
                                        <div class="card-header"><strong>{{ $design->id }} | {{ $design->package_name }}</strong>
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

                                            @if( !empty( $design->details ) )
                                            <p>@php echo nl2br($design->details) @endphp</p>
                                            @endif


                                            <p class="text-center">
                                                @if( $in_progress_count >= 3 )
                                                    <p><button class="btn btn-outline-primary" disabled="disabled">Pick Design</button></p>
                                                @else
                                                    <form action="{{ route('designer.assign.designs.request', $design->id) }}" method="post" style="display: inline"
                                                          onsubmit="return confirm('Pick Up Design?');">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <p>Set Completion Date: <input type="date" name="completion_date"></p>
                                                        <p><button class="btn btn-outline-primary">Pick Design</button></p>
                                                    </form>
                                                @endif
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
