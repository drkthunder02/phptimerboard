<?php

namespace App\Http\Middleware;

/**
 * This middleware checks for if a role is required for a page.  If the user has the correct role
 * then the middleware proceeds to the page, otherwise the middleware returns a 403 forbidden error
 * to the user.
 * 
 * Example:
 * $this->middleware('role:aRole')
 */

//Internal Libraries
use Closure;

//Models
use App\Models\User\UserRole;

class RequireRole
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
        $confirmed = false;
        $ranking = [
            'None' => 0,
            'Guest' => 1,
            'User' => 2,
            'Admin' => 3,
            'SuperUser' => 4,
        ];
        
        $check = UserRole::where('character_id', auth()->user()->character_id)->get(['role']);

        if(!isset($check[0]->role)) {
            abort(403, "You don't any roles.  You don't belong here.");
        }
        
        if($ranking[$check[0]->role] < $ranking[$role]) {
            abort(403, "You don't have the correct role to be in this area.");
        }
        
        return $next($request);
    }
}
