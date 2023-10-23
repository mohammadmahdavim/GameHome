<?php

namespace App\Exports;

use App\Models\SubInvoice;
use App\Models\UserPlane;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PlaneExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = request()->all();
        return SubInvoice::where('sub_invoiceable_type', UserPlane::class)
            ->with('user_plane.plane')
            ->with('user_plane.user')
            ->with('invoice')
            ->whereHas('user_plane', function ($q) use ($request) {
                if (isset($request['user_id'])) {
                    $q->where('user_id', $request['user_id']);
                }
                if (isset($request['plane_id'])) {
                    $q->where('plane_id', $request['plane_id']);
                }
                if (isset($request['start_date'])) {
                    $q->where('start_date', '>=', $request['start_date']);
                }
                if (isset($request['end_date'])) {
                    $q->where('start_date', '<=', $request['end_date']);
                }
            })
            ->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'پلن',
            'نوع پلن',
            'مبلغ فروش',
            'پرداخت کارتی',
            'پرداخت نقدی',
            'پرداخت با پوز',
            'مانده',
            'خریدار',
            'تاریخ',
        ];
    }

    public function map($preflight): array
    {
        if ($preflight->user_plane->plane->type == 'hourly') {
            $type = 'ساعتی';
        } elseif ($preflight->user_plane->plane->type == 'monthly') {
            $type = 'ماهانه';
        } elseif ($preflight->user_plane->plane->type == 'mahd') {
            $type = 'مهد';
        } else {
            $type = 'بدون اشتراک';
        }
        $data = [];
        $data['a'] = $preflight->user_plane->plane->title;
        $data['b'] = $type;
        $data['c'] = $preflight->price;
        $data['d'] = $preflight->invoice->card;
        $data['w'] = $preflight->invoice->cache;
        $data['x'] = $preflight->invoice->pose;
        $data['e'] = $preflight->user_plane->plane_price - $preflight->user_plane->payed;
        $data['f'] = $preflight->user_plane->user->name . ' ' . $preflight->user_plane->user->family;
        $data['g'] = $preflight->user_plane->start_date;
        return $data;


    }
}
