@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/vendors/clockpicker/bootstrap-clockpicker.min.css" type="text/css">

    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
@endsection('css')
@section('script')
    <script src="/assets/vendors/clockpicker/bootstrap-clockpicker.min.js"></script>
    <script src="/assets/js/examples/clockpicker.js"></script>
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
                    <li class="breadcrumb-item"><a href="#"> کارگاه ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">لیست</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-plus"></i> &nbsp;
                ایجاد کارگاه جدید
            </button>

            <!-- Modal -->
            <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ایجاد کارگاه جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/workshop" method="post">
                            @csrf
                            <input name="type" hidden value="mahd">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> نام</label>
                                        <input name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label> دسته بندی</label>
                                        <select class="form-control" name="workshop_type_id" required>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label> تعداد روز</label>
                                        <input name="day_count" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label> روز هفته</label>
                                        <select class="form-control" name="day" required>
                                            <option>شنبه</option>
                                            <option>یکشنبه</option>
                                            <option>دوشنبه</option>
                                            <option>سه شنبه</option>
                                            <option>چهارشنبه</option>
                                            <option>پنجشنبه</option>
                                            <option>جمعه</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> ظرفیت ( نفر)</label>
                                        <input name="capacity" type="number" class="form-control" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label> ساعت</label>
                                        <div class="input-group clockpicker-autoclose-demo">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <input name="time" type="text" class="form-control" value="" id="time"
                                                   required
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label> تاریخ شروع</label>
                                        <input name="date-picker-shamsi-list" autocomplete="off"
                                               class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label> تاریخ پایان</label>
                                        <input name="date-picker-shamsi-list-1" autocomplete="off"
                                               class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="row">

                                    <div class="col-md-3">
                                        <label> قیمت</label>
                                        <div class="price-box-product">

                                            <input required type="number" name="price" id="price" class="form-control">
                                            <div class="price-box-product-content">
                                                <div
                                                    class="price-box-header-product d-flex justify-content-between align-items-center">
                                                    <span>وضعیت مبلغ شما</span>
                                                    <button class="close"><i
                                                            class="ion-android-close"></i></button>
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
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">ذخیره</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>عنوان</th>
                        <th>دسته بندی</th>
                        <th>تعداد روز</th>
                        <th>روز هفته</th>
                        <th>ظرفیت</th>
                        <th>ساعت</th>
                        <th>مبلغ</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $idn = 1;
                        ?>
                        @foreach($rows as $row)

                            <td style="text-align: center">{{$idn}}</td>

                            <td style="text-align: center">{{$row->name}}</td>
                            <td style="text-align: center">{{$row->type->name}}</td>
                            <td style="text-align: center">{{$row->day_count}}</td>
                            <td style="text-align: center">{{$row->day}}</td>
                            <td style="text-align: center">{{$row->capacity}}</td>
                            <td style="text-align: center">{{$row->time}}</td>
                            <td style="text-align: center">{{number_format($row->price)}}</td>

                            <td style="text-align: center">

                                <a href="/workshop/students/{{$row->id}}">
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                    >
                                        <i class="fa fa-users"></i> &nbsp;
                                        دانش آموز
                                    </button>
                                </a>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#staff{{$row->id}}">
                                    <i class="fa fa-users"></i> &nbsp;
                                    مربیان
                                </button>

                                <!-- Modal -->
                                <div class="modal fade " id="staff{{$row->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">افزودن مربی جدید</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/workshop/add_staff" method="post">
                                                @csrf
                                                <input type="hidden" name="workshop_id" value="{{$row->id}}">
                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <label> مربی</label>
                                                            <select class="form-control" name="user_id"
                                                                    required>
                                                                @foreach($staff as $staf)
                                                                    <option
                                                                        value="{{$staf->id}}">{{$staf->name}} {{$staf->family}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">نام</th>
                                                            <th scope="col">نام خانوادگی</th>
                                                            <th scope="col">حذف</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($row->staff as $s)
                                                            <tr>
                                                                <td>#</td>
                                                                <td>{{$s->user->name}}</td>
                                                                <td>{{$s->user->family}}</td>
                                                                <td>
                                                                    <button type="button" class="btn  btn-danger" onclick="deleteStaff({{$row->id}})"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>


                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#edit{{$row->id}}">
                                    <i class="fa fa-pencil"></i> &nbsp;
                                    ویرایش
                                </button>

                                <!-- Modal -->
                                <div class="modal fade " id="edit{{$row->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">ویرایش کارگاه بندی</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/workshop/{{$row->id}}" method="post">
                                                @csrf
                                                {{csrf_field()}}
                                                {{method_field('PATCH')}}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label> نام</label>
                                                            <input name="name" value="{{$row->name}}"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label> دسته بندی</label>
                                                            <select class="form-control" name="workshop_type_id"
                                                                    required>
                                                                @foreach($types as $type)
                                                                    <option
                                                                        @if($row->workshop_type_id==$type->id) selected
                                                                        @endif value="{{$type->id}}">{{$type->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label> تعداد روز</label>
                                                            <input value="{{$row->day_count}}" name="day_count"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label> روز هفته</label>
                                                            <select class="form-control" name="day" required>
                                                                <option @if($row->day=='شنبه') selected @endif>شنبه
                                                                </option>
                                                                <option @if($row->day=='یکشنبه') selected @endif>
                                                                    یکشنبه
                                                                </option>
                                                                <option @if($row->day=='دوشنبه') selected @endif>
                                                                    دوشنبه
                                                                </option>
                                                                <option @if($row->day=='سه شنبه') selected @endif>سه
                                                                    شنبه
                                                                </option>
                                                                <option @if($row->day=='چهارشنبه') selected @endif>
                                                                    چهارشنبه
                                                                </option>
                                                                <option @if($row->day=='پنجشنبه') selected @endif>
                                                                    پنجشنبه
                                                                </option>
                                                                <option @if($row->day=='جمعه') selected @endif>جمعه
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label> ظرفیت ( نفر)</label>
                                                            <input name="capacity" value="{{$row->capacity}}"
                                                                   type="number" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label> ساعت</label>
                                                            <div class="input-group clockpicker-autoclose-demo">
                                                                <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                                </div>
                                                                <input value="{{$row->time}}" name="time" type="text"
                                                                       class="form-control" id="time"
                                                                       required
                                                                       readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label> تاریخ شروع</label>
                                                            <input value="{{$row->start_date}}"
                                                                   name="date-picker-shamsi-list" autocomplete="off"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label> تاریخ پایان</label>
                                                            <input value="{{$row->end_date}}"
                                                                   name="date-picker-shamsi-list-1" autocomplete="off"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <label> قیمت</label>
                                                            <div class="price-box-product">

                                                                <input required type="number" name="price" id="price"
                                                                       class="form-control" value="{{$row->price}}">
                                                                <div class="price-box-product-content">
                                                                    <div
                                                                        class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                        <span>وضعیت مبلغ شما</span>
                                                                        <button class="close"><i
                                                                                class="ion-android-close"></i></button>
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
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-block">ذخیره
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                        url: "{{  url('/workshop/delete/')  }}" + '/' + id,
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
    function deleteStaff(id) {
        swal({
            title: "آیا از حذف مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/workshop/delete_staff/')  }}" + '/' + id,
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


