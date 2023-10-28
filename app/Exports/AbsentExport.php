<?php

namespace App\Exports;

use App\Models\Absent;
use App\Models\Service;
use App\Models\SubInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsentExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = request()->all();
        return Absent::
        when(isset($request['user_id']), function ($query) use ($request) {
            $query->where('user_id', $request['user_id']);
        })->
        when(isset($request['type']), function ($query) use ($request) {
            $query->where('type', $request['type']);
        })
            ->when(isset($request['date-picker-shamsi-list']), function ($query) use ($request) {
                $query->where('date', '>=', $request['date-picker-shamsi-list']);
            })
            ->when(isset($request['date-picker-shamsi-list-1']), function ($query) use ($request) {
                $query->where('date', '<=', $request['date-picker-shamsi-list-1']);
            })
            ->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'نوع',
            'حضورغیاب کننده',
            'مشتری',
            'تاریخ غیبت',
        ];
    }

    public function map($preflight): array
    {

        $data = [];
        $data['e'] = $preflight->invoice == 1 ? 'مهد' : 'کارگاه';
        $data['f'] = $preflight->absenter->name . ' ' . $preflight->absenter->family;
        $data['r'] = $preflight->user->name . ' ' . $preflight->user->family;
        $data['g'] = $preflight->date;
        return $data;


    }
}
