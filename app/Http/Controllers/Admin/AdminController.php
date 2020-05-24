<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('role:Admin');
    }

    public function displayDashboard() {
        return view('dashboard.admin.dashboard');
    }

    public function displayAddEntity() {
        return view('dashboard.admin.addentity');
    }

    public function displayRemoveEntity() {
        return view('dashboard.admin.removeentity');
    }

    public function displayAddPermission() {
        return view('dashboard.admin.addpermission');
    }

    public function displayRemovePermission() {
        return view('dashboard.admin.removepermission');
    }
}
