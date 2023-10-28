<?php

namespace App\Http\Controllers;

use App\lib\Kavenegar;
use App\Models\Plane;
use App\Models\Reserve;
use App\Models\UserPlane;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function index()
    {
        $todayReserve = Reserve::where('date', Jalalian::now()->format('Y/m/d'))
            ->where('status', 'accept')
            ->get();
        $this->sms();
        return view('panel.dashboard.index', ['todayReserve' => $todayReserve]);
    }

    public function sms()
    {
        $cheques = UserPlane::where('dead_date', '<=', Jalalian::now()->addDays(3)->format('Y-m-d'))
            ->where('sms', 0)
            ->whereNotNull('dead_date')
            ->get();
        foreach ($cheques as $cheque) {
            if ($cheque->payed < $cheque->price) {
                Kavenegar::reserve($cheque->user->id,$cheque->user->father_mobile, $cheque->dead_date, $cheque->plane->title, 'finance');
                $cheque->update(['sms' => 1]);
            }
        }
        $planes = Plane::where('type', 'monthly')->pluck('id');
        $cheques = UserPlane::where('dead_date_eshterak', '<=', Jalalian::now()->addDays(3)->format('Y-m-d'))
            ->whereNotNull('dead_date_eshterak')
            ->where('sms', 0)
            ->whereIn('plane_id', $planes)
            ->get();
        foreach ($cheques as $cheque) {
            if ($cheque->plane->type == 'monthly') {
                Kavenegar::reserve($cheque->user->id,$cheque->user->father_mobile, $cheque->dead_date, $cheque->plane->title, 'eshterak');
                $cheque->update(['sms' => 1]);
            }
        }


    }
}
