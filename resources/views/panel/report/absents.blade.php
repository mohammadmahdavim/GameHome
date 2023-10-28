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
            <h3>غیبت ها</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">گزارشات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">غیبت ها</li>
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
                    <form action="/report/export/absents" method="get">
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
                        <input hidden type="text" autocomplete="off" name="type"
                               value="{{request()->input('type')}}"
                               class="form-control">
                        <button class="btn btn-primary">خروجی اکسل</button>
                    </form>
                </div>

            </div>


            <div id='search' style="display: none">
                <form method="get" action="/report/absents">
                    @csrf
                    <div class="d-flex flex-row">

                        <div class="p-2">
                            <label>نوع</label>

                            <select class="js-example-basic-single" name="type">
                                <option></option>
                                <option @if(request()->type==1) selected
                                        @endif value="1">مهد
                                </option>
                                <option @if(request()->type==2) selected
                                        @endif value="2">کارگاه
                                </option>
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
                            <label>تاریخ غیبت از</label>
                            <input type="text" autocomplete="off" name="date-picker-shamsi-list"
                                   value="{{request()->input('date-picker-shamsi-list')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>تاریخ غیبت تا</label>
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
                        <th>نوع</th>
                        <th>حضورغیاب کننده</th>
                        <th>مشتری</th>
                        <th>تاریخ غیبت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $idn = 1; ?>

                    @foreach($rows as $row)

                        <tr style="text-align: center">
                            <td style="text-align: center">{{$idn}}</td>
                            <td>
                                @if($row->type==1)
                                    مهد
                                @else
                                    کارگاه
                                @endif
                            </td>
                            <td>{{$row->absenter->name}} {{$row->absenter->family}}</td>
                            <td>{{$row->user->name}} {{$row->user->family}}</td>
                            <td>{{$row->date}}</td>
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


