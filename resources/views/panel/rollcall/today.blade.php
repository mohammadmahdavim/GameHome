@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
    <link rel="stylesheet" href="/assets/vendors/clockpicker/bootstrap-clockpicker.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
@endsection('css')
@section('script')
    <script src="/js/num2persian-min.js"></script>
    <script src="/js/number-divider.min.js"></script>
    <script>

        $(document).on('focus', '.price-box-product input', function () {
            var boxPrice = $(this).siblings('.price-box-product-content');
            boxPrice.fadeIn(100);
            boxPrice.find('.price-box-numbers').html($(this).val())
            boxPrice.find('.price-box-numbers').divide({
                delimiter: ',',
                divideThousand: false
            });
            var e = this;
            this.nextSibling.nextElementSibling.children[3].childNodes[1].nextElementSibling.innerHTML = e.value
                .toPersianLetter()
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                this.nextSibling.nextElementSibling.children[3].childNodes[1].nextElementSibling.innerHTML = e.value
                    .toPersianLetter();
            }
        });

        $(document).on('click', '.price-box-product-content button.close', function () {
            $(this).parents('.price-box-product-content').fadeOut(100);
        })

        $(document).on('blur', '.price-box-product input', function () {
            $(this).siblings('.price-box-product-content').fadeOut(100);
        });

        $(document).on('keyup', '.price-box-product input', function () {
            var boxPrice = $(this).siblings('.price-box-product-content');
            boxPrice.find('.price-box-numbers').html($(this).val());
            boxPrice.find('.price-box-numbers').divide({
                delimiter: ',',
                divideThousand: false
            });
        });
    </script>
    <script src="/assets/vendors/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/examples/ckeditor.js"></script>
    <!-- end::CKEditor -->
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="/assets/js/examples/datepicker.js"></script>
    <!-- begin::sweet alert demo -->

    <script src="/assets/vendors/select2/js/select2.min.js"></script>
    <script src="/assets/js/examples/select2.js"></script>
    <!-- begin::CKEditor -->

    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function showScan() {
            if ($('#scan-input').css('display') == 'none') {
                $('#scan-input').show(250);
                $('#myinputbox').focus();
            } else {
                $('#scan-input').hide(250);
            }
        }

        // $('#myinputbox').keypress(function () {
        //     event.preventDefault();
        //     return false;
        // })

        // function setup() {
        // document.getElementById("name1").focus();
        // }

        // window.addEventListener('load', setup, false);

        function scan() {
            $.ajax({
                url: '/scanCheck' + '/' + document.getElementById("myinputbox").value,
                type: "GET",
                success: function (response) {
                    if (response['type'] == 'enter') {
                        audio = new Audio('/enter.mp3');
                        audio.play();
                        swal({
                            title: "ثبت ورود",
                            text: "ورود " + response['name'] + " در ساعت " + response['time'] + " ثبت شد",
                            icon: "success",
                            timer: '3500'
                        });
                        icon = '<button type="button" class="btn btn-success btn-floating ml-4"> <i class="ti-check-box"></i> </button>';
                        $('#scan-detail').html(icon + "آخرین فعالیت : ورود " + response['name'] + " در ساعت " + response['time'] + " ثبت شد.");
                    }


                    if (response['type'] == 'exit') {
                        audio = new Audio('/exit.mp3');
                        audio.play();
                        swal({
                            title: "ثبت خروج",
                            text: "خروج " + response['name'] + " در ساعت " + response['time'] + " ثبت شد",
                            icon: "warning",
                            timer: '3500'
                        })
                        icon = '<button type="button" class="btn btn-warning btn-floating ml-4"> <i class="ti-shift-left-alt"></i> </button>';

                        $('#scan-detail').html(icon + "آخرین فعالیت : خروج " + response['name'] + " در ساعت " + response['time'] + " ثبت شد.");

                    }
                    if (response['type'] == 'duplicate') {
                        audio = new Audio('/error.mp3');
                        audio.play();
                        swal({
                            title: "غیر مجاز",
                            text: "این فرد امروز یک بار وارد و خارج شده است.",
                            icon: "error",
                            timer: '3500'
                        })
                        // icon = '<button type="button" class="btn btn-danger btn-floating ml-4"> <i class="ti-alert"></i> </button>';

                        $('#scan-detail').html(icon + "آخرین فعالیت : خطا - " + response['name'] + " امروز یک بار وارد و خارج شده است.");

                    }
                    if (response['type'] == 'enter-exit') {
                        audio = new Audio('/error.mp3');
                        audio.play();
                        swal({
                            title: "غیر مجاز",
                            text: "فاصله بین ورود و خروج فرد کمتر از 5 دقیقه می باشد.",
                            icon: "error",
                            timer: '3500'
                        })
                        icon = '<button type="button" class="btn btn-danger btn-floating ml-4"> <i class="fa fa-warning"></i> </button>';

                        $('#scan-detail').html(icon + " آخرین فعالیت : خطا - فاصله بین ورود و خروج " + response['name'] + " کمتر از نیم ساعت می باشد." + " در صورت لزوم از ثبت دستی استفاده کنید.");

                    }
                    // window.location.reload(true);
                    document.getElementById('myinputbox').value = '';
                    $("#presences").load(" #presences > *");
                    // window.location.reload(true);

                },
                error: function () {
                    audio = new Audio('/error.mp3');
                    audio.play();
                    swal({
                        title: "ناموفق",
                        text: "دوباره اقدام کنید",
                        icon: "warning",
                        timer: '3500'

                    });
                    // window.location.reload(true);
                    document.getElementById('myinputbox').value = ''
                    // window.location.reload(true);

                },
            });

        }

        function attendance() {
            day_id = $('#day_id').val();
            personnel_id = $('#personnel_id').val();
            enter = $('#enter').val();
            exit = $('#exit').val();
            url = '/attendance?day_id=' + day_id + '&personnel_id=' + personnel_id + '&enter=' + enter + '&exit=' + exit;
            attendanceAjax(url);
        }

        function attendanceModal() {
            day_id = $('#day_id_mo').val();
            personnel_id = $('#personnel_id_mo').val();
            enter = $('#enter_mo').val();
            exit = $('#exit_mo').val();
            url = '/attendance?day_id=' + day_id + '&personnel_id=' + personnel_id + '&enter=' + enter + '&exit=' + exit;
            attendanceAjax(url);
        }

        function attendanceAjax(url) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    if (response == 'success') {
                        swal({
                            title: "ثبت شد",
                            text: "اطلاعات درخواستی ثبت شد",
                            icon: "success",
                            timer: '3500'
                        });
                        $("#presences").load(" #presences > *");
                    } else {
                        swal({
                            title: "خطا !",
                            text: "ساعت خروج بعد از ساعت ورود است !",
                            icon: "warning",
                            timer: '3500'

                        });
                    }
                },
                error: function () {

                    swal({
                        title: "ناموفق",
                        text: "دوباره اقدام کنید",
                        icon: "warning",
                        timer: '3500'

                    });
                },
            });
        }
    </script>
    <script src="/js/sweet.js"></script>

    <script src="/assets/vendors/clockpicker/bootstrap-clockpicker.min.js"></script>
    <script src="/assets/js/examples/clockpicker.js"></script>
@endsection('script')
@section('navbar')



@endsection('navbar')
@section('sidebar')

@endsection('sidebar')
@section('header')
    <div class="page-header">
        <div>
            <h3>ورود و خروج</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">مشتریان</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ورود و خروج</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="m-b-0">ثبت ورود و خروج</h5>
                        </div>

                        <ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
                            <li class="flex-sm-fill text-sm-center nav-item">
                                <a class="nav-link active" id="qrCode-tab" data-toggle="tab" href="#qrCode" role="tab"
                                   aria-controls="qrCode" aria-selected="false">ثبت با بارکدخوان</a>
                            </li>
                            <li class="flex-sm-fill text-sm-center nav-item">
                                <a class="nav-link " id="manual-tab" data-toggle="tab" href="#manual" role="tab"
                                   aria-controls="manual" aria-selected="true">ثبت دستی</a>
                            </li>
                        </ul>

                        <div class="tab-content p-t-30" id="myTabContent">

                            <div class="tab-pane fade show active" id="qrCode" role="tabpanel"
                                 aria-labelledby="qrCode-tab">
                                <div class="row text-center">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-info" onclick="showScan()">
                                            ثبت با اسکنر
                                        </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <br>
                                        <div id="scan-input">
                                            <input id="myinputbox" type="text" autofocus style="" class="form-control"
                                                   onchange="scan()">
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-12 mt-3">
                                        <h5 id="scan-detail">
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show " id="manual" role="tabpanel" aria-labelledby="manual-tab">
                                <form action="/attendance" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="handy">
                                    <div class="row">

                                        <div class="col-md-3 form-group">
                                            <label for="">
                                                نام فرد
                                            </label>
                                            <select class="js-example-basic-single form-control select2"
                                                    id="personnel_id"
                                                    onchange="inquiry()"
                                                    name="personnel_id" dir="rtl" required>
                                                <option value="">انتخاب کنید</option>
                                                @foreach($users as $person)
                                                    <option
                                                        value="{{$person->id}}">{{$person->name}} {{$person->family}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="">
                                                ورود
                                            </label>
                                            <div class="input-group clockpicker-autoclose-demo">
                                                <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <input name="enter" type="text" class="form-control" value="" id="enter"
                                                       required
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="">
                                                خروج
                                            </label>
                                            <div class="input-group clockpicker-autoclose-demo">
                                                <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <input name="exit" type="text" class="form-control" value="" id="exit"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label for="">
                                                تعداد
                                            </label>
                                            <input name="count" type="number" class="form-control" value="1" id="count"
                                                   required
                                            >
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <br>
                                            <button type="submit" class="btn btn-success btn-block text-white">
                                                ثبت
                                            </button>
                                        </div>
                                        <div class="col-md-4 form-group"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div>
                            <br>
                            <br>
                            <h5>
                                {{\Morilog\Jalali\Jalalian::now()->format('Y-m-d')}}
                                ,
                                افراد حاظر امروز
                            </h5>
                            <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                                <thead>
                                <tr class="success" style="text-align: center">
                                    <th>شمارنده</th>
                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th>مانده اشتراک</th>
                                    <th>کد</th>
                                    <th>ورود</th>
                                    <th>خروج</th>
                                    <th>حضور</th>
                                    <th>تعداد</th>
                                    <th>جمع ساعت</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $idn = 1; ?>

                                @foreach($todayUsers as $row)

                                    <tr @if($row->user->remaining<0) style="text-align: center;background-color: #faa9a9"
                                        @else style="text-align: center" @endif>
                                        <td style="text-align: center">{{$idn}}</td>
                                        <td style="text-align: center">
                                            <img @if(isset($row->user->image)) src="/user/{{$row->user->image}}"
                                                 @else src="/login_image/happy-children-go-to-school-free-vector.jpg"
                                                 @endif width="50" height="50" class="rounded">
                                        </td>
                                        <td>{{$row->user->name}} {{$row->user->family}}</td>
                                        <td>{{minutes_to_time($row->user->remaining)}}</td>
                                        <td>{{$row->user->code}}</td>
                                        <td>{{$row->enter}}</td>
                                        <td>{{$row->exit}}</td>
                                        <td>
                                            {{minutes_to_time($row->duration)}}

                                        </td>

                                        <td>{{$row->count}}</td>
                                        <td>
                                            {{minutes_to_time($row->sum)}}

                                        </td>
                                        <td>
                                            @if($row->user->remaining<0)
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#pay{{$row->id}}">
                                                    <i class="fa fa-dollar"></i> &nbsp;
                                                    پرداخت
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade " id="pay{{$row->id}}" tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">پرداخت
                                                                    برای کاربران بدون اشتراک
                                                                    ({{$row->user->name}} {{$row->user->family}})
                                                                </h5>

                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h6>
                                                                    <?php
                                                                    $price = 0;
                                                                    $plane = $planes->where('hour', '<=', ($row->user->remaining) * (-1))->where('month', '>=', ($row->user->remaining) * (-1))->first();
                                                                    if ($plane) {
                                                                        $price = $plane->price;
                                                                    }
                                                                    ?>
                                                                    مبلغ:
                                                                    {{number_format($price)}}
                                                                    ریال
                                                                </h6>
                                                                <br>
                                                                <form action="/clearing" method="post">
                                                                    @csrf
                                                                    <input name="price" value="{{$price}}" hidden>
                                                                    <input name="plan_id" value="{{$plane->id}}" hidden>
                                                                    <input name="user_id" value="{{$row->user->id}}"
                                                                           hidden>
                                                                    <div class="d-flex flex-row">

                                                                        <div class="p-2">
                                                                            <div class="price-box-product">
                                                                                نقدی
                                                                                <input name="cache" class="form-control" type="number"
                                                                                       value="{{old('cache')}}">
                                                                                <div class="price-box-product-content">
                                                                                    <div
                                                                                        class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                                        <span>وضعیت مبلغ شما</span>
                                                                                        <button class="close"><i
                                                                                                class="ion-android-close"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <span
                                                                                            class="text-secondary ml-2">به عدد:</span>
                                                                                        <span
                                                                                            class="price-box-numbers ml-2">
                                                                        </span>
                                                                                        <span
                                                                                            class="text-dark">ریال</span>
                                                                                    </div>

                                                                                    <hr>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                                        <span
                                                                                            class="price-box-letters ml-2">
                                                                        </span>
                                                                                        <span
                                                                                            class="text-dark">ریال</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <div class="price-box-product">
                                                                                پوز
                                                                                <input name="pose" class="form-control" type="number"
                                                                                       value="{{old('pose')}}">
                                                                                <div class="price-box-product-content">
                                                                                    <div
                                                                                        class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                                        <span>وضعیت مبلغ شما</span>
                                                                                        <button class="close"><i
                                                                                                class="ion-android-close"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <span
                                                                                            class="text-secondary ml-2">به عدد:</span>
                                                                                        <span
                                                                                            class="price-box-numbers ml-2">
                                                                        </span>
                                                                                        <span
                                                                                            class="text-dark">ریال</span>
                                                                                    </div>

                                                                                    <hr>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                                        <span
                                                                                            class="price-box-letters ml-2">
                                                                        </span>
                                                                                        <span
                                                                                            class="text-dark">ریال</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <div class="price-box-product">
                                                                                کارت به کارت
                                                                                <input name="card" class="form-control" type="number"
                                                                                       value="{{old('card')}}">
                                                                                <div class="price-box-product-content">
                                                                                    <div
                                                                                        class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                                        <span>وضعیت مبلغ شما</span>
                                                                                        <button class="close"><i
                                                                                                class="ion-android-close"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <span
                                                                                            class="text-secondary ml-2">به عدد:</span>
                                                                                        <span
                                                                                            class="price-box-numbers ml-2">
                                                                        </span>
                                                                                        <span
                                                                                            class="text-dark">ریال</span>
                                                                                    </div>

                                                                                    <hr>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                                        <span
                                                                                            class="price-box-letters ml-2">
                                                                        </span>
                                                                                        <span
                                                                                            class="text-dark">ریال</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <br>
                                                                            <button class="btn btn-primary">ذخیره
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <button class="btn  btn-danger" onclick="deleteData({{$row->id}})"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php $idn = $idn + 1 ?>

                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection('content')

<script>
    function deleteData(id) {
        swal({
            title: "آیا از حذف مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/rollcall/delete/')  }}" + '/' + id,
                        type: "GET",

                        success: function () {
                            swal({
                                title: "حذف با موفقیت انجام شد!",
                                icon: "success",

                            });
                            window.location.reload(true);
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
                    swal("عملیات حذف لغو گردید");
                }
            });

    }

    function deletePlaneData(id) {
        swal({
            title: "آیا از حذف مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/users/delete_plane/')  }}" + '/' + id,
                        type: "GET",

                        success: function () {
                            swal({
                                title: "حذف با موفقیت انجام شد!",
                                icon: "success",

                            });
                            window.location.reload(true);
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
                    swal("عملیات حذف لغو گردید");
                }
            });

    }

</script>


<!-- begin::sweet alert demo -->

<script>
    function inquiry() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{url('/attendance/inquiry')}}",
            type: "POST",
            data: {
                personnel_id: $('#personnel_id').val(),
                day_id: $('#day_id').val(),
                _token: '{{csrf_token()}}'
            },
            success: function (response) {
                if (response !== '') {
                    $('#enter').val(response['enter']);
                    $('#exit').val(response['exit']);
                    $('#count').val(response['count']);
                } else {
                    $('#enter').val('');
                    $('#exit').val('');
                    $('#count').val('');
                }
            }
        });
    }

    $('#modal-show').on('shown.bs.modal', function (e) {
        $('.clockpicker-autoclose-demo').clockpicker({
            autoclose: true,
            align: 'right'
        });
    });
</script>
