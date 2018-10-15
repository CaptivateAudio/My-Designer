<?php

namespace MyDesigner\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roles = explode('|', $role);
        if (! $request->user()->hasAnyRole($roles)) {
            abort(404, 'This action is unauthorized.');
        }
        return $next($request);
    }
}
