@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
@endsection('css')
@section('script')
    <script src="/assets/vendors/select2/js/select2.min.js"></script>
    <script src="/assets/js/examples/select2.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
    <!-- begin::CKEditor -->
    <script src="/assets/vendors/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/examples/ckeditor.js"></script>
    <!-- end::CKEditor -->
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="/assets/js/examples/datepicker.js"></script>
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
            <h3>ثبت فاکتور</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">فاکتور</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ثبت فاکتور</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')
@section('content')
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <form action="/invoice/set_session" method="post">
                        @csrf
                        <input hidden name="type" value="product">
                        <div class="row">
                            <label>بوفه</label>
                            <div class="col-md-6">
                                <select name="product_id" class="js-example-basic-single">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">
                                            {{$product->name}} - {{$product->remaining}} - {{$product->price}} ریال
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input name="count" min="1" class="form-control" type="number" required
                                       placeholder="تعداد">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="/invoice/set_session" method="post">
                        @csrf
                        <input hidden name="type" value="service">
                        <div class="row">
                            <label>خدمات</label>
                            <div class="col-md-6">
                                <select name="service_id" class="js-example-basic-single">
                                    @foreach($services as $service)
                                        <option value="{{$service->id}}">
                                            {{$service->name}} - {{$service->price}} ریال
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input name="count" min="1" class="form-control" type="number" required
                                       placeholder="تعداد">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(count($invoices)>0)
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>عنوان</th>
                        <th>قیمت (ریال)</th>
                        <th>تعداد</th>
                        <th>جمع قیمت (ریال)</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $idn = 1;
                    $totalPrice = 0;
                    ?>

                    @foreach($invoices as $invoice)

                        <tr>
                            <td style="text-align: center">{{$idn}}</td>
                            <td style="text-align: center">{{$invoice['name']}}</td>
                            <td style="text-align: center">{{number_format($invoice['price'])}}</td>
                            <td style="text-align: center">{{$invoice['count']}}</td>
                            <td style="text-align: center">{{number_format($invoice['count']*$invoice['price'])}}</td>
                            <td style="text-align: center">
                                <a href="/unset_session/{{$invoice['track_id']}}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <?php $idn = $idn + 1; $totalPrice = $totalPrice + $invoice['count'] * $invoice['price'] ?>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <h4>
                    جمع کل :
                    {{number_format($totalPrice)}}
                    ریال
                </h4>

                <form action="/invoice/store" method="post">
                    @csrf
                    <input name="price" value="{{$totalPrice}}" hidden>
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            مشتری
                            <select class="form-control" name="user_id">
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="p-2">
                            <div class="price-box-product">
                                نقدی
                                <input name="cache" type="number" class="form-control" value="{{old('cache')}}">
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
                        <div class="p-2">
                            <div class="price-box-product">
                                پوز
                                <input name="pose" type="number" class="form-control" value="{{old('pose')}}">
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
                        <div class="p-2">
                            <div class="price-box-product">
                                کارت به کارت
                                <input name="card" type="number" class="form-control" value="{{old('card')}}">
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
                        <div class="p-2">
                            <br>
                            <button class="btn btn-primary">ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection('content')
<script>
    function deleteData(type,id) {
        swal({
            title: "آیا از حذف مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/unset_session/')  }}" + type  + '/' + id,
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
<script src="/js/sweetalert.min.js"></script>
@include('sweet::alert')
