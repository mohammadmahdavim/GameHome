@extends('layouts.user')
@section('css')
    <link rel="stylesheet" href="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/vendors/select2/css/select2.min.css" type="text/css">

@endsection('css')
@section('script')

    <!-- begin::select2 -->
    <script src="/assets/vendors/select2/js/select2.min.js"></script>
    <script src="/assets/js/examples/select2.js"></script>
    <!-- end::select2 -->
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="/assets/js/examples/datepicker.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
    <script>
        jQuery(document).ready(function () {
            jQuery('#hideshow').on('click', function (event) {
                jQuery('#search').toggle('show');
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
            <h3>غیبت ها</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/customer">داشبورد</a></li>
                    <li class="breadcrumb-item active" aria-current="page">غیبت ها</li>
                </ol>
            </nav>
        </div>

    </div>
@endsection('header')

@section('content')
    <div class="card">
        <div class="card-body">


            {{--            <br>--}}
            {{--            <div class="d-flex flex-row">--}}
            {{--                <div class="p-2">--}}
            {{--                    <button class="btn btn-success"> کل مبالغ : &nbsp;<b>{{number_format($price)}}</b></button>--}}
            {{--                </div>--}}
            {{--                <div class="p-2">--}}
            {{--                    <button class="btn btn-secondary"> پرداخت کارتی : &nbsp;<b>{{number_format($card)}}</b></button>--}}
            {{--                </div>--}}
            {{--                <div class="p-2">--}}
            {{--                    <button class="btn btn-secondary"> پرداخت نقدی : &nbsp;<b>{{number_format($cache)}}</b></button>--}}
            {{--                </div>--}}
            {{--                <div class="p-2">--}}
            {{--                    <button class="btn btn-secondary"> پرداخت با پوز : &nbsp;<b>{{number_format($pose)}}</b></button>--}}
            {{--                </div>--}}
            {{--                <div class="p-2">--}}
            {{--                    <button class="btn btn-warning"> کل مانده : &nbsp;<b>{{number_format($price-($card+$cache+$pose))}}</b></button>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="">
                <br>
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>نوع</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $idn = 1; ?>

                    @foreach($rows as $row)

                        <tr style="text-align: center">
                            <td style="text-align: center">{{$idn}}</td>
                            <td>
                                @if($row->type==1)
                                    مهد
                                @else
                                    کارگاه
                                @endif
                            </td>
                            <td>{{$row->date}}</td>
                        </tr>
                        <?php $idn = $idn + 1 ?>

                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection('content')


