@extends('layouts.admin')
@section('css')

@endsection('css')
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#exampleModal").modal('show');
        });
    </script>
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
@endsection('script')
@section('navbar')

@endsection('navbar')
@section('sidebar')

@endsection('sidebar')
@section('content')
    @if(count($todayReserve)>0)
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">رزورهای امروز</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped mb-0 table-fixed" id="">
                            <thead>
                            <tr class="success" style="text-align: center">
                                <th>شمارنده</th>
                                <th>درخواست کننده</th>
                                <th>تاریخ</th>
                                <th>از ساعت</th>
                                <th> تا ساعت</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="text-align: center">
                                <?php $idn = 1; ?>
                                @foreach($todayReserve as $row)
                                    <td style="text-align: center">{{$idn}}</td>
                                    <td style="text-align: center">{{$row->user->name}} {{$row->user->family}}</td>
                                    <td style="text-align: center">{{$row->date}}</td>
                                    <td style="text-align: center">{{$row->from_time}}</td>
                                    <td style="text-align: center">{{$row->until_time}}</td>
                            </tr>
                            <?php $idn = $idn + 1 ?>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection('content')


