@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/vendors/clockpicker/bootstrap-clockpicker.min.css" type="text/css">

    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
    <link rel="stylesheet" href="/assets/vendors/dataTable/responsive.bootstrap.min.css" type="text/css">

@endsection('css')
@section('script')
    <!-- begin::dataTable -->
    <script src="/assets/vendors/dataTable/jquery.dataTables.min.js"></script>
    <script src="/assets/vendors/dataTable/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/vendors/dataTable/dataTables.responsive.min.js"></script>
    <script src="/assets/js/examples/datatable.js"></script>
    <!-- end::dataTable -->
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
            <h3>درخواست رزرو</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">درخواست رزرو</a></li>
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
                <table class="table table-bordered table-striped mb-0 table-fixed" id="">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>درخواست کننده</th>
                        <th>تاریخ</th>
                        <th>از ساعت</th>
                        <th> تا ساعت</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="text-align: center">
                        <?php $idn = 1; ?>
                        @foreach($rows as $row)
                            <td style="text-align: center">{{$idn}}</td>
                            <td style="text-align: center">{{$row->user->name}} {{$row->user->family}}</td>
                            <td style="text-align: center">{{$row->date}}</td>
                            <td style="text-align: center">{{$row->from_time}}</td>
                            <td style="text-align: center">{{$row->until_time}}</td>
                            <td>
                                @if($row->status=='requested')
                                    درخواست داده شده
                                @elseif($row->status=='decline')
                                    رد شده
                                @elseif($row->status=='accept')
                                    قبول شده
                                @else

                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#edit{{$row->id}}">
                                    قبول درخواست
                                </button>

                                <!-- Modal -->
                                <div class="modal fade " id="edit{{$row->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                   قبول درخواست
                                                    {{$row->user->name}} {{$row->user->family}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/accept_reserve" method="post">
                                                <input name="id" value="{{$row->id}}" hidden>
                                                @csrf
                                                {{csrf_field()}}
                                                <div class="modal-body">
                                                    <div class="d-flex flex-row">
                                                        <div class="p-2">
                                                            <div class="price-box-product">
                                                                نقدی
                                                                <input name="cache" class="form-control" type="number"
                                                                       value="{{$row->cache}}">
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
                                                                       value="{{$row->pose}}">
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
                                                                       value="{{$row->card}}">
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
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-block">ذخیره
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn  btn-danger" onclick="deleteData({{$row->id}})">رد درخواست</button>
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
            title: "آیا از رد درخواست مطمئن هستید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{  url('/decline_reserve/')  }}" + '/' + id,
                        type: "GET",

                        success: function () {
                            swal({
                                title: "درخواست رد شد!",
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



