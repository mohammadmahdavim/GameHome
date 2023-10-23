<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $rows = User::whereNotIn('role', ['user','admin'])
            ->with('roles')
            ->get();
        $roles = Role::all();
        return view('panel.user.staff', ['rows' => $rows, 'roles' => $roles]);
    }
}
