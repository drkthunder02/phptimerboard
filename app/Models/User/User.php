<?php

namespace App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Table Name
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'owner_hash',
        'character_id',
        'expires_in',
        'access_token',
        'user_type',
    ];

    public function getUserType() {
        return User::where('user_type')->get();
    }

    public function role() {
        return $this->hasOne('\App\Models\User\UserRole', 'character_id', 'character_id');
    }

    public function permissions() {
        return $this->hasMany('\App\Models\User\UserPermission', 'character_id', 'character_id');
    }

    public function esiToken() {
        return $this->hasOne('\App\Models\Esi\EsiToken', 'character_id', 'character_id');
    }

    public function esiScopes() {
        return $this->hasMany('\App\Models\Esi\EsiScope', 'character_id', 'character_id');
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->character_id;
    }

    public function hasPermission($permission) {
        $found = UserPermission::where(['character_id' => $this->character_id, 'permission' => $permission])->count();

        if($found > 0) {
            return true;
        } else {
            return false;
        }

        return false;
    }

    public function hasEsiScope($scope) {
        $found = EsiScope::where(['character_id' => $this->character_id, 'scope' => $scope])->count();

        if($found > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hasSuperUser() {
        $found = UserRole::where(['character_id' => $this->character_id, 'role' => 'SuperUser'])->count();

        if($found > 0 ) {
            return true;
        } else {
            return false;
        }
    }

}
