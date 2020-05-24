<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('role:Admin');
    }

    public function displayDashboard() {

    }

    public function displayAddAlliance() {

    }

    public function displayAddCorporation() {

    }

    public function displayAddCharacter() {

    }

    public function displayRemoveAlliance() {

    }

    public function displayRemoveCorporation() {

    }

    public function displayRemoveCharacter() {
        
    }

    public function displayModifyPermissions() {

    }

    public function modifyPermissions() {
        
    }
}
