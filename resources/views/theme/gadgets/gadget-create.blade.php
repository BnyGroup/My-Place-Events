@extends($theme)
@section('meta_title',setMetaData()->e_create_title )
@section('meta_description',setMetaData()->e_create_desc)
@section('meta_keywords',setMetaData()->e_create_keyword)

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />



@section('content')
	<div class="container-fluid about-wrapper-two">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
					<h2 class="text-uppercase about-title">@lang('words.cre_gad_page.cre_pg_tit')</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row page-main-contain boxed-box">

			<section class="secondary-bg alert-commision">
				@lang('words.cre_gad_page.cre_fm_tit_text').
			</section>

			<div class="col-md-12">
				@if($error = Session::get('error'))
					<div class="alert alert-danger">
						{{ $error }}
					</div>
				@elseif($success = Session::get('success'))
					<div class="alert alert-success">
						{{ $success }}
					</div>
				@endif

				{!! Form::open(['method'=>'post','route'=>'shop_item.store', 'id'=>'eventForm', 'files'=>'true']) !!}

				<h2 class="profile-title profile-title-text page-header">@lang('words.cre_gad_page.cre_ev_detils')</h2>
				<br/>

				<div class="row">
					
					<!-- Select Event -->
						<div class="col-lg-12 col-md-12 col-sm-12 form-group" style="margin-bottom:20px;">
							<label class="label-text">@lang('words.cre_gad_page.cre_fm_even') <span class="text-danger">*</span></label>
							<select class="form-control form-textbox k-state select2 select2-hidden-accessible" name="event_id" style="width: 100%;" tabindex="-1" required>
										@foreach ($events as $event)
										<option value="{{ $event->id }}" @if(Input::old('event_id') == $event->id) selected="selected" @endif >{{ $event->event_name }} </option>
									@endforeach
									</select>
							@if($errors->has('event_id')) <span class="error">{{ $errors->first('event_id') }}</span> @endif
						</div>
					<!-- Fin Select Event -->
					

					<!-- Name start -->
					<div class="col-lg-12 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_gad_page.cre_fm_title') <span class="text-danger">*</span></label>
						<input type="text" name="item_name" id="event_name" class="form-control form-textbox" value="{{ Input::old('item_name') }}" required/>
						@if($errors->has('item_name')) <span class="error">{{ $errors->first('item_name') }}</span> @endif
					</div>
					<!-- Name end -->

					<!-- Maps start -->
					<div class="col-lg-12 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_gad_page.cre_fm_loca') <span class="text-danger">*</span></label>
						<input type="text" name="item_location" placeholder="Localisation" class="form-control form-textbox" id="create_events" value="{{ Input::old('item_location') }}" required />

						@if($errors->has('item_location')) <span class="error">{{ $errors->first('item_location') }}</span> @endif
						<span class="form-note"> <input type="checkbox" value="1" {{ (! empty(Input::old('map_display')) ? '' : 'checked') }} name="map_display" class="form-textbox">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</span>

					</div>

					<div class="col-lg-12 col-sm-12 col-md-12 form-group">
						<label class="label-text">MAP</label>
						<input type="hidden" name="item_latitude" id="latbox">
						<input type="hidden" name="item_longitude" id="lngbox">
						<div id="map" style="height: 400px;border:1px solid #F16334;"></div>
					</div>
					<!-- Maps end -->

					<!-- START DATE AND TIME -->
					<div class="col-lg-6 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_sdate')<span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1" value="{{ Input::old('start_date') }}" required data-toggle="datetimepicker" data-target=".datetimepicker1"/>
						@if($errors->has('start_date')) <span class="error">{{ $errors->first('start_date') }}</span> @endif
					</div>
					<div class="col-lg-6 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_stime')<span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="start_time" class="form-control form-textbox datetimepicker-input time-1" value="{{ Input::old('start_time') }}" required id="timepicker_start_time"/>
						@if($errors->has('start_time')) <span class="error">{{ $errors->first('start_time') }}</span> @endif
					</div>
					<!-- END DATE AND TIME -->

					<div class="col-lg-6 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_edate') <span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2" value="{{ Input::old('end_date') }}" required data-toggle="datetimepicker" data-target=".datetimepicker2"/>
						@if($errors->has('end_date')) <span class="error">{{ $errors->first('end_date') }}</span> @endif
					</div>
					<div class="col-lg-6 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_etime')<span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="end_time"  class="form-control form-textbox datetimepicker-input time-2"  value="{{ Input::old('end_time') }}" required class="timepicker" id="timepicker_endtime"/>
						@if($errors->has('end_time')) <span class="error">{{ $errors->first('end_time') }}</span> @endif
					</div>
					<!-- ------------------- -->
					<!-- START DATE AND TIME -->

					<!-- Image start -->
					<div class="col-lg-12 col-sm-12 col-md-12 form-group" >
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_img1') <span class="text-danger">*</span></label>
						<div class="form-textbox" style="padding-left: 0;" align="center">
							<img src="{{asset('/img/default-img-icon.jpg')}}" id="ingOup" class="required img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 150px;" />
							<input type="file" name="item1_image" id="imgInp"  style="display: none;" accept="image/x-png,image/gif,image/jpg" required=""/><br /><br />
							<span> <i class="fa fa-exclamation-triangle"></i> @lang('words.cre_eve_page.cre_fm_img_text')</span>
						</div>
						@if($errors->has('item1_image')) <span class="error">{{ $errors->first('item1_image') }}</span> @endif
					</div>
					<!-- Image end -->

					<!-- Description start -->
					<div class="col-lg-12 col-sm-12 col-md-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_desc') <span class="text-danger">*</span></label>
						<textarea name="item_description" id="event_description" class="summernote form-control" required="">{{ Input::old('item_description') }}</textarea>
						@if($errors->has('item_description')) <span class="error">{{ $errors->first('item_description') }}</span> @endif
					</div>
					<!-- Description end -->

					<!-- Select Pays -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_ctry') <span class="text-danger">*</span></label>
						<select class="form-control form-textbox k-state" name="item_country" id="event_country">
						@foreach ($pays as $paysLists)
								<option value="{{ $paysLists['nom_pays'] }}" @if(Input::old('nom_pays') == $paysLists['id']) selected="selected" @endif >{{ $paysLists['nom_pays'] }} </option>
						@endforeach
							<!-- Une liste d'option de pays existants -->
						</select>
						@if($errors->has('item_country')) <span class="error">{{ $errors->first('item_country') }}</span> @endif
					</div>
					<!-- Fin Select Pays -->

					<!-- Refund Start -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group" style="display: none">
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label class="label-text">Refund Policy</label>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group" >
							<input type="radio" name="refund" class="refund" id="refund1" value="0">
							<label data-error="wrong" data-success="right" for="form29"><strong>1 Jour: </strong>{{--Attendees can receive refunds up to 1 day before event start date.--}}
								Les participants peuvent recevoir un remboursement jusqu'à 1 jour avant la date de début de l'événement.</label>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<input type="radio" name="refund" class="refund" id="refund2" value="1">
						<label data-error="wrong" data-success="right" for="form29"><strong>7 Jours: </strong>{{--Attendees can receive refunds up to 7 days before event start date.--}}
							Les participants peuvent recevoir un remboursement jusqu'à 7 jours avant la date de début de l'événement.</label>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<input type="radio" name="refund" class="refund" id="refund3" value="2">
						<label data-error="wrong" data-success="right" for="form29"><strong>30 Jours: </strong>{{--Attendees can receive refunds up to 30 days before event start date.--}}
							Les participants peuvent recevoir un remboursement jusqu'à 30 jours avant la date de début de l'événement.</label>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group" >
							<input type="radio" name="refund" class="refund" id="refund4" value="3" checked>
							<label data-error="wrong" data-success="right" for="form29"><strong>{{--No refunds:--}}Pas de remboursement: </strong>{{--No refunds at any time.--}}Aucun remboursement à tout moment.</label>
						</div>
					</div>
					<!-- Refund End-->

					<!-- Categories start -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_cat') <span class="text-danger">*</span></label>
						<select class="form-control form-textbox k-state" name="item_category" id="event_category">
							<option value="">@lang('words.cre_eve_page.cre_fm_cap')</option>
							@foreach ($categories as $key => $values)

								@if($values->children->isEmpty())
								<option value="{!! $values['id'] !!}" @if(Input::old('item_category') ==  $values['id']) selected="selected" @endif >{!! $values->category_name !!}</option>
								@else
									@foreach ($values->children as $value)
									<option value="{!! $value['id'] !!}" @if(Input::old('item_category') ==  $value['id']) selected="selected" @endif >
										{!! $value->category_name !!}
									</option>
									@endforeach
								@endif

							@endforeach
						</select>
						@if($errors->has('item_category')) <span class="error">{{ $errors->first('item_category') }}</span> @endif
					</div>
					<!-- Categorie end -->

					<!-- Variant start -->
					<div class="col-lg-12 col-sm-12 col-md-12">
						<label class="label-text">@lang('words.cre_gad_page.cre_fm_variant')</label>
						<div class="radio">
							<input type="radio" id="radio1" value="0" name="radio-group" class="event-status" {{ Input::old('radio-group') == 0? 'checked':'' }}>
							<label for="radio1">@lang('words.cre_gad_page.cre_fm_no')</label>
							<input type="radio" id="radio2" value="1" name="radio-group" class="event-status" {{ Input::old('radio-group') == 1 ?'checked':'' }}>
							<label for="radio2">@lang('words.cre_gad_page.cre_fm_yes')</label>
						</div>
					</div>

					<div id="status-box" class="col-lg-12 col-sm-12 col-md-12 form-group" style="display:{{ Input::old('radio-group') == 1?'block':'none'}}">
						<div class="row">
							<div class="col-md-6"> 
								<select name="item_size[]" id="choices-multiple-remove-button1" multiple placeholder="Choisir les tailles disponibles">
									@foreach ($sizes as $size)
											<option @if(Input::old('name') == $size['id']) selected="selected" @endif value="{{ $size['code'] }}" >{{ $size['name'] }} </option>
									@endforeach
								</select> 
							</div>
							<div class="col-md-6"> 
								<select name="item_color[]" id="choices-multiple-remove-button2" multiple placeholder="Choisir les couleurs disponibles">
									@foreach ($colors as $color)
											<option @if(Input::old('name') == $color['id']) selected="selected" @endif value="{{ $color['code'] }}" >{{ $color['name'] }} </option>
									@endforeach
								</select> 
							</div>
						</div>
					</div>
					<!-- Variant end -->

					<!-- Organisateur details start -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="label-text"> @lang('words.cre_eve_page.cre_fm_org') <span class="text-danger">*</span></label>
						{{--@if(count($datas) < 10)--}}
							<span class="form-note">@lang('words.cre_eve_page.cre_fm_ify') &nbsp; &nbsp;
								<a data-toggle="modal" data-target="#orgModal" href="javascript:void()"><i class="fa fa-plus"></i> @lang('words.cre_eve_page.cre_fm_ane')</a></span>
						{{--@endif--}}
						<select class="form-control form-textbox k-state" name="item_org_name" id="eventorg">
							<option value="">@lang('words.cre_eve_page.cre_fm_anp')</option>
							@foreach($listorg as $org)
								<option value="{!! $org['id'] !!}" @if(Input::old('item_org_name') == $org['id']) selected="selected" @endif >{!! $org['organizer_name'] !!}</option>
							@endforeach
						</select>
						@if($errors->has('item_org_name')) <span class="error">{{ $errors->first('item_org_name') }}</span> @endif
					</div>
					<!-- Organisateur details end -->
				</div>

				
				<br>
				<h2 class="profile-title profile-title-text page-header">@lang('words.cre_gad_page.eve_tik_cre_tit')</h2><br>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<input type="hidden" name="tickets_commission" id="commission" value="{{ event_commission() }}" />
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<a href="javascript:void(0);" data-type="paid" class="add_tickets pro-choose-file" >@lang('words.cre_eve_page.eve_tik_pai_btn')</a>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<a href="javascript:void(0);" data-type="free" class="add_tickets pro-choose-file free-ticket" >@lang('words.cre_eve_page.eve_tik_fre_btn')</a>
							</div>
						</div>
					</div>
					<div id="tickets" class="col-lg-12 col-md-12 col-sm-12"></div>
				</div>
				

				<br>
				<h2 class="profile-title profile-title-text page-header">@lang('words.cre_gad_page.add_seeting_tit') </h2><br>
				<div class="row">
					<!-- FAcebook start -->
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="label-text"> @lang('words.cre_gad_page.add_seeting_fb')</label>
						<input type="text" name="item_facebook" class="form-control form-textbox" />
						@if($errors->has('item_facebook')) <span class="error">{{ $errors->first('item_facebook') }}</span> @endif
					</div>
					<!-- Facebook end -->
						<div class="col-lg-12 form-group" align="center">
							<input type="Submit" value="@lang('words.cre_gad_page.add_seeting_btn')" class="pro-choose-file" />
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