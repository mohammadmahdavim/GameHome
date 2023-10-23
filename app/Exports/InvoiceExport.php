<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\SubInvoice;
use App\Models\UserPlane;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoiceExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = request()->all();
        return Invoice::
        when(isset($request['user_id']), function ($query) use ($request) {
            $query->where('user_id', $request['user_id']);
        })
            ->when(isset($request['date-picker-shamsi-list']), function ($query) use ($request) {
                $query->where('payed_at', '>=', $request['date-picker-shamsi-list']);
            })
            ->when(isset($request['date-picker-shamsi-list-1']), function ($query) use ($request) {
                $query->where('payed_at', '<=', $request['date-picker-shamsi-list-1']);
            })->get();
    }

    public
    function headings(): array
    {
        return [
            'خریدار',
            'مبلغ فروش',
            'پرداخت کارتی',
            'پرداخت نقدی',
            'پرداخت با پوز',
            'مانده',
            'تاریخ',
        ];
    }

    public
    function map($preflight): array
    {

        $data = [];
        $data['f'] = $preflight->user->name . ' ' . $preflight->user->family;
        $data['c'] = $preflight->price;
        $data['d'] = $preflight->card;
        $data['w'] = $preflight->cache;
        $data['x'] = $preflight->pose;
        $data['a'] = $preflight->price - ($preflight->card + $preflight->pose + $preflight->cache);
        $data['g'] = $preflight->payed_at;
        return $data;


    }
}
