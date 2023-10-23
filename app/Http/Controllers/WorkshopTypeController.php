<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\WorkshopType;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class WorkshopTypeController extends Controller
{
    public function index()
    {
        $rows = WorkshopType::paginate(30);
        return view('panel.workshop_type.index', ['rows' => $rows]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $row = WorkshopType::create([
            'name' => $request->name,
        ]);
        alert()->success('دسته بندی جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('workshop_type');
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
        $row = WorkshopType::where('id', $id)->first();
        $row->update([
            'name' => $request->name,
        ]);
        alert()->success('دسته بندی جدید با موفقیت افزوده شد', 'عملیات موفق');

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
        $row = WorkshopType::where('id', $id)->first();
        $row->delete();
    }


}
