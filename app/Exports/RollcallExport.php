<?php

namespace App\Exports;

use App\Models\Rollcall;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RollcallExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = request()->all();

        return Rollcall::with('user')
            ->when(isset($request['user_id']), function ($query) use ($request) {
                $query->where('user_id', $request['user_id']);
            })
            ->when(isset($request['start_date']), function ($query) use ($request) {
                $query->where('date', '>=', $request['start_date']);
            })
            ->when(isset($request['end_date']), function ($query) use ($request) {
                $query->where('date', '<=', $request['end_date']);
            })
            ->when(isset($request['calculable']), function ($query) use ($request) {

                $query->where('calculable', $request['calculable'] == 'normal' ? 1 : 0);
            })
            ->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'نوع',
            'نام',
            'تاریخ',
            'ورود',
            'خروج',
            'حضور',
            'تعداد',
            'جمع ساعت',
        ];
    }

    public function map($preflight): array
    {

        $data = [];
        $data['z'] = $preflight->calculable==1 ? 'عادی' : 'مهد';
        $data['a'] = $preflight->user->name . ' ' . $preflight->user->family;
        $data['b'] = $preflight->date;
        $data['c'] = $preflight->enter;
        $data['d'] = $preflight->exit;
        $data['e'] = $preflight->duration;
        $data['f'] = $preflight->count;
        $data['g'] = $preflight->sum;
        return $data;


    }
}
