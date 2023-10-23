@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
@endsection('css')
@section('script')
    <script>
        jQuery(document).ready(function () {
            jQuery('#hideshow').on('click', function (event) {
                jQuery('#search').toggle('show');
            });
        });
    </script>
    <!-- begin::CKEditor -->
    <script src="/assets/vendors/select2/js/select2.min.js"></script>
    <script src="/assets/js/examples/select2.js"></script>
    <!-- end::CKEditor -->
@endsection('script')
@section('navbar')



@endsection('navbar')
@section('sidebar')

@endsection('sidebar')
@section('header')
    <div class="page-header">
        <div>
            <h3>لیست</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">گزارشات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">لیست</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="card-body">
            <input type='button' class="btn btn-warning" id='hideshow' value='جستجوی پیشرفته'>
            <br>
            <div id='search' style="display: none">
                <form method="get" action="/user_report">
                    @csrf
                    <br>
                    <div class="d-flex flex-row">
                        <div class="p-2">
                        </div>
                        <div class="p-2">
                            <h6><label>ارسال کننده </label></h6>
                            <select class="js-example-basic-single" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                                @endforeach
                            </select>
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
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>فرستنده</th>
                        <th>تاریخ ایجاد</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $idn = 1; ?>
                        @foreach($rows as $row)
                            <td style="text-align: center">{{$idn}}</td>

                            <td style="text-align: center">{{$row->title}}</td>
                            <td style="text-align: center">{!! $row->body !!}</td>
                            <td style="text-align: center">{{$row->user->name}} {{$row->user->family}}</td>
                            <td style="text-align: center">{{\Morilog\Jalali\Jalalian::forge($row->created_at->toDateString())->format('Y-m-d')}}</td>

                    </tr>
                    <?php $idn = $idn + 1 ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $rows->withQueryString()->links("pagination::bootstrap-4") !!}

        </div>
    </div>

    <script src="/js/sweetalert.min.js"></script>

    @include('sweet::alert')

@endsection('content')


