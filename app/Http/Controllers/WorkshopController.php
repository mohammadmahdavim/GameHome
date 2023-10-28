<?php

namespace App\Http\Controllers;

use App\lib\Kavenegar;
use App\Models\Absent;
use App\Models\Invoice;
use App\Models\Rollcall;
use App\Models\SubInvoice;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopStaff;
use App\Models\WorkshopStudent;
use App\Models\WorkshopType;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use DateTime;

class WorkshopController extends Controller
{
    public function index()
    {
        $rows = Workshop::with('type')
            ->with('staff.user')
            ->paginate(30);
        $types = WorkshopType::all();
        $staff = User::whereIn('role', ['staff', 'admin'])->get();
        return view('panel.workshop.index', ['rows' => $rows, 'types' => $types, 'staff' => $staff]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = Workshop::create([
            'author' => auth()->user()->id,
            'name' => $request->name,
            'workshop_type_id' => $request->workshop_type_id,
            'day_count' => $request->day_count,
            'day' => $request->day,
            'time' => $request->time,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'start_date' => $request->input('date-picker-shamsi-list'),
            'end_date' => $request->input('date-picker-shamsi-list-1'),
        ]);
        alert()->success('کارگاه جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('workshop');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = Workshop::where('id', $id)->first();
        $row->update([
            'name' => $request->name,
            'workshop_type_id' => $request->workshop_type_id,
            'day_count' => $request->day_count,
            'day' => $request->day,
            'time' => $request->time,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'start_date' => $request->input('date-picker-shamsi-list'),
            'end_date' => $request->input('date-picker-shamsi-list-1'),
        ]);
        alert()->success('کارگاه جدید با موفقیت افزوده شد', 'عملیات موفق');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Workshop::where('id', $id)->first();
        $row->delete();
    }

    public function students($id)
    {
        $workshop = Workshop::find($id);
        $rows = WorkshopStudent::where('workshop_id', $id)->with('user')->get();
        $allStudents = User::where('role', 'user')->get();
        return view('panel.workshop.students', ['rows' => $rows, 'workshop' => $workshop, 'allStudents' => $allStudents]);

    }

    public function add_student(Request $request)
    {
        $check = WorkshopStudent::where('user_id', $request->student_id)->where('workshop_id', $request->workshop_id)->first();
        if ($check) {
            alert()->error('دانش آموز قبلا به این کارگاه افزوده شده است.', 'عملیات نا موفق');
            return back();
        }
        $count = WorkshopStudent::where('workshop_id', $request->workshop_id)->count();
        if ($count >= Workshop::where('id', $request->workshop_id)->pluck('capacity')->first()) {
            alert()->error('ظرفیت تکمیل شده است.', 'عملیات نا موفق');
            return back();
        }
        $row = WorkshopStudent::create([
            'user_id' => $request->student_id,
            'workshop_id' => $request->workshop_id,
            'card' => $request->card,
            'pose' => $request->pose,
            'cache' => $request->cache,
            'remaining' => Workshop::where('id', $request->workshop_id)->pluck('price')->first() - ($request->card + $request->cache + $request->pose),
        ]);

        $invoice = Invoice::create([
            'author' => auth()->user()->id,
            'user_id' => $request->student_id,
            'price' => Workshop::where('id', $request->workshop_id)->pluck('price')->first(),
            'payed_at' => Jalalian::now(),
            'pay_status' => 'handy',
            'cache' => $request->cache,
            'pose' => $request->pose,
            'card' => $request->card,
        ]);
        SubInvoice::create([
            'invoice_id' => $invoice->id,
            'price' => Workshop::where('id', $request->workshop_id)->pluck('price')->first(),
            'sub_invoiceable_id' => $row->id,
            'sub_invoiceable_type' => WorkshopStudent::class,
        ]);
        alert()->success('دانش آموز جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('get_invoice/' . $invoice->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete_student($id)
    {
        $row = WorkshopStudent::where('id', $id)->first();
        $row->sub_invoice[0]->invoice->delete();
        $row->sub_invoice[0]->delete();
        $row->delete();
    }

    public function rollcall($id)
    {
        if (auth()->user()->hasAnyPermission(['my-workshop', 'workshop-rollcall'])) {
            $workshop = Workshop::find($id);
            $students = WorkshopStudent::where('workshop_id', $id)->pluck('user_id');
            $rows = User::where('role', 'user')
                ->whereIn('id', $students)
                ->withsum('workshop_roolcall', 'sum', function ($q) use ($id) {
                    $q->where('workshop_id', $id);
                })
                ->get();
            return view('panel.workshop.rollcall', ['rows' => $rows, 'workshop' => $workshop]);
        } else {
            return abort(403);
        }


    }

    public function rollcall_enter($id, $workshopId)
    {
        if (auth()->user()->hasAnyPermission(['my-workshop', 'workshop-rollcall'])) {
            $user = User::where('id', $id)->first();
            $check = Rollcall::where('user_id', $user->id)
                ->where('date', Jalalian::now()->format('Y-m-d'))
                ->where('calculable', 2)
                ->where('workshop_id', $workshopId)
                ->orderBy('created_at', 'desc')
                ->first();
            $timeNow = Jalalian::now()->format('H:i');
            if (!$check) {
                $check = Rollcall::create([
                    'calculable' => 2,
                    'user_id' => $user->id,
                    'workshop_id' => $workshopId,
                    'date' => Jalalian::now()->format('Y-m-d'),
                    'type' => 'system',
                    'enter' => $timeNow,
                    'author' => auth()->user()->id
                ]);
                return 'ok';
            } else {
                return response('', '500');

            }
        } else {
            return abort(403);
        }


    }

    public function rollcall_exit($id, $workshopId)
    {
        if (auth()->user()->hasAnyPermission(['my-workshop', 'workshop-rollcall'])) {
            $user = User::where('id', $id)->first();
            $check = Rollcall::where('user_id', $user->id)
                ->where('date', Jalalian::now()->format('Y-m-d'))
                ->where('calculable', 2)
                ->where('workshop_id', $workshopId)
                ->orderBy('created_at', 'desc')
                ->first();
            $timeNow = Jalalian::now()->format('H:i');
            if ($check) {
                $check->update([
                    'exit' => $timeNow,
                ]);
                $row = Rollcall::where('id', $check->id)->first();
                $enter = $row->enter;
                $exit = $row->exit;
                if ($exit and $enter) {
                    $start_datetime = new DateTime($enter);
                    $diff = $start_datetime->diff(new DateTime($exit));
                    $total_minutes = ($diff->h * 60);
                    $total_minutes += $diff->i;
                    $row->update(['sum' => $total_minutes * $row->count, 'duration' => $total_minutes]);
                }
            } else {
                return response('', '500');

            }
        } else {
            return abort(403);
        }


    }

    public function rollcall_absent($id)
    {
        if (auth()->user()->hasAnyPermission(['my-workshop', 'workshop-rollcall'])) {
            $user = User::where('id', $id)->first();
            $absent = Absent::where('user_id', $user->id)
                ->where('date', Jalalian::now()->format('Y-m-d'))
                ->where('type', 2)
                ->first();
            if (!$absent) {
                Absent::create([
                    'user_id' => $user->id,
                    'type' => 2,
                    'date' => Jalalian::now()->format('Y-m-d'),
                    'author' => auth()->user()->id
                ]);
                Kavenegar::reserve($user->id, $user->father_mobile, Jalalian::now()->format('Y-m-d'), 'غیبت', 'absent');

            }
        } else {
            return abort(403);
        }


    }

    public function add_staff(Request $request)
    {
        WorkshopStaff::create([
            'user_id' => $request->user_id,
            'workshop_id' => $request->workshop_id,
        ]);
        alert()->success('مربی جدید با موفقیت افزوده شد', 'عملیات موفق');
        return back();
    }

    public function delete_staff($id)
    {
        $row = WorkshopStaff::where('id', $id)->first();
        $row->delete();
    }
}
