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
            <h3>فاکتور ها</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">گزارشات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">فاکتور ها</li>
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
                    <form action="/report/export/invoices" method="get">
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
                        <input hidden type="text" autocomplete="off" name="plane_id"
                               value="{{request()->input('plane_id')}}"
                               class="form-control">
                        <button class="btn btn-danger">خروجی اکسل</button>
                    </form>
                </div>


            </div>


            <div id='search' style="display: none">
                <form method="get" action="/report/invoices">
                    @csrf
                    <div class="d-flex flex-row">
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
                            <label>تاریخ فروش از</label>
                            <input type="text" autocomplete="off" name="date-picker-shamsi-list"
                                   value="{{request()->input('date-picker-shamsi-list')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>تاریخ فروش تا</label>
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

            <br>
            <div class="d-flex flex-row">
                <div class="p-2">
                    <button class="btn btn-success"> کل مبالغ : &nbsp;<b>{{number_format($price)}}</b></button>
                </div>
                <div class="p-2">
                    <button class="btn btn-secondary"> پرداخت کارتی : &nbsp;<b>{{number_format($card)}}</b></button>
                </div>
                <div class="p-2">
                    <button class="btn btn-secondary"> پرداخت نقدی : &nbsp;<b>{{number_format($cache)}}</b></button>
                </div>
                <div class="p-2">
                    <button class="btn btn-secondary"> پرداخت با پوز : &nbsp;<b>{{number_format($pose)}}</b></button>
                </div>
                <div class="p-2">
                    <button class="btn btn-warning"> کل مانده : &nbsp;<b>{{number_format($price-($card+$cache+$pose))}}</b></button>
                </div>
            </div>
            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>خریدار</th>
                        <th>مبلغ فروش</th>
                        <th>پرداخت کارتی</th>
                        <th>پرداخت نقدی</th>
                        <th>پرداخت با پوز</th>
                        <th>مانده</th>
                        <th>تاریخ</th>
                        <th>فاکتور</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $idn = 1; ?>

                    @foreach($rows as $row)

                        <tr>
                            <td style="text-align: center">{{$idn}}</td>
                            <td>{{$row->user->name}} {{$row->user->family}}</td>
                            <td>{{number_format($row->price)}}</td>
                            <td>{{number_format($row->card)}}</td>
                            <td>{{number_format($row->cache)}}</td>
                            <td>{{number_format($row->pose)}}</td>
                            <td>{{number_format($row->price - ($row->card+$row->pose+$row->cache))}}</td>
                            <td>{{$row->payed_at}}</td>
                            <td><a target="_blank" href="/get_invoice/{{$row->id}}">
                                    <button class="btn btn-info">فاکتور</button>
                                </a></td>
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


