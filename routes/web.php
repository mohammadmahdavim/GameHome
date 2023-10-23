<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'level'], function () {

        Route::resource('roles', \App\Http\Controllers\RoleController::class);
        Route::any('roles/delete/{id}', [\App\Http\Controllers\RoleController::class, 'destroy']);
        Route::post('syncRoles', [\App\Http\Controllers\RoleController::class, 'syncRoles']);



        Route::get('get_invoice/{id}', [\App\Http\Controllers\InvoiceController::class, 'get_invoice']);
        Route::get('cards', [\App\Http\Controllers\UserController::class, 'cards'])->middleware('can:user-list');
        Route::get('card/{id}', [\App\Http\Controllers\UserController::class, 'card']);

        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);


        Route::get('user_reports/create_to_manger', [\App\Http\Controllers\UserReportController::class, 'create_to_manger'])->middleware('can:report-create');
        Route::get('user_reports/create_to_parent', [\App\Http\Controllers\UserReportController::class, 'create_to_parent'])->middleware('can:report-create');
        Route::get('user_reports/my_reports', [\App\Http\Controllers\UserReportController::class, 'my_reports'])->middleware('can:report-create');
        Route::resource('user_report', \App\Http\Controllers\UserReportController::class)->middleware('can:report-create');
        Route::any('user_report/delete/{id}', [\App\Http\Controllers\UserReportController::class, 'destroy'])->middleware('can:report-create');

        Route::resource('blogs', \App\Http\Controllers\BlogController::class);
        Route::any('blogs/delete/{id}', [\App\Http\Controllers\BlogController::class, 'destroy']);
        Route::any('blogs/files/{id}', [\App\Http\Controllers\BlogController::class, 'files']);

        Route::post('files/store', [\App\Http\Controllers\FileController::class, 'store']);
        Route::any('files/delete/{id}', [\App\Http\Controllers\FileController::class, 'delete']);
        Route::any('files/download/{id}', [\App\Http\Controllers\FileController::class, 'downloadfile']);

        Route::resource('services', \App\Http\Controllers\ServiceController::class)->middleware('can:service-list');;
        Route::any('services/delete/{id}', [\App\Http\Controllers\ServiceController::class, 'destroy'])->middleware('can:service-list');;

        Route::resource('products', \App\Http\Controllers\ProductController::class)->middleware('can:product-list');;
        Route::any('products/delete/{id}', [\App\Http\Controllers\ProductController::class, 'destroy'])->middleware('can:product-list');;
        Route::post('products/inventory', [\App\Http\Controllers\ProductController::class, 'inventory'])->middleware('can:product-list');;

        Route::resource('planes', \App\Http\Controllers\PlaneController::class)->middleware('can:palne-list');
        Route::get('planes_list/{type}', [\App\Http\Controllers\PlaneController::class, 'planes_list'])->middleware('can:palne-list');
        Route::any('planes/delete/{id}', [\App\Http\Controllers\PlaneController::class, 'destroy'])->middleware('can:palne-list');
        Route::get('planes/students/{id}', [\App\Http\Controllers\PlaneController::class, 'students'])->middleware('can:palne-list');
        Route::get('planes/classes/{id}', [\App\Http\Controllers\PlaneController::class, 'classes'])->middleware('can:palne-list');
        Route::post('classes/store', [\App\Http\Controllers\PlaneController::class, 'classes_store'])->middleware('can:palne-list');
        Route::any('classes/update/{id}', [\App\Http\Controllers\PlaneController::class, 'classes_update'])->middleware('can:palne-list');
        Route::any('classes/delete/{id}', [\App\Http\Controllers\PlaneController::class, 'classes_delete'])->middleware('can:palne-list');
        Route::any('classes/students/{id}', [\App\Http\Controllers\PlaneController::class, 'classes_students'])->middleware('can:palne-list');
        Route::any('classes_students/delete/{id}', [\App\Http\Controllers\PlaneController::class, 'classes_delete_students'])->middleware('can:palne-list');
        Route::post('classes_students/add', [\App\Http\Controllers\PlaneController::class, 'classes_add_students'])->middleware('can:palne-list');

        Route::get('planes/rollcall/{id}', [\App\Http\Controllers\PlaneController::class, 'rollcall'])->middleware('can:plane-rollcall');
        Route::get('planes/rollcall/enter/{id}', [\App\Http\Controllers\PlaneController::class, 'rollcall_enter'])->middleware('can:plane-rollcall');
        Route::get('planes/rollcall/exit/{id}', [\App\Http\Controllers\PlaneController::class, 'rollcall_exit'])->middleware('can:plane-rollcall');
        Route::get('planes/rollcall/absent/{id}', [\App\Http\Controllers\PlaneController::class, 'rollcall_absent'])->middleware('can:plane-rollcall');

        Route::post('users/add_plane', [\App\Http\Controllers\UserController::class, 'add_plane'])->middleware('can:user-list');;
        Route::post('users/add_pay', [\App\Http\Controllers\UserController::class, 'add_pay'])->middleware('can:user-list');;
        Route::any('users/delete_plane/{id}', [\App\Http\Controllers\UserController::class, 'delete_plane'])->middleware('can:user-list');;
        Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('can:user-list');;
        Route::any('users/delete/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:user-list');;
        Route::get('staff', [\App\Http\Controllers\StaffController::class, 'index'])->middleware('can:user-list');;


        Route::get('rollcall/mobile_scan', [\App\Http\Controllers\RollcallController::class, 'mobile_scan'])->middleware('can:rollcall');
        Route::get('rollcall', [\App\Http\Controllers\RollcallController::class, 'today'])->middleware('can:rollcall');
        Route::any('rollcall/delete/{id}', [\App\Http\Controllers\RollcallController::class, 'delete'])->middleware('can:rollcall');
        Route::post('attendance', [\App\Http\Controllers\RollcallController::class, 'update'])->middleware('can:rollcall');
        Route::post('/attendance/inquiry', [\App\Http\Controllers\RollcallController::class, 'inquiry'])->middleware('can:rollcall');
        Route::get('/scanCheck/{id}', [\App\Http\Controllers\RollcallController::class, 'scanCheck'])->middleware('can:rollcall');

        Route::get('invoice/create', [\App\Http\Controllers\InvoiceController::class, 'create'])->middleware('can:factor-create');
        Route::post('invoice/set_session', [\App\Http\Controllers\InvoiceController::class, 'set_session'])->middleware('can:factor-create');
        Route::get('unset_session/{track_id}', [\App\Http\Controllers\InvoiceController::class, 'unset_session'])->middleware('can:factor-create');
        Route::post('invoice/store', [\App\Http\Controllers\InvoiceController::class, 'store'])->middleware('can:factor-create');
        Route::post('clearing', [\App\Http\Controllers\UserController::class, 'clearing'])->middleware('can:factor-create');

        Route::resource('workshop_type', \App\Http\Controllers\WorkshopTypeController::class)->middleware('can:workshop-list');
        Route::any('workshop_type/delete/{id}', [\App\Http\Controllers\WorkshopTypeController::class, 'destroy'])->middleware('can:workshop-list');
        Route::resource('workshop', \App\Http\Controllers\WorkshopController::class)->middleware('can:workshop-list');
        Route::get('workshop/students/{id}', [\App\Http\Controllers\WorkshopController::class, 'students'])->middleware('can:workshop-list');
        Route::post('workshop/add_student', [\App\Http\Controllers\WorkshopController::class, 'add_student'])->middleware('can:workshop-list');
        Route::any('workshop/delete_student/{id}', [\App\Http\Controllers\WorkshopController::class, 'delete_student'])->middleware('can:workshop-list');
        Route::any('workshop/delete/{id}', [\App\Http\Controllers\WorkshopController::class, 'destroy'])->middleware('can:workshop-list');

        Route::get('workshop/rollcall/{id}', [\App\Http\Controllers\WorkshopController::class, 'rollcall'])->middleware('can:workshop-rollcall');
        Route::get('workshop/rollcall/enter/{id}/{workshopID}', [\App\Http\Controllers\WorkshopController::class, 'rollcall_enter'])->middleware('can:workshop-rollcall');
        Route::get('workshop/rollcall/exit/{id}/{workshopID}', [\App\Http\Controllers\WorkshopController::class, 'rollcall_exit'])->middleware('can:workshop-rollcall');
        Route::get('workshop/rollcall/absent/{id}', [\App\Http\Controllers\WorkshopController::class, 'rollcall_absent'])->middleware('can:workshop-rollcall');
        Route::any('workshop/delete_staff/{id}', [\App\Http\Controllers\WorkshopController::class, 'delete_staff'])->middleware('can:workshop-list');
        Route::any('workshop/add_staff', [\App\Http\Controllers\WorkshopController::class, 'add_staff'])->middleware('can:workshop-list');

        Route::get('all_reserve', [\App\Http\Controllers\ReserveController::class,'all_reserve'])->middleware('can:reserve');
        Route::post('accept_reserve', [\App\Http\Controllers\ReserveController::class,'accept_reserve'])->middleware('can:reserve');
        Route::get('decline_reserve/{id}', [\App\Http\Controllers\ReserveController::class,'decline_reserve'])->middleware('can:reserve');


        Route::get('report', [\App\Http\Controllers\RollcallController::class, 'today']);
        Route::group(['prefix' => 'report'], function () {
            Route::get('/rollcall', [\App\Http\Controllers\ReportController::class, 'rollcall'])->middleware('can:all-reports');
            Route::get('/planes', [\App\Http\Controllers\ReportController::class, 'planes'])->middleware('can:all-reports');
            Route::get('/products', [\App\Http\Controllers\ReportController::class, 'products'])->middleware('can:all-reports');
            Route::get('/services', [\App\Http\Controllers\ReportController::class, 'services'])->middleware('can:all-reports');
            Route::get('/invoices', [\App\Http\Controllers\ReportController::class, 'invoices'])->middleware('can:all-reports');

            Route::group(['prefix' => 'export'], function () {
                Route::get('/rollcall', [\App\Http\Controllers\ReportController::class, 'export_rollcall'])->middleware('can:all-reports');
                Route::get('/planes', [\App\Http\Controllers\ReportController::class, 'export_planes'])->middleware('can:all-reports');
                Route::get('/products', [\App\Http\Controllers\ReportController::class, 'export_products'])->middleware('can:all-reports');
                Route::get('/services', [\App\Http\Controllers\ReportController::class, 'export_services'])->middleware('can:all-reports');
                Route::get('/invoices', [\App\Http\Controllers\ReportController::class, 'export_invoices'])->middleware('can:all-reports');

            });
        });
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [\App\Http\Controllers\CustomerController::class, 'index']);
        Route::get('/workshops', [\App\Http\Controllers\CustomerController::class, 'workshops']);
        Route::get('/planes', [\App\Http\Controllers\CustomerController::class, 'plans']);
        Route::get('/rollcalls', [\App\Http\Controllers\CustomerController::class, 'rollcalls']);
        Route::get('/absents', [\App\Http\Controllers\CustomerController::class, 'absents']);
        Route::get('/invoices', [\App\Http\Controllers\CustomerController::class, 'invoices']);
        Route::get('/user_reports', [\App\Http\Controllers\CustomerController::class, 'user_reports']);
        Route::get('/card', [\App\Http\Controllers\CustomerController::class, 'card']);
        Route::resource('reserve', \App\Http\Controllers\ReserveController::class);
        Route::any('reserve/delete/{id}', [\App\Http\Controllers\ReserveController::class, 'destroy']);
        Route::post('pay', [\App\Http\Controllers\PaymentController::class, 'pay']);

    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('payment/checkout/{token}', [\App\Http\Controllers\PaymentController::class, 'checkout'])->middleware(['auth']);
Route::post('payment/checkout/{token}', [\App\Http\Controllers\PaymentController::class, 'checkout'])->middleware(['auth']);
Route::get('payment/bank-redirect/{bank}', [\App\Http\Controllers\PaymentController::class, 'bankRedirect'])->middleware(['auth']);
