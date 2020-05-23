<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use Auth;

use App\Models\User\User;
use App\Models\Esi\EsiScope;
use App\Models\Esi\EsiToken;
use App\Models\User\UserPermission;
use App\Models\User\UserRole;
use App\Models\Admin\AllowedLogin;

use Seat\Eseye\Cache\NullCache;
use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 
                                            'handleProviderCallback', 
                                            'redirectToProvider']);
    }

    /**
     * Logout function
     * 
     * @return void
     */
    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Redirect to the provider's website
     * 
     * @return Socialite
     */
    public function redirectToProvider() {
        return Socialite::driver('eveonline')->redirect();
    }

    /**
     * Get token from callback
     * Redirect to the dashboard if logging in successfully. 
     */
    public function handleProviderCallback() {
        //Get the sso user from the socialite driver
        $ssoUser = Socialite::driver('eveonline')->user();
        if(Auth::check()) {
            //If a refresh token is present, then we are doing a scope callback
            //to update scopes for an access token
            if(isset($ssoUser->refreshToken)) {
                //See if an access token is present already
                $tokenCount = EsiToken::where('character_id', $ssoUser->id)->count();
                if($tokenCount > 0) {
                    //Update the esi token
                    $this->UpdateEsiToken($ssoUser);
                } else {
                    //Save the ESI token
                    $this->SaveEsiToken($ssoUser);
                }
                //After creating the token, we need to update the table for scopes
                $this->SetScopes($ssoUser->user['Scopes'], $ssoUser->id);
                return redirect()->to('/dashboard')->with('success', 'Successfully updated ESI Scopes.');
            } 
        } else {
            $user = $this->createOrGetUser($ssoUser);
            auth()->login($user, true);
            return redirect()->to('/dashboard')->with('success', 'Successfully Logged In.');
        }
    }

     /**
     * Check if a user exists in the database, else, create and 
     * return the user object.
     * 
     * @param \Laravel\Socialite\Two\User $user
     */
    private function createOrGetUser($eve_user) {
        $authUser = null;
        //Search to see if we have a matching user in the database.
        //At this point we don't care about the information
        $userCount = User::where('character_id', $eve_user->id)->count();
        
        //If the user is found, do more checks to see what type of login we are doing
        if($userCount > 0) {
            //Search for user in the database
            $authUser = User::where('character_id', $eve_user->id)->first();
            //Check to see if the owner has changed
            //If the owner has changed, then update their roles and permissions
            if($this->OwnerHasChanged($authUser->owner_hash, $eve_user->owner_hash)) {
                //Get the right role for the user
                $role = $this->GetRole(null, $eve_user->id);
                //Set the role for the user
                $this->SetRole($role, $eve_user->id);
                //Update the user information never the less.
                $this->UpdateUser($eve_user, $role);
                //Update the user's roles and permission
                $this->UpdatePermission($eve_user, $role);
            }
            //Return the user to the calling auth function
            return $authUser;
        } else {
            //Get the role for the character to be stored in the database
            $role = $this->GetRole(null, $eve_user->id);
            //Create the user account
            $user = $this->CreateNewUser($eve_user);
            //Set the role for the user
            $this->SetRole($role, $eve_user->id);
            //Create a user account
            return $user;
        }
    }

    /**
     * Update the ESI Token
     */
    private function UpdateEsiToken($eve_user) {
        EsiToken::where('character_id', $eve_user->id)->update([
            'character_id' => $eve_user->getId(),
            'access_token' => $eve_user->token,
            'refresh_token' => $eve_user->refreshToken,
            'expires_in' => $eve_user->expiresIn,
        ]);
    }

    /**
     * Create a new ESI Token in the database
     */
    private function SaveEsiToken($eve_user) {
        $token = new EsiToken;
        $token->character_id  = $eve_user->id;
        $token->access_token = $eve_user->token;
        $token->refresh_token = $eve_user->refreshToken;
        $token->expires_in = $eve_user->expiresIn;
        $token->save();
    }

    /**
     * Update avatar
     */
    private function UpdateAvatar($eve_user) {
        User::where('character_id', $eve_user->id)->update([
            'avatar' => $eve_user->avatar,
        ]);
    }

    /**
     * Update user permission
     */
    private function UpdatePermission($eve_user, $role) {
        UserPermission::where(['character_id' => $eve_user->id])->delete();
        $perm = new UserPermission();
        $perm->character_id = $eve_user->id;
        $perm->permission = $role;
        $perm->save();
    }

    /**
     * Update the user
     */
    private function UpdateUser($eve_user, $role) {
        User::where('character_id', $eve_user->id)->update([
            'avatar' => $eve_user->avatar,
            'owner_hash' => $eve_user->owner_hash,
            'role' => $role,
        ]);
    }

    /**
     * Create a new user account
     */
    private function CreateNewUser($eve_user) {
        
        $user = User::create([
            'name' => $eve_user->getName(),
            'avatar' => $eve_user->avatar,
            'owner_hash' => $eve_user->owner_hash,
            'character_id' => $eve_user->getId(),
            'expires_in' => $eve_user->expiresIn,
            'access_token' => $eve_user->token,
        ]);

        return $user;
    }

    /**
     * Set the user role in the database
     * 
     * @param role
     * @param charId
     */
    private function SetRole($role, $charId) {
        $permission = new UserRole;
        $permission->character_id = $charId;
        $permission->role = $role;
        $permission->save();
    }
    
    /**
     * Set the user scopes in the database
     * 
     * @param scopes
     * @param charId
     */
    private function SetScopes($scopes, $charId) {
        //Delete the current scopes, so we can add new scopes into the database
        EsiScope::where('character_id', $charId)->delete();
        $scopes = explode(' ', $scopes);
        foreach($scopes as $scope) {
            $data = new EsiScope;
            $data->character_id = $charId;
            $data->scope = $scope;
            $data->save();
        }
    }

    /**
     * Get the current owner hash, and compare it with the new owner hash
     * 
     * @param hash
     * @param charId
     */
    private function OwnerHasChanged($hash, $newHash) {
        if($hash === $newHash) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the account type and returns it
     * 
     * @param refreshToken
     * @param charId
     */
    private function GetRole($refreshToken, $charId) {
        //Set caching to null
        $configuration = Configuration::getInstance();
        $configuration->cache = NullCache::class;

        //Setup the user array
        $haulers = AllowedLogin::where(['login_type' => 'Hauler'])->pluck('entity_id')->toArray();

        // Instantiate a new ESI instance
        $esi = new Eseye();

        //Get the character information
        $character_info = $esi->invoke('get', '/characters/{character_id}/', [
            'character_id' => $charId,
        ]);

        if(isset($character_info->corporation_id)) {
            if(in_array($character_info->corporation_id, $haulers)) {
                $role = 'User';
            } else {
                $role = 'Guest';
            }
        }

        return $role;
    }
}