@extends($theme)

@section('meta_title',setMetaData()->bking_success_title.' - '.$bookingdata->order_id )
@section('meta_description',setMetaData()->bking_success_desc)
@section('meta_keywords',setMetaData()->bking_success_keyword)





@section('content')
<div class="container-fluid about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
				<h2 class="text-uppercase about-title">Succès</h2>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row pb-5">
		<div class="col-md-10 col-sm-12 col-xs-12 col-lg-10 book-box offset-lg-1 col-lg-offset-1 offset-md-1 col-md-offset-1">
			<div class="row">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 book-box-inner">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<h2>@lang('words.events_booking_page.eve_book_bookingGoing') <span style="color:#f16334">{{ $bookingdata->event_name }} </span></h2>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="cale-o">
								<i class="fa fa-calendar-check-o"></i>
								<span>{{ \Carbon\Carbon::now()->format('l - F j, Y') }}</span>
							</p>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="toikcek-o">@lang('words.events_booking_page.eve_book_bookingRegis')</p>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="book-list"><i class="fa fa-check"></i><a href="#" target="_blank">Commande #{{ $bookingdata->order_id }} </a>{{ $bookingdata->order_tickets }} tickets</p>
							
<?php
$ax=1;
//var_dump($orderData_);
foreach($orderData_ as $orderData){  
	$path = URL::to('/').'/public/upload/ticket-pdf/';
	
	$ot_ticket_id = unserialize($orderData->order_t_id)[0]; 
	if($orderData->manual_attend_vendor == 0){
		$orderid=$orderData->orderid;
		$pdf_save_path = $path . $bookingdata->order_id . '-' . $orderData->event_id .'-'.$orderid.'.pdf';
		?>
<a href="{{$pdf_save_path}}" target="_blank">Ticket #{{$ax}} : {{ $orderid }}</a><br>						
<?php							
	$ax++;
	}else{
		$pdf_save_path = $path . $bookingdata->order_id . '-' . $orderData->event_id.'.pdf';
		?>
<a href="{{$pdf_save_path}}" target="_blank">Ticket #{{$ax}}</a><br>						
<?php							
	$ax++;
	}
}
?>							
							
							<p class="book-list"><i class="fa fa-check"></i>@lang('words.events_booking_page.eve_book_bookingSend')<b>
								@if(auth()->guard('frontuser')->check())
								{{ $bookingdata->user_email }}
								@else
								{{ $bookingdata->ot_email }}
								@endif
							</b>
						</p>
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" align="center">
						@if(auth()->guard('frontuser')->check())
						<a href="{{ route('order.single',$bookingdata->order_id) }}" target="_blank" class="pro-choose-file text-uppercase">@lang('words.events_booking_page.eve_book_bookingSussBack')</a>
						@else
						
<?php
	$x=1;
	foreach($orderData_ as $orderData){  
			$path = '/upload/ticket-pdf/';
			$ot_ticket_id = unserialize($orderData->order_t_id)[0]; 
			$orderid=$orderData->orderid;
			$pdf_save_path = $path . $bookingdata->order_id . '-' . $orderData->event_id .'-'.$orderid.'.pdf';
 		 	 
			$bookingdatax = \App\orderTickets::orderTicketsOT($orderid);
              foreach($bookingdatax as $bookingdataxx){ 
					if(!empty($bookingdataxx)){ 
?>
			<a class="pro-choose-file text-uppercase" href="{{ asset($pdf_save_path) }}"  target="_blank">@lang('words.events_booking_page.eve_book_bookingSucDown') - {{ $x }}</a>			
<?php
					}
			  }
		$x++;
	}
?>						
						
						@endif
					</div>
					@if($lastDepositBonus > 0)
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="toikcek-o">@lang('words.events_booking_page.eve_book_reward1') {{$lastDepositBonus}} @if($lastDepositBonus > 1) @lang('words.events_booking_page.eve_book_reward3') @else @lang('words.events_booking_page.eve_book_reward2')@endif </p>
						</div>

						<div class="col-md-5 col-lg-4 col-sm-12 col-xs-12 book-btn">
							@if(auth()->guard('frontuser')->check())
								<a href="{{ route('users.pro') }}/bonus" target="_blank" class="pro-choose-file text-uppercase">@lang('words.events_booking_page.eve_book_reward4')</a>
							@endif
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<style type="text/css">

	@media (max-width: 425px) {
    .pro-choose-file {
        width: 100%; /* Faire en sorte que le bouton occupe 100% de la largeur disponible */
        margin-top: 10px; /* Ajuster la marge pour un espacement plus compact */
    }
}

</style>

@endsection