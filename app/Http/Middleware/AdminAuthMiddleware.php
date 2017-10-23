<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthMiddleware
{
    protected $except = [
        'admin'
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (\Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        }

        $routeName = \Route::currentRouteName();

        if (\Auth::guard($guard)->user()->isSuperAdmin() || in_array(\URL::getRequest()->path(), $this->except)) {
            return $next($request);
        }

        if (!\Gate::forUser(\Auth::guard($guard)->user())->check($routeName)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return jsonResponse(message('unauthorized'),500);
            } else {
                return jsonResponse(message('no_permission_to_operate'),500);
            }
        }

        return $next($request);
    }
}
