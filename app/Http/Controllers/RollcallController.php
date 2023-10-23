<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Personnel;
use App\Models\Plane;
use App\Models\Presence;
use App\Models\Rollcall;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use DateTime;

class RollcallController extends Controller
{

    public function today()
    {
        $users = User::where('role', 'user')->select('id', 'name', 'family')->get();
        $todayUsers = Rollcall::where('date', Jalalian::now()->format('Y-m-d'))
            ->where('calculable', 1)
            ->with('user')
            ->get();
        $planes = Plane::where('type', 'minutes')->get();
        return view('panel.rollcall.today', ['users' => $users, 'todayUsers' => $todayUsers, 'planes' => $planes]);
    }

    public function update(Request $request)
    {
        $today = Jalalian::now()->format('Y-m-d');
        $row = Rollcall::where('date', $today)->where('user_id', $request->personnel_id)->first();
        if ($row) {
            $row->update([
                'enter' => $request->enter,
                'exit' => $request->exit,
                'count' => $request->count,
                'author' => auth()->user()->id
            ]);
        } else {
            $row = Rollcall::create([
                'user_id' => $request->personnel_id,
                'date' => $today,
                'count' => $request->count,
                'type' => $request->type,
                'enter' => $request->enter,
                'exit' => $request->exit,
                'author' => auth()->user()->id
            ]);
        }
        $this->sum($row->id);
        alert()->success('اطلاعات با موفقیت ثبت شد.', 'عملیات موفق');

        return back();
    }

    public function inquiry(Request $request)
    {
        return Rollcall::where('user_id', $request->personnel_id)->where('date', Jalalian::now()->format('Y-m-d'))->select('enter', 'exit', 'count')->orderBy('created_at', 'desc')->first() ?? '';
    }

    public function scanCheck($code)
    {
        $user = User::where('code', $code)->first();
        $check = Rollcall::where('user_id', $user->id)->where('date', Jalalian::now()->format('Y-m-d'))->orderBy('created_at', 'desc')->where('calculable', 1)->first();
        $timeNow = Jalalian::now()->format('H:i');

        if (!$check) {
            $check = Rollcall::create([
                'user_id' => $user->id,
                'calculable' => 1,
                'date' => Jalalian::now()->format('Y-m-d'),
                'type' => 'system',
                'enter' => $timeNow,
                'author' => auth()->user()->id
            ]);

            return ['type' => 'enter', 'name' => $user->name, 'time' => $timeNow];
        } elseif ($check and ($check['exit'] == null || $check['exit'] == '')) {
            $timeAdded = Jalalian::forge($check['enter'])->addMinutes(5)->format('H:i');

            if ($timeNow < $timeAdded) {
                return ['type' => 'enter-exit', 'name' => $user->name, 'time' => $timeNow];
            } else {
                $check->update(['exit' => $timeNow]);
                $this->sum($check->id);
                return ['type' => 'exit', 'name' => $user->name, 'time' => $timeNow];
            }

        } elseif ($check and $check['exit'] != null) {
            $check = Rollcall::create([
                'user_id' => $user->id,
                'calculable' => 1,
                'date' => Jalalian::now()->format('Y-m-d'),
                'type' => 'system',
                'enter' => $timeNow,
                'author' => auth()->user()->id
            ]);

            return ['type' => 'enter', 'name' => $user->name, 'time' => $timeNow];
        }

    }

    public function sum($id)
    {
        $row = Rollcall::where('id', $id)->first();
        $enter = $row->enter;
        $exit = $row->exit;
        if ($exit and $enter) {
            $start_datetime = new DateTime($enter);
            $diff = $start_datetime->diff(new DateTime($exit));
            $total_minutes = ($diff->h * 60);
            $total_minutes += $diff->i;
            $row->update(['sum' => $total_minutes * $row->count, 'duration' => $total_minutes]);
            $user = User::where('id', $row->user_id)->first();
            $user->update([
                'used' => $used = Rollcall::where('user_id', $row->user_id)->where('calculable', 1)->sum('sum'),
                'remaining' => $user->purchase - $used
            ]);
        }

    }

    public function delete($id)
    {
        $row = Rollcall::where('id', $id)->first();
        $row->delete();
        $user = User::where('id', $row->user_id)->first();
        $user->update([
            'used' => $used = Rollcall::where('user_id', $row->user_id)->where('calculable', 1)->sum('sum'),
            'remaining' => $user->purchase - $used
        ]);
    }

    public function mobile_scan()
    {
        return view('panel.rollcall.scan');
    }

}
