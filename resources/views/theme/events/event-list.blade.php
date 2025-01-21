@extends($theme)
@section('meta_title',setMetaData()->e_list_title )
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)
@section('content')
<div class="list-bg"></div>
@include("theme.events.event-search-form")
<div class="container list-widget bg-effect">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 mt-4">
			<h2 class="text-center events-title font-weight-bold">@lang('words.events_title')</h2>
			<!-- <span class="tags-related">Class<a href=""> X </a></span> -->
		</div>
		<div class="col-lg-12 mb-5">
			<div class="row">
				<div class="offset-md-2 col-md-4 col-sm-12 map-under-box">
					<ul class="cat-menu-map" id="fast-search-2">
						<li class="toogle-btn parent-cate-design">
							<a href="javascript:void();" data-toggle="collapse" data-target="#demo1">@lang('words.events_tab.menu_tab_1')<i class="fa fa-angle-down pull-right down-icon"></i></a>
						</li>
						@php
							$url = URL::current();
						@endphp
						@php 
							$iurl = explode('--',$url);
							$udata  = explode('/',$iurl[0]);								
							$acurl = isset($udata[4])?$udata[4]:'';
							$mainulr = isset($iurl[3])?$iurl[3]:'';
						@endphp		
						<li id="demo1" class="collapse {{ $acurl == 'cat'|| is_numeric($acurl)?'show':'' }}">
							<ul class="list-inline lisds-menu sub-itemns">
								<li>
									<a class="shorting" id="cat_date" href="javascript:void();" data-url="{{ $pageActive }}" data-id="cat" data-type="0" > <i class="fa fa-hand-o-right"></i>  {{--All Category--}}Toutes les catégories</a>
								</li>
								@foreach ($categories as $key => $parendCat)

									@php $childIds = array() @endphp
									@foreach ($parendCat->children as $child)
										@php array_push($childIds, $child['id']) @endphp
									@endforeach
									<li data-toggle="collapse" data-target="#{{ $key }}-demo" id="cat_menu" class="shorting" data-url="{{ $pageActive }}" data-id="{!! $parendCat['id'] !!}" data-type="0" ><i class="fa fa-hand-o-right"></i> {{ $parendCat->category_name }}</li>
									<li id="{{ $key }}-demo" class="collapse {{ in_array($acurl, $childIds) ||  $acurl == $parendCat['id']?'show':'' }}">
										<ul class="sub-itemns-s list-inline">
											@foreach ($parendCat->children as $childkey => $value)
												<li>
													 <a class="shorting" id="sub_cat" href="javascript:void();" data-url="{{ $pageActive }}" data-id="{!! $value->id !!}" data-type="0" > {!! $value->category_name !!} </a>
												</li>											
											@endforeach
										</ul>
									</li>
								@endforeach
							</ul>
						</li>
						<!-- <li class="toogle-btn">
							<a href="javascript:void();" data-toggle="collapse" data-target="#demo3">@lang('words.events_tab.menu_tab_3')<i class="fa fa-angle-down pull-right down-icon"></i></a>
						</li>
							<div id="demo3" class="collapse">
								<ul class="list-inline lisds-menu sub-itemns">
									<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="all" data-type="2" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.menu_tab_4')</a></li>
									<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="free" data-type="2" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.menu_tab_5')</a></li>
									<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="paid" data-type="2" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.menu_tab_6')</a></li>
								</ul>
							</div> -->
					</ul>
				</div>
				<div class="col-md-4 col-sm-12 map-under-box">
					<ul class="cat-menu-map">
						<li class="toogle-btn parent-cate-design">
							<a href="javascript:void();" data-toggle="collapse" data-target="#demo2">@lang('words.events_tab.menu_tab_2')<i class="fa fa-angle-down pull-right down-icon"></i></a>
						</li>
						@php 
							$durl = explode('-',$url);
							$dcurl = isset($durl[2])?$durl[2]:'';
						@endphp
						<li id="demo2" class="collapse {{ ($dcurl=='today' || $dcurl=='tomorrow' || $dcurl=='this_week' || $dcurl=='this_month' || $dcurl=='cdate')?'show':''  }}">
							<ul class="list-inline lisds-menu sub-itemns">
								<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="date" data-type="1" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.events_tab.all_dates')</a></li>
								<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="today" data-type="1" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.events_tab.today')</a></li>
								<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="tomorrow" data-type="1" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.events_tab.tomorrow')</a></li>
								<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="this_week" data-type="1" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.events_tab.this_week')</a></li>
								<li><a href="javascript:void();" data-url="{{ $pageActive }}" data-id="this_month" data-type="1" class="date-data shorting"> <i class="fa fa-hand-o-right"></i> @lang('words.events_tab.this_month')</a></li>
								<li><a href="javascript:void();"></i> @lang('words.events_tab.custom_date')</a></li>
								<li id="cdate" class="collapse cdate" style="border:1px solid #eeeeee; padding:5px; text-align: center;">
									<?php
										$startdate = (isset($_GET['ds']) && isValidTimeStamp($_GET['ds']) )?
											Carbon\Carbon::createFromTimestamp($_GET['ds'])->format('m-d-Y'):'';
										$enddate = (isset($_GET['de']) && isValidTimeStamp($_GET['de']) )?
											Carbon\Carbon::createFromTimestamp($_GET['de'])->format('m-d-Y'):'';
									?>
									<input type="text" name="start_date" id="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1-events" data-target=".datetimepicker1-events" data-toggle="datetimepicker" placeholder="@lang('words.events_tab.start_date_p')" style="margin-bottom:5px;" data-val="{{ $startdate }}" />
									<input type="text" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2-events" data-target=".datetimepicker2-events" data-toggle="datetimepicker" placeholder="@lang('words.events_tab.end_date_p')" style="margin-bottom:5px;" data-val="{{ $enddate }}" />
									<a class="btn btn-primary shorting" data-url="{{ $pageActive }}" data-id="cdate" data-type="1" style="margin-bottom:5px;color: #fff;">@lang('words.events_tab.update_date')</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-md-5 mt-sm-4 mt-4">
		

		@if(!empty($events))
			@foreach($events as $event)
			    <div class="col-lg-4 col-md-6 col-sm-12 hover">
			      	<div class="box" style="position: relative;">              	
				        <a href="{{ route('events.details',$event->event_slug) }}"><img src="{{ getImage($event->event_image, 'thumb') }}" alt="{{ $event->event_name }}" /></a>
				        <div class="box-content card__padding">
							<h4 class="card-title"><a href="{{ route('events.details',$event->event_slug) }}">{{ $event->event_name }}</a>
							</h4>
							<div class="badge category" style="cursor: default">
							  <span class="">
								  {{ $event->this_event_category }}
							  </span>
							</div>
							<div class="badge prix f-right">
								<a href="{{ route('events.details',$event->event_slug) }}" class=""><span class="">
                    					@if($event->event_min_price == 0)
											FREE
										@else
											{!! use_currency()->symbol !!} {!! number_format($event->event_min_price, 2) !!}
										@endif
										@if($event->event_min_price != $event->event_max_price)
											- {!! use_currency()->symbol !!} {!! number_format($event->event_max_price, 2) !!}
										@endif
                 			 </span></a>
							</div>
							@php
								$startdate 	= Carbon\Carbon::parse($event->event_start_datetime)->format('D j M Y');
                                $enddate 	= Carbon\Carbon::parse($event->event_end_datetime)->format('D j M Y');
                                $starttime	= Carbon\Carbon::parse($event->event_start_datetime)->format('h:i A');
                                $endtime	= Carbon\Carbon::parse($event->event_end_datetime)->format('h:i A');
							@endphp
							<div class="card__action">
								<span class="date-times bold third-color">
    								<i class="far fa-clock secondary-color"></i>
										@if($startdate == $enddate)
											{{ $startdate }} from {{ $starttime }} to {{ $endtime }}
										@else
											{{ $startdate }} at {{ $starttime }} -  {{ $enddate }} at {{ $endtime }}
										@endif
    								<span class="bold"></span>
								</span>
								<div class="card__location">
									<div class="card__location-content">
										<i class="fas fa-map-marker-alt primary-color"></i>
										<a href="" rel="tag" class="third-color bold"> {{ $event->event_location }}</a>
									</div>
								</div>
							</div>
				          	<div class="box-icon pull-right like-listing"  id="userlike-{{$event->event_unique_id}}">
								@if(auth()->guard('frontuser')->check())
									@php $userid = auth()->guard('frontuser')->user()->id  @endphp
								@else
									@php $userid = ''  @endphp
								@endif
								
								@if(is_null(getbookmark($event->event_unique_id, $userid)))
									<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.save_tooltip')" data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}" data-event="{{ $event->event_unique_id }}" data-mark="0" >
										<i class="far fa-heart"></i>
									</a>							
								@else
									<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.save_tooltip')" data-placement="right" id="save-event" class="save-event addedbm" data-user="{{$userid}}" data-event="{{ $event->event_unique_id }}" data-mark="0" >
										<i class="far fa-heart"></i>
									</a>	
								@endif
								
								<!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
							</div>
							<div class="box-icon pull-right share-listing">
								<a href="javascript:void()" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.share_tooltip')" data-placement="right" class="event-share" data-url="{{route('events.details',$event->event_slug)}}" data-name="{{ $event->event_name }}" data-loca="{{ $event->event_location }}">
									<i class="fas fa-share"></i>
								</a>
							</div>
				          	<div style="clear:both;"></div>
				        </div>
			      	</div>
			    </div>
			@endforeach
	    @endif
	</div>
	<div class="row">
		<div class="col-md-12 col-xs-12 col-lg-8 col-sm-12 text-center">
				{!! $events->render() !!}
		</div>
	</div>
	
</div>
<!--call to action creation �v�nements-->
<section class="secondary-bg  newsletter-bloc text-center">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="mb5 inline-block p0-xs">Vous ne savez pas par o&uacute; commencer ? </h3>
				<br>
				<a class="btn btn-filled mb0" href="{{ route('events.create') }}"> <i class="ti-plus">&nbsp;</i> Cr&eacute;er un &eacute;v&egrave;nement</a>

			</div>
		</div>

	</div>

</section>
<!--call to action creation �v�nements-->
@endsection



@section('pageScript')
<script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
<!-- USER NOT LOGIN MODEL -->
<div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
    <div class="modal-dialog modal-md">    
        <div class="modal-content signup-alert">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>
        <p class="modal-text">@lang('words.save_eve_content')</p>
        <div class="model-btn">
          <a href="{{ route('user.signup') }}" class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>
          <p class="modal-text-small">
            @lang('words.save_eve_login_txt') <a href="{{ route('user.login') }}">@lang('words.save_eve_login_btn')</a>
          </p>
        </div>
      </div>      
    </div>    
    </div>
</div>
<!-- USER NOT LOGIN MODEL -->
<!-- SHARE EVENT MODEL -->
<div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent" aria-hidden="true">
    <div class="modal-dialog modal-md">    
        <div class="modal-content signup-alert">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>
        <div class="share" id="share-body">
          <a href="" class="social-button social-logo-detail facebook" >
            <i class="fa fa-facebook"></i>
          </a>
          <a href="" class="social-button social-logo-detail twitter">
            <i class="fa fa-twitter"></i>
          </a>
          <a href="" class="social-button social-logo-detail linkedin">
            <i class="fa fa-linkedin"></i>
          </a>
          <a href="" class="social-button social-logo-detail google">
            <i class="fa fa-google"></i>
          </a>  
        </div>
      </div>      
    </div>    
    </div>
</div>
<!-- SHARE EVENT MODEL -->
@endsection