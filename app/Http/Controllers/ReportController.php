<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Exports\PlaneExport;
use App\Exports\ProductExport;
use App\Exports\RollcallExport;
use App\Exports\ServiceExport;
use App\Models\Invoice;
use App\Models\Plane;
use App\Models\Product;
use App\Models\Rollcall;
use App\Models\Service;
use App\Models\SubInvoice;
use App\Models\User;
use App\Models\UserPlane;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class ReportController extends Controller
{
    public function rollcall(Request $request)
    {
        $query = Rollcall::with('user')
            ->when($request->get('user_id'), function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->when($request->get('calculable'), function ($query) use ($request) {

                $query->where('calculable', $request->calculable == 'normal' ? 1 : 0);
            })
            ->when($request->get('date-picker-shamsi-list'), function ($query) use ($request) {
                $query->where('date', '>=', $request->input('date-picker-shamsi-list'));
            })
            ->when($request->get('date-picker-shamsi-list-1'), function ($query) use ($request) {
                $query->where('date', '<=', $request->input('date-picker-shamsi-list-1'));
            });
        $rows = $query->orderBy('date', 'desc')
            ->paginate(30);
        $sum = $query->sum('sum');
        $users = User::where('role', 'user')->get();
        return view('panel.report.rollcall', ['rows' => $rows, 'users' => $users, 'sum' => $sum]);
    }

    public function export_rollcall(Request $request)
    {
        $date = Jalalian::now()->format('Y-m-d');
        return Excel::download(new RollcallExport(), $date . ' ' . 'تردد.xlsx');
    }

    public function planes(Request $request)
    {
        $query = SubInvoice::where('sub_invoiceable_type', UserPlane::class)
            ->with('user_plane.plane')
            ->with('user_plane.user')
            ->with('invoice')
            ->whereHas('user_plane', function ($q) use ($request) {
                if ($request->get('user_id')) {
                    $q->where('user_id', $request->user_id);
                }
                if ($request->get('plane_id')) {
                    $q->where('plane_id', $request->plane_id);
                }
                if ($request->get('date-picker-shamsi-list')) {
                    $q->where('start_date', '>=', $request->input('date-picker-shamsi-list'));
                }
                if ($request->get('date-picker-shamsi-list-1')) {
                    $q->where('start_date', '<=', $request->input('date-picker-shamsi-list-1'));
                }
            })
            ->orderBy('created_at', 'desc');
        $rows = $query->paginate(20);
        $price = 0;
        $pose = 0;
        $card = 0;
        $cache = 0;
        $remaining = 0;
        foreach ($query->get() as $q) {
            $price += $q->invoice->price;
            $pose += $q->invoice->pose;
            $card += $q->invoice->card;
            $cache += $q->invoice->cache;
            $allPay = $q->invoice->pose + $q->invoice->card + $q->invoice->cache;
            $remaining += $q->invoice->price - $allPay;
        }
        $users = User::where('role', 'user')->get();
        $planes = Plane::all();
        return view('panel.report.planes', [
            'price' => $price,
            'pose' => $pose,
            'card' => $card,
            'cache' => $cache,
            'remaining' => $remaining,
            'rows' => $rows,
            'users' => $users,
            'planes' => $planes
        ]);
    }

    public function export_planes(Request $request)
    {
        $date = Jalalian::now()->format('Y-m-d');
        return Excel::download(new PlaneExport(), $date . ' ' . 'پلن ها.xlsx');
    }

    public function products(Request $request)
    {
        $query = SubInvoice::where('sub_invoiceable_type', Product::class)
            ->with('product')
            ->with('invoice.user')
            ->when($request->get('item_id'), function ($query) use ($request) {
                $query->where('sub_invoiceable_id', $request->input('item_id'));
            })
            ->whereHas('invoice', function ($q) use ($request) {
                if ($request->get('user_id')) {
                    $q->where('user_id', $request->user_id);
                }
                if ($request->get('date-picker-shamsi-list')) {
                    $q->where('payed_at', '>=', $request->input('date-picker-shamsi-list'));
                }
                if ($request->get('date-picker-shamsi-list-1')) {
                    $q->where('payed_at', '<=', $request->input('date-picker-shamsi-list-1'));
                }
            })
            ->orderBy('created_at', 'desc');
        $rows = $query->paginate(30);
        $price = $query->sum('price');
        $users = User::where('role', 'user')->get();
        $products = Product::all();
        return view('panel.report.products', ['rows' => $rows, 'users' => $users, 'price' => $price, 'products' => $products]);
    }

    public function export_products(Request $request)
    {
        $date = Jalalian::now()->format('Y-m-d');
        return Excel::download(new ProductExport(), $date . ' ' . 'بوفه.xlsx');
    }

    public function services(Request $request)
    {
        $query = SubInvoice::where('sub_invoiceable_type', Service::class)
            ->with('service')
            ->with('invoice.user')
            ->when($request->get('item_id'), function ($query) use ($request) {
                $query->where('sub_invoiceable_id', $request->input('item_id'));
            })
            ->whereHas('invoice', function ($q) use ($request) {
                if ($request->get('user_id')) {
                    $q->where('user_id', $request->user_id);
                }
                if ($request->get('date-picker-shamsi-list')) {
                    $q->where('payed_at', '>=', $request->input('date-picker-shamsi-list'));
                }
                if ($request->get('date-picker-shamsi-list-1')) {
                    $q->where('payed_at', '<=', $request->input('date-picker-shamsi-list-1'));
                }
            })
            ->orderBy('created_at', 'desc');
        $rows = $query->paginate(30);
        $price = $query->sum('price');

        $users = User::where('role', 'user')->get();
        $services = Service::all();

        return view('panel.report.services', ['rows' => $rows, 'users' => $users, 'price' => $price, 'services' => $services]);
    }

    public function export_services(Request $request)
    {
        $date = Jalalian::now()->format('Y-m-d');
        return Excel::download(new ServiceExport(), $date . ' ' . 'سرویس.xlsx');
    }

    public function invoices(Request $request)
    {
        $query = Invoice::
        when($request->get('user_id'), function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })
            ->when($request->get('date-picker-shamsi-list'), function ($query) use ($request) {
                $query->where('payed_at', '>=', $request->input('date-picker-shamsi-list'));
            })
            ->when($request->get('date-picker-shamsi-list-1'), function ($query) use ($request) {
                $query->where('payed_at', '<=', $request->input('date-picker-shamsi-list-1'));
            })
            ->orderBy('created_at', 'desc');
        $rows = $query->paginate(30);
        $price = $query->sum('price');
        $card = $query->sum('card');
        $pose = $query->sum('pose');
        $cache = $query->sum('cache');

        $users = User::where('role', 'user')->get();
        return view('panel.report.invoices', [
            'rows' => $rows,
            'users' => $users,
            'price' => $price,
            'pose' => $pose,
            'card' => $card,
            'cache' => $cache,
        ]);
    }

    public function export_invoices(Request $request)
    {
        $date = Jalalian::now()->format('Y-m-d');
        return Excel::download(new InvoiceExport(), $date . ' ' . 'فاکتور.xlsx');
    }
}
