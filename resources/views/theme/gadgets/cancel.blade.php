@extends($theme)
@section('meta_title',setMetaData()->bking_cancel_title.' - '.$bookingdata->order_id )
@section('meta_description',setMetaData()->bking_cancel_desc)
@section('meta_keywords',setMetaData()->bking_cancel_keyword)
@section('content')



<!--Cover-->
<div class="col-md-12 cover-img" style="background-image:url('{{asset('/img/rbg.png')}}'); border-bottom: 8px solid #FEB00A; margin-bottom: 25px; margin-top: 0px; height: 295px; color: #fff; text-align: center">
	<h3 class="text-uppercase about-title" style="color: #FFFFFF; padding-bottom: 15px;">@lang('words.events_booking_page.eve_book_bookingCancelTitle')</h3>
</div>
<!--Cover-->
 

<style>
	.book-box, .book-box-inner{
		background: none !important
	}
</style>

 
<div class="container">
	<div class="row">
		<div class="col-md-10 col-sm-12 col-xs-12 col-lg-10 book-box offset-lg-1 col-lg-offset-1 offset-md-1 col-md-offset-1">
			<div class="row">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 book-box-inner">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<h2>Commande N°{{ $bookingdata->order_id }}</h2>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<p class="toikcek-o">@lang('words.events_booking_page.eve_book_bookingCancelText')</p>
						</div>
						<div class="col-md-5 col-lg-4 col-sm-12 col-xs-12 book-btn" style="text-align: center; margin: 0px auto;">
							<a href="{{ route('shop') }}" class="pro-choose-file btform1 text-uppercase">@lang('words.events_booking_page.eve_book_bookingCancelback')</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection