@extends($theme)

@section('meta_title',setMetaData()->e_single_title.' '.$event->event_name )
@section('meta_description',setMetaData()->e_single_desc)
@section('meta_keywords',setMetaData()->e_single_keyword)
@section('og_image', getImage($event->event_image))

@section('css')

@endsection
@section('body_class', 'c-'.$event->id)

@section('content')
<style type="text/css">
.disabled-btn{
	background-color:#c2c2c2;
}
	.dumping .row{
		margin-right: 0;
		margin-left: 0;
		width: 100%;
		padding: 0px;
	}	
	.dumping .row .col-md-12{
		padding: 0px;
    	width: 100%;
	}

	div#specialPopup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.2);
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    z-index: 1000;
	height:100vh;
	width: 100%;
	}

	div#specialPopup div{
		width: 60%;
		margin-top: 0vh;
    	margin-bottom: auto;

	}

	div#specialPopup div a.appDownload{
		display:block;
	position: absolute;
	top: 60%;
    left: 56%;
    border: none;
    padding: 20px 30px;
    background-color: #ffffff;
    border-radius: 20px;
    color: #031b63;
    font-weight: 600;
	}

	div#specialPopup div a.appDownload:hover{
    background-color: #031b63;
    color: #ffffff;
	}

	div#specialPopup div button.closeBtn {
		background-color: #dc3545;
		color: #ffffff;
		position: absolute;
		border: none;
		padding: 10px;
		right: 22%;
	}

	@media only screen and (max-width: 2560px)  {

		div#specialPopup div{
		width: 60%;
		}

		div#specialPopup div a.appDownload {
		position: absolute;
		top: 58%;
		left: 57%;
		border: none;
		padding: 20px 30px;
		background-color: #ffffff;
		border-radius: 20px;
		color: #031b63;
		font-weight: 600;
		font-size: 24px;
		}
	}

	
	@media only screen and (max-width: 1440px)  {

		div#specialPopup div {
        width: 60%;
        margin-top: 13vh;
        margin-bottom: auto;
    	}



		div#specialPopup div a.appDownload {
			position: absolute;
			top: 55%;
			left: 58%;
			border: none;
			padding: 20px 30px;
			background-color: #ffffff;
			border-radius: 20px;
			color: #031b63;
			font-weight: 600;
			font-size: 16px;
		}
	}

	@media only screen and (max-width: 1024px)  {

		div#specialPopup div{
		width: 73%;
		}

		div#specialPopup div a.appDownload{
			top: 52%;
        	left: 61%;
			padding: 14px 14px;
			font-size: 14px;
		}
		div#specialPopup div button.closeBtn {
			right: 76%;
		}
	}

	@media only screen and (max-width: 768px)  {
		div#specialPopup div a.appDownload{
			left: 65%;
		}

		div#specialPopup div button.closeBtn {
			right: 85%;
		}
	}

	@media only screen and (max-width: 425px)  {
		div#specialPopup div a.appDownload {
        left: 62%;
		top: 47%;
        font-size: 11px;
        padding: 5px 14px;
        width: 106px;
	}

	div#specialPopup div button.closeBtn {
		font-size: 12px;
		background-color: #dc3545;
		color: #ffffff;
		position: absolute;
		border: none;
		padding: 10px;
		right: 73%;
	}

	div#specialPopup div{
		width: 60%;
		margin-top: 28vh;
    	margin-bottom: auto;

	}
}
</style>

<section class="blur" style="background:url('{!! getImage($event->event_image) !!}');width: 100%;height: 480px;">
</section>
@if ($event->event_unique_id === 7137993923)
    <div id="specialPopup" style="display: none; position:fixed">
		<div class="container">
		<a href="https://refpa7921972.top/L?tag=d_50484m_1573c_&site=50484&ad=1573">
			<img src="/public/img/promo-1xbet-3.png" alt="Image de l'événement" style="max-width: 100%; height: auto;">
			<a class="appDownload" href="https://refpa7921972.top/L?tag=d_50484m_1573c_&site=50484&ad=1573">@lang('words.events_detials_page.telecharge_app')</a>
		</a>
        <button onclick="closePopup()" class="closeBtn">Fermer</button>
		</div>
    </div>
@endif
<section class="page-title page-title- fil-ariane-light">
	<div class="container">
		<div class="row">
			<?php /*?><div class="col-sm-12 text-center">
				<h2 class="default-color " style="margin-top: 24px;">{{ $event->event_name }}</h2>
			</div><?php */?>
			<div class="breadcrumb breadcrumb-2 text-left">
				<p style="display:none" class="test"> {{ $event->event_unique_id }} </p>
				<p id="breadcrumbs"><span><span><a href="{{ url('/') }}{{--https://myplace-event.com/--}}">@lang('words.nav_bar.nav_bar_menu_1')</a> / <span><a href="{{--https://myplace-event.com/events/--}}{{ url('events') }}">@lang('words.nav_bar.nav_bar_menu_2')</a> / <strong class="breadcrumb_last primary-color" aria-current="page">{{ $event->event_name }}</strong></span></span></span></p>
			</div>

		</div>
		<!--end of row-->
	</div>
	<!--end of container-->
</section>
@if($error = Session::get('error'))
<div class="alert alert-danger" style="text-align: center">
	{{ $error }}
</div>
@elseif($success = Session::get('success'))
<div class="alert alert-success" style="text-align: center">
	{{ $success }}
</div>
@endif
<div class="page-main-contain" id="single-event">
	<div class="container">
		<div class="row detail-box-wrapper">
			<div class="col-lg-7 col-sm-12 detail-box-image">
                <div class="myeventimagebox">
				    <img src="{!! getImage($event->event_image, 'resize') !!}" style="width: 100%;height: auto" class="box-image-rev">
                </div>
				<div class="col-lg-12 cover-wrapper-child">
					<div class="row">
							 
                            <div class="col-md-12 col-lg-12 col-sm-12 descripton-content" style="text-align: justify;"> </div>

                        </div>
                    </div>
                </div>


                <div class="col-lg-5 col-sm-12 c-992-p-0">
                	<div class="col-md-12">
                		<div class="col-md-12">
                			<h2 class="mb8 section-title text-left">{{ $event->event_name }}</h2>

                			<div class="col-md-12">
                				<div class="title-style fiche-events">
                					<hr align="center" style="border-top: 0px">
                				</div>
                			</div>
                		</div>
                		{{--<div class="col-lg-12 col-md-12 col-sm-12 k-date">--}}
                			{{--<span style="text-transform: uppercase;">{!! Carbon\Carbon::parse($event->event_start_datetime)->format('F') !!}</span>--}}
                			{{--<p>{!! Carbon\Carbon::parse($event->event_start_datetime)modal-body->format('d') !!}</p>--}}
                		{{--</div>--}}
                		 
                		<div class="col-lg-12 col-sm-12 col-md-12 date-time-set">
                            <div class="inner"> 
                			{{--<h6 class="descripton-content-title">@lang('words.events_detials_page.eve_content_date')</h6>--}}
                			@php
                			/*Carbon\Carbon::setLocale('fr');
                			$startdate 	= Carbon\Carbon::parse($event->event_start_datetime)->format('D j M  Y');
                			$enddate 	= Carbon\Carbon::parse($event->event_end_datetime)->format('D j M Y');
                			$starttime	= Carbon\Carbon::parse($event->event_start_datetime)->format('H:i');
                			$endtime	= Carbon\Carbon::parse($event->event_end_datetime)->format('H:i');*/

                			Jenssegers\Date\Date::setLocale('fr');
                			$startdate 	= ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y'));
                			$enddate 	= ucwords(Jenssegers\Date\Date::parse($event->event_end_datetime)->format('l j F Y'));
                			$starttime	= Carbon\Carbon::parse($event->event_start_datetime)->format('H:i');
                			$endtime	= Carbon\Carbon::parse($event->event_end_datetime)->format('H:i');
                			@endphp
                			 
                			@if($startdate == $enddate)
                			 
                                <div class="floatFelt"><strong class="primary-color"><i class='far fa-calendar-alt primary-color'></i> @lang('words.cre_eve_page.cre_start_date'): </strong></div> 
                                <div class="floatRight"><strong class="third-color"> {{ $startdate }}</strong></div>
                             
                            
                			 
                                <div class="floatFelt"><strong class="primary-color"><i class='far fa-clock primary-color'></i> @lang('words.cre_eve_page.cre_end_hour'):</strong></div>
                                <div class="floatRight"><strong class="third-color">{{ $starttime }} - {{ $endtime }}</strong></div>
                             
                			@else
                			 
                                <div class="floatFelt"><strong class="primary-color"><i class='far fa-calendar-alt primary-color'></i> @lang('words.cre_eve_page.cre_start_date'): </strong></div>
                                <div class="floatRight"><strong class="third-color"> {{ $startdate }}</strong></div>
                            
                			
                                <div class="floatFelt"><strong class="primary-color"><i class='far fa-calendar-alt primary-color'></i> @lang('words.cre_eve_page.cre_end_date'): </strong></div>
                                <div class="floatRight"><strong class="third-color"> {{ $enddate }}</strong></div>
                            
                                <div class="floatFelt"><strong class="primary-color"><i class='far fa-clock primary-color'></i> @lang('words.cre_eve_page.cre_end_hour'): </strong></div>
                                <div class="floatRight"><strong class="third-color">{{ $starttime }} - {{ $endtime }}</strong></div>
                            
                			@endif
                			<!-- <a href="">Add to calender</a> -->
                			 
                                <div class="floatFelt"><strong class="primary-color"><i class='fas fa-map-marker-alt primary-color'></i> @lang('words.cre_eve_page.cre_fm_loca'): </strong></div>
                                <div class="floatRight"><strong class="third-color"> <a style="color: #000D8C !important;" href="http://maps.google.com/?q=<?php echo urlencode($event->event_location) ?>" target="_blank">{{ $event->event_location }}</a> </strong></div>
                             
                                <div class="floatFelt"><strong class="primary-color"><i class='fas fa-map-marker-alt primary-color'></i> @lang('words.cre_eve_page.cre_fm_ctry'): </strong></div>
                                <div class="floatRight"><strong class="third-color"> {{ $event->event_country }} </strong></div>
                             
                			 








                				<div class="floatFelt"><i class='fas fa-tag primary-color'></i>
                				<strong class="primary-color"> @lang('words.cre_eve_page.cre_fm_cat'):  </strong></div>
                				<div class="floatRight"><span class="badge category" style="cursor: default; background-color: #00024F; border-radius: 50px; min-width: 40% !important">
                					<span class="" style="color: #FFFFFF !important">
                						{{ $event->this_event_category }}
                					</span>
                                    </span></div>
                			 
								<p>
									<div class="floatFelt"><strong class="primary-color"><i class='far fa-user primary-color'></i> @lang('words.cre_eve_page.cre_promotor'): </strong></div>
									<div class="floatRight"><strong class="third-color"> {{ $event->org_name }} </strong></div>
								</p>
                            </div>
                		</div>

                		<div class="col-md-12 c-992-p-0 mb-2">
                			<p align="left" class="single-price defaultButton"> 
                				@if($event->event_min_price == 0)
                				    @lang('words.pdf.text_11')
                				@else
                				    {!! number_format($event->event_min_price,0, "."," ") !!} {!! use_currency()->symbol !!} {{-- /  {{number_format(($event->event_min_price / 655),0, "."," ")}} Euros --}}
                				@endif
                				@if($event->event_min_price != $event->event_max_price)
                				-  {!! number_format($event->event_max_price,0, "."," ")!!} {!! use_currency()->symbol !!} {{-- /  {{number_format(($event->event_max_price / 655),0, "."," ")}} Euros --}}
                				@endif
                			</p>
                		</div>
                        @if(auth()->guard('frontuser')->check())
                            @php $userid = auth()->guard('frontuser')->user()->id  @endphp
                            @php $guestData = false @endphp
                        @else
                            @php $userid = ''  @endphp
                            @if(@\Session::get('guestUser')['GuestEmail'] != '')
                            @php $guestData = true @endphp
                            @else
                            @php $guestData = false @endphp
                            @endif
                        @endif

                        <div class="col-sm-12 defaultButton row" >
                                
                         <?php	
								$dx=0; $eventEndDateBilletnow="";
								if(!empty($event->eventEndDateBillet)){
									$eventEndDateBilletnow=$event->eventEndDateBillet.' '.$event->eventEndTimeBillet;
									
									if($eventEndDateBilletnow>=\Carbon\Carbon::now()){
										echo"Billeterie Fermée";
										$dx=1;
									}
								}
								
								/*if(!empty($event->event_end_datetime)){
									
									if($event->event_end_datetime>=\Carbon\Carbon::now()){
										echo"Billeterie Fermée";
										$dx=1;
									}
								}*/
																						
								if($dx==0){
									 echo"<!-- DDX ".$eventEndDateBilletnow."-->";
?>
							<div class="col-sm-6" style="padding-left: 0px;">  
<?php

									if($event->event_end_datetime < \Carbon\Carbon::now()->addDays(1)){ 
										echo"<!-- DX ".$event->event_min_price."-->";
										if($event->event_min_price == 0){
									?>
                                    <button style="cursor: pointer;" class="register-btn reserveNow ticks hide-register text-uppercase {{ $event->event_end_datetime < \Carbon\Carbon::now() ?'disabled-btn':''}}" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" {{ $event->event_end_datetime > \Carbon\Carbon::now()->addDays(1) ?'disabled':''}}>@lang('words.events_detials_page.book_event') <i class="fa fa-chevron-right" style=""></i></button>
                                    <?php		
										}else{
									?>
                                    <button style="cursor: pointer;" class="register-btn reserveNow ticks hide-register text-uppercase {{ $event->event_end_datetime < \Carbon\Carbon::now() ?'disabled-btn':''}}" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" {{ $event->event_end_datetime > \Carbon\Carbon::now()->addDays(1) ?'disabled':''}}>@lang('words.events_detials_page.buy_ticket') <i class="fa fa-chevron-right" style=""></i></button>
                                    <?php 					
										
										}
									
									}else{ ?>										
                                      
										<?php if($event->event_min_price == 0){ 									?>
											 <button style="cursor: pointer;" class="register-btn reserveNow ticks hide-register text-uppercase" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}">@lang('words.events_detials_page.book_event') <i class="fa fa-chevron-right" style=""></i></button>
										<?php		
											}else{
										?>
											 <button style="cursor: pointer;" class="register-btn reserveNow ticks hide-register text-uppercase" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}">@lang('words.events_detials_page.buy_ticket') <i class="fa fa-chevron-right" style=""></i></button>
										<?php } ?>  
									<?php } ?>	  
				      				  </div> 
                                      <div class="col-sm-6" style="padding-right: 0px;">
						<a href="https://wa.me/2250747974505/?text=*@lang('words.events_box_tooltip.Whatsapp_mess1')* _{{route('events.details',$event->event_slug)}}_  *@lang('words.events_box_tooltip.Whatsapp_mess2')*." style="cursor: pointer" class="register-btn reserveNow text-uppercase WhatsBook" id="whatsappBook" data-user="{{$userid}}" data-guest="{{ $guestData }}" target='_blank'>
							<span>@lang('words.events_box_tooltip.book_whatsapp')</span>
							<i class="fab fa-whatsapp" style="font-size: 20px;margin-left: 10px"></i>
						</a>
				      </div>
                                    <?php 
								
								}	
							?> 
										
                       </div>
                              
						<hr style="margin: 30px 15px; border-bottom: 2px dotted #000D8C;">


<div style="position: relative;left: 20px;margin-bottom: 20px;margin-top: 20px">
    <img src="/public/img/faq.png" alt="faq" id="myImg" width="15%" height="15%;">
</div>

	<div class="modal" id="myModal">
  <div class="modal-content-1">
    <span class="close">&times;</span>
    <div class="modal-body">
      	<div class="mail-logo" style="position: relative;display: flex;justify-content: space-around;">
					
					<a id="logo_faq" href="{{ url('/') }}">
                <img src="{{ for_logo() }}" height="80" width=100%; >
            </a> 


					<div id="mon_banner1">
						<img src="{{ asset('/img/bande_haut_faq.png') }}" alt="{{forcompany()}}" height="80" width=125%; style="position: relative;right:30px;">
					</div>							                  
		</div>
		<div id="title_faq_1">
	 	<P><span style="background-color:#d600a9;color: #fff; ">SUIS-JE OBLIGÉ DE CRÉER UN COMPTE SUR LA PLATEFORME POUR ACHETER UN TICKET ?</span> </P>
		</div>

		<div id="title_faq_2">
	 	<P>Nous te permettons d'acheter tes <span style="color:#000D8C;font-weight:900;">tickets</span>  sans t’inscrire.<br>Toutefois, nous te conseillons fortement de le faire ! Les <br><span style="color:#000D8C;font-weight: 900;">avantages :</span> </P>
		</div>

		<div id="title_faq_3" >
	 	<P class="point-before">Avoir <span style="color:#000D8C;font-weight: 900;">l’historique</span>  de tous tes achats de tickets</P>
		</div>

		<div id="title_faq_4">
	 	<P class="point-before">Ne pas ressaisir tes <span style="color:#000D8C;font-weight: 900;">coordonnées</span> à chaque commande</P>
		</div>

		<div id="title_faq_5">
	 	<P class="point-before">Gagner des <span  style="color:#000D8C;font-weight: 900;">points de fidélité </span>à chaque achat</P>
		</div>

		<div id="title_faq_6">
	 	<P class="point-before">Ajouter des événements à tes <span style="color:#000D8C;font-weight: 900;">favoris</span> et passer à l’achat plus tard</P>
		</div>

		<div id="title_faq_7">
	 	<P class="point-before">Bénéficier de <span style="color:#000D8C;font-weight: 900;">réductions</span>  et <span style="color:#000D8C;font-weight: 900;">tickets gratuits</span> </P>
		</div>
			<div id="title_faq_8">
	 	<P><span style="background-color:#d600a9;color: #fff; " >ON ME DEMANDE D’AJOUTER UN CODE COUPON</span> </P>
		</div>
			<div id="title_faq_9">
	 	<P>Cette étape n’est pas obligatoire.Le champ <span style="color:#000D8C;font-weight: 900;"> «CODE COUPON <br> »</span> doit uniquement être rempli par les clients ayant reçu un <br> code de réduction. Si tu n’en as pas reçu, tu peux poursuivre <br>ton achat en sélectionnant le nombre de tickets souhaité puis <br>
        en cliquant sur <span style="color:#000D8C;font-weight: 900;">« ACHETEZ MAINTENANT » .</span> </P>
		</div>
			<div id="title_faq_10">
	 	<P><span  style="background-color:#d600a9;color: #fff; ">JE SOUHAITE MODIFIER LE NOM SUR MON TICKET. EST-CE<br> POSSIBLE ?</span></P>
		</div>
		<div id="title_faq_11">
	 	<P> Par défaut, le nom et prénom apparaissant sur le ticket est <br> celui de l’acheteur. Tu peux toutefois le personnaliser en allant <br>dans la section <span  style="color:#000D8C;font-weight: 900;">« INFORMATIONS SUR LES TICKETS »</span> et en <br>cliquant sur <span  style="color:#000D8C;font-weight: 900;"> « PERSONNALISER LES INFORMATIONS DE CE <br>
            TICKET ».</span> Le ticket sera envoyé à l’adresse mail <br>communiquée. </P>
		</div>
		<div id="title_faq_12">
	 	<P> <span style="background-color:#d600a9;color: #fff; ">QUELS MOYENS DE PAIEMENT PUIS-JE UTILISER POUR L’ACHAT <br>DE MON TICKET ?</span></P>
		</div>
			<div id="title_faq_13">
	 	<P> Si tu as une carte bancaire, peu importe où tu te trouves, tu <br> pourras acheter un ticket sur notre site internet. Tu peux <br>uniquement payer par mobile money si tu te trouves dans <br> l’un des pays suivants :</P>
		</div>
		<div id="pays_title">
			<div id="title_pays_1" >
	 	<P class="point-before">Bénin</P>
		</div>

		<div id="title_pays_2">
	 	<P class="point-before">Burkina Faso</P>
		</div>

		<div id="title_pays_3">
	 	<P class="point-before">Cameroun</P>
		</div>

		<div id="title_pays_4">
	 	<P class="point-before">Côte d'ivoire</P>
		</div>

		<div id="title_pays_5">
	 	<P class="point-before">Mali</P>
		</div>
			<div id="title_pays_6">
	 	<P class="point-before">Sénégal</P>
		</div>

		<div id="title_pays_7">
	 	<P class="point-before">Togo</P>
		</div>
		</div>
		<p id="test_1">D’autres pays complèteront (très) bientôt cette liste !</p>
		<p id="paiment_test"><span style="background-color:#d600a9;color: #fff;">MON PAIEMENT A ÉCHOUÉ. À QUOI CELA EST-IL DU ?</span></p>
		<p id="cause_faq">Il y’a plusieurs causes mais les plus fréquentes sont celles-ci :</p>
		
		<div id="title_cause_1">
	 	<P class="point-before">Tes <span style="color:#000D8C;font-weight: 900;">fonds</span> sont insuffisants</P>
		</div>

		<div id="title_cause_2">
	 	<P class="point-before">Ta <span style="color:#000D8C;font-weight: 900;">connexion internet </span> est instable</P>
		</div>

		<div id="title_cause_3">
	 	<P class="point-before">Tu as mis <span style="color:#000D8C;font-weight: 900;">trop de temps</span> avant de finaliser ta commande</P>
		</div>

		<div id="title_cause_4">
	 	<P class="point-before">La <span style="color:#000D8C;font-weight: 900;">plateforme de paiement </span> est temporairement <br>indisponible</P>
		</div>
			<div id="title_cause_5">
	 	<P class="point-before">Les <span style="color:#000D8C;font-weight: 900;">envois d’informations </span> entre la plateforme de <br> paiement et les différents opérateurs mobile money ont <br> échoué</P>
		</div>
			<div id="title_cause_6" >
	 	<P class="point-before">Tu as indiqué un mauvais <span style="color:#000D8C;font-weight: 900;"> code OTP </span> </P>
		</div>
		<p id="doute">Si tu as un doute, rapproche-toi de nous et nous te donnerons <br> plus de détails.</p>
		<p id="que_faire"><span style="background-color:#d600a9;color: #fff;">QUE DOIS-JE FAIRE LORS DE LA RÉCEPTION DE MON TICKET<br>PAR MAIL ?</span></p>
		<p id="possib">Il y a 2 possibilités :</p>
		  <div id="possib1">
	 	<P class="point-before">Le télécharger sur ton téléphone portable</P>
		</div>
		<div id="possib2" >
	 	<P class="point-before">L’imprimer</P>
		</div>
		<p id="attention"><span style="color:#d600a9;font-weight: 900;">ATTENTION !</span> Ne partage jamais ton ticket d’accès à <br>quelqu’un d’autre. Pas de transfert de mail, pas d’envoi de<br>captures. Car le jour J, celui qui entre est celui qui réussi à<br>faire scanner son ticket en premier. Sois donc prudent !</p>
		<p id="ticket_reçu"><span style="background-color:#d600a9;color: #fff;">JE N’AI PAS REÇU MON TICKET. QUE DOIS-JE FAIRE ?</span></p>
		<p id="possible_que">Il est possible que ton ticket ait atterri dans tes spams. Si tu <br>t’es inscrit sur notre plateforme, tu peux retrouver ton ticket <br>sur ton compte client. Si tu ne le retrouves toujours pas,<br>contacte-nous !</p>
		<div id="contact">
		<p style="color: #d600a9"><span style="color:#000D8C;font-weight: 900;">Email :</span>contact@myplace-events.com</p>
		<p style="color: #d600a9 "><span style="color:#000D8C;font-weight: 900;">WhatsApp :</span> +225 07 47 97 45 05</p>
		<p style="color: #d600a9 "><span style="color:#000D8C;font-weight: 900;">Réseaux sociaux :</span> Facebook, Instagram, LinkedIn</p>
		</div>
		<p>Notre plateforme enregistrant tous tes achats, nous pourrons<br>te renvoyer ton ticket en cas de non-réception.</p>
		
    </div>
     <div id="mon_banner1">
		<img src="{{ asset('/img/bande_bas_faq.png') }}" alt="{{forcompany()}}" height=40% width=107.5%; style="position: relative;right: 25px;top: 25px;">
  </div>
  </div>
 	
</div>
				<script>
// Récupérer l'image qui ouvre le modal
var img = document.getElementById("myImg");

// Récupérer le modal
var modal = document.getElementById("myModal");

// Récupérer le bouton de fermeture
var closeBtn = modal.querySelector(".close");

// Lorsque l'image est cliquée, afficher le modal
img.addEventListener("click", function () {
  modal.style.display = "block";
});

// Lorsque le bouton de fermeture est cliqué, masquer le modal
closeBtn.addEventListener("click", function () {
  modal.style.display = "none";
});

// Lorsque l'utilisateur clique en dehors du modal, masquer le modal
window.addEventListener("click", function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
});
                 </script>

<style type="text/css">
	.modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
  
}

.modal-content-1 {
  background-color: #fefefe;
  margin: 15% auto;
  border: 1px solid #888;
  width: 50%;
  color: #1E1D1D;
  font-family: Arial, sans-serif;
  font-weight: 300;
  padding: 25px;
}

.close {
  color: #aaa;
  float: left;
  font-size: 50px;
  font-weight: 800;
}

.close:hover,
.close:focus,
.close:not(:disabled):not(.disabled) {
  color: black;
  text-decoration: none;
  cursor: pointer;
  top: 12px

}

.modal-body {
  
}

  @media screen and (max-width: 600px) {
    .modal-content-1 {
      width: 100%;
      text-align: center;

    }
    #mon_banner1{
    	display: none;
    }
    #logo_faq{
    	display: none;
    }


  }

#title_faq_1{
	margin-top: 15px;
	margin-bottom: 15px;
}
#title_faq_2{
	margin-top: 15px;
	margin-bottom: 15px;
}
#title_faq_3{
	margin-bottom: 15px;
}
#title_faq_4{
	
	margin-bottom: 15px;
}
#title_faq_5{
	
	margin-bottom: 15px;
}
#title_faq_6{
	
	margin-bottom: 15px;
}
#title_faq_7{
	
	margin-bottom: 15px;
}
#title_faq_8{
	margin-bottom: 15px;

}
#title_faq_9{
	margin-bottom: 20px;

}
#title_faq_10{
	margin-bottom: 15px;

}
#title_faq_11{
	margin-bottom: 25px;

}
#title_faq_12{
	margin-bottom: 20px;

}
#title_faq_13{
	margin-bottom: 15px;

}
#test_1{
	margin-bottom: 30px;
}
#paiment_test{
	margin-bottom: 15px;
}


    .point-before::before {
    content: "";
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: #d600a9;
    border-radius: 50%; /* Arrondit le point */
    margin-right: 5px; /* Espace entre le point et le texte */
  }
  #pays_title{
  	color:#000D8C;
  	font-weight: 900;
  }
  #paiment_test{
  	margin-bottom: 25px;
  }
  #que_faire{
  	margin-bottom: 15px;
  	margin-top: 25px
  }
  #attention{
  	margin-bottom: 15px;
  	margin-top: 25px
  }
  #ticket_reçu{
  	margin-bottom: 25px;
  	margin-top: 15px
  }
  #possible_que{
  	margin-bottom: 25px;
  }
  #contact{
  	margin-bottom: 25px;
  }

</style>

		
								
						<div class="col-sm-12 defaultButton row" style="margin: 0px 0">
							
							<div class="col-sm-6" style="margin-left: -15px;"> 
								
								@if(is_null(getbookmark($event->event_unique_id, $userid)))
									<div class="box-icon likebox" id="userlike-{{$event->event_unique_id}}">
										<a href="javascript:void(0)" id="save-event" class="save-event-2" data-user="{{$userid}}"
										   data-event="{{ $event->event_unique_id }}" data-mark="0">
											@if(is_null(getbookmark($event->event_unique_id, $userid)))
												<i class="far fa-heart"></i>
											@else
												<i class="fas fa-heart"></i>
											@endif
											<span>@lang('words.events_detials_page.add_event_bookmark')</span>
										</a> 
									</div>
								@else
									<div class="box-icon likebox addedbm" id="userlike-{{$event->event_unique_id}}">
										<a href="javascript:void(0)" id="save-event" class="save-event-2" data-user="{{$userid}}"
										   data-event="{{ $event->event_unique_id }}" data-mark="0">
											@if(is_null(getbookmark($event->event_unique_id, $userid)))
												<i class="far fa-heart"></i>
											@else
												<i class="fas fa-heart"></i>
											@endif
											<span>@lang('words.events_detials_page.del_event_bookmark')</span>
										</a> 
									</div>
								
								@endif
								  
								 
							</div>	
							<div class="col-sm-6" style="display: table;">
								<div class="box-icon sharebox">
									<a href="javascript:void(0)" class="event-share" data-url="{{route('events.details',$event->event_slug)}}" data-name="{{ $event->event_name }}" data-loca="{{ $event->event_location }}">
										 <i class="fas fa-share"></i>
										<span>@lang('words.events_detials_page.share_event')</span>
									</a> 
								</div>								 
							</div>
						</div>
										
						 <hr style="margin: 20px 15px; border-bottom: 2px dotted #000D8C;">
										
	
									<div class="col-sm-12 defaultButton row" style="display: block;">

									




<div class="moreInfoSection">										
<button class="EventInfoAccordion" style="position: relative; left: 1px">@lang('words.events_detials_page.add_infos')</button>
<div class="EventInfopanel">
 	{!! $event->event_description !!}
</div>

<button class="EventInfoAccordion" style="position: relative; left: 1px">@lang('words.events_detials_page.event_prod')</button>
<div class="EventInfopanel">
	@if(!empty($gadgets))
		<?php /*foreach($gadgets as $data)
			@include('theme.gadgets.gadget-unique-list')
		@endforeach*/ ?>
	@endif
</div>
<?php
	if(!empty($event->cover)){
		$dtCover="background: url('".getImage($event->cover)."')";
	}else{
		$dtCover="";
	}

?>
<button class="EventInfoAccordion"style="position: relative; left: 1px">@lang('words.events_detials_page.the_org')</button>
<div class="EventInfopanel" style="margin-top: 10px; margin-bottom: 0px; padding-left: 2px; padding-right: 2px;">
   <div class="orgbox"><b><a href="{{ route('org.detail',$event->org_slug) }}" target="_blank">{{ $event->org_name }}</a></b></div>
	
	<div class="orgboxhead" style="{{$dtCover}}"></div>	
	
		<div class="org-box-main">
			<div class="org-boxes">
				<div class="image-box-org">
					<a  href="{{ route('org.detail',$event->org_slug) }}"  target="_blank"><img src="{{ setThumbnail($event->profile_pic) }}"></a>
				</div>
				<div class="org-link-box text-center" style="margin-top:0">
					<button class="btn mb-2 ctog" data-toggle="modal" data-target="#contact-org" style="margin-right: 5%;">@lang('words.events_detials_page.contact_the_org')</button>

					<a href="{{ route('org.detail',$event->org_slug) }}"  target="_blank">
						<button class="btn mb-2 ctog" data-toggle="modal" data-target="#contact-org">@lang('words.events_detials_page.display_org_prof')</button>
					</a>
				</div>
			</div>
		</div>
</div>	
	
	</div>	
										
										
<script>
var acc = document.getElementsByClassName("EventInfoAccordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("EventInfoactive");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>										
										
		</div>

	
               <!-- le FAQ MyPlace Events -->
                <!-- le FAQ MyPlace Events -->


	


                                     
                        </div>
 
                		</div>
                	</div>
                	<!-- Bottom site stickey header open-->
 
 


                <div class="col-lg-12 col-sm-12 col-md-12" id="custome-stickey">
                	<div class="row detail-box-btn">
                        <div class="col-md-12 c-992-p-0">
                            <p align="center" class="single-price" style="margin: 20px 0">
                                @if($event->event_min_price == 0)
                                @lang('words.pdf.text_11')
                                @else
                                {!! number_format($event->event_min_price,0, "."," ") !!} {!! use_currency()->symbol !!}
                                @endif
                                @if($event->event_min_price != $event->event_max_price)
                                -  {!! number_format($event->event_max_price,0, "."," ")!!} {!! use_currency()->symbol !!}
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-12 text-center MobileBooking">
                            @if($event->event_end_datetime < \Carbon\Carbon::now())
                            <button style="cursor: pointer;" class="register-btn hide-register text-uppercase {{ $event->event_start_datetime < \Carbon\Carbon::now() ?'disabled-btn':''}}" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" {{ $event->event_start_datetime < \Carbon\Carbon::now() ?'disabled':''}}>@lang('words.events_detials_page.eve_reg_button')</button>
                            @else
                            <button style="cursor: pointer;" class="register-btn hide-register text-uppercase {{--{{ $event->event_start_datetime < \Carbon\Carbon::now() ?'disabled-btn':''}}--}}" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" {{--{{ $event->event_start_datetime < \Carbon\Carbon::now() ?'disabled':''}}--}}>@lang('words.events_detials_page.eve_reg_button') </button>
                            <br />
                            <a href="https://wa.me/2250747974505/?text=*@lang('words.events_box_tooltip.Whatsapp_mess1')* _{{route('events.details',$event->event_slug)}}_  *@lang('words.events_box_tooltip.Whatsapp_mess2')*." style="cursor: pointer" class="register-btn text-uppercase WhatsBook" id="whatsappBook" data-user="{{$userid}}" data-guest="{{ $guestData }}" target='_blank'>
                                <i class="fab fa-whatsapp" style="font-size: 30px;margin-right: 15px"></i>
                                <span>@lang('words.events_box_tooltip.book_whatsapp')</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Bottom site stickey header close-->

                
			</div>
		</div>

		<div class="container" style="margin-top:40px;">
			<div class="row detail-box-wrapper">
				<div class="col-lg-12 col-sm-12 col-md-12 cover-wrapper-details organisateur-box">
					 
					<!-- Start Model -->
					<div id="contact-org" class="modal fade bd-example-modal-lg" role="dialog">
						<div class="modal-dialog modal-xs">
							<div class="modal-content ticket-registion">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">@lang('words.cre_eve_page.cre_fm_orgT') <strong class="primary-color">{{ $event->org_name }}</strong></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<form id="org-con-form" method="post" action="{{ route('org.contact') }}">
										{!! csrf_field() !!}
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">@lang('words.cre_eve_page.cre_fm_orgN')</label>
											<div class="col-sm-10">
												{{-- <input type="hidden" name="org_mail" value="{{ user_data($event->user_id)->email }}"> --}}
												<input type="hidden" name="org_mail" value="{{ optional(user_data($event->user_id))->email }}">
												<input type="text" class="form-control" id="staticEmail" name="name" >
											</div>
										</div>
										<div class="form-group row">
											<label for="inputPassword" class="col-sm-2 col-form-label">@lang('words.cre_eve_page.cre_fm_orgEM')</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="inputPassword" required="" name="email">
											</div>
										</div>
										<div class="form-group row">
											<label for="subject" class="col-sm-2 col-form-label">@lang('words.cre_eve_page.cre_fm_orgSb')</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="subject" required="" name="subject">
											</div>
										</div>
										<div class="form-group row">
											<label for="msg" class="col-sm-2 col-form-label">@lang('words.cre_eve_page.cre_fm_orgMs')</label>
											<div class="col-sm-10">
												<textarea name="message"class="form-control" rows="5" id="msg" style="resize: none;" required=""></textarea>
											</div>
										</div>
										<input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="@lang('words.cre_eve_page.cre_fm_orgSed')">
									</form>
								</div>
								<!-- <div class="modal-footer"> -->
									<!-- </div>		 -->
								</div>
							</div>
						</div>
						<!-- End Model -->

						@if($event->event_facebook!='' || $event->evetn_twitter!='' || $event->event_instagaram!='')
						<br/>
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
								<h6 class="descripton-content-title">{{--Event On Social Media--}}@lang('words.cre_eve_page.cre_fm_esm')</h6>
								<div class="event_socialmedia">
									@if($event->event_facebook!='')
									<a href="{{ $event->event_facebook }}" target="_blank">
										<i class="fab fa-facebook"></i> Facebook
									</a>
									@endif
									@if($event->evetn_twitter!='')
									<a href="{{ $event->evetn_twitter }}" target="_blank">
										<i class="fab fa-twitter"></i> Twitter
									</a>
									@endif
									@if($event->event_instagaram!='')
									<a href="{{ $event->event_instagaram }}" target="_blank">
										<i class="fab fa-instagram"></i> Instagaram
									</a>
									@endif
								</div>
							</div>
						</div>
						@endif
					<!-- <br/>
					<div class="row">
						<div class="col-lg-12 col-sm-12 col-md-12">
							<h6 class="descripton-content-title">Event QR-Code</h6>
							<div class="display-qrcode">
								<img src="{{ asset('upload/events-qr/'.$event->event_qrcode_image) }}" alt="qu-img" />
							</div>
						</div>
					</div> -->
				</div>
			</div>

			 
		</div>

	</div>
	@endsection
	@section('pageScript')
	<script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
	<script type="text/javascript" src="{{ asset('/js/events/event-detail.js')}}"></script>

	<!-- SHARE EVENT MODEL -->
	<div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content signup-alert">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="modal-body">
					<h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>
					<div class="share" id="share-body">
						<a href="" class="social-button social-logo-detail facebook" >
							<i class="fab fa-facebook"></i>
						</a>
						<a href="" class="social-button social-logo-detail twitter">
							<i class="fab fa-twitter"></i>
						</a>
						<a href="" class="social-button social-logo-detail linkedin">
							<i class="fab fa-linkedin"></i>
						</a>
						 
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SHARE EVENT MODEL -->

 
<style>
	.modal-design .modal-content .pro-choose-file{
   		padding: 10px 10px !important;
	}	

</style>
  <!-- USER NOT LOGIN MODEL -->
  <div class="modal fade bd-example-modal-md modal-design" id="signupAlert" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
  	<div class="modal-dialog modal-md" style="max-width: 600px">
  		<div class="modal-content signup-alert" style="padding-bottom: 0">
  			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  			<div class="modal-body">
  				<div class="row">
  					<div class="col-sm-12" style="text-align:center;">
  						<h5 class="modal-title col-sm-12" style="font-size: 22px;" id="exampleModalLabel2">@lang('words.guest_popup.pop_title_2')</h5>
                        <br>
              
						<div class="getLogin_">
<div class="col-md-12 regBox" style="margin-top: 0px !important;"> 
@lang('words.guest_popup.no_account')<br> <a href="javascript:void(0)" class="openRegisterLink_">@lang('words.guest_popup.register')</a>
</div>
          
						<div class="col-md-12">
							{!! Form::open(['route'=>'signin.postAjax','method'=>'post','class'=>'contact-form','id'=>'signinAjax','style'=>'padding: 0px 0;']) !!}
							<input type="hidden" name="ref" value="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?buyticket=1'; ?>">
							<div class="row">
								<div id="errors-list" class="errors-list"></div>

								<div class="col-md-12 form-group">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=> trans('words.signin_page_content.signin_field_e')]) !!}
									@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
								</div>

								<div class="col-md-12  form-group">
									<input type="password" name="password" value="" class="form-control form-textbox" placeholder="{{ trans('words.user_create.user_cn_pwd') }}">
									@if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span> @endif
								</div>
								<div class="col-md-12">
									{!! Form::submit(trans('words.signin_page_content.signin_form_button'),['class'=>'pro-choose-file text-uppercase','style'=>'margin-top:0px']) !!}
								</div>
								<div class="col-md-12">
									<a href="javascript:void(0)" class="resetLink openResetLink_">@lang('words.signin_page_content.password_forget')</a>
								</div>

							</div>
							{!! Form::close() !!}
							<div class="form-row">
								<div class="col-md-12">
									<hr class="mt10">
									<div class="orConnectWith" style="font-size: 12px; max-width: 230px; background: #f5f5f5;">@lang('words.guest_popup.or_connect_with')</div>
								</div>
								<div class="facebook-login detail" style="width: 100%;text-align: center">
								   <a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg" style="width: 100%;"><i class="fab fa-facebook"></i> Facebook</a>
								   <a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"  style="width: 100%;"><i class="fab fa-google"></i> Google </a>
							   </div>
								
							</div>
						</div>				

				</div>
						
						<div class="getRegister_">
							<div class="col-md-12 col-sm-12 col-lg-12">
							{!! Form::open(['route'=>'signup.postAjax','method'=>'post','class'=>'contact-form','id'=>'registerAjax','style'=>'padding: 0px 0;']) !!}

							<div id="errors-list3" class="errors-list3"></div>
							<div id="success-list3" class="success-list3"></div>

							<div class="form-row">
								<div class="col-md-12 form-group">
									{!! Form::email('email','',['class'=>'form-control form-textbox','required','placeholder'=>trans('words.user_create.user_cn_email')]) !!}
									@if($errors->has('email')) <span class="error">{{ $errors->first('email') }} </span> @endif
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 form-group">
									{!! Form::text('lastname','',['class'=>'form-control form-textbox','required','placeholder'=>trans('words.user_create.user_cn_lnm')]) !!}
								</div>
								<div class="col-md-12 form-group">
									{!! Form::text('firstname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_fnm')]) !!}
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-sm-12 col-lg-12">
									@if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }} </span> @endif
									@if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }} </span> <br>@endif
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::text('mobile','',['class'=>'form-control form-textbox','placeholder'=>'Mobile','required']) !!}
									@if($errors->has('mobile')) <span class="error">{{ $errors->first('mobile') }} </span> @endif
								</div>
							</div>	
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::password('password',['class'=>'form-control form-textbox','required','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!}
									@if($errors->has('password')) <span class="error">{{ $errors->first('password') }} </span> @endif
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::password('confirm_password',['class'=>'form-control form-textbox','required','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
									@if($errors->has('confirm_password'))<span class="error">{{ $errors->first('confirm_password') }} </span> @endif
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<p class="sign-up-links"><input class="form-checkbox" type="checkbox" value="accept" name="accept" required="required"> @lang('words.guest_popup.registering_1')  <a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation/" target="_blank">@lang('words.guest_popup.registering_2')</a> @lang('words.guest_popup.registering_3')</p>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									{!! Form::submit("JE M’INSCRIS",['class'=>'pro-choose-file text-uppercase']) !!}
								</div>
							</div>
							{!! Form::close() !!}
							<div class="form-row" style="margin-top: 18px;">
								<div class="col-md-12">
									<hr class="mt10">
									<div class="orConnectWith" style="font-size: 12px; padding:0px 10px; background: #f5f5f5;">@lang('words.guest_popup.or_connect_with')</div>
								</div>
								<div class="facebook-login auth-social mb10 col-md-12">
									<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"> Facebook</a>
								</div>
								<div class="google-login auth-social col-md-12">
									<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"> Google </a>
								</div>

								<div class="col-md-12 regBox"> 
									@lang('words.guest_popup.no_account2') <a href="javascript:void(0)" class="openLoginLink_">@lang('words.left_panel.connect')</a>
								</div>
							</div>
						</div>
						</div>

						<div class="getResetPswd_">
							<div class="col-md-12 col-sm-12 col-lg-12">
								{!! Form::open(['route'=>'reset.postAjax','method'=>'post','class'=>'contact-form','id'=>'resetPswdAjax','style'=>'padding: 0px 0;']) !!}
									<div class="row">
										<div id="errors-list2" class="errors-list2"></div>
										<div id="success-list"  class="success-list"></div>

										<div class="col-md-12 col-lg-12 col-sm-12 form-group">
											{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_reset_page.reset_filed_pla')]) !!}
											@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
										</div>
										<div class="col-md-12 col-sm-12 col-lg-12">
											{!! Form::submit(trans('words.user_reset_page.reset_form_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
										</div>		
										<div class="col-md-12 regBox"> 
											@lang('words.guest_popup.remember_account') <a href="javascript:void(0)" class="openBackLoginLink_">@lang('words.left_panel.connect')</a>
										</div>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
			
 						
						 
                       <?php /*?><span class="text-align-center" style="background-color: #f5f5f5;padding: 0 15px"> Ou / Or </span>
                       <hr style="border: 1px solid #e2e2e2;"><?php */?>
                   </div>
                   <?php /*?><div class="col-sm-12">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.guest_popup.pop_title')</h5>
                    <p class="modal-text">@lang('words.guest_popup.pop_desc') <!-- {{ forcompany() }}. --></p>
                    <div class="model-btn">
                       {!! Form::open(['method'=>'post','route'=>'guest.login', 'id'=>'guestLogin']) !!}
                       <div id="result" class="form-group text-center">
                          	<input id="phone" type="tel" name="guestUserPhone" value="" placeholder="0700000000" class="tel form-control form-textbox" minlength="10" maxlength="14" required style="width: 250px;margin:0 auto" />
                          	<span id="valid-msg" class="hide">✓ Valide</span>
      						<span id="error-msg" class="hide"></span>
                      </div>
                       <div class="form-group text-center">
                          <!-- <label class="label-text">@lang('words.guest_popup.pop_name')</label> -->
                          <input type="text" name="guestuserName" value="" placeholder="@lang('words.guest_popup.pop_name')" class="form-control form-textbox" style="width: 250px;margin:0 auto" required/>
                      </div>
                      <div class="form-group text-center">
                          <!-- <label class="label-text">@lang('words.guest_popup.pop_email')</label> -->
                          <input type="text" name="guestUserEmail" value="" placeholder="@lang('words.guest_popup.pop_email')" class="form-control form-textbox" style="width: 250px;margin:0 auto" required/>
                      </div>
                      <div class="form-group payment-btn">
                          <input type="submit" class="btn btn-payment text-uppercase" name="booking" value="@lang('words.guest_popup.pop_btn')" disabled />
                      </div>
                      {!! Form::close() !!}
                  </div>
              </div><?php */?>
          </div>
      </div>
  </div>
</div>
</div>
<?php /*?><script src="{{ asset('/js/isValidNumber.js')}}"></script><?php */?>
<script src="{{ asset('/js/script.js')}}"></script>
<!-- USER NOT LOGIN MODEL -->

<!-- USER NOT LOGIN MODEL -->
<!-- TICKETS REGISTER MODEL -->
<div class="modal fade bd-example-modal-lg buyticket" tabindex="-1" id="registration" role="dialog" aria-labelledby="registration" aria-hidden="true">
 <div class="modal-dialog modal-lg">
    <div class="modal-content ticket-registion">
       <div class="modal-header" style="">
          <h5 class="modal-title" id="exampleModalLabel">{{ $event->event_name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
		
      {!! Form::open(['method'=>'post','route'=>'ticket.booking', 'id'=>'booktickets', 'files'=>'true']) !!}
		
      <div class="modal-body">
		  	
		  <div class="geoclass">
			  <div style="border-radius: 12px;width: 100%;text-overflow: ellipsis;white-space: nowrap;border: 1px solid #707070;padding: 10px;overflow: hidden;"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $startdate }} | {{ $event->event_location }}</div></div>
		  
          <input type="hidden" name="event_id" value="{{$event->event_unique_id}}" >
          <input type="hidden" name="event_uid" value="{{$event->event_create_by}}" >
		  <div class="dumping" style="overflow-x: auto; padding: 20px 0px; margin-bottom: 10px">
         @if(auth()->guard('frontuser')->check())
			  @if(is_null(auth()->guard('frontuser')->user()->cellphone))
				<input id="phone" type="tel" name="userCellphone" value="" placeholder="+2250000000000" class="tel form-control form-textbox" pattern="^+\d+" style="margin:0 auto" required/>
			  @endif
          @endif
          <?php if(!is_null($event_tickets)){ ?>
              <?php $adx=0; ?>
			  @foreach(($event_tickets->active_event_tickets($event->event_unique_id)) as $tkey => $ticket)
				 <div class="bd-callout bd-callout-info tickets-info" 
					  <?php
					  if(count($event_tickets->active_event_tickets($event->event_unique_id))==1){ echo"style='max-width:34%'"; }else 
					  if(count($event_tickets->active_event_tickets($event->event_unique_id))==2){ echo"style='max-width:45%'"; }?>>
					 <div class="row">
						<div class="col-md-12">
						   <h3 class="ticket-title" >{{$ticket->ticket_title}}</h3>
						   <input type="hidden" name="ticket_id[]" value="{{$ticket->ticket_id}}">
						   <input type="hidden" name="tid[]" value="{{$ticket->id}}" >
						   <p class="ticket-price">
							  <?php if($ticket->ticket_type == 2){ ?>
                                  <strong>@lang('words.events_detials_page.donation')</strong>
                                  <p>@lang('words.events_detials_page.calc_fees') </p>
							  <?php }else if($ticket->ticket_price_actual == 0){ ?>
							      <span>@lang('words.events_tab.menu_tab_5')</span>
							  <?php }else{ ?>
							     <span>{{number_format($ticket->ticket_price_buyer,0, "."," ")}} {{--{{number_format($ticket->ticket_price_actual,0, "."," ")}} {!! use_currency()->symbol !!} + {{ number_format($ticket->ticket_price_buyer - $ticket->ticket_price_actual, 0, "."," ")}}--}} {!! use_currency()->symbol !!} {{--Fees--}}{{--Commission = {{ number_format($ticket->ticket_price_buyer, 0, "."," ") }} {!! use_currency()->symbol !!}--}}</span>
							  <?php } ?>
							  
							  @if($event->event_remaining  == 1)
							  <span class="ticket-remaiming x-ticket">{{$ticket->ticket_remaning_qty}} @lang('words.events_detials_page.remaining')</span>
							  @endif
						  </p>
						  @if($ticket->ticket_desc_status == 1 && $ticket->ticket_description != '')
						  <div class="ticket-desc">
							  <a href="javascript:void(0)" class="btn btn-primary des-show showDesc">@lang('words.book_popup.book_desc')</a>
							  <p class="ticket-description">
								 {{$ticket->ticket_description}}
							 </p>
						 </div>
						 @endif
					 </div>
					 <div class="col-md-12">
					   <?php if($ticket->ticket_type == 2){ ?>
					   <span class="dntmain">
						  {!! use_currency()->symbol !!} <input type="text" name="ticket_type_dns[{{$tkey}}]" data-qty="1" onkeypress="return isNumberKey(event)" class="form-control form-textbox dnsprice text-right" style="width: calc(100% - 15px);display:inline-block;" placeholder="0" />
						  <input type="hidden" name="ticket_type_qty[{{$tkey}}]" data-amount="0.00" class="form-control form-textbox ticket" />
					  </span>
					  <?php }else if($ticket->ticket_remaning_qty>0){ ?>
                         
                         <div class="changek" data-id="{{$ticket->ticket_id}}">
                            <a href="#" data-way="down" title="-" class="downk">-</a>
                             <input type="text" name="ticket_type_qty[{{$tkey}}]" id="input-{{$ticket->ticket_id}}" class="selnumticket ticket" value="0" min="0" max="{{ $ticket->ticket_remaning_qty }}" data-amount="{{ $ticket->ticket_price_buyer }}" />
                            <a href="#" data-way="up" title="+" class="upk">+</a>
                         </div> 
                         
					  <?php }else{ ?>
					      <div align="center"style="padding: 18px; color: red;">@lang('words.events_detials_page.soldout')</div>
					  <?php } ?>
				  </div>
			  </div>
			  </div>
                  <?php $adx++; ?>
			  @endforeach
          
             <?php if($adx<=0){ ?><div align="center"style="padding: 30px;color: red;font-size: 29px">@lang('words.events_detials_page.soldout')</div><?php } ?>
          
          <?php if($event->event_code != ''){ ?>
          	<div class=" bd-callout bd-callout-info eventCode tickets-info">
             <div class="row">
                <div class="col-lg-9">
                   <h3 class="ticket-title">@lang('words.events_detials_page.access_code')</h3>
               </div>
               <div class="col-lg-3">
                   <input type="text" name="event_code" class="form-control form-textbox" required="" autocomplete="off">
               </div>
           </div>
        </div>
       	  <?php } ?>
     		</div>
        <!-- discount coupon area -->
    <div class="discount-coupon-area">
        <div class="row" style="width: 100%">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<h4 class="couponhead">@lang('words.events_detials_page.code_red')</h4>
            <div class="col-lg-9">
                <input type="text" name="coupon" id="coupon_input" class="form-control" placeholder="@lang('words.events_detials_page.enter_red_code')" value="{{ request()->coupon ?? '' }}">
            </div>
            <button id="applyCoupon" class="col-lg-3 btn btn-flat btn-primary" disabled type="button" style="height: 52px; line-height: normal;">@lang('words.events_detials_page.apply_coupon')</button>
        </div>
        <span id="status_text" class="text-danger" style="display: block"></span>
    </div>     
     
            <?php } ?>
</div>
<div class="modal-footer">
  <input type="hidden" name="total_ticket" id="total_qty_txt" />
  <input type="hidden" name="total_amount" id="total_amount_txt" />
  <input type="hidden" name="total_remise" id="total_remise_txt" />
  <input type="hidden" name="total_remise_type" id="total_remise_type_txt" />
  <input type="hidden" name="codecoupon" id="lecodecoupon" />
    
    
  <span class="total-qty">@lang('words.ticke_popup.ticket_qty') : <b id="total_qty">0</b></span>
  <span class="remise">Remise : <b id="remise">0</b></span>
  <span class="total-amount">@lang('words.ticke_popup.ticket_amount') : <span style="color:#d600a9"><b id="total_amount">0</b> {{ use_currency()->symbol }}</span> </span>
  <input type="submit" id="btnBookTicket" class="btn btn-flat btn-primary" value="@lang('words.ticke_popup.ticket_btn')" disabled>
</div>
{!! Form::close() !!}
</div>
</div>
</div>
<!-- Header scrolling Start -->
<style>
	.footer-wrapper{
		display: none
	}
	.page-main-contain{
		margin-bottom: 50px;
	}
</style>
<script>
var wi=$(window).width();
if (wi > "991") {	    
	$(window).scroll(function(e){  //
		
        var $el = $('.myeventimagebox');  var screen=$( window ).width();
        var isPositionFixed = ($el.css('position') == 'fixed');
        if ($(this).scrollTop() > 100 && !isPositionFixed){ 
			
			var $db = $('.detail-box-image').width();
            $el.css({'position': 'fixed', 'top': '75px', 'width':$db+'px'});
			/*if(screen>=1500){ 
				var t=59-(screen-1400)/21;
            	$el.css({'position': 'fixed', 'top': '75px', 'width':t+'%'});
			}else if(screen>1430){ 
				var t=59-(screen-1400)/18;
            	$el.css({'position': 'fixed', 'top': '75px', 'width':t+'%'});
			}else if(screen>=1430){ 
            	$el.css({'position': 'fixed', 'top': '75px', 'width':'59%'});
			}else if(screen>=1300){  
				$el.css({'position': 'fixed', 'top': '75px', 'width':'58%'});			
			}else if(screen>=1200){  
				$el.css({'position': 'fixed', 'top': '75px', 'width':'58%'});			
			}*/
        }
        if ($(this).scrollTop() < 100 && isPositionFixed){
        	$el.css({'position': 'static', 'top': '75px', 'width':'100%'}); 
        } 
	
        var $el2 = $('.fil-ariane-light');
        var isPositionFixed2 = ($el2.css('position') == 'fixed');
        if ($(this).scrollTop() > 100 && !isPositionFixed2){ 
			if(screen>=1460){
            	$el2.css({'position': 'fixed', 'top': '0px', 'left':'13.2%', 'z-index':'999999', 'width':'43%'}); 
			}else if(screen<1400 && screen>=1200){
				$el2.css({'position': 'fixed', 'top': '0px', 'left':'13.2%', 'z-index':'999999', 'width':'55%'}); 
			}else if(screen<1200){
				$el2.css({'position': 'fixed', 'top': '0px', 'left':'9.2%', 'z-index':'999999', 'width':'55%'}); 
			}
        }
        if ($(this).scrollTop() < 100 && isPositionFixed2){
        	$el2.css({'position': 'static', 'top': '0px', 'left':'13.2%', 'z-index':'999999', 'width':'100%'}); 
        } 

});  
	
}
    
    $(document).on('submit', '.discount-coupon', function (e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let data = $(this).serialize();
        $('.lds-ellipsis').show();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                console.log(data);
                $('.lds-ellipsis').hide();
                $('#cart-container').html(data['details']);
                if (data['type'] == 'fail') {
                    toastr.error(data['msg']);
                    return;
                }
                toastr.success(data['msg']);
            },
            error: function (err) {
                $('.lds-ellipsis').hide();
                toastr.error('{{ __("Coupon invalide") }}');
            }
        });
    });
    
    $(document).ready(function () {    
        $('#coupon_input').on('keyup', function() { 
            validateCoupon(this);
        });
        $('#applyCoupon').on('click', function() { 
            applyCoupon();
        });
    
		 
												
		$("body").on("click",".changek a",function(e){  
			  e.preventDefault();
			  var _this=$(this);

			  var id = _this.closest('.changek').data('id');
			  var way= _this.data("way");

			  quantity_change(way,id)
		 });

 	});
	function quantity_change(way, id){

          quantity = $('#input-'+id).val(); 
          if(way=='up'){
            quantity++;
          } else {
              quantity--;
          }
          if(quantity<1){
            quantity = 0;
          }
          if(quantity>15){
            quantity = 15;
          }
			
		  if(way=='up'){
			  var qt=$('#total_qty_txt').val(); 
			  console.log('TT Qte:'+qt)
			  if(qt>14){
				  alert("Désolé, vous ne pouvez commander que 15 tickets.")
				  return false;
			  }
		  }
		  if(quantity>=1){ $('#btnBookTicket').removeAttr('disabled') }
          $('#input-'+id).val(quantity);
		  
		changeTicket();

    }
	
	function changeTicket() {  
		var tickets_qty = 0;
		var t_qty		= 0;
		var price		= 0;
		var amount		= 0;
        var discount_amount = 0;
        var total_remise = $('#total_remise_txt').val();
        var total_remise_type = $('#total_remise_type_txt').val();        


		$('.ticket').each(function(e) {
			price		= parseFloat($(this).attr("data-amount"))
			t_qty 		= parseFloat($(this).val())

			tickets_qty	+= parseFloat($(this).val())
			amount 		+= parseFloat(t_qty * price)
		})

		if(tickets_qty != 0){
			$('#btnBookTicket').removeAttr('disabled');
            
            if(total_remise_type=='percentage'){
                discount_amount = (amount*total_remise)/100;
                amount = amount - discount_amount;
            }else{
                amount = amount - total_remise;                
            }
            
            
		}else{
			$('#btnBookTicket').attr("disabled", true)
		}
    
        
		$('#total_qty').html(tickets_qty)
		$('#total_amount').html((amount).toFixed(2))
		$('#total_qty_txt').val(tickets_qty)
		$('#total_amount_txt').val((amount).toFixed(2))
	}
	
    function validateCoupon(context) {
        let code = $(context).val();  
        let submit_btn = $('#applyCoupon');
        let status_text = $('#status_text');
        status_text.hide();

        if (code.length) {
            submit_btn.prop("disabled", true);

            $.get("{{ route('couponcheck') }}", {code: code}).then(function (data) {
                if (data>=1) {
                    let msg = "{{ __('Ce coupon est disponible') }}";
                    status_text.removeClass('text-danger').addClass('text-success').text(msg).show();
                    submit_btn.prop("disabled", false);
                } else {
                    let msg = "{{ __('Ce coupon n`est pas disponible') }}";
                    status_text.removeClass('text-success').addClass('text-danger').text(msg).show();
                    submit_btn.prop("disabled", true);
                }
            });
        }
    }
    
    function applyCoupon(){
        let code = $('#coupon_input').val();  
        let submit_btn = $('#applyCoupon');
        let remise = $('#remise');
        let status_text = $('#status_text');
        
        let amount = $('#total_amount_txt').val();
        let discount_amount = 0;
        let total_remise = $('#total_remise_txt').val();
        var total_remise_type = $('#total_remise_type_txt').val();        
        
        if (code.length) {
			
			if(amount <= 0){
				let msg = "{{ __('Veuillez choisir au moins ticket.') }}";
                status_text.removeClass('text-success').addClass('text-danger').text(msg).show();
				return false;
			}else{
				status_text.empty();
			}
			
            submit_btn.prop("disabled", true);
            status_text.prop("disabled", true);

            $.get("{{ route('coupon.cinfos') }}", {code: code}).then(function (data) {
                 data.forEach(function (product) {
 
                     $('#total_remise_txt').val(product.discount);
                     if(product.discount_type=='percentage'){
                         remise.html(product.discount+"%")
                     }else{
                         remise.html("-"+product.discount+" FCFA")                         
                     }
                     $('#total_remise_type_txt').val(product.discount_type);
                     
                     if(amount>0){  
                        if(product.discount_type=='percentage'){  
                            discount_amount = (amount*product.discount)/100;
                            amount = amount - discount_amount;
                        }else{ 
                            amount = amount - product.discount;                
                        }
                         
                        $('#total_amount_txt').val((amount).toFixed(2));
                        $('#total_amount').html((amount).toFixed(2));
  
                    } 
                     
                    $('#lecodecoupon').val(code);
                    $('#coupon_input').prop("disabled", true);   
                     
                 });
            });
        }
        
    }
    
</script>
<!-- Header scrolling Close -->

<!-- TICKETS REGISTER MODEL -->
<script type="text/javascript">
 function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
       return false;

   return true;
}

$(document).ready(function() {
    $('.buyticket').on('shown', function() {

		console.log("++++")
       
    })
});
	
	
$('#org-con-form').validate({
    rules:{
       name:'required',
       email:{
          required:true,
          email:true,
      },
      subject:'required',
      message:{
          required:true,
          minlength:5,
      },
  },
  messages:{
   name:'This name field is required',
   email:'This email field is required',
   subject:'This subject field is required',
   message:{
      required : 'This message field is required',
      minlength : 'Enter atleast 5 character.'
  },
},
highlight: function(element) {
   $(element).closest('.form-group').addClass('has-error');
},
unhighlight: function(element) {
   $(element).closest('.form-group').removeClass('has-error');
}
});
var optionsFeed = {
    complete: function(response) {
       var resT = $.parseJSON(response.responseText);
       console.debug(resT.success);
       $("#org-con-form")[0].reset();
       if (resT.success != null) {
          swal("Bon travail!",  resT.success , "success")
      }
  }
};
	
$("body").on("click","#organizer-form",function(e){
    $('#contact-org').modal('hide');
    $(this).parents("form").ajaxForm(optionsFeed);
});
	
	
	
$(".getRegister_, .getResetPswd_").css("display","none");
	
	
	
$( ".openRegisterLink_" ).click(function() {
	$( ".getLogin_" ).slideToggle( "slow");
	$(".getRegister_").slideToggle( "slow");
});
	
$(".openLoginLink_").click(function() {
  	$(".getRegister_").slideToggle( "slow");
    $(".getLogin_").slideToggle( "slow");
});	
	
$( ".openResetLink_" ).click(function() {
	$(".getLogin_").slideToggle( "slow");
    $(".getResetPswd_").slideToggle( "slow");
});		

$( ".openBackLoginLink_" ).click(function() {
  	$(".getResetPswd_").slideToggle( "slow", function() {
    $(".getLogin_").slideToggle( "slow");
  });
});		
	
	
<?php if(isset($_GET['buyticket'])){ ?>
$('#registration').modal('show');

<?php
}
 ?>
	
 
</script>
<!-- Script pour afficher le popup pour les evenements speciaux -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Vérifie si l'élément popup existe dans la page
		setTimeout(function() {
        const popup = document.getElementById('specialPopup');
        if (popup) {
            popup.style.display = 'block'; // Affiche la popup
        }
	}, 500);
    });

    function closePopup() {
        const popup = document.getElementById('specialPopup');
        if (popup) {
            popup.style.display = 'none'; // Ferme la popup
        }
    }
</script>
@if($notmatch = Session::get('notmatch'))
<script type="text/javascript">
	swal({
		title: "Booking code is invalid",
		text: "",
		type: "error",
		showCancelButton: false,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "OK",
		closeOnConfirm: false
	});
</script>
@endif

@endsection