<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

trait EveOAuth {

    protected $user;

    public function login() {
        try {
            return Socialite::driver('eveonline')->redirect();
        } catch(Exception $e) {
            return back();
        }
    }

    public function callback() {
        try {
            $this->user = Socialite::driver('eveonline')->user();
        } catch(InvalidStateException $e) {
            return back();
        }
        return $this->user;
    }

    public function get_character() {
        //Get more detailed character data from CREST
        $httpClient = new Client();
        $url = "https://esi.evetech.net/latest/characters/{$this->user->id}/?datasource=tranquility";
        try {
            $response = $httpClient->get($url);
        } catch (Exception $exception) {
            return abort(504, 'ESI is not reachable, try again late.');
        }
        return json_decode($response->getBody()->getContents());
    }
}

?>
