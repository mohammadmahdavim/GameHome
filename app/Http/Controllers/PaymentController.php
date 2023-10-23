<?php

namespace App\Http\Controllers;

use App\Finanace;
use App\lib\EnConverter;
use App\LogFinanace;
use App\Models\Gateway;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plane;
use App\Models\SubInvoice;
use App\Models\User;
use App\Models\UserPlane;
use App\Models\Workshop;
use App\Models\WorkshopStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class PaymentController extends Controller
{

    public function pay(Request $request)
    {
        if ($request->model == 'plane') {
            $model = Plane::where('id', $request->model_id)->first();
            $price = ($model->price +  $model->service_price) / 10;
        } elseif ($request->model == 'workshop') {
            $check = $this->checkWorkshop($request->model_id);
            if ($check != 'ok') {
                alert()->warning($check, 'عملیات پرداخت ناموفق بود.');

                return back();
            }
            $model = Workshop::where('id', $request->model_id)->first();
            $price = ($model->price) / 10;
        } else {
            return back();
        }
        # for change persian charakter
        $request->merge([
            'price' => EnConverter::bn2en($price)
        ]);
        # end

        $gateway = Gateway::active()->where('id', 1)->first();
        if (!$gateway) {
            return response()->json([
                'message' => 'درگاه انتخاب شده معتبر نمی باشد.'
            ], 400);
        }

        if ($request->price > 100) {
            $token = Str::random(50);
            Payment::create([
                'user_id' => auth()->user()->id,
                'amount' => $price,
                'gateway_id' => $gateway->id,
                'token' => $token,
                'date' => time(),
                'trans_id' => null,
                'id_get' => null,
                'type' => 'online',
                'status' => 'waiting',
                'ip' => $request->ip(),
                'model' => $request->model,
                'model_id' => $request->model_id,
            ]);

            $payment = Gateway::payment($gateway->id, $token);
            $payment = $payment->getData();
            if ($payment->status == 200) {
                return redirect($payment->url);
            }

            return response()->json([
                'message' => 'ارتباط با بانک برقرار نمی باشد. بعدا تلاش کنید!'
            ], 400);
        }

        return response()->json([
            'message' => 'مبلغ باید بیش از 100 تومان باشد.'
        ], 400);
    }


    public function checkout(Request $request, $token)
    {

        $payment = Payment::where('token', $token)
            ->where('status', 'waiting')
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($payment) {
            $verify = Gateway::verify($token);
            if ($verify) {
                if ($payment->model == 'plane') {
                    $invoice = $this->add_plane($payment->model_id);
                } else {
                    $invoice = $this->add_student($payment->model_id, $payment->amount);
                }
                return redirect('get_invoice/' . $invoice->id);

            }
            alert()->warning('عملیات پرداخت ناموفق بود. درصورت کسر پول ظرف 72 ساعت به حساب شما باز خواهد گشت.');
            return redirect('/customer');
        }

        abort(404);
    }

    public function add_plane($planeId)
    {
        $plane = Plane::where('id', $planeId)->first();
        $row = UserPlane::create([
            'user_id' => auth()->user()->id,
            'plane_id' => $planeId,
            'start_date' => Jalalian::now()->format('Y-m-d'),
            'all_hour' => $plane->hour,
            'plane_price' => $plane->price + $plane->service_price,
            'payed' => $plane->price
        ]);
        if ($plane->type == 'monthly') {
            $date = Jalalian::fromFormat('Y/m/d', $row->start_date)->addMonths($plane->month);
            $row->update([
                'dead_date_eshterak' => $date,
            ]);
        }
        $user = User::where('id', auth()->user()->id)->first();
        if ($plane->type == 'hourly' or $plane->type == 'monthly') {
            $user->update([
                'purchase' => $user->purchase + ($plane->hour * 60),
                'remaining' => ($user->purchase + ($plane->hour * 60)) - $user->used,
                'tuition' => $user->tuition + $plane->price + $plane->service_price,
                'payed' => $user->payed + $plane->price,
                'tuition_remaining' => $user->tuition_remaining + ($plane->price + $plane->service_price - $plane->price)
            ]);
        } else {
            $user->update([
                'tuition' => $user->tuition + $plane->price + $plane->service_price,
                'payed' => $user->payed + $plane->price,
                'tuition_remaining' => $user->tuition_remaining + ($plane->price + $plane->service_price - $plane->price)
            ]);
        }

        return $invoice = $this->creat_invoice(auth()->user()->id, $plane->price + $plane->service_price, Jalalian::now()->format('Y-m-d'), $plane->price+ $plane->service_price, 0, 0, UserPlane::class, $row->id);
    }

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

    public function add_student($workshopid, $price)
    {
        $row = WorkshopStudent::create([
            'user_id' => auth()->user()->id,
            'workshop_id' => $workshopid,
            'card' => $price,
            'remaining' => 0,
        ]);

        $invoice = Invoice::create([
            'author' => auth()->user()->id,
            'user_id' => auth()->user()->id,
            'price' => $price,
            'payed_at' => Jalalian::now(),
            'pay_status' => 'handy',
            'card' => $price,
        ]);
        SubInvoice::create([
            'invoice_id' => $invoice->id,
            'price' => Workshop::where('id', $workshopid)->pluck('price')->first(),
            'sub_invoiceable_id' => $row->id,
            'sub_invoiceable_type' => WorkshopStudent::class,
        ]);
        return $invoice;
    }

    public function checkWorkshop($workshopId)
    {
        $check = WorkshopStudent::where('user_id', auth()->user()->id)->where('workshop_id', $workshopId)->first();
        if ($check) {
            return 'ظرفیت تکمیل شده است.';

        }
        $count = WorkshopStudent::where('workshop_id', $workshopId)->count();
        if ($count >= Workshop::where('id', $workshopId)->pluck('capacity')->first()) {
            return 'ظرفیت تکمیل شده است.';
        }
        return 'ok';

    }


}
