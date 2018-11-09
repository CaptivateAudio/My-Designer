@extends('layouts.admin')

@section('title', 'User Styles')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>User Styles</h2>
            </div>
            <div class="col-md-6 text-right">Admin > User Styles > {{ $user->first_name }} {{ $user->last_name }}</div>
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

                    <div class="row">
                        <div class="col-md-8"><div class="panel-heading"><h3><small class="text-muted">{{ $user->id }} - {{ $user->first_name }} {{ $user->last_name }}</small></h3></div></div>
                        {{-- <div class="col-md-4"><p class="text-right"><a href="" class="btn btn-primary">Add New Style</a></p></div> --}}
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
                                    <th>Style Name</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($styles as $style)
                                <tr>
                                    <td>{{ $style->id }}</td>
                                    <td>{{ $style->style_name }}</td>
                                    <td>
                                    @if( $style->type == 'text' )
                                        {{ $style->value }}
                                    @else
                                        <a href="{{ URL::to('/') }}/uploads/{{ $current_user_id }}/styles/{{ $style->attachments->first()['filename'] }}" target="_blank">{{ $style->value }}</a>
                                    @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No styles found.</td>
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
