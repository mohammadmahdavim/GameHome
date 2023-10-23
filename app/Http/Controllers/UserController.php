<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Plane;
use App\Models\Rollcall;
use App\Models\SubInvoice;
use App\Models\User;
use App\Models\UserPlane;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Morilog\Jalali\Jalalian;

class UserController extends Controller
{
    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->fileController = new FileController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = User::with('planes.plane')
            ->when($request->get('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->get('father_name'), function ($query) use ($request) {
                $query->where('father_name', 'like', '%' . $request->father_name . '%');
            })
            ->when($request->get('mother_name'), function ($query) use ($request) {
                $query->where('mother_name', 'like', '%' . $request->mother_name . '%');
            })
            ->where('role', 'user')
            ->paginate(30);
        $planes = Plane::whereIn('type', ['hourly', 'monthly'])->get();
        return view('panel.user.index', ['rows' => $rows, 'planes' => $planes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.user.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'father_mobile' => 'required|unique:users',
        ]);
        $row = User::create([
            'role' => $request->role,
            'name' => $request->name,
            'family' => $request->family,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'father_mobile' => $request->father_mobile,
            'mother_mobile' => $request->mother_mobile,
            'password' => Hash::make($request->father_mobile),
            'description' => $request->description,
            'birth_date' => $request->input('date-picker-shamsi-list'),
        ]);
        $row->update([
            'code' => $row->id + 1000
        ]);
        $this->fileController->getUploadImage($request, $row, 'user');
        alert()->success('مشتری جدید با موفقیت افزوده شد', 'عملیات موفق');

        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = User::where('id', $id)->first();
        return view('panel.user.edit', ['row' => $row]);
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
        $row = User::where('id', $id)->first();
        $row->update([
            'name' => $request->name,
            'family' => $request->family,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'father_mobile' => $request->father_mobile,
            'mother_mobile' => $request->mother_mobile,
            'password' => Hash::make($request->father_mobile),
            'description' => $request->description,
            'birth_date' => $request->input('date-picker-shamsi-list'),
        ]);

        $this->fileController->getUploadImage($request, $row, 'user');
        alert()->success('مشتری با موفقیت ویرایش شد.', 'عملیات موفق');

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
        $row = User::where('id', $id)->first();
        $row->delete();
    }

    public function files($id)
    {
        $files = User::where('id', $id)->with('files')->first();
        return view('panel.user.files', ['id' => $id, 'model' => 'App\Models\User', 'files' => $files]);
    }

    public function add_plane(Request $request)
    {
        $plane = Plane::where('id', $request->plane_id)->first();
        $row = UserPlane::create([
            'user_id' => $request->user_id,
            'plane_id' => $request->plane_id,
            'start_date' => $request->input('date-picker-shamsi-list'),
            'dead_date' => $request->input('date-picker-shamsi-list-1'),
            'all_hour' => $plane->hour,
            'plane_price' => $plane->price + $plane->service_price,
            'payed' => $request->card + $request->pose + $request->cache
        ]);
        if ($plane->type == 'monthly') {
            $date = Jalalian::fromFormat('Y/m/d', $row->start_date)->addMonths($plane->month);
            $row->update([
                'dead_date_eshterak' => $date,
            ]);
        }
        $user = User::where('id', $request->user_id)->first();
        $user->update([
            'purchase' => $user->purchase + ($plane->hour * 60),
            'remaining' => ($user->purchase + ($plane->hour * 60)) - $user->used,
            'tuition' => $user->tuition + $plane->price + $plane->service_price,
            'payed' => $user->payed + ($request->card + $request->pose + $request->cache),
            'tuition_remaining' => $user->tuition_remaining + ($plane->price + $plane->service_price - ($request->card + $request->pose + $request->cache))
        ]);
        $invoice = $this->creat_invoice($request->user_id, $plane->price + $plane->service_price, Jalalian::now()->format('Y-m-d'), $request->card, $request->pose, $request->cache, UserPlane::class, $row->id);
        return redirect('get_invoice/' . $invoice->id);

        alert()->success('پلن با موفقیت اضافه شد.', 'عملیات موفق');

        return back();
    }

    public function delete_plane($id)
    {
        $row = UserPlane::where('id', $id)->with('sub_invoice.invoice')->first();
        $plane = Plane::where('id', $row->plane_id)->first();
        $user = User::where('id', $row->user_id)->first();
        $user->update([
            'purchase' => $user->purchase - ($plane->hour * 60),
            'remaining' => ($user->purchase - ($plane->hour * 60)) - $user->used,
            'tuition' => $user->tuition - $plane->price + $plane->service_price,
            'payed' => $user->payed - ($row->sub_invoice[0]->invoice->card + $row->sub_invoice[0]->invoice->pose + $row->sub_invoice[0]->invoice->cache),
            'tuition_remaining' => $user->tuition_remaining - ($plane->price + $plane->service_price - ($row->sub_invoice[0]->invoice->card + $row->sub_invoice[0]->invoice->pose + $row->sub_invoice[0]->invoice->cache))
        ]);
        $row->sub_invoice[0]->invoice->delete();
        $row->sub_invoice[0]->delete();
        $row->delete();
    }

    /**
     * @param Request $request
     * @param $plane
     */
    public function creat_invoice($userID, $price, $pay_at, $card, $pose, $cache, $model, $id)
    {
        $invoice = Invoice::create([
            'author' => auth()->user()->id,
            'user_id' => $userID,
            'price' => $price,
            'payed_at' => $pay_at,
            'pay_status' => 'handy',
            'cache' => $cache,
            'pose' => $pose,
            'card' => $card,
        ]);
        SubInvoice::create([
            'invoice_id' => $invoice->id,
            'price' => $price,
            'sub_invoiceable_id' => $id,
            'sub_invoiceable_type' => $model,
        ]);
        return $invoice;
    }

    public function clearing(Request $request)
    {
        $allPay = $request->cache + $request->pose + $request->card;
        if ($allPay != $request->price) {
            alert()->error('مبلغ پرداخت شده با مبلغ فاکتور مغایرت دارد', 'ناموفق');
            return back()->withInput();
        }
        $invoice = Invoice::create([
            'author' => auth()->user()->id,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'payed_at' => Jalalian::now()->format('Y-m-d'),
            'pay_status' => 'handy',
            'cache' => $request->cache,
            'pose' => $request->pose,
            'card' => $request->card,
        ]);
        $user = User::where('id', $request->user_id)->first();
        $user->update([
            'purchase' => Rollcall::where('user_id', $user->id)->sum('sum'),
            'used' => Rollcall::where('user_id', $user->id)->sum('sum'),
            'remaining' => 0,
        ]);
        $plane = Plane::where('id', $request->plane_id)->first();
        if ($plane) {
            SubInvoice::create([
                'invoice_id' => $invoice->id,
                'price' => $request->price,
                'sub_invoiceable_id' => $request->plane_id,
                'sub_invoiceable_type' => Plane::class,
            ]);
        }
        return redirect('get_invoice/' . $invoice->id);

        alert()->success('کاربر تسویه شد.', 'عملیات موفق');

        return back();
    }

    public function add_pay(Request $request)
    {
        $userPlane = UserPlane::where('id', $request->user_plane_id)
            ->with('sub_invoice.invoice')
            ->first();
        $payed = $request->cache + $request->pose + $request->card;
        $userPlane->update([
            'payed' => $userPlane->payed + $payed
        ]);
        $userPlane->sub_invoice[0]->invoice->update([
            'card' => $userPlane->sub_invoice[0]->invoice->card + $request->card,
            'pose' => $userPlane->sub_invoice[0]->invoice->pose + $request->pose,
            'cache' => $userPlane->sub_invoice[0]->invoice->cache + $request->cache,
        ]);
        $user = User::where('id', $userPlane->user_id)->first();
        $user->update([

            'payed' => $user->payed + $payed,
            'tuition_remaining' => $user->tuition_remaining - $payed
        ]);
        alert()->success('پرداخت با موفقیت اضافه شد.', 'عملیات موفق');

        return back();
    }

    public function cards()
    {
        $users = User::where('role', 'user')->get();
        return view('panel.user.cards', ['users' => $users]);
    }

    public function card($id)
    {
        $users = User::where('id', $id)->get();
        return view('panel.user.cards', ['users' => $users]);
    }
}

