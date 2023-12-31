<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\lib\Kavenegar;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'father_mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $row = User::create([
            'national_code' => $data['national_code'],
            'father_job' => $data['father_job'],
            'name' => $data['name'],
            'family' => $data['family'],
            'father_name' => $data['father_name'],
            'mother_name' => $data['mother_name'],
            'father_mobile' => $data['father_mobile'],
            'mother_mobile' => $data['mother_mobile'],
            'birth_date' => $data['date-picker-shamsi-list'],
            'password' => Hash::make($data['password']),
        ]);

        $row->update([
            'code' => $row->id + 1000
        ]);
        Kavenegar::reserve($row->id, $row->father_mobile, Jalalian::forge($row->created_at)->format('Y/m/d'), '', 'register');
        //        alert()->success('به سایت خوش آمدید', 'موفق');
//        return redirect('/customer');
        return $row;


    }
}
