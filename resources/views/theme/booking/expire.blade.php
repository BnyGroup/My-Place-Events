@extends($theme)
@section('meta_title',setMetaData()->bking_cancel_title.' - '.$bookingdata->order_id )
@section('meta_description',setMetaData()->bking_cancel_desc)
@section('meta_keywords',setMetaData()->bking_cancel_keyword)
@section('content')
<div class="container-fluid about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
				<h2 class="text-uppercase about-title">@lang('words.events_booking_page.eve_book_bookingExpireTitle')</h2>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="book-box-inner">
				<div class="Event_title">
					<h2>{{ $bookingdata->event_name }}</h2>
				</div>
				<div class="Cancel_msg">
					<div class="toikcek-o">@lang('words.events_booking_page.eve_book_bookingExpireTitle').
						<span>@lang('words.events_booking_page.eve_book_bookingExpireText')</span></div>
				</div>
				<div class="book-btn_exp">
					<a href="{{ route('events.details',$bookingdata->event_slug) }}" class="pro-choose-file text-uppercase">@lang('words.events_booking_page.eve_book_bookingExpireback')</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection