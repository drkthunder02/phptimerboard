<?php

namespace App\Http\Controllers\Auth;

//Internal Library
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Socialite;
use Auth;

//Models
use App\Models\User\User;
use App\Models\Esi\EsiScope;
use App\Models\Esi\EsiToken;

class EsiScopeController extends Controller
{
    /**
     * Constructor function to setup middleware needed for access
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:User');
    }

    /**
     * Displays a page to allow user to select scopes.
     * 
     * This function needs some work before being ready for the base repo, but leaving it in so people can see how I do it.
     */
    public function displayScopes() {
        //Get the ESI Scopes for the user
        $scopes = EsiScope::where(['character_id' => Auth::user()->character_id])->get();

        //Return the view for the user
        return view('scopes.select')->with('scopes', $scopes);
    }

    public function redirectToProvider(Request $request) {
        //Redirect to the socialite provider
        return Socialite::driver('eveonline')->setScopes($request->scopes)->redirect();
    }
}