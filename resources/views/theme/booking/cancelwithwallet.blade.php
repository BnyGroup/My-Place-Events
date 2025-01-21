@extends($theme)
@section('meta_title',setMetaData()->bking_cancel_title.' - '.$bookingdata->order_id )
@section('meta_description',setMetaData()->bking_cancel_desc)
@section('meta_keywords',setMetaData()->bking_cancel_keyword)
@section('content')
<div class="container-fluid about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
				<h2 class="text-uppercase about-title">@lang('words.events_booking_page.eve_book_bookingCancelTitle')</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-10 col-sm-12 col-xs-12 col-lg-10 book-box offset-lg-1 col-lg-offset-1 offset-md-1 col-md-offset-1">
			<div class="row">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 book-box-inner">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<h2>{{ $bookingdata->event_name }}</h2>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="toikcek-o">@lang('words.events_booking_page.eve_book_bookingCancelTextWithWallet')</p>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="book-list"><i class="fa fa-check"></i><a href="">Commande #{{$bookingdata->order_id}} </a>{{ $bookingdata->order_tickets }} ticket(s)</p>
						</div>
						<div class="col-md-5 col-lg-4 col-sm-12 col-xs-12 book-btn">
							<a href="{{ route('events.details',$bookingdata->event_slug) }}" class="pro-choose-file text-uppercase">@lang('words.events_booking_page.eve_book_bookingCancelback')</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection