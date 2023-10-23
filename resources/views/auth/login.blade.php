<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- begin::global styles -->
    <link rel="stylesheet" href="/assets/vendors/bundle.css" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="/assets/css/app.css" type="text/css">
    <!-- end::custom styles -->

    <!-- begin::favicon -->
    <!-- end::favicon -->

    <!-- begin::theme color -->
    <meta name="theme-color" content="#3f51b5"/>
    <!-- end::theme color -->

</head>
<body class="bg-white h-100-vh p-t-0">

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>در حال بارگذاری ...</span>
</div>
<!-- end::page loader -->

<div class="container h-100-vh">
    <div class="row align-items-center h-100-vh">
        <div class="col-lg-6 d-none d-lg-block p-t-b-25">
            <img class="img-fluid" src="/login_image/happy-children-go-to-school-free-vector.jpg" alt="...">
        </div>

        <div class="col-lg-4 offset-lg-1 p-t-25 p-b-10">


            <h3>ورود</h3>
            <p>ورود به پنل خود</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                @include('include.errors')

                <div class="form-group row">

                    <div class="col-md-12">
                        <input id="father_mobile" type=""
                               class="form-control form-control-lg{{ $errors->has('father_mobile') ? ' is-invalid' : '' }}"
                               name="father_mobile" required autofocus placeholder="موبایل">

                        @if ($errors->has('father_mobile'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('father_mobile') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <input id="password" type="password"
                               class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" required placeholder="رمز ورود">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-lg btn-block btn-uppercase mb-4">ورود به پنل</button>
                        <p class="text-left">
                            <a href="/register">
                                <button type="button" class="btn btn-danger">ایجاد حساب کاربری</button>

                            </a>
                        </p>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
</body>
<script src="/js/sweetalert.min.js"></script>
@include('sweet::alert')
<!-- begin::global scripts -->
<script src="/assets/vendors/bundle.js"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="/assets/js/app.js"></script>
<!-- end::custom scripts -->


</html>
