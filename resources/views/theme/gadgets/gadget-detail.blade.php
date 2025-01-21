@extends($theme)

@section('meta_title',setMetaData()->e_single_title.' - '.$gadget->item_name )
@section('meta_description',setMetaData()->e_single_desc)
@section('meta_keywords',setMetaData()->e_single_keyword)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/special-event.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/intlTelInput.css')}}" />
@endsection
@section('body_class', 'c-'.$gadget->id)

@section('content')
<style type="text/css">
.disabled-btn{
	background-color:#c2c2c2;
}
</style>

<section class="blur" style="background:url('{!! getImage($gadget->item1_image) !!}');width: 100%;height: 480px;">
</section>
<section class="page-title page-title- fil-ariane-light" style="background: #fcfcfc;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="default-color " style="margin-top: 24px;">{{ $gadget->item_name }}</h2>
			</div>

			<div class="breadcrumb breadcrumb-2 text-center">
				<p id="breadcrumbs"><span><span><a href="{{ url('/') }}{{--https://myplace-event.com/--}}">@lang('words.nav_bar.nav_bar_menu_1')</a> / <span><a href="{{--https://myplace-event.com/events/--}}{{ url('shop') }}">@lang('words.nav_bar.nav_bar_menu_8')</a> / <strong class="breadcrumb_last primary-color" aria-current="page">{{ $gadget->item_name }}</strong></span></span></span></p>
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
@elseif($danger = Session::get('danger'))
	<div class="alert alert-danger" style="text-align: center">
		{{ $danger }}
	</div>
@endif
<div class="page-main-contain" id="single-event">
	{{--<div class="header-background">
		<div class="image">
			<img src="{!! getImage($gadget->item_image) !!}">
		</div>
	</div>--}}
	<div class="container">
		<div class="row detail-box-wrapper">
			<div class="col-lg-8 col-sm-12 detail-box-image">
				<img src="{!! getImage($gadget->item1_image, 'resize') !!}" style="width: 100%;height: auto" class="box-image-rev">
				<div class="col-lg-12 cover-wrapper-child">
					<div class="row">
							<!-- <div class="col-lg-12 col-sm-12 col-md-12 descripton-content">
                                <h6>Registrations are closed</h6>
                                <p>Thank you for the RSVP. Take a note that you can attend the event only after getting the registration confirmation email from us.</p>
                            </div> -->
                            <div class="col-md-12 col-lg-12 col-sm-12 descripton-content" style="text-align: justify;">
                            	{{--<h6>@lang('words.events_detials_page.eve_content_desc')</h6>--}}
                            	{!! $gadget->item_description !!}
                            </div>


							<!-- <div class="col-lg-12 col-md-12 col-xs-12 descripton-content">
                                <h6>TAGS</h6>
                                <a href="" class="link-tags">Things To Do in Rajkot</a>
                                <a href="" class="link-tags">Seminar</a>
                                <a href="" class="link-tags">Science & Tech</a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 c-992-p-0">
                	<div class="col-md-12 detail-box-content c-992-shaddow-0">
                		<div class="col-md-12">
                			<h2 class=" mb8 section-title text-center third-color">@lang('words.cre_eve_page.cre_gad_detils')</h2>

                			<div class="col-md-12">
                				<div class="title-style fiche-events">
                					<div class=icon-bg><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                					<hr align="center">
                				</div>
                			</div>
                		</div>
                		{{--<div class="col-lg-12 col-md-12 col-sm-12 k-date">--}}
                			{{--<span style="text-transform: uppercase;">{!! Carbon\Carbon::parse($gadget->item_start_datetime)->format('F') !!}</span>--}}
                			{{--<p>{!! Carbon\Carbon::parse($gadget->item_start_datetime)modal-body->format('d') !!}</p>--}}
                		{{--</div>--}}
                		<div class="col-lg-12 col-md-12 col-sm-12">
                		</div>
                		<div class="col-lg-12 col-sm-12 col-md-12 date-time-set">

                			{{--<h6 class="descripton-content-title">@lang('words.events_detials_page.eve_content_date')</h6>--}}
                			@php
                			/*Carbon\Carbon::setLocale('fr');
                			$startdate 	= Carbon\Carbon::parse($gadget->item_start_datetime)->format('D j M  Y');
                			$enddate 	= Carbon\Carbon::parse($gadget->item_end_datetime)->format('D j M Y');
                			$starttime	= Carbon\Carbon::parse($gadget->item_start_datetime)->format('H:i');
                			$endtime	= Carbon\Carbon::parse($gadget->item_end_datetime)->format('H:i');*/

                			Jenssegers\Date\Date::setLocale('fr');
                			$startdate 	= ucwords(Jenssegers\Date\Date::parse($gadget->item_start_datetime)->format('l j M Y'));
                			$enddate 	= ucwords(Jenssegers\Date\Date::parse($gadget->item_end_datetime)->format('l j M Y'));
                			$starttime	= Carbon\Carbon::parse($gadget->item_start_datetime)->format('H:i');
                			$endtime	= Carbon\Carbon::parse($gadget->item_end_datetime)->format('H:i');
                			@endphp
                			@if($startdate == $enddate)
                			<p><strong class="primary-color"><i class='far fa-calendar-alt primary-color'></i> @lang('words.cre_eve_page.cre_fm_date'): </strong> <strong class="third-color"> {{ $startdate }}</strong></p>
                			<p><strong class="primary-color"><i class='far fa-clock primary-color'></i> @lang('words.cre_eve_page.cre_fm_stime'):</strong>  <strong class="third-color">{{ $starttime }} - {{ $endtime }}</strong></p>
                			@else
                			<p><strong class="primary-color"><i class='far fa-calendar-alt primary-color'></i> @lang('words.cre_eve_page.cre_fm_sdate'): </strong> <strong class="third-color"> {{ $startdate }}</strong></p>
                			<p><strong class="primary-color"><i class='far fa-calendar-alt primary-color'></i> @lang('words.cre_eve_page.cre_fm_edate'): </strong> <strong class="third-color"> {{ $enddate }}</strong></p>
                			<p><strong class="primary-color"><i class='far fa-clock primary-color'></i> @lang('words.cre_eve_page.cre_fm_stime'): </strong> <strong class="third-color">{{ $starttime }} - {{ $endtime }}</strong></p>
                			@endif
                			<!-- <a href="">Add to calender</a> -->
                			<p><strong class="primary-color"><i class='fas fa-map-marker-alt primary-color'></i> @lang('words.cre_eve_page.cre_fm_loca'): </strong> <strong class="third-color"> {{ $gadget->item_location }} </strong></p>
                			<p><strong class="primary-color"><i class='fas fa-map-pin primary-color'></i> @lang('words.cre_eve_page.cre_fm_ctry'): </strong> <strong class="third-color"> {{ $gadget->item_country }} </strong></p>
                			<p>
                				<i class='fas fa-tag primary-color'></i>
                				<strong class="primary-color"> @lang('words.cre_eve_page.cre_fm_cat'):  </strong>
                				<span class="badge category" style="cursor: default">
                					<span class="">
                						{{-- $gadget->this_item_category --}}
										{{App\Event::getCategoryById($gadget->item_category)}}
                					</span>
                				</span>
                			</p>
                			<p><strong class="primary-color"><i class='far fa-user primary-color'></i> @lang('words.cre_eve_page.cre_fm_org'): </strong> <strong class="third-color"> {{ $gadget->org_name }} </strong></p>
                		</div>

						{{--PRIX--}}
                		{{--<div class="col-md-12 c-992-p-0">
                			<p align="center" class="single-price defaultButton">
                				@if($gadget->event_min_price == 0)
                				@lang('words.pdf.text_11')
                				@else
                				{!! number_format($gadget->event_min_price,0, "."," ") !!} {!! use_currency()->symbol !!}
                				@endif
                				@if($gadget->event_min_price != $gadget->event_max_price)
                				-  {!! number_format($gadget->event_max_price,0, "."," ")!!} {!! use_currency()->symbol !!}
                				@endif
                			</p>
                		</div>--}}


                		<div class="col-sm-12">
                			<div class="row">
                				<div class="col-sm-12 social-icon-box">
                					<a href="javascript:void()" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.share_tooltip')" data-placement="right" class="event-share" data-url="{{route('shop_item.details',$gadget->item_slug)}}" data-name="{{ $gadget->item_name }}" data-loca="{{ $gadget->item_location }}">
                						<i class="fa fa-share"></i>
                					</a>
                					{{--
                						@if(auth()->guard('frontuser')->check())
                						@php $userid = auth()->guard('frontuser')->user()->id  @endphp
                						@else
                						@php $userid = ''  @endphp
                						@endif
                						--}}

                						@if(auth()->guard('frontuser')->check())
                						@php $userid = auth()->guard('frontuser')->user()->id  @endphp
                						@php $guestData = false @endphp
                						@else
                						@php $userid = ''  @endphp
                						@if(\Session::get('guestUser')['GuestEmail'] != '')
                						@php $guestData = true @endphp
                						@else
                						@php $guestData = false @endphp
                						@endif
                						@endif


                						<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.save_tooltip')" data-placement="right" class="save-event" data-user="{{$userid}}" data-event="{{ $gadget->item_unique_id }}" data-mark="0" >
                							@if(is_null($bookmark))
                							<i class="far fa-heart"></i>
                							@else
                							<i class="fas fa-heart"></i>
                							@endif
                						</a>
                					</div>
                					<div class="col-sm-12 text-center">
										<form action="{{route('shop_cart.store')}}" method="POST">
											{{ csrf_field() }}
											<input type="hidden" name="gadget_id" value="{{$gadget->id}}">
											<div class="row">
												<div style="padding:10px 0 10px 0" class="col-md-12 col-sm-12">
													<select class="form-control form-textbox k-state" name="event_ticket" id="event_ticket" required>
														@foreach(($event_tickets->active_event_tickets($gadget->item_unique_id)) as $event_ticket)
															<option value="{{$event_ticket->ticket_price_buyer}}">{{ $event_ticket->ticket_price_buyer }} </option>
														@endforeach
													</select>
													@if($errors->has('event_ticket')) <span class="error">{{ $errors->first('event_ticket') }}</span> @endif
                        						</div>
											</div>
											
											<div class="row">
												<div class="col-md-6 col-sm-12" style="padding:0px 5px 10px 0" >
													@if(json_decode($gadget->item_color))
														<select class="form-control form-textbox k-state" name="color" id="color">
															@foreach(json_decode($gadget->item_color) as $color)
																<option value="{{$color}}" selected="selected">{{ $color }} </option>
															@endforeach
														</select>
														@if($errors->has('color')) <span class="error">{{ $errors->first('color') }}</span> @endif
													@else
														<select class="form-control form-textbox k-state" name="color" id="color" disabled>
															<option ></option>
														</select>
													@endif
												</div>

												<div  class="col-md-6 col-sm-12" style="padding:0px 0 10px 0" >
													@if(json_decode($gadget->item_size))
														<select class="form-control form-textbox k-state" name="size" id="size">
															@foreach(json_decode($gadget->item_size) as $size)
																<option value="{{$size}}" selected="selected">{{ $size }} </option>
															@endforeach
														</select>
														@if($errors->has('size')) <span class="error">{{ $errors->first('size') }}</span> @endif
													@else
														<select class="form-control form-textbox k-state" name="size" id="size" disabled>
															<option ></option>
														</select>
													@endif
												</div>
											</div>
											
											<div class="row">
												<button href="#" type="submit" class="btn no-rad btn-block btn-lg" style="color:#fff;width:100%">@lang('words.cre_gad_page.add_to_cart')</button>
											</div>
											
										</form>

                						{{--@if($gadget->item_end_datetime < \Carbon\Carbon::now())
                						<button style="cursor: pointer;" class="register-btn hide-register text-uppercase {{ $gadget->item_start_datetime < \Carbon\Carbon::now() ?'disabled-btn':''}}" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" {{ $gadget->item_start_datetime < \Carbon\Carbon::now() ?'disabled':''}}>@lang('words.events_detials_page.eve_reg_button')</button>
                						@else
                						<button style="cursor: pointer;" class="register-btn hide-register text-uppercase id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}">@lang('words.events_detials_page.eve_reg_button') </button>
                						<br />
                						<a href="https://wa.me/2250747974505/?text=*@lang('words.events_box_tooltip.Whatsapp_mess1')* _{{route('shop_item.details',$gadget->item_slug)}}_  *@lang('words.events_box_tooltip.Whatsapp_mess2')*." style="cursor: pointer" class="register-btn text-uppercase WhatsBook" id="whatsappBook" data-user="{{$userid}}" data-guest="{{ $guestData }}" target='_blank'>
                							<i class="fab fa-whatsapp" style="font-size: 30px;margin-right: 15px"></i>
                							<span>@lang('words.events_box_tooltip.book_whatsapp')</span>
                						</a>
                						@endif--}}
                					</div>
                					{{--<div class="col-sm-12 text-center">
                						<br>
                						<img align="center" src="https://myplace-event.com/public/img/paiements-money-vertical.png" alt="" class="img-fluid" style="max-width: 150px;">
                					</div>--}}
                				</div>
                			</div>
                		</div>
                	</div>
                	<!-- Bottom site stickey header open-->

					

                	<div class="col-lg-12 col-sm-12 col-md-12 cover-wrapper-details" style="margin-top: 40px;
                	margin-bottom: 55px;">
						<div class="container">
							<div class="row" id="share-with-social">
								<div class="col-lg-12 col-md-12 col-xs-12 descripton-content social-parent cover-wrapper-child">
									<h3 style="text-align: center;">@lang('words.share_title_popup')</h3>
									<a href="https://www.facebook.com/sharer/sharer.php?u={{route('shop_item.details',$gadget->item_slug)}}"
										class="social-button social-logo-detail" >
										<i class="fab fa-facebook"></i>
									</a>
									<a href="https://twitter.com/intent/tweet?text={{$gadget->item_name}}&amp;url={{route('shop_item.details',$gadget->item_slug)}}"
										class="social-button social-logo-detail">
										<i class="fab fa-twitter"></i>
									</a>
									<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{route('shop_item.details',$gadget->item_slug)}}&amp;title={{ $gadget->item_name }}&amp;summary=Event At - {{ $gadget->item_location }}"
										class="social-button social-logo-detail">
										<i class="fab fa-linkedin"></i>
									</a>
									{{--<a href="https://plus.google.com/share?url={{route('shop_item.details',$gadget->item_slug)}}" --}}
										{{--class="social-button social-logo-detail">--}}
										{{--<i class="fab fa-google"></i>--}}
									{{--</a>						--}}
								</div>
							</div>
						</div>
                	</div>


                <div class="col-lg-12 col-sm-12 col-md-12" id="custome-stickey">
                	<div class="row detail-box-btn">
                        {{--<div class="col-md-12 c-992-p-0">
                            <p align="center" class="single-price" style="margin: 20px 0">
                                @if($gadget->event_min_price == 0)
                                @lang('words.pdf.text_11')
                                @else
                                {!! number_format($gadget->event_min_price,0, "."," ") !!} {!! use_currency()->symbol !!}
                                @endif
                                @if($gadget->event_min_price != $gadget->event_max_price)
                                -  {!! number_format($gadget->event_max_price,0, "."," ")!!} {!! use_currency()->symbol !!}
                                @endif
                            </p>
                        </div>--}}
                        {{--<div class="col-sm-12 text-center MobileBooking">
							

                           @if($gadget->item_end_datetime < \Carbon\Carbon::now())
                            <button style="cursor: pointer;" class="register-btn hide-register text-uppercase {{ $gadget->item_start_datetime < \Carbon\Carbon::now() ?'disabled-btn':''}}" id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" {{ $gadget->item_start_datetime < \Carbon\Carbon::now() ?'disabled':''}}>@lang('words.events_detials_page.eve_reg_button')</button>
                            @else
                            <button style="cursor: pointer;" class="register-btn hide-register text-uppercase  id="eventRegister" data-user="{{$userid}}" data-guest="{{ $guestData }}" >@lang('words.events_detials_page.eve_reg_button') </button>
                            <br />
                            <a href="https://wa.me/2250747974505/?text=*@lang('words.events_box_tooltip.Whatsapp_mess1')* _{{route('shop_item.details',$gadget->item_slug)}}_  *@lang('words.events_box_tooltip.Whatsapp_mess2')*." style="cursor: pointer" class="register-btn text-uppercase WhatsBook" id="whatsappBook" data-user="{{$userid}}" data-guest="{{ $guestData }}" target='_blank'>
                                <i class="fab fa-whatsapp" style="font-size: 30px;margin-right: 15px"></i>
                                <span>@lang('words.events_box_tooltip.book_whatsapp')</span>
                            </a>
                            @endif
                        </div>--}}
                    </div>
                </div>
                <!-- Bottom site stickey header close-->

                {{--<div class="col-lg-12 col-sm-12 col-md-12 cover-wrapper-details">
                   <div class="container">
                      <div class="row">
                         <div class="col-lg-8 cover-wrapper-child">
                            <div class="row">
									<!-- <div class="col-lg-12 col-sm-12 col-md-12 descripton-content">
										<h6>Registrations are closed</h6>
										<p>Thank you for the RSVP. Take a note that you can attend the event only after getting the registration confirmation email from us.</p>
									</div> -->
									<div class="col-md-12 col-lg-12 col-sm-12 descripton-content">
										<h6>@lang('words.events_detials_page.eve_content_desc')</h6>
										{!! $gadget->item_description !!}
									</div>
									<!-- <div class="col-lg-12 col-md-12 col-xs-12 descripton-content">
										<h6>TAGS</h6>
										<a href="" class="link-tags">Things To Do in Rajkot</a>
										<a href="" class="link-tags">Seminar</a>
										<a href="" class="link-tags">Science & Tech</a>
									</div> -->
								</div>
							</div>
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-md-12">
										<div class="org-box-main">
											<h4>Organizer</h4>
											<div class="org-boxes">
												<div class="image-box-org">
													<img src="{{ setThumbnail($gadget->profile_pic) }}">
												</div>
												<div class="org-link-box text-center">
													<p class="org-box-tit text-center">{{ $gadget->org_name }}</p>
													<button class="btn pro-choose-file text-uppercase mb-2 ctog" data-toggle="modal" data-target="#contact-org"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp; Contact The organizer</button>
													<a href="{{ route('org.detail',$gadget->org_slug) }}" target="_blank"><i class="fa fa-eye"></i> View Organizer profile</a>
												</div>
											</div>
										</div>
										<!-- Start Model -->
										<div id="contact-org" class="modal fade bd-example-modal-lg" role="dialog">
											<div class="modal-dialog modal-xs">
												<div class="modal-content ticket-registion">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Organizer Contact</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													</div>
													<div class="modal-body">
														<form id="org-con-form" method="post" action="{{ route('org.contact') }}">
															{!! csrf_field() !!}
															<div class="form-group row">
																<label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Name</label>
																<div class="col-sm-10">
																	<input type="hidden" name="org_mail" value="{{user_data($gadget->user_id)->email}}">
																	<input type="text" class="form-control" id="staticEmail" name="name" >
																</div>
															</div>
															<div class="form-group row">
																<label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
																<div class="col-sm-10">
																	<input type="email" class="form-control" id="inputPassword" required="" name="email">
																</div>
															</div>
															<div class="form-group row">
																<label for="subject" class="col-sm-2 col-form-label">Subject</label>
																<div class="col-sm-10">
																	<input type="text" class="form-control" id="subject" required="" name="subject">
																</div>
															</div>
															<div class="form-group row">
																<label for="msg" class="col-sm-2 col-form-label">Message</label>
																<div class="col-sm-10">
																	<textarea name="message"class="form-control" rows="5" id="msg" style="resize: none;" required=""></textarea>
																</div>
															</div>
															<input type="submit" id="organizer-form" class="btn btn-flat btn-primary" value="Submit">
														</form>
													</div>
													<!-- <div class="modal-footer"> -->
														<!-- </div>		 -->
													</div>
												</div>
											</div>
											<!-- End Model -->
										</div>
									</div>

									@if($gadget->item_facebook!='' || $gadget->evetn_twitter!='' || $gadget->item_instagaram!='')
									<br/>
									<div class="row">
										<div class="col-lg-12 col-sm-12 col-md-12">
											<h6 class="descripton-content-title">Event On Social Media</h6>
											<div class="item_socialmedia">
												@if($gadget->item_facebook!='')
												<a href="{{ $gadget->item_facebook }}" target="_blank">
													<i class="fa fa-facebook"></i> Facebook
												</a>
												@endif
												@if($gadget->evetn_twitter!='')
												<a href="{{ $gadget->evetn_twitter }}" target="_blank">
													<i class="fa fa-twitter"></i> Twitter
												</a>
												@endif
												@if($gadget->item_instagaram!='')
												<a href="{{ $gadget->item_instagaram }}" target="_blank">
													<i class="fa fa-instagram"></i> Instagaram
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
											<img src="{{ asset('upload/events-qr/'.$gadget->item_qrcode_image) }}" alt="qu-img" />
										</div>
									</div>
								</div> -->
							</div>
						</div>
						<div class="row" id="share-with-social">
							<div class="col-lg-12 col-md-12 col-xs-12 descripton-content social-parent cover-wrapper-child">
								<h6>@lang('words.share_title_popup')</h6>
								<a href="https://www.facebook.com/sharer/sharer.php?u={{route('shop_item.details',$gadget->item_slug)}}"
									class="social-button social-logo-detail" >
									<i class="fa fa-facebook"></i>
								</a>
								<a href="https://twitter.com/intent/tweet?text={{$gadget->item_name}}&amp;url={{route('shop_item.details',$gadget->item_slug)}}"
									class="social-button social-logo-detail">
									<i class="fa fa-twitter"></i>
								</a>
								<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{route('shop_item.details',$gadget->item_slug)}}&amp;title={{ $gadget->item_name }}&amp;summary=Event At - {{ $gadget->item_location }}"
									class="social-button social-logo-detail">
									<i class="fa fa-linkedin"></i>
								</a>
								<a href="https://plus.google.com/share?url={{route('shop_item.details',$gadget->item_slug)}}"
									class="social-button social-logo-detail">
									<i class="fa fa-google"></i>
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 offset-lg-2 col-sm-8 offset-sm-2 col-md-8 offset-md-2 text-center profile-pop">
								<h5>{{ $gadget->org_name }}</h5>
								<p class="text-capitalize">{!! str_limit(strip_tags($gadget->org_about), 175) !!}</p>
								<a href="{{ route('org.detail',$gadget->org_slug) }}" target="_blank">
									<b>@lang('words.events_detials_page.eve_content_profile')</b>
								</a>
							</div>
						</div>
						@if($gadget->map_display == 1)
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12 detail-map">
								<iframe scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q={{ $gadget->item_location }}&output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
							</div>
						</div>
						@endif
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12 text-center profile-pop">
								<h5 class="text-capitalize">{{ $gadget->item_name }}</h5>
								<small>@lang('words.events_detials_page.eve_content_at')</small>
								<p class="listing-map-address text-capitalize">{{ $gadget->item_address }}</p>
							</div>
						</div>
					</div>
				</div>--}}
				{{--	<div class="container">
					<div class="row detail-box-wrapper">
						<div class="col-lg-12 col-sm-12 col-md-12 cover-wrapper-details">
							<div class="container">
								<div class="row">
									--}}{{--<div class="col-lg-12 cover-wrapper-child">
										<div class="row">
											<!-- <div class="col-lg-12 col-sm-12 col-md-12 descripton-content">
												<h6>Registrations are closed</h6>
												<p>Thank you for the RSVP. Take a note that you can attend the event only after getting the registration confirmation email from us.</p>
											</div> -->
											<div class="col-md-12 col-lg-12 col-sm-12 descripton-content">
												--}}{{----}}{{--<h6>@lang('words.events_detials_page.eve_content_desc')</h6>--}}{{----}}{{--
												{!! $gadget->item_description !!}
											</div>
											<!-- <div class="col-lg-12 col-md-12 col-xs-12 descripton-content">
												<h6>TAGS</h6>
												<a href="" class="link-tags">Things To Do in Rajkot</a>
												<a href="" class="link-tags">Seminar</a>
												<a href="" class="link-tags">Science & Tech</a>
											</div> -->
										</div>
									</div>--}}{{--
								</div>
								<div class="row" id="share-with-social">
									<div class="col-lg-12 col-md-12 col-xs-12 descripton-content social-parent cover-wrapper-child">
										<h6>@lang('words.share_title_popup')</h6>
										<a href="https://www.facebook.com/sharer/sharer.php?u={{route('shop_item.details',$gadget->item_slug)}}"
											class="social-button social-logo-detail" >
											<i class="fab fa-facebook"></i>
										</a>
										<a href="https://twitter.com/intent/tweet?text={{$gadget->item_name}}&amp;url={{route('shop_item.details',$gadget->item_slug)}}"
											class="social-button social-logo-detail">
											<i class="fab fa-twitter"></i>
										</a>
										<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{route('shop_item.details',$gadget->item_slug)}}&amp;title={{ $gadget->item_name }}&amp;summary=Event At - {{ $gadget->item_location }}"
											class="social-button social-logo-detail">
											<i class="fab fa-linkedin"></i>
										</a>
										--}}{{--<a href="https://plus.google.com/share?url={{route('shop_item.details',$gadget->item_slug)}}" --}}{{--
											--}}{{--class="social-button social-logo-detail">--}}{{--
											--}}{{--<i class="fab fa-google"></i>--}}{{--
										--}}{{--</a>						--}}{{--
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>--}}
			</div>
		</div>

		<div class="container" style="margin-top:40px;">
			<div class="row detail-box-wrapper">
				<div class="col-lg-12 col-sm-12 col-md-12 cover-wrapper-details organisateur-box">
					<div class="org-box-main">
						<div class="org-boxes">
							<div class="image-box-org">
								<a  href="{{ route('org.detail',$gadget->org_slug) }}"  target="_blank"><img src="{{ setThumbnail($gadget->profile_pic) }}"></a>
							</div>
							<div class="org-link-box text-center">
								<p class="org-box-tit text-center">{{ $gadget->org_name }}</p>
								<button class="btn mb-2 ctog" data-toggle="modal" data-target="#contact-org"><i class="far fa-envelope"></i>@lang('words.cre_eve_page.cre_fm_orco')</button>

								<a href="{{ route('org.detail',$gadget->org_slug) }}"  target="_blank">
									<button class="btn mb-2 ctog secondary-bg" data-toggle="modal" data-target="#contact-org"><i class="fa fa-eye"></i>@lang('words.cre_eve_page.cre_fm_orpro')</button>
								</a>
							</div>
						</div>
					</div>
					<!-- Start Model -->
					<div id="contact-org" class="modal fade bd-example-modal-lg" role="dialog">
						<div class="modal-dialog modal-xs">
							<div class="modal-content ticket-registion">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">@lang('words.cre_eve_page.cre_fm_orgT') <strong class="primary-color">{{ $gadget->org_name }}</strong></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<form id="org-con-form" method="post" action="{{ route('org.contact') }}">
										{!! csrf_field() !!}
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">@lang('words.cre_eve_page.cre_fm_orgN')</label>
											<div class="col-sm-10">
												<input type="hidden" name="org_mail" value="{{ user_data($gadget->user_id)->email }}">
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

						@if($gadget->item_facebook!='' || $gadget->item_twitter!='' || $gadget->item_instagaram!='')
						<br/>
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
								<h6 class="descripton-content-title">{{--Event On Social Media--}}@lang('words.cre_eve_page.cre_fm_esm')</h6>
								<div class="item_socialmedia">
									@if($gadget->item_facebook!='')
									<a href="{{ $gadget->item_facebook }}" target="_blank">
										<i class="fab fa-facebook"></i> Facebook
									</a>
									@endif
									@if($gadget->item_twitter!='')
									<a href="{{ $gadget->item_twitter }}" target="_blank">
										<i class="fab fa-twitter"></i> Twitter
									</a>
									@endif
									@if($gadget->item_instagaram!='')
									<a href="{{ $gadget->item_instagaram }}" target="_blank">
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
								<img src="{{ asset('upload/events-qr/'.$gadget->item_qrcode_image) }}" alt="qu-img" />
							</div>
						</div>
					</div> -->
				</div>
			</div>

			<div class="row detail-box-wrapper" style="margin-bottom: 50px;">
				<div class="col-lg-12 col-sm-12 col-md-12 cover-wrapper-details">
					<div class="container">
						<div class="row">
							<div class="col-lg-8 offset-lg-2 col-sm-8 offset-sm-2 col-md-8 offset-md-2 text-center profile-pop">
								<h5>{{ $gadget->org_name }}</h5>
								<p class="text-capitalize">{!! str_limit(strip_tags($gadget->org_about), 175) !!}</p>
								<a href="{{ route('org.detail',$gadget->org_slug) }}" target="_blank">
									<b>@lang('words.events_detials_page.eve_content_profile')</b>
								</a>
							</div>
						</div>
						@if($gadget->map_display == 1)
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12 detail-map">
								<iframe scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q={{ $gadget->item_location }}&output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
							</div>
						</div>
						@endif
						{{--<div class="row">--}}
							{{--<div class="col-lg-12 col-sm-12 col-md-12 text-center profile-pop">--}}
								{{--<h5 class="text-capitalize">{{ $gadget->item_name }}</h5>--}}
								{{--<small>@lang('words.events_detials_page.eve_content_at')</small>							--}}
								{{--<p class="listing-map-address text-capitalize">{{ $gadget->item_address }}</p>--}}
							{{--</div>--}}
						{{--</div>--}}
					</div>
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
						{{--<a href="" class="social-button social-logo-detail google">--}}
							{{--<i class="fa fa-google"></i>--}}
						{{--</a>  --}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SHARE EVENT MODEL -->

	<!-- USER NOT LOGIN MODEL -->
<!-- <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
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
  </div> -->


  <!-- USER NOT LOGIN MODEL -->
  <div class="modal fade bd-example-modal-md modal-design" id="signupAlert" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
  	<div class="modal-dialog modal-md">
  		<div class="modal-content signup-alert" style="padding-bottom: 0">
  			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  			<div class="modal-body">
  				<div class="row">
  					<div class="col-sm-12" style="text-align:center;">
  						<h5 class="modal-title col-sm-12" id="exampleModalLabel2">@lang('words.guest_popup.pop_title_2')</h5>
                        <br>
                        <a href="{{route('user.login')}}" class="btn btn-block btn-lg custom-rounded login" style="width: 100%;line-height: inherit"></i> Connexion / Inscription</a><br>
                        <div class="facebook-login detail" style="width: 100%;text-align: center">
                           <a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg" style="width: 100%;line-height: inherit"><i class="fab fa-facebook"></i> Facebook</a>
                           <a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"  style="width: 100%;line-height: inherit"><i class="fab fa-google"></i> Google </a>
                       </div>
                       <br>
                       <span class="text-align-center" style="background-color: #f5f5f5;padding: 0 15px"> Ou / Or </span>
                       <hr style="border: 1px solid #e2e2e2;">
                   </div>
                   <div class="col-sm-12">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.guest_popup.pop_title')</h5>
                    <p class="modal-text">@lang('words.guest_popup.pop_desc') <!-- {{ forcompany() }}. --></p>
                    <div class="model-btn">
                       {!! Form::open(['method'=>'post','route'=>'guest.login', 'id'=>'guestLogin']) !!}
                       <div class="form-group text-center">
                          <!-- <label class="label-text">@lang('words.guest_popup.pop_name')</label> -->
                          <input type="text" name="guestuserName" value="" placeholder="@lang('words.guest_popup.pop_name')" class="form-control form-textbox" style="width: 250px;margin:0 auto" />
                      </div>
                      <div class="form-group text-center">
                          <!-- <label class="label-text">@lang('words.guest_popup.pop_email')</label> -->
                          <input type="text" name="guestUserEmail" value="" placeholder="@lang('words.guest_popup.pop_email')" class="form-control form-textbox" style="width: 250px;margin:0 auto" required/>
                      </div>
                      <div class="form-group text-center">
                          <input id="phone" type="tel" name="guestUserPhone" value="" placeholder="+2250000000000" class="tel form-control form-textbox" pattern="^+\d+" style="width: 250px;margin:0 auto" required/>
                      </div>
                      <div class="form-group payment-btn">
                          <input type="submit" class="btn btn-payment text-uppercase" name="booking" value="@lang('words.guest_popup.pop_btn')" />
                      </div>
                      {!! Form::close() !!}
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
<script  src="{{ asset('/js/intlTelInput.js')}}"></script>
<script  src="{{ asset('/js/script.js')}}"></script>
<!-- USER NOT LOGIN MODEL -->

<!-- USER NOT LOGIN MODEL -->
<!-- TICKETS REGISTER MODEL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="registration" role="dialog" aria-labelledby="registration" aria-hidden="true">
 <div class="modal-dialog modal-lg">
    <div class="modal-content ticket-registion">
       <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('words.ticke_popup.ticket_popup')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
</div>
</div>
</div>
<!-- Header scrolling Start -->

<script>
 
	 var prevScrollpos = window.pageYOffset;
	 window.onscroll = function() {
		var currentScrollPos = window.pageYOffset;

		if (prevScrollpos > currentScrollPos) {
		   document.getElementById("header-scroll").style.top = "0";
		   document.getElementById("resposive-scroll").style.top = "0";
		   document.getElementById("custome-stickey").style.top = "6.5%";
	   } else {
		   document.getElementById("custome-stickey").style.top = "0";
		   document.getElementById("header-scroll").style.top = "-70px";
		   document.getElementById("resposive-scroll").style.top = "-70px";
	   }
	   prevScrollpos = currentScrollPos;
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
          swal("Good job!",  resT.success , "success")
      }
  }
};

$("body").on("click","#organizer-form",function(e){
    $('#contact-org').modal('hide');
    $(this).parents("form").ajaxForm(optionsFeed);
});

	// Stickey Buttons
/*
	$(window).scroll(function() {
		*/
		/*var scrollPercent = ($(window).scrollTop() / $(document).height()) * 100;
	   	if (scrollPercent > 22) {
	   		$('#custome-stickey').show();
	   		$('.unhide-register').attr('id','eventRegister');
	   		$('.hide-register').removeAttr('id');
	   	}else{
	   		$('.hide-register').attr('id','eventRegister');
	   		$('.unhide-register').removeAttr('id');
	   		$('#custome-stickey').hide()
	/*   }
});*/
	// Stickey Buttons
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