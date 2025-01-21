@extends($theme)
@section('meta_title',setMetaData()->bookmark_title.' - '.fusername() )
@section('meta_description',setMetaData()->bookmark_desc)
@section('meta_keywords',setMetaData()->bookmark_keyword)
@section('content')
@php
	Jenssegers\Date\Date::setLocale('fr');
@endphp
<div class="container page-main-contain">
	<div class="col-md-12 user-tickets" style="border-top: 1px solid #dfdfdf;">
		<div class="row">
				@include('layouts.sidebar')
		<div class="col-lg-10 col-12">
			<h2 class="text-heading">{{ fusername() }}</h2>
			<p class="order-details text-center">{{ auth()->guard('frontuser')->user()->email }}</p>
			<div class="row">
				<div class="col-xl">
					<div class="user-tab-contain">
						<div class="row tab-header">
						 	<ul class="nav nav-tabs col-lg-6" >
								<li class="col-4 no-gutters">
									@php 
										$url = URL::current();
										$urls = explode('/',$url);
										$fixurl = isset($urls[5]) ? $urls[5] : '';
									@endphp
									<a data-toggle="tab" href="#item1" class="{{ $fixurl == 'upcoming'?'active show':'' }}">
										<span class="label">{{ $upcount }}</span>
										@lang('words.user_tickts.upcom_eve')
									</a>
								</li>
								<li class="col-4 no-gutters">
									<a  data-toggle="tab" href="#item2" class="{{ $fixurl == 'saved'?'active show':'' }}">
										<span class="label">{{ count($savedcount) }}</span>
										@lang('words.user_tickts.upcom_sav')
									</a>
								</li>
								<li class="col-4 no-gutters">
									<a data-toggle="tab" href="#item3" class="{{ $fixurl == 'past'?'active show':'' }}">
										<span class="label">{{ $pasteve }}</span>
										@lang('words.user_tickts.upcom_pas')
									</a>
								</li>
							</ul>
						</div>
								
						<div class="tab-content col-lg-8">
							  	<div id="item1" class="tab-pane fade {{ $fixurl == 'upcoming'?'in active':'' }}">
							@if(!empty($bookdata) && count($bookdata) > 0)
								@foreach($bookdata as $key => $eve)
								<a href="{{ route('order.single',$eve->order_id)}}">
									<div class="rev-box rev-box-border row">											
										<div class="col-lg-3 col-sm-12 col-md-4 box-imager-wrapper">
											<img src="{{ getImage($eve->event_image) }}" class="box-image-rev">
										</div>
										<div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
											<p class="text-uppercase box-rev-box-title">{{ /*Carbon\Carbon::parse($eve->event_start_datetime)->format('M j, Y h:i A') */ ucwords(Jenssegers\Date\Date::parse($eve->event_start_datetime)->format('l j F Y H:i'))}}</p>
											<h5 class="text-capitalize box-conetent-title">{{ $eve->event_name }}</h5>
											<p class="text-capitalize box-footer-title">@lang('words.eve_order.eve_book_tbl_1'){{ $eve->order_id }} de {{ $eve->order_tickets }} Ticket(s) le {{ /*date_format($eve->updated_at,'F d, Y')*/ ucwords(Jenssegers\Date\Date::parse($eve->updated_at)->format('l j F Y H:i')) }}</p>
										</div>
									</div>
								</a>
								@endforeach
								{!! $bookdata->links() !!}
							@else
							  		<div class="no-event-found">
						    			<img src="{{ asset('/img/no-event.png') }}" align="No-Events" />
						    			<h2>@lang('words.events_upcom')</h2>
						    		</div>
						    @endif
								</div>

							  	<div id="item2" class="tab-pane fade {{ $fixurl == 'saved'?'in active':'' }}">
							  	@if(!empty($data) && count($data) > 0)
							  		@foreach($data as $key => $val)
							  	<a href="{{ route('events.details',$val->event_slug)}}">
							  		<div class="rev-box rev-box-border row">											
										<div class="col-lg-3 col-sm-12 col-md-4 box-imager-wrapper">
											<img src="{{ getImage($val->event_image) }}" class="box-image-rev">
										</div>
										<div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
											<p class="text-uppercase box-rev-box-title">{{ /*Carbon\Carbon::parse($val->event_start_datetime)->format('D, M j, Y h:i A')*/ ucwords(Jenssegers\Date\Date::parse($val->event_start_datetime)->format('l j F Y H:i')) }}</p>
											<h5 class="text-capitalize box-conetent-title">{{ $val->event_name }}</h5>
											<p class="text-capitalize box-footer-title">{{ $val->event_location }}</p>
										</div>
									</div>
								</a>
									@endforeach
						    		{!! $data->links() !!}
								@else
							  		<div class="no-event-found">
						    			<img src="{{ asset('/img/no-event.png') }}" align="No-Events" />
						    			<h2>@lang('words.events_saved')</h2>
						    		</div>
						    	@endif
							  	</div>

							  	<div id="item3" class="tab-pane fade {{ $fixurl == 'past'?'in active':'' }} ">
							  	@if(!empty($past) && count($past) > 0)
							  		@foreach($past as $key => $val)
							  		<a href="{{ route('order.single',$val->order_id)}}">
							  			<div class="rev-box rev-box-border row">											
											<div class="col-lg-3 col-sm-12 col-md-4 box-imager-wrapper">
												<img src="{{ getImage($val->event_image) }}" class="box-image-rev">
											</div>
											<div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
												<p class="text-uppercase box-rev-box-title">{{ /*Carbon\Carbon::parse($val->event_start_datetime)->format('M j, Y h:i A')*/ucwords(Jenssegers\Date\Date::parse($val->event_start_datetime)->format('l j F Y H:i')) }}</p>
												<h5 class="text-capitalize box-conetent-title">{{ $val->event_name }}</h5>
												<p class="text-capitalize box-footer-title">Commande #{{ $val->order_id }} de {{ $val->order_tickets }} Ticket(s) le {{ /*date_format($val->updated_at,/*'F d, Y')*/ucwords(Jenssegers\Date\Date::parse($val->updated_at)->format('l j F Y H:i')) }}</p>
											</div>
										</div>
									</a>
							  		@endforeach
						    		{!! $past->links() !!}
					    		@else
						  		<div class="no-event-found">
						    			<img src="{{ asset('/img/no-event.png') }}" align="No-Events" />
						    			<h2>@lang('words.events_past')</h2>
						    		</div>
						    	@endif
							  	</div>
						</div> 
					</div>
				</div>
			</div>
		</div>
</div>
	</div>
	</div>
@endsection