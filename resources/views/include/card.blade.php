<div
    style="border: double black; height: 12.0cm!important; width:7.7cm !important;font-family: b Nazanin !important;"
    class="ml-3 mb-3">
    <div class="header-logo">
        <img width="50px" height="50px"
             src="https://rashasoftware.ir/playhouse/wp-content/uploads/2019/11/fox-color-1.svg" alt="...">
        {{--        <span class="logo-text d-none d-lg-block" style="font-family: B 'B Nazanin'">خانه بازی شاد</span>--}}
        <span style="font-family: b 'B Koodak' !important">
            <b>
                خانه بازی شاد
            </b>
        </span>
    </div>
    {{--    <h5 style="text-align: center; margin-top: 12px;font-family: b Nazanin !important; font-weight: 900; color: black; line-height: 20px">--}}
    {{--        نمایشگاه بین المللی کتاب تهران--}}
    {{--    </h5>--}}
    {{--    <div--}}
    {{--        style="text-align: right;margin-right: 10px; margin-top: 5px;font-family: b Nazanin !important; font-weight: 900">--}}
    {{--        مصلی تهران - اردیبهشت 1401--}}
    {{--    </div>--}}
    <h1 style="text-align: center;color: black; margin-top: 15px;
                                font-family: b Nazanin !important;font-weight: bolder;font-size: 30px">
        {{$user->name}} {{$user->family}}
        <div style="margin-top: 5px;font-family: b Nazanin !important; line-height: 40px">
            {{--            {{$user->role->name ?? 'کارمند'}}--}}
        </div>
    </h1>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-5"
             style="margin-right: -42px;margin-top: 10px;width: 100px!important;height: 100px!important;">{!! DNS2D::getBarcodeHTML($user->code ? $user->code : "1", 'QRCODE') !!}</div>
        <div class="col-4"></div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h6 style="text-align: center;margin-top: 10px">{{$user->code ? $user->code : "1"}}
        <br>
        <br>

        <span style="font-size: 8px">
        حقوق محفوظ می باشد.
    </span>
    </h6>


</div>

