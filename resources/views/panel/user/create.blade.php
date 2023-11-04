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
                    <li class="breadcrumb-item"><a href="#">مشتریان</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ایجاد</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/users" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @include('include.errors')
                <input name="role" hidden value="user">

                <div class="row">
                    <div class="col-md-3">
                        <br>
                        <h6><label>نام </label></h6>
                        <input type="text" id="title" class="form-control" name="name" value="{{ old('name') }}"
                               required>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>نام خانوادگی</label></h6>
                        <input type="text" id="title" class="form-control" name="family" value="{{ old('family') }}"
                               required>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>کد ملی</label></h6>
                        <input type="text" id="title" class="form-control" name="national_code" value="{{ old('national_code') }}"
                               required>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>نام پدر</label></h6>
                        <input type="text" id="title" class="form-control" name="father_name"
                               value="{{ old('father_name') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>شغل پدر</label></h6>
                        <input type="text" id="title" class="form-control" name="father_job"
                               value="{{ old('father_job') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>نام مادر</label></h6>
                        <input type="text" id="title" class="form-control" name="mother_name"
                               value="{{ old('mother_name') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>موبایل پدر</label></h6>
                        <input type="text" id="title" class="form-control" name="father_mobile"
                               value="{{ old('father_mobile') }}"
                               required>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>موبایل مادر</label></h6>
                        <input type="text" id="title" class="form-control" name="mother_mobile"
                               value="{{ old('mother_mobile') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>تاریخ تولد</label></h6>
                        <input type="text"  class="form-control" autocomplete="off" name="date-picker-shamsi-list"
                               value="{{ old('date-picker-shamsi-list') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <br>
                        <h6><label>تصویر </label></h6>
                        <input type="file" id="image" class="form-control" name="image">
                    </div>
                    <div class="col-md-12">
                        <br>
                        <h6><label>توضیحات </label></h6>
                        <textarea id="editor-demo1" name="description"
                        >{{old('description')}}</textarea>
                    </div>

                </div>
                <div class="form-group">
                    <br>
                    <button class="btn btn-primary btn-block" type="submit">ذخیره و ثبت نام
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection('content')
