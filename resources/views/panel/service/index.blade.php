@extends('layouts.admin')
@section('css')
@endsection('css')
@section('script')
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
                    <li class="breadcrumb-item"><a href="#">سرویس ها</a></li>
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
                ایجاد سرویس جدید
            </button>

            <!-- Modal -->
            <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ایجاد سرویس جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/services" method="post">
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
            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>عنوان</th>
                        <th>قیمت (ریال)</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $idn = 1; ?>
                        @foreach($rows as $row)
                            <td style="text-align: center">{{$idn}}</td>

                            <td style="text-align: center">{{$row->name}}</td>

                            <td style="text-align: center">{{number_format($row->price)}}</td>
                            <td style="text-align: center">
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
                                                <h5 class="modal-title" id="exampleModalLabel">ویرایش سرویس</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/services/{{$row->id}}" method="post">
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
                        url: "{{  url('/services/delete/')  }}" + '/' + id,
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


