<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ forcompany() }} - Votre événement a été approuvé</title>
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
            background:#2547B0;
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
            font-size: 10px;
            color: #999999;
        }
        .term-service a{
            color: #FF33D1;
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
            line-height:1.5
        }
        .login .login-link a{
            text-decoration:none;
            color:#FF33D1;
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

        .img_feli{
            width: 100%;
        }

        .img_banner_bas{

             width: 100%;
             position: relative;
             top: 5px;

        }


    </style>
</head>

<body>
<div class="mail-container">
    <div class="mail-inner-content">
        <!-- HEADER -->
       <!--  <div class="mail-header">
            <div class="mail-logo">
                <a href="">
                    <img src="{{ for_logo() }}" alt="{{forcompany()}}" height="50" />
                </a>
            </div>
            <div class="mail-header-title" >
                <h1>Confirmation de l'événement</h1>
            </div>
        </div> -->
        <div class="mail-header">
           <div class="mail-header-title" >
                <h1>VALIDATION D’UN ÉVÉNEMENT</h1>
            </div>
        </div>
               <img class="img_feli" src="{{ asset('/img/banner_haut.png') }}" alt="{{forcompany()}}" height="120">
        <div class="mail-body">
            <div class="body-title">
                <h4>Félicitations <span>{{ $orderData->fnm }} {{ $orderData->lnm }} ! </span>  </h4> 

                <h4> Ton événement <!-- <span>{{ $orderData->event_name }}</span> --> a été officiellement validé sur notre plateforme  
                    <span style="color: #FF33D1;"> My Place <br> Events </span>. Nous sommes  Nous sommes enchantés de collaborer avec toi. </h4>

                    <h4>Les tickets d’accès peuvent dès maintenant être réservés par tes clients. </h4>

                    <h4>Nous t’encourageons vivement à partager le lien de ton événement sur tes <br>
                    différents réseaux sociaux pour maximiser sa visibilité. </h4>

                    <h4>Pour toute question ou assistance, n’hésite pas à nous contacter au <br> 

                     <span  style="color: #FF33D1;">  +225 07 47 97 45 05 </span> ou par mail à <span style="color: #FF33D1;"> {{ frommail() }}  </span>  <br> 

                     Nous sommes là pour contribuer à la réussite de ton événement.  

                    </h4>

               <!--  <h4> Votre événement <br/><span>{{ $orderData->event_name }}</span> a été approuvé.</h4>
                <p><strong>@lang('words.mail_tmp.org_by_te') : </strong> {{ $orderData->ORG_NAME }}</p> -->
            </div>

            <div style=" position: relative;  left: 40%; margin-top: 20px;margin-bottom: 20px; display: block; width: 38%; ">  
               <a href="https://myplace-events.com/" target="_blank"><button style=" color: black; background-color: #FFC300; font-weight: bold;"> ALLER SUR LE SITE </button></a>
            </div>
             <img class="img_banner_bas" src="{{ asset('/img/banner_bas.png') }}" alt="{{forcompany()}}" height="60">
        </div>
        
        <!-- FOOTER -->
       <!--  <div class="mail-footer">
            <p> @lang('words.mail_tmp.terms_se3') {{ frommail() }} <br/>
                Copyright © {{ date('Y') }} {{ forcompany() }} @lang('words.mail_tmp.terms_se4').  </p>
        </div> -->
    </div>
</div>
</body>
</html>