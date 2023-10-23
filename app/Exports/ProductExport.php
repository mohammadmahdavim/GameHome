<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\SubInvoice;
use App\Models\UserPlane;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = request()->all();
        return SubInvoice::where('sub_invoiceable_type', Product::class)
            ->with('product')
            ->with('invoice.user')
            ->when(isset($request['item_id']), function ($query) use ($request) {
                $query->where('sub_invoiceable_id', $request['item_id']);
            })
            ->whereHas('invoice', function ($q) use ($request) {
                if (isset($request['user_id'])) {
                    $q->where('user_id', $request['user_id']);
                }
                if (isset($request['start_date'])) {
                    $q->where('payed_at', '>=', $request['start_date']);
                }
                if (isset($request['end_date'])) {
                    $q->where('payed_at', '<=', $request['end_date']);
                }
            })
            ->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'محصول',
            'مبلغ فروش',
//            'پرداخت کارتی',
//            'پرداخت نقدی',
//            'پرداخت با پوز',
            'خریدار',
            'تاریخ',
        ];
    }

    public function map($preflight): array
    {

        $data = [];
        $data['a'] = $preflight->product->name;
        $data['c'] = $preflight->price;
//        $data['d'] = $preflight->invoice->card;
//        $data['w'] = $preflight->invoice->cache;
//        $data['x'] = $preflight->invoice->pose;
        $data['f'] = $preflight->invoice->user->name . ' ' . $preflight->invoice->user->family;
        $data['g'] = $preflight->invoice->payed_at;
        return $data;


    }
}
