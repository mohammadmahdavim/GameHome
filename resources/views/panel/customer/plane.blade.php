@extends('layouts.user')
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
            <h3>پلن ها</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">داشبورد</a></li>
                    <li class="breadcrumb-item"><a href="#">پلن ها</a></li>
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
                <table class="table table-bordered table-striped mb-0 table-fixed" id="myTable">
                    <thead>
                    <tr class="success" style="text-align: center">
                        <th>شمارنده</th>
                        <th>نوع</th>
                        <th>عنوان</th>
                        <th>ساعت</th>
                        <th>ماه</th>
                        <th>قیمت (ریال)</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $idn = 1; ?>
                    @foreach($rows as $row)
                        <tr style="text-align: center">

                            <td>{{$idn}}</td>
                            <td>
                                @if($row->type=='hourly')
                                    ساعتی
                                @elseif($row->type=='monthly')
                                    ماهانه
                                @elseif($row->type=='mahd')
                                    مهد
                                @else
                                    بدون اشتراک
                                @endif
                            </td>
                            <td style="text-align: center">{{$row->title}}</td>
                            <td style="text-align: center">{{$row->hour}}</td>
                            <td style="text-align: center">{{$row->month}}</td>
                            <td style="text-align: center">{{number_format($row->price+$row->service_price)}}</td>
                            <td>
                                <form action="/customer/pay" method="post">
                                    @csrf
                                    <input name="model_id" value="{{$row->id}}" hidden>
                                    <input name="model" value="plane" hidden>
                                    <button type="submit" class="btn btn-success">پرداخت آنلاین</button>

                                </form>

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



