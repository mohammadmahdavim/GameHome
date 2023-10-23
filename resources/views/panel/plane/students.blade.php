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
                    <li class="breadcrumb-item"><a href="#">{{$plane->name}} پلن </a></li>
                    <li class="breadcrumb-item active" aria-current="page">لیست دانش آموزان</li>
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
                        <th>نام پدر</th>
                        <th>نام مادر</th>
                        <th>همراه پدر</th>
                        <th>همراه مادر</th>
                        <th>تاریخ تولد</th>
                        <th>توضیحات</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $idn = 1; ?>
                        @foreach($rows as $row)
                            <td style="text-align: center">{{$idn}}</td>
                                <td style="text-align: center">
                                    <img @if($row->image) src="/user/{{$row->image}}" @else src="/login_image/happy-children-go-to-school-free-vector.jpg" @endif width="50" height="50" class="rounded">
                                </td>
                            <td style="text-align: center">{{$row->name}} {{$row->family}}</td>
                            <td style="text-align: center">{{$row->father_name}}</td>
                            <td style="text-align: center">{{$row->mother_name}}</td>
                            <td style="text-align: center">{{$row->father_mobile}}</td>
                            <td style="text-align: center">{{$row->mother_mobile}}</td>
                            <td style="text-align: center">{{$row->birth_date}}</td>
                            <td style="text-align: center">{!! $row->description !!}</td>
                            <td style="text-align: center">
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
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">

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
                                                            <th scope="row">{{$plane->plane->type}}</th>
                                                            <th scope="row">{{$plane->start_date}}</th>
                                                            <th scope="row">{{$plane->plane->price+$plane->plane->service_price}}</th>
                                                            <th scope="row">{{$plane->plane->service}}</th>
                                                            <th scope="row">{{$plane->plane->hour}}</th>
                                                            <th scope="row">{{$plane->plane->month}}</th>
{{--                                                            <th scope="row">{{$plane->plane->breakfast}}</th>--}}
{{--                                                            <th scope="row">{{$plane->plane->lunch}}</th>--}}
                                                            <th scope="row">
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


