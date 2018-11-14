@extends('layouts.admin')

@section('title', 'Styles')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Styles</h2>
            </div>
            <div class="col-md-6 text-right"><span class="text-capitalize">{{ Auth::user()->roles->first()->role_name }}</span> > Styles</div>
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
                        <div class="col-md-12"><p><a href="" class="btn btn-primary" data-toggle="collapse" data-target="#newStyleForm" aria-expanded="false" aria-controls="newStyleForm">+ Add New</a></p></div>
                    </div>

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

                    <div id="newStyleForm" class="row collapse">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('style.settings.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Style Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="style_name" class="form-control" value="" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Type</label>
                                    <div class="col-sm-8">
                                        <select name="type" id="add_user_styles_type" class="form-control">
                                            <option value="text">Simple Text Value</option>
                                            <option value="url">File Upload</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row collapse" id="file_row">
                                    <label class="col-sm-4 col-form-label">Value</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="value" class="form-control" value="" />
                                    </div>
                                </div>

                                <div class="form-group row collapse" id="filevalue_row">
                                    <label class="col-sm-4 col-form-label">Value</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="filevalue" class="form-control" value="" />
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

                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Style Name</th>
                                    <th>Value</th>
                                    <th>Actions</th>
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
                                    <td>
                                        <a href="{{ route('style.settings.edit', $style->id) }}" class="btn btn-outline-primary">Edit</a>
                                        <form action="{{ route('style.settings.destroy', $style->id) }}" method="POST"
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
                                        <td colspan="4">No styles found.</td>
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
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#add_user_styles_type').on('change', function(){
            if( $(this).val() == 'text' ){
                $('#filevalue_row').removeClass('show');
                $('#file_row').addClass('show');
            }
            else{
                $('#filevalue_row').addClass('show');
                $('#file_row').removeClass('show');
            }
        });

        $('#add_user_styles_type').change();
    });
</script>
@endsection
