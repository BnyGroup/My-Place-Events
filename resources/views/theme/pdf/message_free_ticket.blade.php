

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ forcompany() }} - Message de paiement</title>
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
            background: #FFF;
            width: 100%;
            padding: 5px 0;
        }
        .mail-inner-content{
            width: 1080;
            margin: 20px auto;
            /*border: 1px solid #efefef;*/
            border-radius: 0px;         
        }
        .mail-header .mail-logo{
            text-align: center;
            padding: 20px 10px;
        }
        .mail-header .mail-header-title{
            background:#FF33D1;
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
            color: #FF33D1;
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
            font-size: 15px;
            color: #999999;
            font-weight: bold;
        }
        .term-service a{
            color: #FF33D1;
            text-decoration: none;          
        }
        .note{
            text-align: center;
            font-size: 13px;
            color: #1531B0;
            font-weight: bold;
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
            line-height:1.5
        }
        .login .login-link a{
            text-decoration:none;
            color:#D600A9;
            font-weight:normal;
        }
        
        
            .mail img{

            width: 100%;
            position: relative;
            padding-top:100px;
        }
      


    </style>
</head>

<body>
    <div class="mail-container">
        <div class="mail-inner-content">
            <!-- HEADER -->
            <div class="mail-header">
                <div class="mail-logo" style="position: relative;display: flex;justify-content: space-around;bottom:30px; ">
             <a href="">
                    <img src="{{ for_logo() }}" alt="{{forcompany()}}" height="100" />
              </a>

                    <div id="mon_banner1">
                        <img src="{{ asset('/img/brand_bas.png') }}" alt="{{forcompany()}}" height="100" width=95%; style="position: relative;left:30px; " >
                    </div>
                                      
                </div>
                    <div class="mail-header-title" >
                    <h1>E-Ticket de l'évènement</h1>
                </div>
            </div>
            <div class="mail-body">
               

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="mes_mesge_imgevent" style="display: flex;justify-content: space-around;top: 50px; text-align: center;">
                            <h2 id="message1" style="position: relative;top:60px;font-size: 2em; right: 20px;" > <span style="color: #FF33D1"> 
                                {{guestUserData($orderData->gust_id)->name}} </span> , vient de confirmer sa <br> <span style="text-align: center;"> commande pour :<br>  </span>  
                                <span style="position:relative; top: 10px; color: #1531B0; font-size: 20px; text-align: center;">{{ $orderData->event_name }}</span> 
                            </h2>

                            <h3 id="event_img2"> <img src="{{ getImage($orderData->event_image, 'thumb') }}" style=" height: 20em; width: 20em ; position:relative; border-radius: 90px;right: 20px; background-color: #fff; padding: 10px; box-shadow: 0 0 8px rgba(10, 10, 10, 10.10); margin-top: 50px;"></h3>

                           

                        </div>
                        <div id="trait_org" style="position: relative; top: 120px;">
                        <div id="mon_trait" style="position: relative;bottom: 50px;"> <hr style=" border: none; border-top: 2px dashed #000; width: 100%; margin: 20px 0;"> </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="nom_org" style=" position: relative;bottom: 50px;text-align: center;">
                            <p class="toikcek-o" style="font-size: 2em">Organisé par: <span style="color: #1531B0 "> {{ $orderData->org_name }}</span> </p>
                        </div>
                        </div>
                
                <div class="order-summary" style="position: relative;top: 100px;">
                 
                    <div class="order-body">
                        <table cellspacing="0" cellpadding="0" border="0" style="position: relative;bottom: 30px; margin-top: 30px;">
                            <tbody>
                                <tr>
                                    <td class="bottom-dashed">
                                        <h2>@lang('words.pdf.summ_ord')</h2>
                                    </td>
                          
                                    <td style="text-align:right;border-bottom:1px dashed #d3d3d3">          
                                        <div class="date">
                                          

                                            {{ Carbon\Carbon::parse($orderData->BOOKING_ON)->format('l - F j, Y') }}
                                        </div>
                                        
 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">            
                                        <p class="order-number">@lang('words.eve_order.eve_book_tbl_1') : {{ $orderData->order_id }} </p>
                                        @php
                                            $order_t_id     = unserialize($orderData->order_t_id);
                                            $order_t_title  = unserialize($orderData->order_t_title);
                                            $order_t_price  = unserialize($orderData->order_t_price);
                                            $order_t_fees   = unserialize($orderData->order_t_fees);
                                            $order_t_qty    = unserialize($orderData->order_t_qty);
                                        @endphp
                                    <table cellspacing="0" cellpadding="0" border="0" style="width: 100%;">
                                        <h1 style="color: #1531B0; text-align: center;">E-Ticket</h1>
                                            <thead>
                                                <tr>                        
                                                    <th class="table-th">
                                                        <div class="title">Type</div>
                                                    </th>
                                                    <th class="table-th" style="text-align:right;">
                                                        <div class="title">Prix Unitaire</div>
                                                    </th>
                                                    <th class="table-th" style="text-align:center;">
                                                        <div class="title">@lang('words.events_booking_page.eve_book_tik_qty')</div>
                                                    </th>
                                                    <th class="table-th" style="text-align:right;">
                                                        <div class="title">Prix Total</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($order_t_id))
                                                    @foreach($order_t_id as $key => $ticket)
                                                    <tr>
                                                        <td class="table-td" style="width: 50%;">
                                                            <div class="title">{{ $order_t_title[$key] }}</div>
                                                        </td>
                                                                <td class="table-td" style="text-align:right;width: 30%;">
                                                            <div class="title">
                                        
<?php

        if (\Session::has('discount')){
            
            if(Session::get('discount_type')[0]=='percentage'){    
                $discount_amount = ($order_t_price[$key]*Session::get('discount')[0])/100;
                $order_t_price[$key] = $order_t_price[$key] - $discount_amount;
            }else{
                $order_t_price[$key] = $order_t_price[$key] - Session::get('discount')[0];
            }
            
        }                                       
?>                                      
    
                                                                
                                                                @if($order_t_price[$key] == 0)
                                                                    @lang('words.pdf.text_11')
                                                                @else
                                                                    {!! use_currency()->symbol !!} {{ ($order_t_price[$key] + $order_t_fees[$key]) }}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="table-td" style="text-align:center;width: 20%;">
                                                            <div class="title">{{ $order_t_qty[$key] }}</div>
                                                        </td>
                                                        <td class="table-td" style="text-align:right;width: 30%;">
                                                            <div class="title">
                                        
<?php

        if (\Session::has('discount')){
            
            if(Session::get('discount_type')[0]=='percentage'){    
                $discount_amount = ($order_t_price[$key]*Session::get('discount')[0])/100;
                $order_t_price[$key] = $order_t_price[$key] - $discount_amount;
            }else{
                $order_t_price[$key] = $order_t_price[$key] - Session::get('discount')[0];
            }
            
        }                                       
?>                                      
    
                                                                
                                                                @if($order_t_price[$key] == 0)
                                                                    @lang('words.pdf.text_11')
                                                                @else
                                                                    {!! use_currency()->symbol !!} {{ ($order_t_price[$key] + $order_t_fees[$key]) * $order_t_qty[$key] }}
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="bottom-dashed"></div>
                        <p class="term-service">
                            @lang('words.pdf.sum_ord_1') <a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation/" target="_blank" >@lang('words.mail_tmp.terms_ser')</a>  @lang('words.mail_tmp.org_tik_an')
                            <a href="https://myplace-events.com/fr/pages/politique-de-confidentialite-des-donnees-personnelles" target="_blank" >@lang('words.mail_tmp.terms_se2')</a> de My Place Events.
                        </p>
                    </div>
                    
                </div>
             
                <div class="about-event">
                    
                    <div class="event-datetime">
                    
                        @php
                            Jenssegers\Date\Date::setLocale('fr');
                            $startdate  = ucwords(Jenssegers\Date\Date::parse($orderData->event_start_datetime)->format('l j M Y'));
                            $enddate    = ucwords(Jenssegers\Date\Date::parse($orderData->event_end_datetime)->format('l j M Y'));
                            $starttime  = Carbon\Carbon::parse($orderData->event_start_datetime)->format('H:i');
                            $endtime    = Carbon\Carbon::parse($orderData->event_end_datetime)->format('H:i');
                        @endphp
                    
                    </div>

                    <div style="position: relative; top:80px; ">
                        <h2 style=" font-weight: bold;">@lang('words.mail_tmp.org_tik_ab')</h2>
                        
                        <h4  style=" font-weight: bold;">Date : {{ $startdate }} - {{ $enddate }}   </h4>
                        <h4  style=" font-weight: bold;">Heure : {{ $starttime }} - {{ $endtime }} </h4>
                        <h4  style=" font-weight: bold;">Lieu : {{ $orderData->event_address }}</h4>

                    </div>

           
                </div>
                 <div class="mail">

                <img src="{{ asset('/img/brand_bas.png') }}" alt="{{forcompany()}}">
                
            </div>
                   
            </div>
            <!-- FOOTER -->
          
        </div>
    </div>
</body>
</html>



