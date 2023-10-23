@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <!-- begin::select2 -->
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::select2 -->
@endsection('css')
@section('script')
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
            <h3>لیست</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">کارکنان</a></li>
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
                ایجاد فرد جدید
            </button>

            <!-- Modal -->
            <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ایجاد فرد جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/users" method="post" enctype="multipart/form-data">
                            @csrf
                            <input name="role" hidden value="staff">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> نام</label>
                                        <input name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label> نام خانوادگی</label>
                                        <input name="family" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>کد ملی</label>
                                        <input name="father_mobile" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label> تصویر</label>
                                        <input name="image" type="file" class="form-control">
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
            @include('include.errors')
            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>تصویر</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>نقش ها</th>
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
                            <td style="text-align: center">{{$row->name}}</td>
                            <td style="text-align: center">{{$row->family}}</td>
                            <td style="text-align: center">
                                @foreach($row->roles as $role)
                                    <span class="btn btn-sm btn-info">{{$role->name}}</span>
                                @endforeach
                            </td>
                            <td style="text-align: center">



                                <button class="btn  btn-danger" onclick="deleteData({{$row->id}})"><i
                                        class="fa fa-trash"></i></button>
                                @can('role-list')
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#role{{$row->id}}">
                                        <i class="fa fa-pencil"></i> &nbsp;
                                        اختصاص نقش
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade " id="role{{$row->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">اختصاص نقش </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="/syncRoles" method="post">
                                                    @csrf
                                                    {{csrf_field()}}
                                                    <input name="id" hidden value="{{$row->id}}">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label> نام</label>
                                                                <br>
                                                                {{$row->name}} {{$row->family}}
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label> نقش ها</label>
                                                                <select name="roles[]"
                                                                        class="js-example-basic-single"
                                                                        multiple >
                                                                    @foreach($roles as $r)
                                                                        <option
                                                                            @if(in_array($r->id,$row->roles->pluck('id')->toArray())) selected
                                                                            @endif value="{{$r->id}}">{{$r->name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
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
                                @endcan
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
                                            <div class="modal-header"
                                            <h5 class="modal-title" id="exampleModalLabel">ویرایش فرد</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/users/{{$row->id}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            {{csrf_field()}}
                                            {{method_field('PATCH')}}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label> نام</label>
                                                        <input name="name" value="{{$row->name}}" class="form-control"
                                                               required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label> نام خانوادگی</label>
                                                        <input name="family" value="{{$row->family}}"
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>کد ملی</label>
                                                        <input name="father_mobile" value="{{$row->father_mobile}}"
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label> تصویر</label>
                                                        <input name="image" type="file" class="form-control">
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

</script>


