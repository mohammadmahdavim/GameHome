@extends('layouts.admin')

@section('head')
    <style>
        @media print {
            .pagebreak {
                /*clear: both;*/
                page-break-before: always;
                /*page-break-after: always;*/
            }

            /* page-break-after works, as well */
        }
    </style>

@endsection

@section('content')
    <button class="btn btn-info" onClick="printdiv('printable_div_id')">پرینت</button>

    <div class="row" id='printable_div_id'>
        <div class="col-md-12">
            <br>
            <div class="card">
                <div class="card-body">

                    {{--                    {{count($users)/12}}--}}
                    @for ($i = 0; $i < (count($users)/12); $i++)
                        <div class="row pagebreak">
                            @foreach($users->skip($i*12)->take(12) as $key=>$user)
                                @include('include.card')
                            @endforeach
                        </div>
                        <br>
                    @endfor
                    {{--                    <div class="row">--}}
                    {{--                        @foreach($users->take(12) as $key=>$user)--}}
                    {{--                            @include('components.card')--}}
                    {{--                        @endforeach--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function printdiv(elem) {
        var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
        var footer_str = '</body></html>';
        var new_str = document.getElementById(elem).innerHTML;
        var old_str = document.body.innerHTML;
        document.body.innerHTML = header_str + new_str + footer_str;
        window.print();
        document.body.innerHTML = old_str;
        return false;
    }
</script>
