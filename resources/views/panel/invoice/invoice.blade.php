<html dir="rtl" lang="fa">
<style>
    /* reset */

    * {
        border: 0;
        box-sizing: content-box;
        color: inherit;
        font-family: inherit;
        font-size: inherit;
        font-style: inherit;
        font-weight: inherit;
        line-height: inherit;
        list-style: none;
        margin: 0;
        padding: 0;
        text-decoration: none;
        vertical-align: top;
    }

    /* content editable */

    *[contenteditable] {
        border-radius: 0.25em;
        min-width: 1em;
        outline: 0;
    }

    *[contenteditable] {
        cursor: pointer;
    }

    *[contenteditable]:hover,
    *[contenteditable]:focus,
    td:hover *[contenteditable],
    td:focus *[contenteditable],
    img.hover {
        background: #def;
        box-shadow: 0 0 1em 0.5em #def;
    }

    span[contenteditable] {
        display: inline-block;
    }

    /* heading */

    h1 {
        font: bold 100% sans-serif;
        letter-spacing: 0.01em;
        text-align: center;
        text-transform: uppercase;
    }

    /* table */

    table {
        font-size: 75%;
        table-layout: fixed;
        width: 100%;
    }

    table {
        border-collapse: separate;
        border-spacing: 2px;
    }

    th,
    td {
        border-width: 1px;
        padding: 0.5em;
        position: relative;
        text-align: right;
    }

    th,
    td {
        border-radius: 0.25em;
        border-style: solid;
    }

    th {
        background: #eee;
        border-color: #bbb;
    }

    td {
        border-color: #ddd;
    }

    /* page */

    html {
        font: 16px/1 "Open Sans", sans-serif;
        overflow: auto;
        padding: 0.5in;
    }

    html {
        background: #999;
        cursor: default;
    }

    body {
        box-sizing: border-box;
        height: 11in;
        margin: 0 auto;
        overflow: hidden;
        padding: 0.5in;
        width: 8.5in;
    }

    body {
        background: #fff;
        border-radius: 1px;
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    }

    /* header */

    header {
        margin: 0 0 3em;
    }

    header:after {
        clear: both;
        content: "";
        display: table;
    }

    header h1 {
        background: #000;
        border-radius: 0.25em;
        color: #fff;
        margin: 0 0 1em;
        padding: 0.5em 0;
    }

    header address {
        float: left;
        font-size: 75%;
        font-style: normal;
        line-height: 1.25;
        margin: 0 1em 1em 0;
    }

    header address p {
        margin: 0 0 0.25em;
    }

    header span,
    header img {
        display: block;
        float: left;
    }

    header span {
        margin: 0 0 1em 1em;
        max-height: 25%;
        max-width: 60%;
        position: relative;
    }

    header img {
        max-height: 100%;
        max-width: 100%;
    }

    header input {
        cursor: pointer;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        height: 100%;
        left: 0;
        opacity: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }

    /* article */

    article,
    article address,
    table.meta,
    table.inventory {
        margin: 0 0 3em;
        float: left;
    }

    article:after {
        clear: both;
        content: "";
        display: table;
    }

    article h1 {
        clip: rect(0 0 0 0);
        position: absolute;
    }

    article address {
        float: left;
        font-size: 125%;
        font-weight: bold;
    }

    /* table meta & balance */

    table.meta,
    table.balance {
        float: right;
        width: 36%;
    }

    table.meta:after,
    table.balance:after {
        clear: both;
        content: "";
        display: table;
    }

    /* table meta */

    table.meta th {
        width: 40%;
    }

    table.meta td {
        width: 60%;
    }

    /* table items */

    table.inventory {
        clear: both;
        width: 100%;
    }

    table.inventory th {
        font-weight: bold;
        text-align: center;
    }

    table.inventory td:nth-child(1) {
        width: 26%;
    }

    table.inventory td:nth-child(2) {
        width: 38%;
    }

    table.inventory td:nth-child(3) {
        text-align: center;
        width: 12%;
    }

    table.inventory td:nth-child(4) {
        text-align: center;
        width: 12%;
    }

    table.inventory td:nth-child(5) {
        text-align: center;
        width: 12%;
    }

    /* table balance */

    table.balance th,
    table.balance td {
        width: 50%;
    }

    table.balance td {
        text-align: right;
    }

    /* aside */

    aside h1 {
        border: none;
        border-width: 0 0 1px;
        margin: 0 0 1em;
    }

    aside h1 {
        border-color: #999;
        border-bottom-style: solid;
    }

    /* javascript */

    .add,
    .cut {
        border-width: 1px;
        display: block;
        font-size: 0.8rem;
        padding: 0.25em 0.5em;
        float: right;
        text-align: center;
        width: 0.6em;
    }

    .add,
    .cut {
        background: #9af;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        background-image: -moz-linear-gradient(#00adee 5%, #0078a5 100%);
        background-image: -webkit-linear-gradient(#00adee 5%, #0078a5 100%);
        border-radius: 0.5em;
        border-color: #0076a3;
        color: #fff;
        cursor: pointer;
        font-weight: bold;
        text-shadow: 0 -1px 2px rgba(0, 0, 0, 0.333);
    }

    .add {
        margin: -2.5em 0 0;
    }

    .add:hover {
        background: #00adee;
    }

    .cut {
        opacity: 0;
        position: absolute;
        top: 0;
        left: -1.5em;
    }

    .cut {
        -webkit-transition: opacity 100ms ease-in;
    }

    tr:hover .cut {
        opacity: 1;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact;
        }

        html {
            background: none;
            padding: 0;
        }

        body {
            box-shadow: none;
            margin: 0;
        }

        span:empty {
            display: none;
        }

        .add,
        .cut {
            display: none;
        }
    }

    @page {
        margin: 0;
    }

</style>
<head>
    <meta charset="utf-8">
    <title>فاکتور</title>

</head>

<body dir="">
<header>
    <h1>فاکتور مجموعه خانه بازی شاد</h1>
    <address contenteditable style="float: left;text-align: right">
        <p>{{\Morilog\Jalali\Jalalian::now()->format('Y/m/d')}}</p>
    </address>
    <address contenteditable style="float: right;text-align: right">
        <p>شماره فاکتور: 1000{{$row->id}}</p>
        <p>خریدار: {{$row->user->name}} {{$row->user->family}}</p>
        <p>تاریخ خرید
            <br>
            {{$row->payed_at}}
        </p>
    </address>
    <span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span>
</header>
<h1> آیتم های خریداری شده</h1>
<br>
<article>
    <table class="inventory" dir="rtl">
        <thead>
        <tr>
            <th><span contenteditable>#</span></th>
            <th><span contenteditable>آیتم</span></th>
            <th><span contenteditable>قیمت</span></th>
        </tr>
        </thead>
        <tbody>
        <?php $idn = 1; ?>

        @foreach($row->sub_invoices as $sub)
            <tr>
                <td style="text-align: center">{{$idn}}</td>
                <td style="text-align: center"><span data-prefix></span><span contenteditable>
                        @if($sub->sub_invoiceable->name)
                            {{$sub->sub_invoiceable->name}}
                        @elseif($sub->sub_invoiceable->plane)
                            پلن
                            {{$sub->sub_invoiceable->plane->title}}
                        @elseif($sub->sub_invoiceable->date)
                            رزرو خانه بازی برای تاریخ
                            {{$sub->sub_invoiceable->date}}

                        @else
                            کارگاه
                            {{$sub->sub_invoiceable->workshop->name}}

                        @endif
                    </span></td>
                <td style="text-align: center"><span contenteditable>{{number_format($sub->price)}}</span></td>
            </tr>
            <?php $idn = $idn + 1 ?>

        @endforeach
        </tbody>
    </table>
    <table class="balance" style="float: left">
        <tr>
            <th><span contenteditable>{{number_format($row->price)}}</span></th>
            <td><span data-prefix></span><span>کل مبلغ</span></td>
        </tr>
        <tr>
            <th><span contenteditable>{{$row->cache+$row->pose+$row->card}}</span></th>
            <td><span data-prefix></span><span contenteditable>پرداخت کرده</span></td>
        </tr>
        <tr>
            <th><span contenteditable>{{number_format($row->card)}}</span></th>
            <td><span data-prefix></span><span contenteditable>کارت</span></td>
        </tr>
        <tr>
            <th><span contenteditable>{{number_format($row->pose)}}</span></th>
            <td><span data-prefix></span><span contenteditable>پوز</span></td>
        </tr>
        <tr>
            <th><span contenteditable>{{number_format($row->cache)}}</span></th>
            <td><span data-prefix></span><span contenteditable>نقدی</span></td>
        </tr>
        <tr>
            <th><span contenteditable>{{number_format($row->price - ($row->cache+$row->pose+$row->card))}}</span></th>
            <td><span data-prefix></span><span>مانده</span></td>
        </tr>
    </table>
</article>

</body>

</html>
