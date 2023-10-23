<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Service;
use App\Models\SubInvoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Morilog\Jalali\Jalalian;

class InvoiceController extends Controller
{
    public function create()
    {
//        session()->forget('invoice');
        $invoices = Session::get('invoice');
        if (!$invoices) {
            $invoices = [];
        }
        $products = Product::all();
        $services = Service::all();
        $users = User::all();

        return view('panel.invoice.create', ['products' => $products, 'services' => $services, 'invoices' => $invoices, 'users' => $users]);
    }

    public function set_session(Request $request)
    {

        $x = $request->all();
        if ($x['type'] == 'product') {
            $product = Product::where('id', $x['product_id'])->first();
            $data = [
                'track_id' => $x['product_id'] * time(),
                'type' => 'product',
                'id' => $x['product_id'],
                'count' => $x['count'],
                'name' => $product->name,
                'price' => $product->price,
                'sum_price' => $x['count'] * $product->price,
            ];
        } else {
            $service = Service::where('id', $x['service_id'])->first();
            $data = [
                'track_id' => $x['service_id'] * time(),
                'type' => 'service',
                'id' => $x['service_id'],
                'count' => $x['count'],
                'name' => $service->name,
                'price' => $service->price,
                'sum_price' => $x['count'] * $service->price,
            ];
        }
        session()->push('invoice', $data);

        return back();
    }

    public function unset_session($track_id)
    {

        $sessions = Session::get('invoice');
        session()->forget('invoice');

        foreach ($sessions as $session) {
            if ($session['track_id'] != $track_id) {
                session()->push('invoice', $session);
            }
        }
        return back();
    }

    public function store(Request $request)
    {
        $allPay = $request->cache + $request->pose + $request->card;
        if ($allPay != $request->price) {
            alert()->error('مبلغ پرداخت شده با مبلغ فاکتور مغایرت دارد', 'ناموفق');
            return back()->withInput();
        }
        $subInvoices = Session::get('invoice');
        if (!$subInvoices) {
            alert()->error('هیچ محصولی ثبت نشده است.', 'ناموفق');
            return back()->withInput();
        }
        $invoice = Invoice::create([
            'author' => auth()->user()->id,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'cache' => $request->cache,
            'card' => $request->card,
            'pose' => $request->pose,
            'payed_at' => Jalalian::now()->format('Y-m-d'),
            'pay_status' => 'handy',
        ]);
        foreach ($subInvoices as $subInvoice) {
            SubInvoice::create([
                'invoice_id' => $invoice->id,
                'price' => $subInvoice['sum_price'],
                'sub_invoiceable_id' => $subInvoice['id'],
                'sub_invoiceable_type' => $subInvoice['type'] == 'product' ? Product::class : Service::class,
            ]);
            if ($subInvoice['type'] == 'product') {
                $product = Product::where('id', $subInvoice['id'])->first();
                $product->update([
                    'remaining' => $product->remaining - $subInvoice['count']
                ]);
            }
        }
        session()->forget('invoice');
        alert()->success('فاکتور با موفقیت ثبت شد.', 'موفق');
        return redirect('get_invoice/' . $invoice->id);
    }

    public function get_invoice($id)
    {
        $row = Invoice::where('id', $id)
            ->with('sub_invoices.sub_invoiceable')
            ->first();

        return view('panel.invoice.invoice', ['row' => $row]);
    }
}
