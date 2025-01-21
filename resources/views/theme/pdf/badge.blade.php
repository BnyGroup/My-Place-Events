<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
	<style>
		@font-face {
			font-family: 'IBM Plex Sans';
			src: url('https://myplace-events.com/public/font/Poppins-Regular.ttf');
		}
		
		@font-face {
			font-family: 'Helvetica Neue', sans-serif;
		}
		
		.ff3 {
			font-family: 'Helvetica Neue', sans-serif;
			line-height: 1.003000;
			font-style: normal;
			font-weight: normal;
			visibility: visible;
		}
		
		a {
			text-decoration: none;
		}
		
		body {
			margin: 0px;
			font-family: 'Helvetica Neue', sans-serif;
		}
	</style>
</head>

<body>
	@foreach($bookingdata as $key=>$bTicket) @php $pagebreak = $key>0?'page-brk':$key; @endphp

	<?php
	Jenssegers\ Date\ Date::setLocale( 'fr' );
	$startdate = ucwords( Jenssegers\ Date\ Date::parse( $bTicket->event_start_datetime )->format( 'l j F Y' ) );
	$enddate = ucwords( Jenssegers\ Date\ Date::parse( $bTicket->event_end_datetime )->format( 'l j F Y' ) );
	$starttime = Carbon\ Carbon::parse( $bTicket->event_start_datetime )->format( 'H:i' );
	$endtime = Carbon\ Carbon::parse( $bTicket->event_end_datetime )->format( 'H:i' );

	if ( \Session::has( 'discount' ) ) {
		$ddt = \Session::get( 'discount' )[ 0 ];
		$dtype = \Session::get( 'discount_type' )[ 0 ];
		if ( $dtype == 'percentage' ) {
			$discount_amount = ( $bTicket->TICKE_PRICE * $ddt ) / 100;
			$bTicket->TICKE_PRICE = $bTicket->TICKE_PRICE - $discount_amount;
		} else {
			$bTicket->TICKE_PRICE = $bTicket->TICKE_PRICE - $ddt;
		}

	}
$fonction="";
    $org ="";
    
	if ( !empty( $bTicket->moreinfos ) ) {

		$moreFields = $bTicket->moreinfos;
		$moreinfos = ( array )json_decode( $moreFields );
		$keys = array_keys( $moreinfos );
		if ( $keys != null ) {

			foreach ( $moreinfos as $k => $v ) {
				if ( $k == "Fonction" ) {
					$fonction = $v;
				} else if ( $k == "Entreprise" ) {
					$org = $v;
				}
				//$k=str_replace('_',' ',$k);
				//$mm.="<span style='text-transform: capitalize'>".$k.":</span> ".$v." <br> ";
			}
		}

	}

	?>
	<img style="position:absolute;top:6.71in;left:0.35in;width:1.05in;height:1.25in" src="/var/www/html/public/img/ri_1.png"/>
	<div style="position:absolute;top:1.0in;left:0in;width:3.8in;line-height:0.29in;text-align: center; ">
		<span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:IBM Plex Sans;color:#999999">Forum Afrique RSE Santé - 3ème édition</span>
	</div>
	<div style="position:absolute;top:6.54in;left:4.0in;width:3.84in;line-height:0.23in;"><span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:IBM Plex Sans;color:#000000">Comment utiliser ce pass ?</span><span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">Imprimez ce pass personnel ou gardez-le accessible dans</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">votre smartphone et présentez-le à votre arrivée.</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
	</div>
	<div style="position:absolute;top:1.0in;left:3.75in;width:3.8in;line-height:0.29in;text-align: center;"><span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:IBM Plex Sans;color:#999999">Forum Afrique RSE Santé - 3ème édition</span><span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:IBM Plex Sans;color:#999999"> </span><br/>
	</div>
	<div style="position:absolute;top:6.46in;left:1.5in;width:2.8in;line-height:0.25in;"><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#0090ff">Où et Quand</span><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#0090ff"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#000000">Forum Afrique RSE Santé - 3ème édition</span><span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">Jeudi 7 novembre 2024</span><br/>
	</div>
	<div style="position:absolute;top:8.13in;left:0.55in;width:2.91in;line-height:0.23in;"><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#0090ff">Rester informé, échanger et contribuer</span><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#0090ff"> </span><br/>
	</div>
	<div style="position:absolute;top:1.3in;left:0in;width:3.75in;line-height:0.23in;text-align: center;"><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#999999">Hôtel Sofitel Ivoire, 7 novembre 2024</span><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#999999"> </span><br/>
	</div>
	<div style="position:absolute;top:5.66in;left:0in;width:3.6in;line-height:0.19in; text-align: center"><span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#999999">Entrée</span><span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#999999"> </span><br/>
	</div>
	<div style="position:absolute;top:5.66in;left:3.7in;width:3.6in;line-height:0.19in; text-align: center; "><span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#999999">Entrée</span><span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#999999"> </span><br/>
	</div>
	<div style="position:absolute;top:10.23in;left:1.66in;width:4in;line-height:0.19in;">

		<div style="position:absolute;text-align: center;width: 284px;top: -165px;">
			<img style="position:absolute;width:1.12in;height:1.12in" src="/var/www/html/public/img/vi_2.png"/>
			<img style="position:absolute;width:1.00in;height:0.97in" src="/var/www/html/public/img/vi_3.png"/>
			<img style="position:absolute;width:1.03in;height:1.00in" src="/var/www/html/public/img/vi_4.png"/>
		</div>


		<DIV style="position:absolute; left:-0.8in; text-align: center;"><a href="https://forum.santeenentreprise.com/afrique-rse-sante-2024#FORAS2024"><span style="font-style:normal;font-weight:normal;font-size:8pt;font-family:IBM Plex Sans;color:#999999; text-decoration: none">https://forum.santeenentreprise.com/afrique-rse-sante-2024</span></a> <span style="font-style:normal;font-weight:normal;font-size:7pt;font-family:IBM Plex Sans;color:#999999"> </span><br/>
		<a href="https://forum.santeenentreprise.com/afrique-rse-sante-2024#FORAS2024"><span style="font-style:normal;font-weight:normal;font-size:8pt;font-family:IBM Plex Sans;color:#000000">#FORAS2024</span></a> <span style="font-style:normal;font-weight:normal;font-size:8pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		</DIV>
	</div>
	 
	<div style="position:absolute;top:7.00in;left:1.5in;width:2.57in;line-height:0.18in;">
		<DIV style="position:relative; left:1.35in;"><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		</DIV>
		<span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">De 08:30 à 16:40</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">Hôtel Sofitel Ivoire</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#000000">Boulevard Hassan II</span><span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">Abidjan, Côte d'Ivoire</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
	</div>
	<img style="position:absolute;top:-0.04in;left:0.00in;width:3.7in;" src="/var/www/html/public/img/ri_2.png"/>
	<img style="position:absolute;top:-0.04in;left:3.7in;width:3.7in;" src="/var/www/html/public/img/ri_3.png"/>

	<div style="position:absolute;top:1.3in;left:3.75in;width:3.8in;line-height:0.23in;text-align: center;"><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#999999">Hôtel Sofitel Ivoire, 7 novembre 2024</span><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:IBM Plex Sans;color:#999999"> </span><br/>

	</div>
	
	<div style="position:absolute;top:4.47in;left: 3.7in;width: 3.6in;line-height:0.26in; text-align: center">
		<img src="{{ getQrImage($bTicket->ot_qr_image) }}" style="width:33%; border-radius:10px">
	</div>

	<div style="position:absolute;top:3.53in;left: 3.7in;width: 3.6in;line-height:0.20in;text-align: center;"><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">N° Billet : {{ $bTicket->ot_order_id }}</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
	</div>
	<div style="position:absolute;top:2.06in;left: 15px;width: 3.6in;line-height:0.44in;text-align: center;"> <span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000">@if(is_null($bTicket->gust_id) && $bTicket->USER_FNAME!='') {{ $bTicket->USER_FNAME }} {{ $bTicket->USER_LNAME }} @else {{ $bTicket->ot_l_name }} {{ $bTicket->ot_f_name }} @endif</span> <span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000">{{$fonction}}</span> <span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000">{{$org}}</span> <span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000"> </span><br/>
	</div>
	<div style="position:absolute;top:2.06in;left: 3.7in;width: 3.6in;line-height:0.44in;text-align: center;">
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000">@if(is_null($bTicket->gust_id) && $bTicket->USER_FNAME!='') {{ $bTicket->USER_FNAME }} {{ $bTicket->USER_LNAME }} @else {{ $bTicket->ot_l_name }} {{ $bTicket->ot_f_name }} @endif</span>
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000"> </span><br/>
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000">{{$fonction}}</span>
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000"> </span><br/>

		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000">{{$org}}</span>
		<span style="font-style:normal;font-weight:normal;font-size:18pt;font-family:ff3;color:#000000"> </span><br/>
	</div>
	<div style="position:absolute;top:8.81in;left: 1.20in;width:1.96in;line-height:0.20in;text-align: center;"><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000">Site web dédié</span><span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:IBM Plex Sans;color:#000000"> </span><br/>
	</div>
	@endforeach
</body>
</html>