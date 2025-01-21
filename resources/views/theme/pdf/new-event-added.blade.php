<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ forcompany() }} - Nouvel événement ajouté</title>
    <style type="text/css">
        @font-face {
            font-family: 'bentonsansbold';
            src: url('{{ asset("/font/bentonsans_bold-webfont.woff2") }}') format('woff2'),
            url('{{ asset("/font/bentonsans_bold-webfont.woff") }}') format('woff');
            font-weight: normal;
            font-style: normal;

        }
        @font-face {
            font-family: 'bentonsansmedium';
            src: url('{{ asset("/font/bentonsans_medium-webfont.woff2") }}') format('woff2'),
            url('{{ asset("/font/bentonsans_medium-webfont.woff") }}') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'bentonsansregular';
            src: url('{{ asset("/font/bentonsans_regular-webfont.woff2") }}') format('woff2'),
            url('{{ asset("font/bentonsans_regular-webfont.woff") }}') format('woff');
            font-weight: normal;
            font-style: normal;

        }

        body{
            font-family:"bentonsansregular","Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
        }
        .mail-container{
            background: #f7f7f7;
            width: 100%;
            padding: 5px 0;
        }
        .mail-inner-content{
            width: 700px;
            margin: 20px auto;
            /*border: 1px solid #efefef;*/
            border-radius: 0px;
        }
        .mail-header .mail-logo{
            text-align: center;
            padding: 20px 10px;
        }
        .mail-header .mail-header-title{
            background:#b8248d;
            color:#FFFFFF;
            text-align:center;
            padding:15px;
            letter-spacing: 2px;
        }
        .mail-header .mail-header-title h1{
            padding: 0;
            margin: 0;
        }
        .mail-body{
            padding: 10px;
            background: #ffffff;
        }
        .body-title{}
        .body-title h4{
            padding: 5px 0;
            color: #404040;
            font-weight: normal;
            font-size: 18px;
            line-height: 30px;
            margin: 0;
            text-align: center;
        }
        .body-title h4 span{
            color: #b8248d;
        }
        .body-title p{
            padding: 10px 0 5px 0;
            margin: 0;
            font-size: 14px;
            color: #777777;
            text-align: center;
        }
        .order-summary{
            padding: 25px 0;
        }
        .order-summary .bg-down,
        .order-summary .bg-up {
            height: 7px;
        }
        .order-summary .bg-down img{
            width: 100%;
            height: 12px;
        }
        .order-summary .bg-up img{
            width: 100%;
        }
        .order-summary .order-body{
            background: #ededed;
            min-height: 15px;
            padding: 18px 20px;
        }
        .order-title h2{
            color: #404040;
            font-weight: 300;
            margin: 0 0 12px 0;
            font-size: 24px;
            line-height: 30px;
        }
        .order-body table{
            width:100%;
            margin-bottom:12px
        }
        .order-body h2{
            color:#404040;
            font-weight:300;
            margin:0 0 12px 0;
            font-size:24px;
            line-height:30px;
        }
        .bottom-dashed{
            border-bottom:1px dashed #d3d3d3;
        }
        .order-body .date{
            color:#666666;
            font-weight:400;
            font-size:13px;
            line-height:18px;
        }
        .order-body .order-number{
            color:#666666;
            font-weight:400;
            font-size:15px;
            line-height:21px;
            margin-bottom:18px;
        }
        .order-body .table-th{
            border-bottom:1px dashed #d3d3d3;
            text-align:left;
            padding:5px 10px 12px 0;
            padding-right:10px;
        }
        .order-body .table-td{
            padding:12px 10px 12px 0;
        }
        .order-body .table-th .title{
            color:#666666;
            font-weight:bold;
            font-size:15px;
            line-height:21px;
            letter-spacing: 1px;
        }
        .order-body .table-td .title{
            color:#666666;
            font-weight:400;
            font-size:15px;
            line-height:21px;
        }
        .about-event{
            padding: 10px 25px;
        }
        .about-event h2.title{
            color:#404040;
            font-weight:300;
            margin:0 0 12px 0;
            font-size:24px;
            line-height:30px;
        }
        .about-event .event-vanue,
        .about-event .event-datetime{
            font-size: 14px;
        }
        .about-event .event-vanue strong,
        .about-event .event-datetime strong{
            padding: 5px;
            margin: 0 0 10px 0;
            color: #777777;
        }
        .about-event .event-vanue p,
        .about-event .event-datetime p{
            font-size: 13px;
            padding: 5px;
            margin: 0 0 10px 0;
            color: #444444;
        }
        .term-service{
            text-align: center;
            font-size: 10px;
            color: #999999;
        }
        .term-service a{
            color: #b8248d;
            text-decoration: none;
        }
        .note{
            text-align: center;
            font-size: 13px;
            color: #666666;
        }
        .login{
            padding: 20px 0 0 0;
        }
        .login td.image{
            width: 220px;
            text-align: center;
        }
        .login h2{
            color:#404040;
            font-weight:300;
            margin:0 0 12px 0;
            font-size:24px;
            line-height:30px;
            margin-bottom:8px;
        }
        .login .login-link{
            color:#666666;
            font-weight:400;
            font-size:15px;
            line-height:21px;
            font-weight:300;
            font-size:14px;
            line-height:1.5;
        }
        .login .login-link a{
            text-decoration:none;
            color:#b8248d;
            font-weight:normal;
        }
        .mail-footer{
            text-align: center;
        }
        .mail-footer p{
            font-size: 11px;
            padding: 5px 0;
            margin: 5px 0 5px 0;
            line-height: 20px;
            color: #999999;
            letter-spacing: 1px;
        }


    </style>
</head>

<body>
<div class="mail-container">
    <div class="mail-inner-content">
        <!-- HEADER -->
        <div class="mail-header">
            <div class="mail-logo">
                <a href="">
                    <img src="{{ for_logo() }}" alt="{{forcompany()}}" height="50" />
                </a>
            </div>
            <div class="mail-header-title" >
                <h1>Nouvel événement Ajouté</h1>
            </div>
        </div>
        <div class="mail-body">
            <div class="order-summary">
                <div class="bg-up">
                    <img src="{{ asset('/img/ticket-up.jpg') }}" alt="{{forcompany()}}">
                </div>
                <div class="order-body">
                    @php
                        $startdate 	= Carbon\Carbon::parse($orderData->event_start_datetime)->format('l, F j, Y');
                        $enddate 	= Carbon\Carbon::parse($orderData->event_end_datetime)->format('l, F j, Y');
                        $starttime	= Carbon\Carbon::parse($orderData->event_start_datetime)->format('h:i A');
                        $endtime	= Carbon\Carbon::parse($orderData->event_end_datetime)->format('h:i A');
                    @endphp
                    <table cellspacing="0" cellpadding="0" border="0" align="center">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                <img
                                        src="{{ getImage($orderData->event_image, 'thumb') }}"
                                        alt="{{ $orderData->event_name }}"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="bottom-dashed">
                                Nom de l'événement
                            </td>
                            <td style="text-align:right;border-bottom:1px dashed #d3d3d3">
                                {{$orderData->event_name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="bottom-dashed">
                                Catégorie
                            </td>
                            <td style="text-align:right;border-bottom:1px dashed #d3d3d3">
                                {{ $orderData->event_category }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date de l'événement
                            </td>
                            <td>
                                Début : {{ $startdate }} {{ $starttime }}<br>
                                Fin : {{ $enddate }} {{ $endtime }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Description
                            </td>
                            <td>
                                {!! $orderData->event_description !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Lieu
                            </td>
                            <td>
                                {{ $orderData->event_location }} - {{ $orderData->event_country }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <div class="mail-footer">
            <p> @lang('words.mail_tmp.terms_se3') {{ frommail() }} <br/>
                Copyright © {{ date('Y') }} {{ forcompany() }} @lang('words.mail_tmp.terms_se4').  </p>
        </div>
    </div>
</div>
</body>
</html>



