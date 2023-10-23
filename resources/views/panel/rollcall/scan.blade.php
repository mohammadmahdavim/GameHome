@extends('layouts.admin')
@section('script')
    <script src="/js/sweetalert.min.js"></script>
    @include('sweet::alert')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete"
                || document.readyState === "interactive") {
                // call on next available tick
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        docReady(function () {
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;
            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    // Handle on success condition with the decoded message.

                    console.log(decodedText);
                    $.ajax({
                        url: '/scanCheck' + '/' + decodedText,
                        type: "GET",
                        success: function (response) {
                            if (response['type'] == 'enter') {
                                audio = new Audio('/enter.mp3');
                                audio.play();
                                swal({
                                    title: "ثبت ورود",
                                    text: "ورود " + response['name'] + " در ساعت " + response['time'] + " ثبت شد",
                                    icon: "success",
                                    timer: '3500'
                                });
                                icon = '<button type="button" class="btn btn-success btn-floating ml-4"> <i class="ti-check-box"></i> </button>';
                                $('#scan-detail').html(icon + "آخرین فعالیت : ورود " + response['name'] + " در ساعت " + response['time'] + " ثبت شد.");
                            }


                            if (response['type'] == 'exit') {
                                audio = new Audio('/exit.mp3');
                                audio.play();
                                swal({
                                    title: "ثبت خروج",
                                    text: "خروج " + response['name'] + " در ساعت " + response['time'] + " ثبت شد",
                                    icon: "warning",
                                    timer: '3500'
                                })
                                icon = '<button type="button" class="btn btn-warning btn-floating ml-4"> <i class="ti-shift-left-alt"></i> </button>';

                                $('#scan-detail').html(icon + "آخرین فعالیت : خروج " + response['name'] + " در ساعت " + response['time'] + " ثبت شد.");

                            }
                            if (response['type'] == 'duplicate') {
                                audio = new Audio('/error.mp3');
                                audio.play();
                                swal({
                                    title: "غیر مجاز",
                                    text: "این فرد امروز یک بار وارد و خارج شده است.",
                                    icon: "error",
                                    timer: '3500'
                                })
                                // icon = '<button type="button" class="btn btn-danger btn-floating ml-4"> <i class="ti-alert"></i> </button>';

                                $('#scan-detail').html(icon + "آخرین فعالیت : خطا - " + response['name'] + " امروز یک بار وارد و خارج شده است.");

                            }
                            if (response['type'] == 'enter-exit') {
                                audio = new Audio('/error.mp3');
                                audio.play();
                                swal({
                                    title: "غیر مجاز",
                                    text: "فاصله بین ورود و خروج فرد کمتر از 5 دقیقه می باشد.",
                                    icon: "error",
                                    timer: '3500'
                                })
                                icon = '<button type="button" class="btn btn-danger btn-floating ml-4"> <i class="fa fa-warning"></i> </button>';

                                $('#scan-detail').html(icon + " آخرین فعالیت : خطا - فاصله بین ورود و خروج " + response['name'] + " کمتر از نیم ساعت می باشد." + " در صورت لزوم از ثبت دستی استفاده کنید.");

                            }
                            // window.location.reload(true);
                            document.getElementById('myinputbox').value = '';
                            $("#presences").load(" #presences > *");
                            // window.location.reload(true);

                        },
                        error: function () {
                            audio = new Audio('/error.mp3');
                            audio.play();
                            swal({
                                title: "ناموفق",
                                text: "دوباره اقدام کنید",
                                icon: "warning",
                                timer: '3500'

                            });
                            // window.location.reload(true);
                            document.getElementById('myinputbox').value = ''
                            // window.location.reload(true);

                        },
                    });

                    document.getElementById("myText").value = decodedText;


                }
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", { fps: 10, qrbox: 250 });
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
@endsection
@section('content')
    <main class="main-content">

        <div class="container-fluid">

            <!-- begin::page header -->
            <div class="page-header">
                <div>
                    <h3>داشبورد</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">داشبورد</a></li>
                            <li class="breadcrumb-item active" aria-current="page">پیش فرض</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!-- end::page header -->

            <div id="qr-reader" style="width:500px"></div>
        </div>

    </main>

@endsection



