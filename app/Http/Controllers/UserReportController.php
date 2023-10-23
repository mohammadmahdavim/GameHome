<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    public function index(Request $request)
    {
        $rows = Report::orderBy('created_at', 'desc')
            ->where('for_manager', 1)
            ->when($request->get('user_id'), function ($query) use ($request) {
                $query->where('user_id',$request->user_id );
            })
            ->paginate(30);
        $users = User::whereNotIn('role', ['user'])->get();

        return view('panel.user_report.index', ['rows' => $rows,'users'=>$users]);
    }

    public function my_reports()
    {
        $rows = Report::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('panel.user_report.my_reports', ['rows' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_to_manger()
    {
        return view('panel.user_report.create_to_manger');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_to_parent()
    {
        $users = User::where('role', 'user')->get();
        return view('panel.user_report.create_to_parent', ['users' => $users]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $row = Report::create([
            'title' => $request->title,
            'body' => $request->body,
            'receiver' => $request->receiver,
            'for_manager' => $request->for_manager,
            'user_id' => auth()->user()->id,

        ]);
        alert()->success('گزارش جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('user_reports/my_reports');
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
        $row = Report::where('id', $id)->first();
        $row->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        alert()->success('گزارش  با موفقیت ویرایش شد', 'عملیات موفق');

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
        $row = Report::where('id', $id)->first();
        $row->delete();
    }
}
