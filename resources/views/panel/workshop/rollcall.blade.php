@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
@endsection('css')
@section('script')
    <!-- begin::CKEditor -->
    <script src="/assets/vendors/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/examples/ckeditor.js"></script>
    <!-- end::CKEditor -->
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="/assets/js/examples/datepicker.js"></script>
    <!-- begin::sweet alert demo -->
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
    <script src="/assets/vendors/select2/js/select2.min.js"></script>
    <script src="/assets/js/examples/select2.js"></script>

@endsection('script')
@section('navbar')



@endsection('navbar')
@section('sidebar')

@endsection('sidebar')
@section('header')
    <div class="page-header">
        <div>
            <h3>لیست حضور غیاب امروز</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$workshop->name}} کارگاه </a></li>
                    <li class="breadcrumb-item active" aria-current="page">لیست حضور غیاب امروز</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>تصویر</th>
                        <th>نام</th>
                        <th>جمع جضور</th>
                        <th>نام پدر</th>
                        <th>نام مادر</th>
                        <th>همراه پدر</th>
                        <th>همراه مادر</th>
                        <th>کد عضویت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $idn = 1; ?>
                        @foreach($rows as $row)
                            <td style="text-align: center">{{$idn}}</td>
                            <td style="text-align: center">
                                <img @if($row->image) src="/user/{{$row->image}}"
                                     @else src="/login_image/happy-children-go-to-school-free-vector.jpg"
                                     @endif width="50" height="50" class="rounded">
                            </td>
                            <td style="text-align: center">{{$row->name}} {{$row->family}}</td>
                                <td style="text-align: center">{{minutes_to_time($row->workshop_roolcall_sum_sum)}}</td>
                                <td style="text-align: center">{{$row->father_name}}</td>
                            <td style="text-align: center">{{$row->mother_name}}</td>
                            <td style="text-align: center">{{$row->father_mobile}}</td>
                            <td style="text-align: center">{{$row->mother_mobile}}</td>
                            <td style="text-align: center">{{$row->code}}</td>
                            <td style="text-align: center">

                                    <button type="button" class="btn btn-success btn-sm" onclick="enter({{$row->id}},{{$workshop->id}})">ورود</button>


                                    <button type="button" class="btn btn-success btn-sm" onclick="exit({{$row->id}},{{$workshop->id}})">خروج</button>


                                    <button type="button" class="btn btn-danger btn-sm" onclick="absent({{$row->id}},{{$workshop->id}})">غایب</button>

                            </td>
                    </tr>
                    <?php $idn = $idn + 1 ?>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="/js/sweetalert.min.js"></script>

    @include('sweet::alert')

@endsection('content')
<script>
    function enter(id,workshopId) {
        swal({
            title: "آیا از ثبت مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/workshop/rollcall/enter/')  }}" + '/' + id+ '/' + workshopId,
                        type: "GET",

                        success: function () {
                            swal({
                                title: "ثبت ورود با موفقیت انجام شد!",
                                icon: "success",

                            });
                        },
                        error: function () {
                            swal({
                                title: "خطا...",
                                text: 'امروز یکبار ورود ثبت کرده اید.',
                                type: 'error',
                                timer: '1500'
                            })

                        }
                    });
                } else {
                    swal("عملیات  لغو گردید");
                }
            });

    }
    function exit(id,workshopId) {
        swal({
            title: "آیا از ثبت مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/workshop/rollcall/exit/')  }}" + '/' + id+ '/' + workshopId,
                        type: "GET",

                        success: function () {
                            swal({
                                title: "ثبت خروج با موفقیت انجام شد!",
                                icon: "success",

                            });
                        },
                        error: function () {
                            console.log('d');
                            swal({
                                title: "خطا...",
                                text: 'ابتدا ثبت ورود کنید.',
                                type: 'error',
                                timer: '1500'
                            })

                        }
                    });
                } else {
                    swal("عملیات  لغو گردید");
                }
            });

    }
    function absent(id) {
        swal({
            title: "آیا از ثبت مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/workshop/rollcall/absent/')  }}" + '/' + id,
                        type: "GET",

                        success: function () {
                            swal({
                                title: "ثبت غیبت با موفقیت انجام شد!",
                                icon: "success",

                            });
                        },
                        error: function () {
                            swal({
                                title: "خطا...",
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })

                        }
                    });
                } else {
                    swal("عملیات  لغو گردید");
                }
            });

    }


</script>

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
