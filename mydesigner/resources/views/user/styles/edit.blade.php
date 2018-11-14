@extends('layouts.admin')

@section('title', 'Styles')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Edit Style</h2>
            </div>
            <div class="col-md-6 text-right"><span class="text-capitalize">{{ Auth::user()->roles->first()->role_name }}</span> > Styles > Edit</div>
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
                        <form action="{{ route('style.settings.update', $style->id) }}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Style Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="style_name" class="form-control" value="{{ $style->style_name }}" />
                                </div>
                            </div>

                            @if( $style->type == 'text' )
                                <div class="form-group row" id="file_row">
                                    <label class="col-sm-4 col-form-label">Value</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="value" class="form-control" value="{{ $style->value }}" />
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-secondary" href="{{ route('style.settings.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
