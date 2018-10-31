@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="row">
                    <div class="col-md-8"><div class="panel-heading"><h1>My Styles</h1></div></div>
                    <div class="col-md-4"><p class="text-right"><a href="" class="btn btn-primary" data-toggle="collapse" data-target="#newStyleForm" aria-expanded="false" aria-controls="newStyleForm">Add New Style</a></p></div>
                </div>

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
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
                                    <select name="type" class="form-control">
                                        <option value="text">Simple Text Value</option>
                                        <option value="url">File Upload</option>
                                    </select>
                                </div>
                            </div>

                            {{-- 
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Value</label>
                                <div class="col-sm-8">
                                    <input type="text" name="value" class="form-control" value="" />
                                </div>
                            </div>
                             --}}

                            <div class="form-group row">
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
                                <td>{{ $style->value }}</td>
                                <td></td>
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
@endsection
