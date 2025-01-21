@extends($theme)
@section('meta_title',setMetaData()->e_update_title.' - '.$gadgets->item_name )
@section('meta_description',setMetaData()->e_update_desc)
@section('meta_keywords',setMetaData()->e_update_keyword)

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<style>
	.event_id_select{
		height: 50px !important;
	}
</style>

@section('content')
<div class="container-fluid about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
				<h2 class="text-uppercase about-title">Modifier le gadget {{ $gadgets->item_name }}</h2>
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
			{!! Form::model($gadgets,['route'=>['shop.item.update',$gadgets->item_unique_id],'method'=>'patch','files'=>'true','id'=>'eventForm']) !!}
			<h2 class="profile-title profile-title-text page-header">Modifier les détails du gadget</h2>
			<br/>
			<div class="row">
				
				<div class="col-lg-12 col-md-12 col-sm-12 form-group" style="margin-bottom:20px;">
					<label class="label-text">@lang('words.cre_gad_page.cre_fm_even') <span class="text-danger">*</span></label>
					<select class="form-control form-textbox k-state select2 select2-hidden-accessible event_id_select" name="event_id" style="width: 100%;" tabindex="-1" required>
						@foreach ($events as $event)
							<option value="{{ $event->id }}" @if($event->id == $gadgets->event_id) selected="selected" @endif >{{ $event->event_name }} </option>
						@endforeach
					</select>
					@if($errors->has('event_id')) <span class="error">{{ $errors->first('event_id') }}</span> @endif
				</div> 

				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_gad_page.cre_fm_title') <span class="text-danger">*</span></label>
					<input type="text" name="item_name" id="item_name" class="form-control form-textbox" value="{{ $gadgets->item_name }}" />
					@if($errors->has('item_name')) <span class="error">{{ $errors->first('item_name') }}</span> @endif
				</div>
				
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_loca') <span class="text-danger">*</span></label>
					<input type="text" name="item_location" placeholder="Localisation" class="form-control form-textbox" id="create_events" value="{{ $gadgets->item_location }}" required />

					{{--<input type="text" name="item_location" placeholder="Location" class="form-control form-textbox" id="header-location" value="{{ Input::old('item_location') }}" required />--}}
					@if($errors->has('item_location')) <span class="error">{{ $errors->first('item_location') }}</span> @endif
					<span class="form-note"> <input type="checkbox" value="1" {{ (! empty(Input::old('map_display')) ? '' : 'checked') }} name="map_display" class="form-textbox">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</span>
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">MAP </label>
					<input type="hidden" name="item_latitude" id="latbox" value="{{ $gadgets->item_latitude }}">
					<input type="hidden" name="item_longitude" id="lngbox" value="{{ $gadgets->item_longitude }}">
					<div id="map" style="height: 400px;border:1px solid #F16334;"></div>
				</div>

				<!-- Start Date and Time -->
				<?php $sdate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $gadgets->item_start_datetime)->format('m/d/Y'); ?>

				<?php $edate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $gadgets->item_end_datetime)->format('m/d/Y'); ?>

				<?php $time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $gadgets->item_start_datetime)->format('g:i A'); ?>
				<?php $etime = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $gadgets->item_end_datetime)->format('g:i A'); ?>
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
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_img1') <span class="text-danger">*</span></label>
					<div class="form-textbox" style="padding-left: 0;" align="center">
						<img src="{{ setImage($gadgets->item1_image) }}" id="ingOup" class="required img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 150px;" />
						<input type="file" name="item1_image" id="imgInp"  style="display: none;" accept="image/x-png,image/gif,image/jpeg" />
						<input type="hidden" name="old_image" value="{{ $gadgets->item1_image }}">
					</div>
					@if($errors->has('item1_image')) <span class="error">{{ $errors->first('item1_image') }}</span> @endif
				</div>
				<!-- comment -->
				{{--
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_url')</label>
					<input type="text" name="event_url" class="form-control form-textbox" value="{{ $gadgets->event_url }}"/>
					@if($errors->has('event_url')) <span class="error">{{ $errors->first('event_url') }}</span> @endif
				</div>
				--}}
				<!-- comment -->
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_desc') <span class="text-danger">*</span></label>
					<textarea name="item_description" id="item_description" class="summernote" >{!! $gadgets->item_description !!}</textarea>
					@if($errors->has('item_description')) <span class="error">{{ $errors->first('item_description') }}</span> @endif
				</div>

				<!-- Select Pays -->
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_ctry') <span class="text-danger">*</span></label>
					<select class="form-control form-textbox k-state" name="item_country" id="item_country">
						@foreach ($pays as $paysLists)
							<option value="{{ $paysLists['nom_pays']}}"@if($paysLists['nom_pays'] == $gadgets->item_country) selected="selected" @endif >{{ $paysLists['nom_pays'] }} </option>
						@endforeach
					<!-- Une liste d'option de pays existants -->
					</select>
					@if($errors->has('item_country')) <span class="error">{{ $errors->first('item_country') }}</span> @endif
				</div>
				<!-- Fin Select Pays -->

				<div class="col-lg-12 col-md-12 col-sm-12 form-group" style="display: none">
					<div class="row">
						<div class="col-lg-12">
							<label class="text-uppercase label-text">{{--Refund Policy--}}Politique de remboursement</label>
						</div>				
						<div class="col-md-12">
							<input type="radio" name="refund" class="refund" id="refund1" value="0" {{ !is_null($price_change)?'disabled':'' }} {{ $gadgets->refund_policy == '0'?'checked':'' }}>
			      			<label data-error="wrong" data-success="right" for="form29"><strong>1 {{--day--}}Jour: </strong>{{--Attendees can receive refunds up to 1 day before event start date--}}
								Les participants peuvent recevoir un remboursement jusqu'à 1 jour avant la date de début de l'événement.</label>
			      		</div>
			      		<div class="col-md-12">	
			      			<input type="radio" name="refund" class="refund" id="refund2" value="1" {{ !is_null($price_change)?'disabled':'' }} {{ $gadgets->refund_policy == '1'?'checked':'' }}>
					       <label data-error="wrong" data-success="right" for="form29"><strong>7 jours: </strong>{{--Attendees can receive refunds up to 7 days before event start date.--}}
							   Les participants peuvent recevoir un remboursement jusqu'à 7 jours avant la date de début de l'événement.</label>
					    </div>
					     <div class="col-md-12">
					       <input type="radio" name="refund" class="refund" id="refund3" value="2" {{ !is_null($price_change)?'disabled':'' }} {{ $gadgets->refund_policy == '2'?'checked':'' }}>	  
					       <label data-error="wrong" data-success="right" for="form29"><strong>30 jours: </strong>{{--Attendees can receive refunds up to 30 days before event start date.--}}
							   Les participants peuvent recevoir un remboursement jusqu'à 30 jours avant la date de début de l'événement.</label>
					    </div>
					    <div class="col-md-12">	   
					    	<input type="radio" name="refund" class="refund" id="refund4" value="3" {{ !is_null($price_change)?'disabled':'' }} {{ $gadgets->refund_policy == '3'?'checked':'' }}>
					         <label data-error="wrong" data-success="right" for="form29"><strong>{{--No refunds--}}Pas de remboursement: </strong>{{--No refunds at any time--}}Aucun remboursement à tout moment.</label>
					    </div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.cre_fm_cat') <span class="text-danger">*</span></label>
					<select class="form-control form-textbox" name="item_category" id="item_category">
						<option value="{{$gadgets->item_category}}">@lang('words.cre_eve_page.cre_fm_cap')</option>
						@foreach ($categories as $key => $values)
						{{-- <optgroup label=""> --}}
							@if($values->children->isEmpty())
							<option value="{!! $values['id'] !!}" @if($gadgets->item_category == $values['id']) selected="selected" @endif>{!! $values->category_name !!}</option>
							@else
							@foreach ($values->children as $value)
							<option value="{{$gadgets->item_category}}" @if($gadgets->item_category == $value['id']) selected="selected" @endif>
								{!! $value->category_name !!}
							</option>
							@endforeach
							@endif
						{{-- </optgroup> --}}
						@endforeach
					</select>
					@if($errors->has('item_category')) <span class="error">{{ $errors->first('item_category') }}</span> @endif
					</div>
					<div class="col-lg-12 col-sm-12 col-md-12">
						@if ($gadgets->item_size || $gadgets->item_color)
							<label class="label-text">@lang('words.cre_gad_page.cre_fm_variant')</label>
							<div class="radio">
								<input type="radio" id="radio1" value="0" name="radio-group" class="event-status">
								<label for="radio1">@lang('words.cre_gad_page.cre_fm_no')</label>
								<input type="radio" id="radio2" value="1" name="radio-group" class="event-status" checked>
								<label for="radio2">@lang('words.cre_gad_page.cre_fm_yes')</label>
							</div>
						@else
							<label class="label-text">@lang('words.cre_gad_page.cre_fm_variant')</label>
							<div class="radio">
								<input type="radio" id="radio1" value="0" name="radio-group" class="event-status" {{ Input::old('radio-group') == 0? 'checked':'' }}>
								<label for="radio1">@lang('words.cre_gad_page.cre_fm_no')</label>
								<input type="radio" id="radio2" value="1" name="radio-group" class="event-status" {{ Input::old('radio-group') == 1 ?'checked':'' }}>
								<label for="radio2">@lang('words.cre_gad_page.cre_fm_yes')</label>
							</div>
						@endif
					</div>
					
					<div id="status-box" class="col-lg-12 col-sm-12 col-md-12 form-group" style="display:{{ Input::old('radio-group') == 1?'block':'none'}}">
						<div class="row">
							<div class="col-md-6"> 
								<select name="item_size[]" id="choices-multiple-remove-button1" multiple placeholder="Choisir les tailles disponibles">
									@if ($gadgets->item_size)
										@foreach(json_decode($gadgets->item_size) as $size)
                                        	<option value="{{$size}}" selected="selected">{{ $size }} </option>
                                    	@endforeach
									@endif
								</select> 
							</div>
							<div class="col-md-6"> 
								<select name="item_color[]" id="choices-multiple-remove-button2" multiple placeholder="Choisir les couleurs disponibles">
									@if ($gadgets->item_color)
										@foreach(json_decode($gadgets->item_color) as $color)
                                        	<option value="{{$color}}" selected="selected">{{ $color }} </option>
                                    	@endforeach
									@endif
								</select> 
							</div>
						</div>
					</div>

				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="text-uppercase label-text"> @lang('words.cre_eve_page.cre_fm_org')</label>
					<select class="form-control form-textbox" name="item_org_name">
						<option value="">@lang('words.cre_eve_page.cre_fm_anp')</option>
						@foreach($listorg as $org)
							<option value="{{$gadgets->item_org_name}}" @if($gadgets->item_org_name == $org['id']) selected="selected" @endif >{!! $org['organizer_name'] !!}</option>
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
										$commis = (event_commission()!='')?event_commission():0;
										$fee = $tik->ticket_price_actual*($commis/100)
									?>
									@lang('words.cre_eve_page.tik_fes_tik_ss') : $ <strong id="fee">{{$fee}}</strong>  @lang('words.cre_eve_page.tik_box_txt_bt') : $ <strong id="buyertotal">{{ $tik->ticket_price_buyer }}</strong>  
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
						<input type="text" name="event_facebook" class="form-control form-textbox"  value="{{ $gadgets->event_facebook }}" />
						@if($errors->has('event_facebook')) <span class="error">{{ $errors->first('event_facebook') }}</span> @endif
					</div>
					<!-- comment -->
					{{--
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_twi')</label>
						<input type="text" name="evetn_twitter" class="form-control form-textbox" value="{{ $gadgets->evetn_twitter }}"/>
						@if($errors->has('evetn_twitter')) <span class="error">{{ $errors->first('evetn_twitter') }}</span> @endif
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_int')</label>
						<input type="text" name="event_instagaram" class="form-control form-textbox" value="{{ $gadgets->event_instagaram }}"/>
						@if($errors->has('event_instagaram')) <span class="error">{{ $errors->first('event_instagaram') }}</span> @endif
					</div>
					--}}
					<!-- comment -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text"> @lang('words.cre_eve_page.add_seeting_pub')</label>
						<div class="toggal-switch">
							{{ $gadgets->item_status }}
							@if($gadgets->item_status == 1)
							<input name="item_status" value="1" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@elseif($gadgets->item_status == 0)
							<input name="item_status" value="0" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@elseif($gadgets->item_status == 2)
								<input name="item_status" value="2" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked>
							@endif
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="text-uppercase label-text">  @lang('words.cre_eve_page.add_seeting_rea')</label>
						<div class="toggal-switch">
							@if($gadgets->event_remaining == 1)
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
		 
		$(document).ready(function(){

			$('.select2').select2({
			closeOnSelect: false
			});

			$('#timepicker_endtime').mdtimepicker({format: 'hh:mm'}); //Initializes the time picker and uses the specified format (i.e. 23:30)
			$('#timepicker_start_time').mdtimepicker({format: 'hh:mm'}); //Initializes the time picker and uses the specified format (i.e. 23:30)
			$('.event-status').change(function(){
				if($(this).val() == 1) {
					$('#status-box').show();
				}else{
					$('#status-box').hide();
				}
			});
			
			

			var multipleCancelButton1 = new Choices('#choices-multiple-remove-button1', {
				removeItemButton: true,
				maxItemCount:5,
				searchResultLimit:5,
				renderChoiceLimit:5
			});

			var multipleCancelButton2 = new Choices('#choices-multiple-remove-button2', {
				removeItemButton: true,
				maxItemCount:5,
				searchResultLimit:5,
				renderChoiceLimit:5
			});


			

			$('#eventForm').validate({
				rules: {
					// ticket_title[] : 'required',
					// ticket_qty[]: 'required',
					item_name : 'required',
					item_org_name : 'required',
					location : 'required',
					item_start_datetime : {
						required : true,
						date: true,
					},
					item_end_datetime : {
						required : true,
						date: true,
					},
					item_category : 'required',
					item_description : {
						required  : true,
						minlength  : 15,
					},
					/* event_address : {
					required : true,
					minlength : 5,
					},*/
					item_country : {
						required : true,
					},
					item1_image : 'required',
					ticket_price : {
						required : true,
						min:1
					},
				},


				messages : {
					// ticket_title[] : 'Ce champ est requis.',
					// ticket_qty[] : 'Ce champ est requis.',
					item_name : "Le nom du gadget est obligatoire, veuillez le saisir",
					item_org_name : "Un organisateur est requis. Veuillez en sélectionner un.",
					location : "Le lieu requis",
					item_start_datetime: {
						required : "La date de début est requise",
						date: "Veuillez entrer une date valide",
					},
					item_category : "La catégorie lié au gadget est obligatoire",
					item_end_datetime: {
						required : "La date de fin est requise",
						date: "Veuillez entrer une date valide",
					},
					item_description : {
						required : "La description du gadget est obligatoire",
						minlength : "Description requise minimum 15 caractères",
					},
					/*event_address : {
					required : "Enter event address",
					minlength : "Please enter at least 5 characters",
					},*/
					item_country : {
						required : "Entrez le pays",
					},
					item1_image : "Une image du gadget est requise",
				}
			});
		});
	</script>

	<script type="text/javascript" src="{{ asset('/js/events/event_script.js')}}"></script>

	<div style="display: none;" class="ticket-label">
		<span class="tpf">
			<label class="ticket-label">{{--Ticket Price--}}Prix du Ticket</label>
			<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_fr')" readonly="" required/>
		</span>
		<span class="tpp">
			<label class="ticket-label">{{--Ticket Price--}}Prix du Ticket</label>
			<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" id=ticket_price placeholder="@lang('words.cre_eve_page.tik_box_txt_pr')"/>
		</span>
		<span class="tpd">
			<label class="ticket-label">{{--Ticket Price--}} Prix du Ticket</label>
			<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_dn')" readonly="" required/>
		</span>

		<div class="addeventtickets">
			<div class="col-md-5 form-group">
				<label class="ticket-label">{{--Ticket Name--}}Nom du Ticket</label>
				<input type="text" name="ticket_title[]" class="form-control form-textbox required" placeholder="@lang('words.cre_eve_page.tik_box_txt_nm')" required/>
			</div>
			<div class="col-md-3 form-group">
				<label class="ticket-label">{{--Ticket Qty--}}Quantité</label>
				<input type="text" name="ticket_qty[]" class="form-control form-textbox" placeholder="@lang('words.cre_eve_page.tik_box_txt_ty')" required/>
			</div>
			<div class="col-md-3 form-group tpfg">
				<span class="ticketpricttxt"></span>
				<span class="form-note bfees" id="bfees">@lang('words.cre_eve_page.tik_box_txt_bt') : <strong>00.00</strong> {{ use_currency()->symbol }}</span><br>
			</div>
			<div class="col-md-1 ticket-select-btn">
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
					<select class="form-control form-textbox k-state" name="ticket_desc_status[]">
						<option value="1">@lang('words.cre_eve_page.tik_dro_tas_hi')</option>
						<option value="0" selected="">@lang('words.cre_eve_page.tik_dro_tas_sh')</option>
					</select>
				</div>
				<div class="form-group">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_eve_tik_sh')</label>
					<select class="form-control form-textbox k-state" name="ticket_status[]">
						<option value="1">@lang('words.cre_eve_page.tik_dro_tas_hi')</option>
						<option value="0" selected>@lang('words.cre_eve_page.tik_dro_tas_sh')</option>
					</select>
				</div>
				<div class="form-group servicesfee">
					<label class="text-uppercase label-text">@lang('words.cre_eve_page.tik_fee_tik_ss')</label>
					<select class="form-control form-textbox select_fee k-state" name="ticket_services_fee[]">
						<option value="1">@lang('words.cre_eve_page.tik_fee_tik_fe')</option>
						<option value="0">@lang('words.cre_eve_page.tik_fee_tik_ab')</option>
					</select>
					<span class="form-note tfees" id="tfees">@lang('words.cre_eve_page.tik_fes_tik_ss') : {{ use_currency()->symbol }} <strong id="fee">0</strong>@lang('words.cre_eve_page.tik_box_txt_bt') |  : {{ use_currency()->symbol }} <strong id="buyertotal">0</strong>  </span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- ********************************** -->
	<!-- ***** ADD ORGANIZATION MODEL ***** -->
	<div id="orgModal" class="modal fade" role="dialog">
		<div class="modal-dialog ">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Créer un organisateur</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				{!! Form::open(['route'=>'org.insert','method'=>'post','id'=>'formorg']) !!}
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<label class="text-uppercase label-text">@lang('words.create_org.org_name') :</label><br/>
								<input type="text" name="organizer_name" class="form-control form-textbox" id="org_name" value="{{ Input::old('organizer_name') }}" >
								<span id="org_error" class="error"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-lg-3 col-md-3 col-sm-3">
						<input type="submit" class="btn btn-default pro-choose-file orgsubmit mt-0" value="Valider" />
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<button type="button" class="btn btn-default pro-choose-file mt-0" data-dismiss="modal">Fermer</button>
					</div>
				</div>
				{!! Form::close()!!}
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<!-- ***** ADD ORGANIZATION MODEL ***** -->
	<!-- ********************************** -->
	<script type="text/javascript">
		/* ========================================= */
	/* FROM VALADTION */
	/* ========================================= */

	/* ========================================= */
	/* FROM VALADTION */
	/* ========================================= */

	/* ========================================= */
	/* FROM VALADTION */
	/* ========================================= */
	</script>

@endsection