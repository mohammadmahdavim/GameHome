<?php

namespace App\Http\Controllers;

use App\lib\Kavenegar;
use App\Models\Absent;
use App\Models\MahdClass;
use App\Models\Plane;
use App\Models\Rollcall;
use App\Models\User;
use App\Models\UserPlane;
use http\Client\Response;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use DateTime;

class PlaneController extends Controller
{
    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->fileController = new FileController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Plane::all();
        return view('panel.plane.index', ['rows' => $rows]);
    }

    public function planes_list($type)
    {
        $rows = Plane::where('type', $type)->get();
        return view('panel.plane.' . $type, ['rows' => $rows]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $row = Plane::create([
            'title' => $request->title,
            'type' => $request->type,
            'hour' => $request->hour,
            'price' => $request->price,
            'month' => $request->month,
            'service' => $request->service,
            'service_price' => $request->service_price,
            'shift' => $request->shift ? $request->shift : 'صبح',
            'author' => auth()->user()->id,

        ]);
        $this->fileController->getUploadImage($request, $row, 'plane');
        alert()->success('پلن جدید با موفقیت افزوده شد', 'عملیات موفق');

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
        $row = Plane::where('id', $id)->first();
        $row->update([
            'title' => $request->title,
            'type' => $request->type,
            'hour' => $request->hour,
            'price' => $request->price,
            'service' => $request->service,
            'service_price' => $request->service_price,
            'month' => $request->month,
            'shift' => $request->shift ? $request->shift : 'صبح',
        ]);
        $this->fileController->getUploadImage($request, $row, 'plane');
        alert()->success('پلن با موفقیت ویرایش شد.', 'عملیات موفق');

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
        $row = Plane::where('id', $id)->first();
        $row->delete();
    }

    public function files($id)
    {
        $files = Plane::where('id', $id)->with('files')->first();
        return view('panel.plane.files', ['id' => $id, 'model' => 'App\Models\Blog', 'files' => $files]);
    }

    public function students($id)
    {
        $plane = Plane::where('id', $id)->first();
        $userPlanes = UserPlane::where('plane_id', $id)->pluck('user_id');
        $users = User::whereIn('id', $userPlanes)->get();
        return view('panel.plane.students', ['rows' => $users, 'plane' => $plane]);
    }

    public function classes($id)
    {
        $plane = Plane::where('id', $id)->first();
        $classes = MahdClass::where('plane_id', $id)->get();
        return view('panel.plane.classes', ['rows' => $classes, 'plane' => $plane]);

    }

    public function classes_store(Request $request)
    {
        MahdClass::create([
            'name' => $request->name,
            'description' => $request->description,
            'plane_id' => $request->plane_id,
        ]);

        alert()->success('کلاس با موفقیت ایجاد شد.', 'عملیات موفق');

        return back();
    }

    public function classes_update(Request $request, $id)
    {
        $row = MahdClass::where('id', $id)->first();
        $row->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        alert()->success('کلاس با موفقیت ویرایش شد.', 'عملیات موفق');

        return back();
    }

    public function classes_delete($id)
    {
        $row = MahdClass::where('id', $id)->first();
        $row->delete();

        alert()->success('کلاس با موفقیت ویرایش شد.', 'عملیات موفق');

        return back();
    }

    public function classes_students($id)
    {

        $allStudents = User::where('role', 'user')->whereNull('mahd_class_id')->get();
        $students = User::where('role', 'user')
            ->where('mahd_class_id', $id)
            ->get();
        $class = MahdClass::where('id', $id)->first();
        $plane = Plane::where('id', $class->plane_id)->first();

        return view('panel.plane.classes_students', ['rows' => $students, 'plane' => $plane, 'allStudents' => $allStudents, 'class' => $class]);
    }

    public function classes_add_students(Request $request)
    {

        $planeId = MahdClass::where('id', $request->mahd_class_id)->pluck('plane_id')->first();
        $plane = Plane::where('id', $planeId)->first();
        $payed = $request->card + $request->cache + $request->pose;
        $id = UserPlane::create([
            'plane_id' => $planeId,
            'user_id' => $request->student_id,
            'plane_price' => $plane->price,
            'payed' => $payed,
            'start_date' => Jalalian::now()->format('Y-m-d'),
        ])->id;
        $user = User::where('id', $request->student_id)->first();
        $user->update([
            'mahd_class_id' => $request->mahd_class_id
        ]);
        $userController = new UserController();
        $userController->creat_invoice($request->student_id, $plane->price, Jalalian::now()->format('Y-m-d'), $request->card, $request->pose, $request->cache, UserPlane::class, $id);
        alert()->success('دانش آموز به کلاس افزوده شد.', 'عملیات موفق');

        return back();
    }

    public function classes_delete_students($userId)
    {
        $user = User::where('id', $userId)->first();

        $class = MahdClass::where('id', $user->mahd_class_id)->first();
        $userPlane = UserPlane::where('user_id', $userId)->where('plane_id', $class->plane_id)->first();
        $userPlane->sub_invoice[0]->invoice->delete();
        $userPlane->sub_invoice[0]->delete();
        $userPlane->delete();
        $user->update([
            'mahd_class_id' => NULL
        ]);
    }

    public function rollcall($id)
    {
        $planeId = MahdClass::where('id', $id)->pluck('plane_id')->first();
        $students = User::where('role', 'user')
            ->where('mahd_class_id', $id)
            ->withsum('mahd_roolcall', 'sum', function ($q) use ($planeId) {
                $q->where('plane_id', $planeId);
            })
            ->get();
        $class = MahdClass::where('id', $id)->first();

        return view('panel.plane.rollcall', ['rows' => $students, 'class' => $class]);

    }

    public function rollcall_enter($id)
    {
        $user = User::where('id', $id)->first();
        $check = Rollcall::where('user_id', $user->id)
            ->where('date', Jalalian::now()->format('Y-m-d'))
            ->where('calculable', 0)
            ->orderBy('created_at', 'desc')
            ->first();
        $class = MahdClass::where('id', $user->mahd_class_id)->first();
        $timeNow = Jalalian::now()->format('H:i');
        if (!$check) {
            $check = Rollcall::create([
                'calculable' => 0,
                'user_id' => $user->id,
                'plane_id' => $class->plane_id,
                'date' => Jalalian::now()->format('Y-m-d'),
                'type' => 'system',
                'enter' => $timeNow,
                'author' => auth()->user()->id
            ]);
            return 'ok';
        } else {
            return response('', '500');

        }

    }

    public function rollcall_exit($id)
    {
        $user = User::where('id', $id)->first();
        $check = Rollcall::where('user_id', $user->id)
            ->where('date', Jalalian::now()->format('Y-m-d'))
            ->where('calculable', 0)
            ->orderBy('created_at', 'desc')
            ->first();
        $timeNow = Jalalian::now()->format('H:i');
        if ($check) {
            $check->update([
                'exit' => $timeNow,
            ]);
            $row = Rollcall::where('id', $check->id)->first();
            $enter = $row->enter;
            $exit = $row->exit;
            if ($exit and $enter) {
                $start_datetime = new DateTime($enter);
                $diff = $start_datetime->diff(new DateTime($exit));
                $total_minutes = ($diff->h * 60);
                $total_minutes += $diff->i;
                $row->update(['sum' => $total_minutes * $row->count, 'duration' => $total_minutes]);
            }
        } else {
            return response('', '500');

        }

    }

    public function rollcall_absent($id)
    {
        $user = User::where('id', $id)->first();
        $absent = Absent::where('user_id', $user->id)
            ->where('date', Jalalian::now()->format('Y-m-d'))
            ->where('type', 1)
            ->first();
        if (!$absent) {
            Absent::create([
                'user_id' => $user->id,
                'date' => Jalalian::now()->format('Y-m-d'),
                'author' => auth()->user()->id
            ]);
            Kavenegar::reserve($user->id,$user->father_mobile, Jalalian::now()->format('Y-m-d'), 'غیبت','absent');
        }

    }


}
