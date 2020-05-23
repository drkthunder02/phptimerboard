<?php

namespace App\Library\Esi;

//Internal Libraries
use DB;
use Carbon\Carbon;

//Models
use App\Models\Esi\EsiToken;
use App\Models\Esi\EsiScope;
use App\Models\Jobs\JobSendEveMail;
use App\Models\Mail\EveMail;

//Seat Stuff
use Seat\Eseye\Cache\NullCache;
use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;
use Seat\Eseye\Exceptions\RequestFailedException;

/**
 * This class represents a few ESI helper functions for the program
 */
class Esi {
    /**
     * Check if a scope is in the database for a particular character
     * 
     * @param charId
     * @param scope
     * 
     * @return true,false
     */
    public function HaveEsiScope($charId, $scope) {
        //Get the esi config
        $config = config('esi');
        //Check for an esi scope
        $check = EsiScope::where(['character_id' => $charId, 'scope' => $scope])->count();
        if($check == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function DecodeDate($date) {
        //Find the end of the date
        $dateEnd = strpos($date, "T");
        //Split the string up into date and time
        $dateArr = str_split($date, $dateEnd);
        //Trim the T and Z from the end of the second item in the array
        $dateArr[1] = ltrim($dateArr[1], "T");
        $dateArr[1] = rtrim($dateArr[1], "Z");
        //Combine the date
        $realDate = $dateArr[0] . " " . $dateArr[1];
        //Return the combined date in the correct format
        return $realDate;
    }

    public function GetRefreshToken($charId) {
        //Get the refresh token from the database
        $tokenCount = EsiToken::where([
            'character_id' => $charId,
        ])->count();
        //If the token is not found, then don't return it.
        if($tokenCount == 0) {
            return null;
        }
        $token = EsiToken::where([
            'character_id' => $charId,
        ])->first();
        return $token->refresh_token;
    }
    
    public function SetupEsiAuthentication($token = null) {
        //Get the platform configuration
        $config = config('esi');
        //Declare some variables
        $authentication = null;
        if($token === null) {
            $authentication = new EsiAuthentication([
                'client_id' => $config['client_id'],
                'secret' => $config['secret'],
            ]);
        } else {
            $authentication = new EsiAuthentication([
                'client_id' => $config['client_id'],
                'secret' => $config['secret'],
                'refresh_token' => $token,
            ]);
        }
        //Setup the esi variable
        $esi = new Eseye($authentication);
        //Return the created variable
        return $esi;
    }
}
?>