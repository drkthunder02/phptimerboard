<?php

namespace App\Http\Controllers\Timers;

//Internal Library
use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;

//Library

//Models
use App\Models\Timer\TimerLog;
use App\Models\Timer\Timer;

class TimerController extends Controller
{
    public function __construct() {
        $this->middleware('role:User');
    }

    public function displayAddTimer() {
        return view('timer.addtimer');
    }

    public function storeAddTimer() {

    }

    public function displayRemoveTimer () {
        return view('timer.deletetimer');
    }

    public function storeRemoveTimer() {

    }

    public function displayModifyTimer() {
        return view('timer.modifytimer');
    }

    public function storeModifyTimer() {
        $this->validate([
            'region' => 'required',
            'system' => 'required',
            'planet' => 'required',
            'moon' => 'required',
            'type' => 'required',
            'stage' => 'required',
            'owner' => 'required',
            'notes' => 'required',
            'user' => 'required',
        ]);

        Timer::where([
            'region' => $request->region,
            'system' => $request->system,
            'planet' => $request->planet,
            'moon' => $request->moon,
        ])->update([
            'type' => $request->type,
            'stage' => $request->stage,
            'owner' => $request->owner,
            'notes' => $request->notes,
            'user' => $request->user,
        ]);

        return redirect('/timer.displaytimer')->with('success', 'Timer has been modified.');
    }

    public function displayTimers() {
        $currentTime = Carbon::now();

        $timers = Timer::where(['eve_time', '>', $currentTime])->orderBy('type', 'desc')->get();

        return view('timer.displaytimer')->with('timers', $timers);
    }
}
