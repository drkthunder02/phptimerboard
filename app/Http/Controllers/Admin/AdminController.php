<?php

namespace App\Http\Controllers\Admin;

//Internal Library
use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;

//Library
use App\Library\Lookups\LookupHelper;

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

    public function storeAddEntity(Request $request) {
        //Validate the input parameters
        $this->validate($request, [
            'entity_name' => 'required',
            'entity_type' => 'required',
            'login_type' => 'required',
        ]);

        //Declare the variable needed for the lookup helper
        $lookup = new LookupHelper;

        //Get the correct id from the name entered into the form
        if($request->entity_type == 'Character') {
            $entityId = $lookup->CharacterNameToId($request->entity_name);
        } else if($request->entity_type == 'Corporation') {
            $entityId = $lookup->CorporationNameToId($request->entity_name);
        } else if($request->entity_type == 'Alliance') {
            $entityId = $lookup->AllianceNameToId($request->entity_name);
        }

        //Attempt to insert the data into the allowed login table
        AllowedLogin::insertOrIgnore([
            'entity_id' => $entityId,
            'entity_type' => $request->entity_type,
            'login_type' => $request->login_type,
        ]);

        //Redirect back to the admin dashboard
        return redirect('/dashboard/admin/dashboard')->with('success', 'Added the entity to the allowed logins.');
    }

    public function displayRemoveEntity() {
        return view('dashboard.admin.removeentity');
    }

    public function storeRemoveEntity(Request $request) {
        //Validate the request
        $this->validate($request, [
            'entity_id' => 'required',
        ]);

        //Delete the entity id from the Allowed Login table
        AllowedLogin::where([
            'entity_id' => $request->entity_id,
        ])->delete();

        //Redirect back to the admin dashboard
        return redirect('/dashboard/admin/dashboard')->with('success', 'Removed the entity from the allowed login list.');
    }

    public function displayAddPermission() {
        return view('dashboard.admin.addpermission');
    }

    public function storeAddPermissions(Request $request) {
        //Validate the request
        $this->validate($request, [
            'user_id' => 'required',
            'permission' => 'required',
        ]);

        //Add the user permission
        UserPermission::insertOrIgnore([
            'character_id' => $request->user_id,
            'permission' => $request->permission,
        ]);

        return redirect('/dashboard/admin/dashboard')->with('success', 'Added user permission.');
    }

    public function displayRemovePermission() {
        return view('dashboard.admin.removepermission');
    }

    public function storeRemovePermission(Request $request) {
        //Validate the user request
        $this->validate($request, [
            'user_id' => 'required',
            'permission' => 'required',
        ]);

        //Delete the user permission
        UserPermission::where([
            'character_id' => $request->user_id,
            'permission' => $request->permission,
        ])->delete();

        return redirect('/dashboard/admin/dashboard')->with('success', 'Removed user permission.');
    }
}
