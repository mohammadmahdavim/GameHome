<?php

namespace App\Http\Controllers;

use App\lib\Kavenegar;
use App\Models\Invoice;
use App\Models\Reserve;
use App\Models\SubInvoice;
use App\Models\UserPlane;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class ReserveController extends Controller
{
    public function index()
    {
        $rows = Reserve::where('user_id', auth()->user()->id)->get();
        return view('panel.customer.reserve', ['rows' => $rows]);
    }

    public function all_reserve()
    {
        $rows = Reserve::all();
        return view('panel.reserve.index', ['rows' => $rows]);
    }

    public function accept_reserve(Request $request)
    {
        $row = Reserve::where('id', $request->id)->first();
        $row->update([
            'card' => $request->card,
            'cache' => $request->cache,
            'pose' => $request->pose,
            'status' => 'accept',
        ]);
        $check = SubInvoice::where('sub_invoiceable_id', $row->id)
            ->where('sub_invoiceable_type', Reserve::class)
            ->first();
        if ($check) {
            $check->update([
                'price' => $row->cache + $row->pose + $row->card,
            ]);
            $invoice = Invoice::where('id', $check->invoice_id)->first();
            $invoice->update([
                'price' => $row->cache + $row->pose + $row->card,
                'payed_at' => Jalalian::now()->format('Y-m-d'),
                'pay_status' => 'handy',
                'cache' => $row->cache,
                'pose' => $row->pose,
                'card' => $row->card,
            ]);
        } else {
            $invoice = Invoice::create([
                'author' => auth()->user()->id,
                'user_id' => $row->user_id,
                'price' => $row->cache + $row->pose + $row->card,
                'payed_at' => Jalalian::now()->format('Y-m-d'),
                'pay_status' => 'handy',
                'cache' => $row->cache,
                'pose' => $row->pose,
                'card' => $row->card,
            ]);
            SubInvoice::create([
                'invoice_id' => $invoice->id,
                'price' => $row->cache + $row->pose + $row->card,
                'sub_invoiceable_id' => $row->id,
                'sub_invoiceable_type' => Reserve::class,
            ]);
            Kavenegar::reserve($row->user->id,$row->user->father_mobile, $row->date, 'قبول','reserve');

        }

        return redirect('get_invoice/' . $invoice->id);
        alert()->success('درخواست  با موفقیت تایید شد.', 'عملیات موفق');
        return back();
    }

    public function decline_reserve($id)
    {
       $reserve= Reserve::where('id', $id)->update(['status' => 'decline']);
        $subInvoice = SubInvoice::where('sub_invoiceable_id', $id)
            ->where('sub_invoiceable_type', Reserve::class)
            ->first();
        if ($subInvoice) {
            $invoice = Invoice::where('id', $subInvoice->invoice_id)->first();
            $subInvoice->delete();
            $invoice->delete();
        }
        Kavenegar::reserve($reserve->user->id,$reserve->user->father_mobile, $reserve->date, 'رد','reserve');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Reserve::create([
            'user_id' => auth()->user()->id,
            'date' => $request->input('date-picker-shamsi-list'),
            'from_time' => $request->from_time,
            'until_time' => $request->until_time,
        ]);
        alert()->success('درخواست شما با موفقیت ثبت شد.', 'عملیات موفق');
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
        $row = Reserve::where('id', $id)->first();
        $row->delete();
    }
}
