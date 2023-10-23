<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use App\Models\Invoice;
use App\Models\Plane;
use App\Models\Report;
use App\Models\Rollcall;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopStudent;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('panel.customer.index');
    }

    public function workshops()
    {

        $myWorkshopId = WorkshopStudent::where('user_id', auth()->user()->id)->pluck('workshop_id');
        $myWorkshop = Workshop::whereIn('id', $myWorkshopId)->get();
        $rows = Workshop::whereNotIn('id', $myWorkshopId)->get();
        return view('panel.customer.workshop', ['rows' => $rows, 'myWorkshop' => $myWorkshop]);
    }

    public function plans()
    {
        $rows = Plane::whereNotIn('type',['minutes'])->orderBy('created_at','desc')->get();
        return view('panel.customer.plane', ['rows' => $rows]);
    }

    public function rollcalls()
    {
        $rows = Rollcall::where('user_id', auth()->user()->id)->orderBy('created_at','desc')->paginate(20);
        return view('panel.customer.rollcall', ['rows' => $rows]);
    }

    public function absents()
    {

        $rows = Absent::where('user_id', auth()->user()->id)->orderBy('created_at','desc')->get();
        return view('panel.customer.absent', ['rows' => $rows]);
    }

    public function invoices()
    {
        $rows = Invoice::where('user_id', auth()->user()->id)->orderBy('created_at','desc')
            ->with('sub_invoices.sub_invoiceable')
            ->with('user')
            ->get();
        return view('panel.customer.invoice', ['rows' => $rows]);
    }

    public function user_reports()
    {
        $rows = Report::where('receiver', auth()->user()->id)->orderBy('created_at','desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('panel.customer.reports', ['rows' => $rows]);
    }

    public function card()
    {
        $users=User::where('id',auth()->user()->id)->orderBy('created_at','desc')->get();
        return view('panel.customer.card',['users'=>$users]);
    }


}
