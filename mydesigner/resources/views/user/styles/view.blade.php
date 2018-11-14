@extends('layouts.admin')

@section('title', 'Account')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>View User Styles</h2>
            </div>
            <div class="col-md-6 text-right"><span class="text-capitalize">{{ Auth::user()->roles->first()->role_name }}</span> > Account</div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div id="admin-content-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profile</div>

                    <div class="card-body">
                        <p>
                            @php
                                if( ! empty ($user->avatar ) ) :
                                    $avatar_url = URL::to('/').'/uploads/'.$user->id.'/avatar/'. $user->attachments->first()['filename'];
                                else :
                                    $avatar_url = asset('images/user.jpg');
                                endif;
                            @endphp
                            <img class="img-fluid" src="{{ $avatar_url }}" width="150" height="150">
                        </p>
                        <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                    
                </div>

                <p>&nbsp;</p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Style Name</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($styles as $style)
                        <tr>
                            <td>{{ $style->style_name }}</td>
                            <td>
                            @if( $style->type == 'text' )
                                {{ $style->value }}
                            @else
                                <a href="{{ URL::to('/') }}/uploads/{{ $user->id }}/styles/{{ $style->attachments->first()['filename'] }}" target="_blank">{{ $style->value }}</a>
                            @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="2">No styles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div>
@endsection
