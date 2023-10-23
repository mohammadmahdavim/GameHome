@extends('layouts.admin')
@section('css')
    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
@endsection('css')
@section('script')
    <!-- begin::CKEditor -->
    <script src="/assets/vendors/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/examples/ckeditor.js"></script>
    <!-- end::CKEditor -->

    <!-- begin::sweet alert demo -->
    <script src="/js/sweetalert.min.js"></script>
    {{--    @include('sweet::alert')--}}
    <!-- begin::sweet alert demo -->
@endsection('script')
@section('navbar')


@endsection('navbar')
@section('sidebar')
@endsection('sidebar')

@section('header')
    <div class="page-header">
        <div>
            <h3>فایل ها</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">وبلاگ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">فایل ها</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/files/store" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @include('include.errors')
                <input type="hidden" name="model" value="{{$model}}">
                <input type="hidden" name="id" value="{{$id}}">
                <div class="row">
                    <div class="col-md-3">

                        <h6><label>عنوان فایل </label></h6>
                        <input type="text" id="title" class="form-control" name="title" value="{{ old('title') }}"
                               required>
                    </div>
                    <div class="col-md-3">

                        <h6><label>فایل</label></h6>
                        <input type="file" id="file" class="form-control" name="file" required>
                    </div>
                    <div class="col-md-3">

                        <br>
                        <br>
                        <button class="btn btn-primary" type="submit">ذخیره و ارسال
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <br>
            <hr>
            <br>
            <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                <thead>
                <tr class="success" style="text-align: center">
                    <th>شمارنده</th>
                    <th>نام</th>
                    <th>تایپ</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $idn = 1; ?>
                    @foreach($files->files as $row)
                        <td style="text-align: center">{{$idn}}</td>
                        <td style="text-align: center">{{$row->title}}</td>
                        <td style="text-align: center">{{$row->type}}</td>
                        <td style="text-align: center">
                            <a href="/files/download/{{$row->id}}">
                                <button class="btn btn-info">دانلود</button>
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
    </div>
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
                        url: "{{  url('/files/delete/')  }}" + '/' + id,
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
