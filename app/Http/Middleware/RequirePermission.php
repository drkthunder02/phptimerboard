<?php

namespace App\Http\Middleware;

/**
 * This middleware checks if a user has a certain permission set by te program.
 * If the user has the correct permission it allows, them onto the page, and if the user doesn't then
 * the middleware returns a 403 error.
 * 
 * Example:
 * $this->middleware('permission:aPermission')
 */

//Internal Library
use Closure;

//Models
use App\Models\User\UserPermission;

class RequirePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $perms = UserPermission::where(['character_id' => auth()->user()->character_id, 'permission'=> $permission])->get(['permission']);

        abort_unless(auth()->check() && isset($perms[0]->permission), 403, "You don't have the correct permission to be in this area.");

        return $next($request);
    }
}
