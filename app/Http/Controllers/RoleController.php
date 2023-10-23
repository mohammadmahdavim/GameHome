<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $rows = Role::all();
        $permissions = Permission::all();

        return view('panel.role.index', ['rows' => $rows, 'permissions' => $permissions]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $role = Role::create([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permissions);

        alert()->success('نقش جدید با موفقیت افزوده شد', 'عملیات موفق');

        return back();
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
        $role = Role::where('id', $id)->first();
        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permissions);

        alert()->success('نقش  با موفقیت ویرایش شد', 'عملیات موفق');

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
        $row = Role::where('id', $id)->first();
        $row->delete();
    }

    public function syncRoles(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        $user->syncRoles($request->roles);
        alert()->success('دسترسی ها  با موفقیت ویرایش شد', 'عملیات موفق');

        return back();
    }

}
