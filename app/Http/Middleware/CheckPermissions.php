<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            abort(403, 'Unauthorized action.1');
        }
        // dd($user->role->permission);
        $rolePermissions = json_decode($user->role->permission, true);

        if ($rolePermissions === null) {
            abort(403, 'Unauthorized action.2');
        }

        foreach ($permissions as $permission) {
            if (!in_array($permission, $rolePermissions)) {
                abort(403, 'Unauthorized action.3');
            }
        }

        return $next($request);
    }
}
