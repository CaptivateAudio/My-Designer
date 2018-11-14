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
                                
                                <div class="h3">
                                    @switch($design->status)
                                        @case('request')
                                            <span class="badge badge-secondary text-white"><strong>ID# : {{ $design->id }}</strong> | {{ $design->status }}</span>
                                        @break

                                        @case('in-progress')
                                            <span class="badge badge-info text-white"><strong>ID# : {{ $design->id }}</strong> | {{ $design->status }}</span>
                                        @break

                                        @case('approved')
                                            <span class="badge badge-success text-white"><strong>ID# : {{ $design->id }}</strong> | {{ $design->status }}</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge badge-dark text-white"><strong>ID# : {{ $design->id }}</strong> | {{ $design->status }}</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge badge-light text-white"><strong>ID# : {{ $design->id }}</strong> | {{ $design->status }}</span>
                                        @break

                                        @default
                                            <span class="badge badge-warning text-white"><strong>ID# : {{ $design->id }}</strong> | {{ $design->status }}</span>
                                        @break
                                    @endswitch
                                </div>

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

        <div class="row mt-4 mb-4">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form method="POST" action="{{ route('user.design.feedback.submit', $design->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Message</label>
                            <div class="col-sm-8">
                                <textarea name="comment" rows="4" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Version</label>
                            <div class="col-sm-8">
                                <input type="text" name="version" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Attachment</label>
                            <div class="col-sm-8">
                                <input type="file" name="attachment" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-8">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="feedback-wrap">
            <div class="row">
                <div class="col-md-12">
                    @forelse( $feedback_lists as $feedback )
                        @php
                        $role_name = $feedback->user->roles->first()['role_name'];

                        $commented_by = $feedback->user()->first();
                        @endphp
                        <div class="feedback {{ $role_name }}-feedback">
                            @if( $feedback->status == 'pending')
                                @php $status_class = 'row row-eq-height border border-warning'; @endphp
                            @else
                                @php $status_class = 'row row-eq-height'; @endphp
                            @endif
                            <div class="{{ $status_class }}">
                                <div class="col-md-3 feedback-sender-wrap">
                                    <div class="feedback-sender">
                                        <div class="avatar">
                                            @php
                                                if( ! empty ( $feedback->user()->first()['avatar'] ) ) :
                                                    $avatar_url = URL::to('/').'/uploads/'.$commented_by['id'].'/avatar/'. $commented_by->attachments->first()['filename'];
                                                else :
                                                    $avatar_url = asset('images/user.jpg');
                                                endif;
                                            @endphp

                                            @if( $role_name == 'user' )
                                                <a href="{{ route('user.view', $commented_by['id']) }}"><img src="{{ $avatar_url }}" class="rounded-circle" width="65" height="65"></a>
                                            @else
                                                <img src="{{ $avatar_url }}" class="rounded-circle" width="65" height="65">
                                            @endif
                                        </div>
                                        @if( $role_name == 'user' )
                                            <div class="name"><p><strong><a href="{{ route('user.view', $commented_by['id']) }}">{{ $commented_by['first_name'] }} {{$commented_by['last_name']}}</a></strong></p></div>
                                        @else
                                            <div class="name"><p><strong>{{ $feedback->user()->first()['first_name'] }} {{$feedback->user()->first()['last_name']}}</strong></p></div>
                                        @endif
                                        <p>{{ $role_name }}</p>
                                        <p><small>{{ $feedback->updated_at }}</small></p>
                                    </div>
                                </div>

                                <div class="col-md-9 feedback-content-wrap">
                                    <div class="feedback-content">

                                        @if( $feedback->status == 'pending')
                                            <p><em>Pending approval</em></p>
                                        @endif

                                        @unless( empty( $feedback->version ) )
                                        <p><strong>Version {{ $feedback->version }}</strong></p>
                                        @endunless

                                        <p>@php echo nl2br($feedback->comment) @endphp</p>

                                        @php
                                            $attachments = array();
                                            $attachment_count = $feedback->attachments->count();
                                            if( $attachment_count >= 1 ){
                                                $attachments = $feedback->attachments()->get();
                                            }
                                        @endphp

                                        @forelse( $attachments as $attachment )
                                            <p><a href="{{ URL::to('/') }}/uploads/{{ $commented_by['id'] }}/feedback-attachment/{{ $feedback->attachments->first()['filename'] }}" target="_blank">{{ $attachment['filename_original'] }}</a></p>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
