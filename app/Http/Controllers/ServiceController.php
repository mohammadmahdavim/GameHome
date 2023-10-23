<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Service::paginate(30);
        return view('panel.service.index', ['rows' => $rows]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $row = Service::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        alert()->success('سرویس جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('services');
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
        $row = Service::where('id', $id)->first();
        $row->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        alert()->success('سرویس با موفقیت ویرایش شد', 'عملیات موفق');

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
        $row = Service::where('id', $id)->first();
        $row->delete();
    }
}
