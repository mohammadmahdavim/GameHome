@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <!-- begin::select2 -->
@endsection('css')
@section('script')
    <script>
        jQuery(document).ready(function () {
            jQuery('#hideshow').on('click', function (event) {
                jQuery('#search').toggle('show');
            });
        });
    </script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="/assets/js/examples/datepicker.js"></script>
    <!-- begin::sweet alert demo -->
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
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
                    <li class="breadcrumb-item"><a href="#">محصول ها</a></li>
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
                ایجاد محصول جدید
            </button>

            <!-- Modal -->
            <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ایجاد محصول جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/products" method="post">
                            @csrf
                            <input name="type" hidden value="mahd">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> نام</label>
                                        <input name="name" class="form-control" required>
                                    </div>
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
            <input type='button' class="btn btn-warning" id='hideshow' value='جستجوی پیشرفته'>
            <div id='search' style="display: none">
                <form method="get" action="/products">
                    @csrf
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            <label>نام محصول</label>
                            <input type="text" autocomplete="off" name="name"
                                   value="{{request()->input('name')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>موجودی از</label>
                            <input type="text" autocomplete="off" name="remaining_from"
                                   value="{{request()->input('remaining_from')}}"
                                   class="form-control">
                        </div>
                        <div class="p-2">
                            <label>موجودی تا</label>
                            <input type="text" autocomplete="off" name="remaining_to"
                                   value="{{request()->input('remaining_to')}}"
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
                        <th>عنوان</th>
                        <th>قیمت فروش</th>
                        <th>جمع خرید</th>
                        <th>جمع فروش</th>
                        <th>سود</th>
                        <th>موجودی</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $idn = 1;
                        ?>
                        @foreach($rows as $row)
                            <?php
                            $inventoryPrice = 0;
                            $lastInventory = $row->inventories->pluck('purchase_price')->last();
                            if ($lastInventory) {
                                $inventoryPrice = $lastInventory * $row->remaining;
                            }
                            $purchase_prices = $row->inventories_sum_sum_price ? $row->inventories_sum_sum_price : 0;
                            $sale_prices = $row->sub_invoice_sum_price ? $row->sub_invoice_sum_price : 0;
                            $benefit = $sale_prices - $purchase_prices + $inventoryPrice;
                            ?>
                            <td style="text-align: center">{{$idn}}</td>

                            <td style="text-align: center">{{$row->name}}</td>

                            <td style="text-align: center">{{number_format($row->price)}}</td>
                            <td style="text-align: center">{{number_format($purchase_prices)}}</td>
                            <td style="text-align: center">{{number_format($sale_prices)}}</td>
                            <td style="text-align: center">{{number_format($benefit)}}</td>
                            <td style="text-align: center">{{$row->remaining}}</td>

                            <td style="text-align: center">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#inventory{{$row->id}}">
                                    <i class="fa fa-inbox"></i> &nbsp;
                                    ورودی به انبار
                                </button>

                                <!-- Modal -->
                                <div class="modal fade " id="inventory{{$row->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    ورودی به انبار برای محصول
                                                    {{$row->name}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/products/inventory" method="post">
                                                    @csrf
                                                    {{csrf_field()}}
                                                    <input name="product_id" value="{{$row->id}}" hidden>

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label> تعداد</label>
                                                            <input name="count"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label> تاریخ </label>
                                                            <input name="date-picker-shamsi-list" autocomplete="off"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label> قیمت خرید</label>
                                                            <div class="price-box-product">

                                                                <input required type="number" name="price" id="price"
                                                                       class="form-control">
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

                                                    <button type="submit" class="btn btn-primary btn-block">ذخیره
                                                    </button>
                                                </form>
                                                <br>
                                                <table>
                                                    <thead>
                                                    <tr class="success" style="text-align: center">
                                                        <th>شمارنده</th>
                                                        <th>تاریخ</th>
                                                        <th>تعداد</th>
                                                        <th>قیمت خرید</th>
                                                        <th>قیمت کل</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $idn2 = 1; ?>
                                                    @foreach($row->inventories as $inventory)
                                                        <tr>

                                                            <td style="text-align: center">{{$idn2}}</td>
                                                            <td style="text-align: center">{{$inventory->date}}</td>
                                                            <td style="text-align: center">{{$inventory->count}}</td>
                                                            <td style="text-align: center">{{$inventory->purchase_price}}</td>
                                                            <td style="text-align: center">{{$inventory->sum_price}}</td>
                                                        </tr>
                                                        <?php $idn2 = $idn2 + 1 ?>
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
                                                <h5 class="modal-title" id="exampleModalLabel">ویرایش محصول</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/products/{{$row->id}}" method="post">
                                                @csrf
                                                {{csrf_field()}}
                                                {{method_field('PATCH')}}
                                                <input name="type" hidden value="mahd">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label> نام</label>
                                                            <input name="name" value="{{$row->name}}"
                                                                   class="form-control" required>
                                                        </div>
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
                        url: "{{  url('/products/delete/')  }}" + '/' + id,
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


