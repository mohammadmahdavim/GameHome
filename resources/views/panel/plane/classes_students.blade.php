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
            <h3>لیست دانش آموزان</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$plane->title}}  </a></li>
                    <li class="breadcrumb-item"><a href="/planes/classes/{{$class->id}}">{{$class->name}} کلاس </a></li>
                    <li class="breadcrumb-item active" aria-current="page">لیست دانش آموزان</li>
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
                اضافه کردن دانش آموز جدید
            </button>

            <!-- Modal -->
            <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">اضافه کردن دانش آموز جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/classes_students/add" method="post">
                            @csrf
                            <input type="hidden" name="mahd_class_id" value="{{$class->id}}">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> دانش آموز</label>
                                        <select class="js-example-basic-single form-control select2" name="student_id"
                                                required>
                                            @foreach($allStudents as $allStudent)
                                                <option
                                                    value="{{$allStudent->id}}">{{$allStudent->name}} {{$allStudent->family}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-row">

                                        <div class="p-2">
                                            <div class="price-box-product">
                                                نقدی
                                                <input name="cache" class="form-control"
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
                                                <input name="pose" class="form-control"
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
                                                <input name="card" class="form-control"
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

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">ذخیره و ثبت نام</button>
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
                        <th>تصویر</th>
                        <th>نام</th>
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
                            <td style="text-align: center">{{$row->father_name}}</td>
                            <td style="text-align: center">{{$row->mother_name}}</td>
                            <td style="text-align: center">{{$row->father_mobile}}</td>
                            <td style="text-align: center">{{$row->mother_mobile}}</td>
                            <td style="text-align: center">{{$row->code}}</td>

                            <td style="text-align: center">
                                <button class="btn  btn-danger" onclick="deleteData({{$row->id}})"><i
                                        class="fa fa-trash"></i> &nbsp; حذف از کلاس</button>
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
                        url: "{{  url('/classes_students/delete/')  }}" + '/' + id,
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


