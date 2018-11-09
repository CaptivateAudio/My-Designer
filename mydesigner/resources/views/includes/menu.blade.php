@if (!Auth::guest() && Auth::user()->hasRole('admin'))
    @include('includes.menu.admin')
@endif

@if (!Auth::guest() && Auth::user()->hasRole('user'))
    @include('includes.menu.user')
@endif

@if (!Auth::guest() && Auth::user()->hasRole('designer'))
    @include('includes.menu.designer')
@endif

@if (!Auth::guest() && Auth::user()->hasRole('manager'))
    @include('includes.menu.manager')
@endif