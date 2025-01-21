<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-3.min.css') }}">
    <style type="text/css">
    @font-face {
        font-family: FranceTVBrown-Regular;
        src: url('https://myplace-events.com/public/font/FranceTVBrown-Regular.tff');
    }
    @page{margin:4em}
    @media print{.page-break{height:0;margin:0}
    body {-webkit-print-color-adjust: exact}}
    body{font-family: 'monospace';padding:.5em;margin:0}
</style>
</head>
<body>
    @foreach($bookingdata as $key=>$bTicket)
    @php $pagebreak = $key>0?'page-brk':$key; @endphp
    <div class="page {{$pagebreak}}">
        <table style="background-image: url(/public/img/TICKET-BG.png);background-repeat:repeat;border-collapse: collapse;color:#fff;background-color:#1e2044;min-height:390px;margin:auto;width:1100px">
            <tbody>
                <tr><td style="padding:22px"></td></tr>
                <tr><td colspan="3" style="padding:30px;background: #ffa00a;background-image: url(/public/img/TICKET-tiret.png);background-position: center;background-size: contain;background-repeat: no-repeat;"></td></tr>
                <tr style="background:#ffa10b">
                    <td style="width:330px;background-repeat: no-repeat;background-position: right;background-size: contain;background-image: url(/public/img/TICKET-tiretH.png);padding:15px 20px 10px;">
                        <div style="font-size: 20px;margin: 10px 0;color: #1e2044;font-weight: 700">VOTRE TICKET POUR</div>
                        <div style="text-transform: uppercase;font-size: 65px;line-height: 1;margin: 10px 0;color:#fff;font-weight: 900;font-family: 'monospace';">
                            {{ substr($bTicket->event_name, 0,100) }}
                        </div>
                        <div style="display:block">
                            <span style="background: #1e2044;padding: 6px 6px 8px;color: #fff;font-size: 20px;display:block">{{ $bTicket->ot_qr_code }}</span>
                        </div>
                    </td>
                    <td style="width: 450px;background-repeat: no-repeat;background-position: right;background-size: contain;background-image: url(/public/img/TICKET-tiretH.png);padding:10px;text-align:center">
                        @php
                        /*$startdate = Carbon\Carbon::parse($bTicket->event_start_datetime)->format('l, F j, Y');
                        $enddate = Carbon\Carbon::parse($bTicket->event_end_datetime)->format('l, F j, Y');
                        $starttime = Carbon\Carbon::parse($bTicket->event_start_datetime)->format('h:i A');
                        $endtime = Carbon\Carbon::parse($bTicket->event_end_datetime)->format('h:i A');*/
                        Jenssegers\Date\Date::setLocale('fr');
                        $startdate  = ucwords(Jenssegers\Date\Date::parse($bTicket->event_start_datetime)->format('l j F Y'));
                        $enddate    = ucwords(Jenssegers\Date\Date::parse($bTicket->event_end_datetime)->format('l j F Y'));
                        $starttime  = Carbon\Carbon::parse($bTicket->event_start_datetime)->format('H:i');
                        $endtime    = Carbon\Carbon::parse($bTicket->event_end_datetime)->format('H:i');
                        @endphp
<?php

		if (\Session::has('discount')){
			$ddt=\Session::get('discount')[0]; 
			$dtype=\Session::get('discount_type')[0];
			if($dtype=='percentage'){ 
                $discount_amount = ($bTicket->TICKE_PRICE*$ddt)/100;
                $bTicket->TICKE_PRICE = $bTicket->TICKE_PRICE-$discount_amount;
            }else{ 
                $bTicket->TICKE_PRICE = $bTicket->TICKE_PRICE-$ddt;
            }
			
		}
						
?>						
                        @if($startdate == $enddate)
                        <p style="text-align: left;font-size: 16px;color: #000;font-weight: 500;padding: 10px 15px;background: #ffffff;margin: 10px 0;text-transform:uppercase">
                            <span>{{ $startdate }}</span> | <span class="StartTime">{{ $starttime }} - {{ $endtime }}</span>
                        </p>
                        @else
                        <p style="text-align: left;font-size: 16px;color: #000;font-weight: 500;padding: 10px 15px;background: #ffffff;margin: 10px 0;text-transform:uppercase">
                            <span class="StartDate">{{ $startdate }}</span> | <span class="StartTime">{{ $starttime }}</span> => <span class="EndDate">{{ $enddate }}</span> | <span class="EndTime">{{ $endtime }}</span>
                        </p>
                        @endif
                        <p style="text-align: left;font-size: 16px;color: #000;font-weight: 500;padding: 10px 15px;background: #ffffff;margin: 10px 0;text-transform:uppercase"><span class="Owner">{{ $bTicket->ot_f_name }} {{ $bTicket->ot_l_name }}</span></p>
                        <p style="text-align: left;font-size: 16px;color: #000;font-weight: 500;padding: 10px 15px;background: #ffffff;margin: 10px 0;text-transform:uppercase"><span class="Owner">{{ $bTicket->TICKE_TITLE }}</span></p>
                        <div style="font-size: 35px;color: #fff;text-transform: uppercase;text-align: left;clear: both;margin-bottom: 20px;display: block">
                            <span class="Price" style="display: block;float: left">Prix:</span>
                            <span style="background:#1e2044;padding:10px 0 10px 15px;color:#fff;float: left;font-weight:900">
                                @if($bTicket->TICKE_PRICE == 0)
                                	@lang('words.pdf.text_11')
                                @else
									{{ number_format($bTicket->TICKE_PRICE, 0, "."," ") /*number_format($bTicket->TICKE_PRICE, 0) */}}
									{{ use_currency()->symbol }}
                                @endif
                            </span>
                        </div>
                        <div style="text-align:left;color:#fff;font-size: 16px;margin: 15px 0 0;clear: both">
                                @lang('words.user_ord_page.ord_pg_ord')
                                #{{ $bTicket->ot_order_id }} @lang('words.view_ord_tbl.view_order_tak') :
                                @if(is_null($bTicket->gust_id))
                                {{ $bTicket->USER_FNAME }} {{ $bTicket->USER_LNAME }}
                                @else
                                {{ $bTicket->ot_f_name }}
                                @endif
                            <span style="color:#1e2044">@lang('words.pdf.on') {{ Jenssegers\Date\Date::parse($bTicket->ORDER_ON)->format('l j F Y') /*Carbon\Carbon::parse($bTicket->ORDER_ON)->format('l, F j, Y')*/ }}
                                - {{ Carbon\Carbon::parse($bTicket->ORDER_ON)->format('H:i')  }}
                            </span>
                        </div>
                    </td>
                    <td style="width: 200px;border-radius: 20px 0 0 20px;padding: 30px 0 30px 10px;background-image: url(/public/img/Qr-BG.png);background-size: cover;background-position: center;background-repeat: no-repeat">
                        <p style="text-align: center"><img style=";width:120px;"
                            src="{{ for_logo_ppath() }}" alt="">
                        </p>
                        <p style="text-align: center">
                            <img src="{{ getQrImage($bTicket->ot_qr_image) }}" width="150"/>
                        </p>
                    </td>
                </tr>
                <tr><td colspan="3" style="padding:30px;background: #ffa00a;background-image: url(/public/img/TICKET-tiret.png);background-position: center;background-size: contain;background-repeat: no-repeat"></td></tr>
                <tr><td style="padding:22px"></td></tr>
                </tbody>
            </table>
        </div>
        @endforeach
    </body>
    </html>