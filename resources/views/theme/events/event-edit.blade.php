@extends($theme)
@section('meta_title',setMetaData()->e_update_title.' - '.$events->event_name )
@section('meta_description',setMetaData()->e_update_desc)
@section('meta_keywords',setMetaData()->e_update_keyword)

@section('content')
<div class="container-fluid about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
				<h2 class="text-uppercase about-title">@lang('words.edt_eve_page.edt_eve_page') {{ $events->event_name }}</h2>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row page-main-contain">
		<div class="col-lg-12 col-sm-12 col-md-12">
			@if($error = Session::get('error'))
			<div class="alert alert-danger">
				{{ $error }}
			</div>
			@elseif($success = Session::get('success'))
			<div class="alert alert-success">
				{{ $success }}
			</div>
			@endif
			{!! Form::model($events,['route'=>['events.update',$events->event_unique_id],'method'=>'patch','files'=>'true','id'=>'eventForm']) !!}
			<h2 class="profile-title profile-title-text page-header">@lang('words.edt_eve_page.edt_eve_deti')</h2>
			<br/>
			<div class="row">
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_title') <span class="text-danger">*</span></label>
					<input type="text" name="event_name" id="event_name" class="form-control form-textbox" value="{{ $events->event_name }}" />
					@if($errors->has('event_name')) <span class="error">{{ $errors->first('event_name') }}</span> @endif
				</div>
				{{--<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_loca') <span class="text-danger">*</span></label>
					<input type="text" name="event_location" placeholder="Location" id="location" class="form-control form-textbox" value="{{ $events->event_location }}" />
					--}}{{--<input type="text" name="event_location" placeholder="Location" id="header-location" class="form-control form-textbox" value="{{ $events->event_location }}" />--}}{{--
					@if($errors->has('event_location')) <span class="error">{{ $errors->first('event_location') }}</span> @endif
					@if($events->map_display == 1)
					<span class="form-note">
						<input type="checkbox" id="ckbox1" value="1" checked name="map_display" class="form-textbox">
						<label for="ckbox1" >&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</label>
					</span>
					@else
					<span class="form-note">
						<input type="checkbox" id="ckbox2" value="0"  name="map_display" class="form-textbox">
						<label for="ckbox2">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</label>
					</span>
					@endif
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">--}}{{--MAP--}}{{--Carte </label>
					<input type="hidden" name="event_latitude" id="latbox" value="{{ $events->event_latitude }}">
    				<input type="hidden" name="event_longitude" id="lngbox" value="{{ $events->event_longitude }}">
					<div id="maps" style="height: 400px;border:1px solid #F16334;"></div>
				</div>--}}
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_loca') <span class="text-danger">*</span></label>
					<input type="text" name="event_location" placeholder="Localisation" class="form-control form-textbox" id="create_events" value="{{ $events->event_location }}" required />

					{{--<input type="text" name="event_location" placeholder="Location" class="form-control form-textbox" id="header-location" value="{{ Input::old('event_location') }}" required />--}}
					@if($errors->has('event_location')) <span class="error">{{ $errors->first('event_location') }}</span> @endif
					<span class="form-note"> <input type="checkbox" value="1" {{ (! empty(Input::old('map_display')) ? '' : 'checked') }} name="map_display" class="form-textbox">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</span>
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">MAP </label>
					<input type="hidden" name="event_latitude" id="latbox" value="{{ $events->event_latitude }}">
					<input type="hidden" name="event_longitude" id="lngbox" value="{{ $events->event_longitude }}">
					<div id="map" style="height: 400px;border:1px solid #F16334;"></div>
				</div>

				<!-- Start Date and Time -->
				<?php $sdate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $events->event_start_datetime)->format('m/d/Y'); ?>

				<?php $edate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $events->event_end_datetime)->format('m/d/Y'); ?>

				<?php $time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $events->event_start_datetime)->format('g:i A'); ?>
				<?php $etime = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $events->event_end_datetime)->format('g:i A'); ?>
				<!-- Start Date and Time -->

				<div class="col-lg-6 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">{{--Start Date--}}Date de début <span class="text-danger">*</span></label>
					<input autocomplete="off" type="text" name="start_date" class="form-control form-textbox datetimepicker-input datetimepicker3" data-toggle="datetimepicker" data-val="{{ $sdate }}" data-target=".datetimepicker3"/>
					@if($errors->has('start_date')) <span class="error">{{ $errors->first('start_date') }}</span> @endif
				</div>

				<div class="col-lg-6 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">{{--Start Time--}}Heure de début<span class="text-danger">*</span></label>
					<input type="time" name="start_time" class="form-control form-textbox datetimepicker-input time-3"  data-val= "{{ $time }}"  id="timepicker_start_time"/>
					@if($errors->has('start_time')) <span class="error">{{ $errors->first('start_time') }}</span> @endif
				</div>
				<!-- Start Date and Time -->
				<!-- End Date and Time -->
				<div class="col-lg-6 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">{{--End Date--}}Date de fin <span class="text-danger">*</span></label>
					<input autocomplete="off" type="text" name="end_date" class="form-control form-textbox datetimepicker-input datetimepicker4" data-val="{{ $edate }}" data-toggle="datetimepicker" data-target=".datetimepicker4" />
					@if($errors->has('end_date')) <span class="error">{{ $errors->first('end_date') }}</span> @endif
				</div>

				<div class="col-lg-6 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">{{--End Time--}} Heure de fin <span class="text-danger">*</span></label>
					<input type="time" name="end_time" class="form-control form-textbox datetimepicker-input time-4"  data-val="{{ $etime }}"  id="timepicker_endtime"/>
					@if($errors->has('end_time')) <span class="error">{{ $errors->first('end_time') }}</span> @endif
				</div>
				<!-- End Date and Time -->
				
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_img') <span class="text-danger">*</span></label>
					<div class="form-textbox">
						<img src="{{ setImage($events->event_image) }}" id="ingOup" class="required img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 150px;" />
						<input type="file" name="event_image" id="imgInp"  style="display: none;" accept="image/x-png,image/gif,image/jpeg" />
						<input type="hidden" name="old_image" value="{{ $events->event_image }}">
					</div>
					@if($errors->has('event_image')) <span class="error">{{ $errors->first('event_image') }}</span> @endif
				</div>
				<!-- comment -->
				{{--
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_url')</label>
					<input type="text" name="event_url" class="form-control form-textbox" value="{{ $events->event_url }}"/>
					@if($errors->has('event_url')) <span class="error">{{ $errors->first('event_url') }}</span> @endif
				</div>
				--}}
				<!-- comment -->
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_desc') <span class="text-danger">*</span></label>
					<textarea name="event_description" id="event_description" class="summernote" >{!! $events->event_description !!}</textarea>
					@if($errors->has('event_description')) <span class="error">{{ $errors->first('event_description') }}</span> @endif
				</div>

				<!-- Select Pays -->
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_ctry') <span class="text-danger">*</span></label>
					<select class="form-control form-textbox k-state" name="event_country" id="event_country">
						@foreach ($pays as $paysLists)
							<option value="{{ $paysLists['nom_pays']}}"@if($paysLists['nom_pays'] == $events->event_country) selected="selected" @endif >{{ $paysLists['nom_pays'] }} </option>
					@endforeach
					<!-- Une liste d'option de pays existants -->
					</select>
					@if($errors->has('event_country')) <span class="error">{{ $errors->first('event_country') }}</span> @endif
				</div>
				<!-- Fin Select Pays -->

				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_add')  <span class="text-danger">*</span></label>
					<textarea name="event_address" id="event_address" class="form-control form-textbox" rows="3" cols="5">{!! $events->event_address !!}</textarea>
					@if($errors->has('event_address')) <span class="error">{{ $errors->first('event_address') }}</span> @endif
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 form-group" style="display: none">
					<div class="row">
						<div class="col-lg-12">
							<label class="text-uppercase label-text">{{--Refund Policy--}}Politique de remboursement</label>
						</div>				
						<div class="col-md-12">
							<input type="radio" name="refund" class="refund" id="refund1" value="0" {{ !is_null($price_change)?'disabled':'' }} {{ $events->refund_policy == '0'?'checked':'' }}>
			      			<label data-error="wrong" data-success="right" for="form29"><strong>1 {{--day--}}Jour: </strong>{{--Attendees can receive refunds up to 1 day before event start date--}}
								Les participants peuvent recevoir un remboursement jusqu'à 1 jour avant la date de début de l'événement.</label>
			      		</div>
			      		<div class="col-md-12">	
			      			<input type="radio" name="refund" class="refund" id="refund2" value="1" {{ !is_null($price_change)?'disabled':'' }} {{ $events->refund_policy == '1'?'checked':'' }}>
					       <label data-error="wrong" data-success="right" for="form29"><strong>7 jours: </strong>{{--Attendees can receive refunds up to 7 days before event start date.--}}
							   Les participants peuvent recevoir un remboursement jusqu'à 7 jours avant la date de début de l'événement.</label>
					    </div>
					     <div class="col-md-12">
					       <input type="radio" name="refund" class="refund" id="refund3" value="2" {{ !is_null($price_change)?'disabled':'' }} {{ $events->refund_policy == '2'?'checked':'' }}>	  
					       <label data-error="wrong" data-success="right" for="form29"><strong>30 jours: </strong>{{--Attendees can receive refunds up to 30 days before event start date.--}}
							   Les participants peuvent recevoir un remboursement jusqu'à 30 jours avant la date de début de l'événement.</label>
					    </div>
					    <div class="col-md-12">	   
					    	<input type="radio" name="refund" class="refund" id="refund4" value="3" {{ !is_null($price_change)?'disabled':'' }} {{ $events->refund_policy == '3'?'checked':'' }}>
					         <label data-error="wrong" data-success="right" for="form29"><strong>{{--No refunds--}}Pas de remboursement: </strong>{{--No refunds at any time--}}Aucun remboursement à tout moment.</label>
					    </div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_cat') <span class="text-danger">*</span></label>
					<select class="form-control form-textbox" name="event_category" id="event_category">
						<option value="">@lang('words.cre_eve_page.cre_fm_cap')</option>
						@foreach ($categories as $key => $values)
						{{-- <optgroup label=""> --}}
							@if($values->children->isEmpty())
							<option value="{!! $values['id'] !!}" @if($events->event_category == $values['id']) selected="selected" @endif>{!! $values->category_name !!}</option>
							@else
							@foreach ($values->children as $value)
							<option value="{!! $value['id'] !!}" @if($events->event_category == $value['id']) selected="selected" @endif>
								{!! $value->category_name !!}
							</option>
							@endforeach
							@endif
						{{-- </optgroup> --}}
						@endforeach
					</select>
					@if($errors->has('event_category')) <span class="error">{{ $errors->first('event_category') }}</span> @endif
					</div>

					<div class="col-lg-12 col-sm-12 col-md-12">
						<label class="text-uppercase label-text">{{--Event status--}}Satus de l'évènement</label>
						<div class="radio">
							<input type="radio" id="radio1" value="0" name="radio-group" class="event-status" {{ Input::old('radio-group') == 0 || $events->event_code == ''? 'checked':'' }}>
							<label for="radio1">Public</label>
							<input type="radio" id="radio2" value="1" name="radio-group" class="event-status" {{ $events->event_code != '' || Input::old('radio-group') == 1?'checked':'' }}>
							<label for="radio2">{{--Private--}}Privé</label>
						</div>
					</div>
					<div id="status-box" class="col-lg-12 col-sm-12 col-md-12 form-group" style="display:{{ $events->event_code != '' || Input::old('radio-group') == 1  ?'block':'none'}}">
						<div class="row">
							<div class="col-lg-4">
								<input type="text" name="event_code" class="form-control form-textbox" value="{{$events->event_code}}" placeholder="Event Code" id="ecode">
								@if($errors->has('event_code')) <span class="error">{{ $errors->first('event_code') }}</span> @endif
							</div>
							<div class="col-lg-4">
								<input type="text" name="confirm_event_code" class="form-control form-textbox" value="{{$events->event_code}}" placeholder="Confirm event code" id="cecode">
								@if($errors->has('confirm_event_code')) <span class="error">{{ $errors->first('confirm_event_code') }}</span> @endif
							</div>
						</div>
					</div>
				
				<div class="col-lg-12 col-sm-12 col-md-12 form-group" style="margin: 20px 0">
						<div class="row">
							<div class="col-lg-4" style="margin: 5px 0">
								<label class="label-text">Programmer une date de fermeture de la billeterie</label>
								<input type="text" name="eventEndDateBillet" id="timepicker_eventEndDateBillet" class="form-control form-textbox datetimepicker-input datetimepicker7"  
								value="{{ Input::old('eventEndDateBillet') }}" data-toggle="datetimepicker" data-target=".datetimepicker7"/>
							</div>
							<div class="col-lg-3" style="margin: 10px 0">
								<label class="label-text">Heure de fermeture de la billeterie</label>
								<input type="text" name="eventEndTimeBillet"  class="form-control form-textbox datetimepicker-input time-2 timepicker"  value="{{ Input::old('eventEndTimeBillet') }}" id="eventEndTimeBillet"/>
							</div>
						</div>
					</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="text-uppercase label-text"> @lang('words.cre_eve_page.cre_fm_org')</label>
					<select class="form-control form-textbox" name="event_org_name">
						<option value="">@lang('words.cre_eve_page.cre_fm_anp')</option>
						@foreach($listorg as $org)
							<option value="{!! $org['id'] !!}" @if($events->event_org_name == $org['id']) selected="selected" @endif >{!! $org['organizer_name'] !!}</option>
						@endforeach
					</select>

				</div>
			</div>
			
		<hr/>
			<h2 class="profile-title profile-title-text page-header">@lang('words.cre_eve_page.eve_tik_cre_tit')  </h2>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="">@lang('words.cre_eve_page.eve_tik_cre_tag')</label>
					<input type="hidden" name="tickets_commission" id="commission" value="{{ event_commission() }}" />
					<p class="alert alert-info"  >
								<b>Si vous souhaitez ajouter plus de tickets, cliquez sur le bouton "TICKETS  PAYANTS" et/ou TICKETS GRATUITS"
								</b>
					</p>
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4">
							<a href="javascript:void(0);" data-type="paid" class="add_tickets pro-choose-file" >@lang('words.cre_eve_page.eve_tik_pai_btn')</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-4">
							<a href="javascript:void(0);" data-type="free" class="add_tickets pro-choose-file" >@lang('words.cre_eve_page.eve_tik_fre_btn')</a>
						</div>
						{{--<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
							<a href="javascript:void(0);" data-type="donation" class="add_tickets pro-choose-file" >@lang('words.cre_eve_page.eve_tik_dnt_btn')</a>
						</div>--}}
					</div>
				</div>
				<div id="tickets" class="col-lg-12 col-md-12 col-sm-12">
					@if(!is_null($price_change))
					<div class="alert alert-info">
	  					<strong>{{--Event is allready booked so you can't able to change price of tickets--}}L'événement est déjà réservé, vous ne pouvez donc pas changer le prix des billets</strong>
					</div>
					@endif
					@php $i=1 @endphp
					@foreach($ticket as $key => $tik)
					<div class="row tickets-box ticket-{{$i}}">
						<input type="hidden" name="ticket_id[]" value="{{ $tik->id }}" />						
						<div class="col-md-5 form-group">
							<input type="text" name="ticket_title[]" class="form-control form-textbox required" placeholder="@lang('words.cre_eve_page.tik_box_txt_nm')" value="{{ $tik->ticket_title }}" />
						</div>
						<div class="col-md-3 form-group">
							<input type="hidden" name="remaning_qty[]" value="{{ $tik->ticket_remaning_qty }}">
							<input type="hidden" name="old_qty[]" value="{{ $tik->ticket_qty }}">
							<input type="text" name="ticket_qty[]" class="form-control form-textbox" placeholder="@lang('words.cre_eve_page.tik_box_txt_ty')" required value="{{ $tik->ticket_qty }}" />
						</div>
						
						<div class="col-md-3 form-group">

							@if($tik->ticket_type == 1)
							<span>
								<input type="text" name="ticket_price_actual[]" id=ticket_price class="form-control form-textbox ticket-price" value="{{ /*$tik->ticket_price_actual*/ $tik->ticket_price_buyer }}" placeholder="$ @lang('words.cre_eve_page.tik_box_txt_pr')"
								@if(!is_null($price_change))
								readonly="" @endif />
							</span>
							<span class="form-note" id="bfees">@lang('words.cre_eve_page.tik_box_txt_bt') : $ <strong>{{ /*$tik->ticket_price_buyer*/ $tik->ticket_price_actual }}</strong></span>
							<input type="hidden" name="ticket_type[]" value="1" readonly="" />
							@elseif($tik->ticket_type == 2)
							<span class="ticketpricttxt">
								<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_dn')" readonly="" required="" aria-invalid="false" >
							</span>
							@else
							<span>
								<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_fr')" readonly="" required/>
							</span>
							<input type="hidden" name="ticket_type[]" value="00.00" readonly="" />
							@endif
						</div>
						<div class="col-md-1">
							<a type="button" class="text-muted setting" style="line-height: 36px;"><i class="fa fa-cog"></i></a>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12 setting" style="display:none">
							<div class="form-group">
								<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_box_tas_de')</label>
								<textarea name="ticket_description[]" class="form-control form-textbox" rows="3" cols="15">{!! $tik->ticket_description !!}</textarea>
							</div>
							<div class="form-group">
								<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_box_tas_hi')</label>
								<select class="form-control form-textbox" name="ticket_desc_status[]">
									<option value="0" {{$tik->ticket_desc_status==0?'selected':''}} >@lang('words.cre_eve_page.tik_dro_tas_hi')</option>
									<option value="1" {{$tik->ticket_desc_status==1?'selected':''}} >@lang('words.cre_eve_page.tik_dro_tas_sh')</option>
								</select>
							</div>
							
							<div class="form-group">
								<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_eve_tik_sh')</label>
								<select class="form-control form-textbox" name="ticket_status[]">
									<option value="0" {{$tik->ticket_status==0?'selected':''}} >@lang('words.cre_eve_page.tik_dro_tas_hi')</option>
									<option value="1" {{$tik->ticket_status==1?'selected':''}} >@lang('words.cre_eve_page.tik_dro_tas_sh')</option>
								</select>
							</div>
							@if($tik->ticket_type == 1)
							<div class="form-group">
								<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_fee_tik_ss')</label>
								<select class="form-control form-textbox select_fee" name="ticket_services_fee[]">
									<option value="1" {{$tik->ticket_services_fee==1?'selected':''}} >@lang('words.cre_eve_page.tik_fee_tik_fe')</option>
									<option value="0" {{$tik->ticket_services_fee==0?'selected':''}}
										>@lang('words.cre_eve_page.tik_fee_tik_ab')</option>
								</select>
								<span class="form-note" id="tfees">
									<?php 
										if($tik->ticket_services_fee==1){
											$commis ="3.5";//(event_commission()!='')?	event_commission():0;
											$fee = ($tik->ticket_price_buyer*$commis)/100;
										}else{
											$fee=0;
										}
									?>
									@lang('words.cre_eve_page.tik_fes_tik_ss') : <strong id="fee">{{$fee}} F CFA</strong>  @lang('words.cre_eve_page.tik_box_txt_bt') : <strong id="buyertotal">{{ $tik->ticket_price_buyer }} F CFA</strong>  
								</span>
							</div>
							@elseif($tik->ticket_type == 2)
							<div class="form-group">
								<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_fee_tik_ss')</label>
								<select class="form-control form-textbox select_fee" name="ticket_services_fee[]">
									<option value="1" {{$tik->ticket_services_fee==1?'selected':''}} >@lang('words.cre_eve_page.tik_fee_tik_fe')</option>
									<option value="0" {{$tik->ticket_services_fee==0?'selected':''}}
										>@lang('words.cre_eve_page.tik_fee_tik_ab')</option>
								</select>
							</div>
							@else
								<input type="hidden" name="ticket_services_fee[]" value="0"/>
							@endif
							<div class="clearfix"></div>
						</div>
					</div>
					@php $i++ @endphp
					@endforeach
				</div>
			</div>
				<hr/>
				<h2 class="profile-title profile-title-text page-header">@lang('words.cre_eve_page.add_seeting_tit') </h2>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_fb')</label>
						<input type="text" name="event_facebook" class="form-control form-textbox"  value="{{ $events->event_facebook }}" />
						@if($errors->has('event_facebook')) <span class="error">{{ $errors->first('event_facebook') }}</span> @endif
					</div>
					<!-- comment -->
					{{--
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_twi')</label>
						<input type="text" name="evetn_twitter" class="form-control form-textbox" value="{{ $events->evetn_twitter }}"/>
						@if($errors->has('evetn_twitter')) <span class="error">{{ $errors->first('evetn_twitter') }}</span> @endif
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_int')</label>
						<input type="text" name="event_instagaram" class="form-control form-textbox" value="{{ $events->event_instagaram }}"/>
						@if($errors->has('event_instagaram')) <span class="error">{{ $errors->first('event_instagaram') }}</span> @endif
					</div>
					--}}
					<!-- comment -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_pub')</label>
						<div class="toggal-switch">
							{{ $events->event_status }}
							@if($events->event_status == 1)
							<input name="event_status" value="1" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@elseif($events->event_status == 0)
							<input name="event_status" value="0" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@elseif($events->event_status == 2)
								<input name="event_status" value="2" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@endif
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text">  @lang('words.cre_eve_page.add_seeting_rea')</label>
						<div class="toggal-switch">
							@if($events->event_remaining == 1)
							<input name="event_remaining" value="1"  data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_yes')" data-off="@lang('words.cre_eve_page.add_seeting_not')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@lang('words.cre_eve_page.add_seeting_sho')
							@else
							<input name="event_remaining" value="0"  data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_yes')" data-off="@lang('words.cre_eve_page.add_seeting_not')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox">
							@lang('words.cre_eve_page.add_seeting_sho')
							@endif
						</div>
					</div>

					<div class="col-md-4 col-sm-12 col-lg-4 form-group">
						<input type="Submit" value="@lang('words.edt_eve_page.edt_eve_btn')" class="pro-choose-file text-uppercase" />
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection
@section('pageScript')
	<script type="text/javascript">

		$('#timepicker_endtime').mdtimepicker({format: 'hh:mm'}); //Initializes the time picker and uses the specified format (i.e. 23:30)
		$('#timepicker_start_time').mdtimepicker({format: 'hh:mm'}); //Initializes the time picker and uses the specified format (i.e. 23:30)
		$('#timepicker_start_time').mdtimepicker({theme: 'green'});

			$('.datetimepicker7').datetimepicker({
				useCurrent: false,
				language: 'fr-FR',
				//format: 'MM/DD/YYYY',
				format: 'DD/MM/YYYY',
				minDate:new Date() 
			});		
		
		function initAutocomplete() {
		/*var inputs = document.getElementById('header-location');*/
		var inputs = document.getElementById('location');
        var autocompletes = new google.maps.places.Autocomplete(inputs);
        autocompletes.addListener('place_changed', function () {
            var placess = autocompletes.getPlace();
            $('#location_selected').val(placess.address_components[0].long_name);            
        });


				var lats = <?php echo $events->event_latitude; ?>;
				var longs = <?php echo $events->event_longitude; ?>;

		        var map = new google.maps.Map(document.getElementById('maps'), {
		          center: {lat: lats, lng: longs },
		          zoom: 13,
		          mapTypeId: 'roadmap'
		        });


		        var marker = new google.maps.Marker({
		          position: {lat: lats, lng: longs},
		          map: map
		        });


		        // Create the search box and link it to the UI element.
		        var input = document.getElementById('location');
		        var searchBox = new google.maps.places.SearchBox(input);
		        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

		        var autocomplete = new google.maps.places.Autocomplete(input);
		          google.maps.event.addListener(autocomplete, 'place_changed', function () {
		              var place = autocomplete.getPlace();
		              document.getElementById('latbox').value = place.geometry.location.lat();
		              document.getElementById('lngbox').value = place.geometry.location.lng();
		              document.getElementById('city').value   = place.name;
		          });


		        // Bias the SearchBox results towards current map's viewport.
		        map.addListener('bounds_changed', function() {
		          searchBox.setBounds(map.getBounds());
		        });

		        var markers = [];
		        // Listen for the event fired when the user selects a prediction and retrieve
		        // more details for that place.
		        searchBox.addListener('places_changed', function() {
		          var places = searchBox.getPlaces();

		          if (places.length == 0) {
		            return;
		          }

		          // Clear out the old markers.
		          markers.forEach(function(marker) {
		            marker.setMap(null);
		          });
		          markers = [];

		          // For each place, get the icon, name and location.
		          var bounds = new google.maps.LatLngBounds();
		          places.forEach(function(place) {
		            if (!place.geometry) {
		              console.log("Returned place contains no geometry");
		              return;
		            }

		            // Create a marker for each place.
		            var marker = new google.maps.Marker({
		                position: place.geometry.location,
		                map: map,
		                draggable:true,
		                title:"Drag me!"
		               });

		          marker.addListener('click', toggleBounce);
		             function toggleBounce() {
		          if (marker.getAnimation() !== null) {
		            marker.setAnimation(null);
		          } else {
		            marker.setAnimation(google.maps.Animation.BOUNCE);
		          }
		        }

		       google.maps.event.addListener(marker, 'dragend', function (event) {
		          document.getElementById("latbox").value = event.latLng.lat();
		          document.getElementById("lngbox").value = event.latLng.lng();
		      });

		        if (place.geometry.viewport) {
		          // Only geocodes have viewport.
		          bounds.union(place.geometry.viewport);
		        } else {
		          bounds.extend(place.geometry.location);
		        }
		      });
		      map.fitBounds(bounds);
		  });
		}
	</script>
	{{--<script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('services.google.api_key') }}&libraries=places&callback=initAutocompletes" async defer></script>--}}
	
	<script type="text/javascript" src="{{ asset('/js/events/event_script.js')}}"></script>
	<script type="text/javascript">
		$('.event-status').change(function(){
			if($(this).val() == 1) {
				$('#status-box').show();
			}else{
				$('#status-box').hide();
			}
		});
	</script>

	<div style="display: none;">
	<span class="tpf">
		<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_fr')" readonly="" required/>
	</span>
	<span class="tpp">
		<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" id=ticket_price placeholder="@lang('words.cre_eve_page.tik_box_txt_pr')"/>
	</span>
	<span class="tpd">
		<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_dn')" readonly="" required/>
	</span>
	<div class="addeventtickets">  
		<div class="col-md-5 form-group">
			<input type="text" name="ticket_title[]" class="form-control form-textbox required" placeholder="@lang('words.cre_eve_page.tik_box_txt_nm')" required />
		</div>
		<div class="col-md-3 form-group">
			<input type="text" name="ticket_qty[]" class="form-control form-textbox" placeholder="@lang('words.cre_eve_page.tik_box_txt_ty')" required/>
		</div>
		<div class="col-md-3 form-group tpfg">
			<span class="ticketpricttxt"></span>
			<span class="form-note bfees" id="bfees">@lang('words.cre_eve_page.tik_box_txt_bt') : {{ use_currency()->symbol }} <strong>00.00</strong></span> 
		</div>
		<div class="col-md-1">
			<a type="button" class="text-muted setting" style="line-height: 36px;"><i class="fa fa-cog"></i></a> | <a type="button" class="text-danger remove" style="line-height: 36px;"><i class="fa fa-times"></i></a>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12 setting" style="display:none">
			<div class="form-group">
				<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_box_tas_de')</label>
				<textarea name="ticket_description[]" class="form-control form-textbox" rows="3" cols="15"></textarea>
			</div>
			<div class="form-group">
				<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_box_tas_hi')</label>
				<select class="form-control form-textbox" name="ticket_desc_status[]">
					<option value="0" selected >@lang('words.cre_eve_page.tik_dro_tas_hi')</option>
					<option value="1" >@lang('words.cre_eve_page.tik_dro_tas_sh')</option>
				</select>
			</div>
			<div class="form-group">
				<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_eve_tik_sh')</label>
				<select class="form-control form-textbox" name="ticket_status[]">
					<option value="0" selected >@lang('words.cre_eve_page.tik_dro_tas_hi')</option>
					<option value="1" >@lang('words.cre_eve_page.tik_dro_tas_sh')</option>
				</select>
			</div>
			<div class="form-group servicesfee">
				<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_fee_tik_ss')</label>
				<select class="form-control form-textbox select_fee" name="ticket_services_fee[]">
					<option value="1">@lang('words.cre_eve_page.tik_fee_tik_fe')</option>
					<option value="0">@lang('words.cre_eve_page.tik_fee_tik_ab')</option>
				</select>
				<span class="form-note" id="tfees">@lang('words.cre_eve_page.tik_fes_tik_ss') : {{ use_currency()->symbol }} <strong id="fee">0</strong>@lang('words.cre_eve_page.tik_box_txt_bt') |  : {{ use_currency()->symbol }} <strong id="buyertotal">0</strong>  </span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
@endsection