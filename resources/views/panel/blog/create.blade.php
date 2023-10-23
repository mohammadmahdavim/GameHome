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
            <h3>ایجاد</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">وبلاگ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ایجاد</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')
@section('content')
    <div class="card">
        <div class="card-body">
            <form  action="/blogs" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @include('include.errors')
                <div class="row">
                    <div class="col-md-3">
                        <br>
                        <h6><label>عنوان مقاله </label></h6>
                        <input type="text" id="title" class="form-control" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-9">
                        <br>
                        <h6><label>متن کوتاه</label></h6>
                        <input type="text" id="little_body" class="form-control" name="little_body">
                    </div>
                    <div class="col-md-12">
                        <br>
                        <h6><label>متن </label></h6>
                        <textarea id="editor-demo1" name="body"
                        >{{old('description')}}</textarea>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>تصویر اصلی</label></h6>
                        <input type="file" id="image" class="form-control" name="image" required>
                    </div>
                </div>
                <div class="form-group">
                    <br>
                    <button class="btn btn-primary" type="submit">ذخیره و ارسال
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection('content')
