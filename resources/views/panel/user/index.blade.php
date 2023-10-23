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
    <!-- begin::sweet alert demo -->
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
                    <li class="breadcrumb-item"><a href="#">مشتریان</a></li>
                    <li class="breadcrumb-item active" aria-current="page">لیست</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="/users/create">
                <button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; ایجاد</button>
            </a>
            <input type='button' class="btn btn-warning" id='hideshow' value='جستجوی پیشرفته'>
            <div id='search' style="display: none">
                <form method="get" action="/users">
                    @csrf
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            <label>نام </label>
                            <input type="text" autocomplete="off" name="name"
                                   value="{{request()->input('name')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>نام پدر</label>
                            <input type="text" autocomplete="off" name="father_name"
                                   value="{{request()->input('father_name')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>نام مادر</label>
                            <input type="text" autocomplete="off" name="mother_name"
                                   value="{{request()->input('mother_name')}}"
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
                        <th>نام</th>
                        <th>نام پدر</th>
{{--                        <th>نام مادر</th>--}}
{{--                        <th>همراه پدر</th>--}}
{{--                        <th>همراه مادر</th>--}}
                        <th>اشتراک خریده</th>
                        <th>اشتراک مانده</th>
                        <th>بدهکاری</th>
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
                            <td style="text-align: center">{{$row->father_name}}</td>
{{--                            <td style="text-align: center">{{$row->mother_name}}</td>--}}
{{--                            <td style="text-align: center">{{$row->father_mobile}}</td>--}}
{{--                            <td style="text-align: center">{{$row->mother_mobile}}</td>--}}
                            <td style="text-align: center">
                                {{minutes_to_time($row->purchase)}}
                            </td>
                            <td style="text-align: center">
                                {{minutes_to_time($row->remaining)}}
                            </td>
                                <td style="text-align: center">
                                    {{number_format($row->tuition_remaining)}}
                                </td>
                            <td style="text-align: center">{{$row->code}}</td>
                            <td style="text-align: center">
                                <a href="/card/{{$row->id}}">
                                    <button class="btn btn-info">کارت</button>
                                </a>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#plans{{$row->id}}">
                                    <i class="fa fa-list"></i> &nbsp;
                                    پلن ها
                                </button>

                                <!-- Modal -->
                                <div class="modal fade " id="plans{{$row->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">اختصاص پلن</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="/users/add_plane" method="post">
                                                    @csrf
                                                    <input name="user_id" value="{{$row->id}}" hidden>
                                                    {{csrf_field()}}
                                                    <input name="type" hidden value="monthly">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label> پلن</label>
                                                            <select name="plane_id" class="js-example-basic-single">
                                                                @foreach($planes as $p)
                                                                    <option value="{{$p->id}}">{{$p->title}}
                                                                        ({{number_format($p->price+$p->service_price)}})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label> تاریخ شروع</label>
                                                            <input name="date-picker-shamsi-list" autocomplete="off"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label> تاریخ سررسید مالی</label>
                                                            <input name="date-picker-shamsi-list-1" autocomplete="off"
                                                                   class="form-control" >
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">

                                                        <div class="col-md-12">
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
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="text-secondary ml-2">به عدد:</span>
                                                                                <span class="price-box-numbers ml-2">
                                                                        </span>
                                                                                <span class="text-dark">ریال</span>
                                                                            </div>

                                                                            <hr>
                                                                            <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                                <span class="price-box-letters ml-2">
                                                                        </span>
                                                                                <span class="text-dark">ریال</span>
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
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="text-secondary ml-2">به عدد:</span>
                                                                                <span class="price-box-numbers ml-2">
                                                                        </span>
                                                                                <span class="text-dark">ریال</span>
                                                                            </div>

                                                                            <hr>
                                                                            <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                                <span class="price-box-letters ml-2">
                                                                        </span>
                                                                                <span class="text-dark">ریال</span>
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
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="text-secondary ml-2">به عدد:</span>
                                                                                <span class="price-box-numbers ml-2">
                                                                        </span>
                                                                                <span class="text-dark">ریال</span>
                                                                            </div>

                                                                            <hr>
                                                                            <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                                <span class="price-box-letters ml-2">
                                                                        </span>
                                                                                <span class="text-dark">ریال</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-2">
                                                            <br>
                                                            <button type="submit" class="btn btn-primary btn-block">
                                                                ذخیره
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br>
                                                <hr>
                                                <h5>پلن های
                                                    {{$row->name}} {{$row->family}}
                                                </h5>
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">پلن</th>
                                                        <th scope="col">نوع</th>
                                                        <th scope="col">تاریخ شروع</th>
                                                        <th scope="col">قیمت تمام شده</th>
                                                        <th scope="col">پرداخت کرده</th>
                                                        <th scope="col">مانده</th>
                                                        <th scope="col">سرویس جانبی</th>
                                                        <th scope="col">ساعت</th>
                                                        <th scope="col">ماه</th>
                                                        {{--                                                        <th scope="col">صبحانه</th>--}}
                                                        {{--                                                        <th scope="col">ناهار</th>--}}
                                                        <th scope="col">حذف</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $idnp = 1; ?>

                                                    @foreach($row->planes as $plane)
                                                        <tr>
                                                            <th scope="row">{{$idnp}}</th>
                                                            <th scope="row">{{$plane->plane->title}}</th>
                                                            <th scope="row">
                                                                @if($plane->plane->type=='mahd')
                                                                    مهد
                                                                @elseif($plane->plane->type=='hourly')
                                                                    ساعتی
                                                                @else
                                                                    ماهانه
                                                                @endif
                                                            </th>
                                                            <th scope="row">{{$plane->start_date}}</th>
                                                            <th scope="row">{{number_format($plane->plane_price)}}</th>
                                                            <th scope="row">{{number_format($plane->payed)}}</th>
                                                            <th scope="row">{{number_format($plane->plane_price-$plane->payed)}}</th>
                                                            <th scope="row">{{$plane->plane->service}}</th>
                                                            <th scope="row">{{$plane->plane->hour}}</th>
                                                            <th scope="row">{{$plane->plane->month}}</th>
                                                            {{--                                                            <th scope="row">{{$plane->plane->breakfast}}</th>--}}
                                                            {{--                                                            <th scope="row">{{$plane->plane->lunch}}</th>--}}
                                                            <th scope="row">
                                                                <button type="button" class="btn btn-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#plans_pay{{$plane->id}}">
                                                                    <i class="fa fa-list"></i> &nbsp;
                                                                    ثبت پرداختی
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade " id="plans_pay{{$plane->id}}"
                                                                     tabindex="-1" role="dialog"
                                                                     style="background-color: grey"
                                                                     aria-labelledby="exampleModalLabel"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog modal-xl" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    ثبت پرداختی برای پلن
                                                                                    {{$plane->plane->title}}
                                                                                    برای مشتری
                                                                                    {{$row->name}} {{$row->family}}
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                    <span
                                                                                        aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <form action="/users/add_pay"
                                                                                      method="post">
                                                                                    @csrf
                                                                                    {{csrf_field()}}
                                                                                    <input name="user_plane_id" hidden
                                                                                           value="{{$plane->id}}">

                                                                                    <div class="row">

                                                                                        <div class="col-md-12">
                                                                                            <div
                                                                                                class="d-flex flex-row">
                                                                                                <div class="p-2">
                                                                                                    <div
                                                                                                        class="price-box-product">
                                                                                                        نقدی
                                                                                                        <input
                                                                                                            name="cache" type="number"
                                                                                                            class="form-control"
                                                                                                            value="{{old('cache')}}">
                                                                                                        <div
                                                                                                            class="price-box-product-content">
                                                                                                            <div
                                                                                                                class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                                                                <span>وضعیت مبلغ شما</span>
                                                                                                                <button
                                                                                                                    class="close">
                                                                                                                    <i
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
                                                                                                    <div
                                                                                                        class="price-box-product">
                                                                                                        پوز
                                                                                                        <input
                                                                                                            name="pose"
                                                                                                            class="form-control" type="number"
                                                                                                            value="{{old('pose')}}">
                                                                                                        <div
                                                                                                            class="price-box-product-content">
                                                                                                            <div
                                                                                                                class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                                                                <span>وضعیت مبلغ شما</span>
                                                                                                                <button
                                                                                                                    class="close">
                                                                                                                    <i
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
                                                                                                    <div
                                                                                                        class="price-box-product">
                                                                                                        کارت به کارت
                                                                                                        <input
                                                                                                            name="card"
                                                                                                            class="form-control" type="number"
                                                                                                            value="{{old('card')}}">
                                                                                                        <div
                                                                                                            class="price-box-product-content">
                                                                                                            <div
                                                                                                                class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                                                                <span>وضعیت مبلغ شما</span>
                                                                                                                <button
                                                                                                                    class="close">
                                                                                                                    <i
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
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <br>
                                                                                            <button type="submit"
                                                                                                    class="btn btn-primary btn-block">
                                                                                                ذخیره
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn  btn-danger"
                                                                        onclick="deletePlaneData({{$plane->id}})"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </th>
                                                        </tr>
                                                        <?php $idnp = $idnp + 1 ?>

                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/users/{{$row->id}}/edit">
                                    <button class="btn btn-success">
                                        <i class="fa fa-pencil"></i>&nbsp;
                                        ویرایش
                                    </button>
                                </a>
                                <button class="btn  btn-danger" onclick="deleteData({{$row->id}})"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                    </tr>
                    <?php $idn = $idn + 1 ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $rows->withQueryString()->links("pagination::bootstrap-4") !!}

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
    <script src="/js/sweetalert.min.js"></script>

    @include('sweet::alert')

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
                        url: "{{  url('/users/delete/')  }}" + '/' + id,
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


