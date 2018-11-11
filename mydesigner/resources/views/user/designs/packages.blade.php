@extends('layouts.admin')

@section('title', 'Packages')

@section('heading')
<div id="admin-content-heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Packages</h2>
            </div>
            <div class="col-md-6 text-right">User > Packages</div>
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

                    <div class="panel-body">
                        <div class="row">
                            @foreach($packages as $package)
                                <div class="col-md-4 mt-4 mb-4">
                                    <div class="card">
                                            <div class="card-header"><strong>{{ $package->package_name }}</strong></div>

                                            <div class="card-body">
                                                <p class="text-center">Price: {{ number_format($package->amount, 2) }}</p>

                                                <p class="text-center">
                                                    <a href="{{ route('user.request.design', $package->id) }}"><button class="btn btn-outline-secondary">Request</button></a>
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>      
                            @endforeach

                            @if($packages->count() == 0)
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
