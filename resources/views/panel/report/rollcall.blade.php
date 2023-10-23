@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">

@endsection('css')
@section('script')

    <!-- begin::select2 -->
    <script src="/assets/vendors/select2/js/select2.min.js"></script>
    <script src="/assets/js/examples/select2.js"></script>
    <!-- end::select2 -->
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="/assets/js/examples/datepicker.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
    <script>
        jQuery(document).ready(function () {
            jQuery('#hideshow').on('click', function (event) {
                jQuery('#search').toggle('show');
            });
        });
    </script>
@endsection('script')
@section('navbar')



@endsection('navbar')
@section('sidebar')

@endsection('sidebar')
@section('header')
    <div class="page-header">
        <div>
            <h3>تردد</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">گزارشات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تردد</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row">
                <div class="p-2"><input type='button' class="btn btn-warning" id='hideshow' value='جستجوی پیشرفته'>
                </div>
                <div class="p-2">
                    <form action="/report/export/rollcall" method="get">
                        @csrf
                        <input hidden type="text" autocomplete="off" name="start_date"
                               value="{{request()->input('date-picker-shamsi-list')}}"
                               class="form-control">
                        <input hidden type="text" autocomplete="off" name="end_date"
                               value="{{request()->input('date-picker-shamsi-list-1')}}"
                               class="form-control">
                        <input hidden type="text" autocomplete="off" name="user_id"
                               value="{{request()->input('user_id')}}"
                               class="form-control">
                        <input hidden type="text" autocomplete="off" name="calculable"
                               value="{{request()->input('calculable')}}"
                               class="form-control">
                        <button class="btn btn-primary">خروجی اکسل</button>
                    </form>
                </div>
                <div class="p-2">
                    <button class="btn btn-success"> جمع کل ساعت : &nbsp;<b>{{minutes_to_time($sum)}}</b></button>
                </div>
            </div>


            <div id='search' style="display: none">
                <form method="get" action="/report/rollcall">
                    @csrf
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            <label>نوع تردد</label>
                            <select class="form-control" name="calculable">
                                <option selected></option>
                                <option @if(request()->calculable=='normal') selected @endif value="normal">عادی</option>
                                <option @if(request()->calculable=='mahd') selected @endif value="mahd">مهد</option>
                            </select>
                        </div>
                        <div class="p-2">
                            <label>نام مشتری</label>
                            <select class="js-example-basic-single" name="user_id">
                                <option></option>
                                @foreach($users as $user)
                                    <option @if(request()->user_id==$user->id) selected
                                            @endif value="{{$user->id}}">{{$user->name}}
                                        &nbsp;{{$user->family}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="p-2">
                            <label>تاریخ حضور از</label>
                            <input type="text" autocomplete="off" name="date-picker-shamsi-list"
                                   value="{{request()->input('date-picker-shamsi-list')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>تاریخ حضور تا</label>
                            <input type="text" autocomplete="off" name="date-picker-shamsi-list-1"
                                   value="{{request()->input('date-picker-shamsi-list-1')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <br>
                            <button type="submit" class="btn btn-info">جستجوکن</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>تصویر</th>
                        <th>نوع</th>
                        <th>نام</th>
                        <th>تاریخ</th>
                        <th>ورود</th>
                        <th>خروج</th>
                        <th>حضور</th>
                        <th>تعداد</th>
                        <th>جمع ساعت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $idn = 1; ?>

                    @foreach($rows as $row)

                        <tr>
                            <td style="text-align: center">{{$idn}}</td>
                            <td style="text-align: center">
                                <img @if(isset($row->user->image)) src="/user/{{$row->user->image}}"
                                     @else src="/icon.png"
                                     @endif width="50" height="50" class="rounded">
                            </td>
                            <td>
                                {{$row->calculable==1  ? 'عادی' : 'مهد'}}
                            </td>
                            <td>{{$row->user->name}} {{$row->user->family}}</td>
                            <td>{{$row->date}}</td>
                            <td>{{$row->enter}}</td>
                            <td>{{$row->exit}}</td>
                            <td>{{minutes_to_time($row->duration)}}</td>
                            <td>{{$row->count}}</td>
                            <td>{{minutes_to_time($row->sum)}}</td>

                        </tr>
                        <?php $idn = $idn + 1 ?>

                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $rows->withQueryString()->links("pagination::bootstrap-4") !!}

        </div>
    </div>

@endsection('content')
<?php
function minutes_to_time($minutes)
{
    if ($minutes < 0) {
        $allMinutes = $minutes * (-1);
    } else {
        $allMinutes = $minutes;
    }
    $hour = floor($allMinutes / 60);
    if ($hour < 10) {
        $hour = '0' . $hour;
    }
    $allMinutes = fmod($allMinutes, '60');
    if ($allMinutes < 10) {
        $allMinutes = '0' . $allMinutes;
    }
    $time = $hour . ':' . $allMinutes;
    if ($minutes < 0) {
        return $time . '-';
    } else {
        return $time;
    }

}
?>


