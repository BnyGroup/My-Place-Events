<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{ forcompany() }} - {{--Order Confirmed--}}Commande confirmée</title>
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
			background:#F16334;
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
			color: #F16334;
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
			color: #F16334;
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
			color:#F16334;
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
		.re-subscribe{
			background-color:#F16334;
			color:#fff;
			text-decoration:none;
			padding: 10px;
			border-radius:2px; 
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
						<img src="{{asset('/img/'.siteSetting()->logo)}}" alt="{{ siteSetting()->title }}" height="50" style="display:inline-block;"/>
					</a>
				</div>
				<div class="mail-header-title" >
					<h1>{{--Refund order --}}Ordre de remboursement #{{ $userdata->order_id}}</h1>
				</div>
			</div>
			<div class="mail-body">
				<div class="body-title">
					<h4>
						{{--Hi --}}Salut<span> {{ user_data($userdata->user_id)->fullname }} </span>, {{--Your refund is successfully transfer in your account.--}}
						Votre remboursement est transféré avec succès dans votre compte.</b></span>
					</h4>
					<div class="bottom-dashed"></div>
				</div>
				<div class="order-summary">
					<div class="bg-up">
						<img src="{{ asset('/img/ticket-up.jpg') }}" alt="" style="display:block;">
					</div>
					<div class="order-body">
						<p class="note">
							{{--Your order refund on--}} Votre commande est remboursée le <b>{{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d F, Y h:i A') }}</b> <br>	<b>{{--successfully--}}avec succès</b> {{--tansfer in your bank account.--}}
							virement sur votre compte bancaire.
						</p>
						<p class="note">
							<br>
							<table border="1">	
								<thead>	
									<tr>
										<th>{{--Event Name--}}Nom Event</th>
										<th>{{--Order id--}}ID Commande</th>
										<th>{{--Total Tickets--}}Billet Total</th>
										<th>{{--Refund Amount--}}Montant du remboursement</th>
									</tr>
								</thead>
								<tbody>	
									<tr align="center">
										<td>{{ $userdata->event_name }}</td>
										<td>#{{ $userdata->order_id }}</td>
										<td>{{ $userdata->order_tickets }}</td>
										<td>{!! use_currency()->symbol !!} {{ number_format($userdata->final_amount) }}</td>
									</tr>
								</tbody>
							</table>
						</p>
						<p class="note">
							{{--Thank you, for connected with us.--}}Merci de vous être connecté avec nous.
						</p>
						<br>
						<div class="bottom-dashed"></div>
						<p class="term-service">
	            			{{--Follow the --}}Suivez moi{{ siteSetting()->title }} <a href="" target="_blank" >{{--Terms of Service --}}Conditions d'utilisation</a> and  <a href="" target="_blank" >{{--Privacy Policy--}}Politique de confidentialité</a>
	        			</p>
					</div>
					<div class="bg-down">
						<img src="{{ asset('/img/ticket-down.jpg') }}" alt="" style="display:block;">
					</div>
				</div>
				<div class="about-event">
					<div class="bottom-dashed"></div>				
					<table class="login">
						<tr>
							<td class="image">
								<img src="{{ asset('/img/ticket-image.png') }}" width="150" style="display:block;">
							</td>
							<td>
								<h2>{{--Your Account--}}Votre Compte</h2>
								<div class="login-link">
									<a href="{{ route('user.signup') }}" target="_blank">{{--Log in--}}Connectez vous</a> {{--to access tickets and manage your orders --}}
									accéder aux tickets et gérer vos commandes
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- FOOTER -->
			<div class="mail-footer">
				<p>{{--This email was sent to --}}Cet email a été envoyé à {{ siteSetting()->site_email }} <br/>
				 Copyright © {{ date('Y') }} {{ siteSetting()->title }}. {{--All rights reserved--}}Tous les droits sont réservés.  </p>
			</div>
		</div>
	</div>
</body>
</html>



