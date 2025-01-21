@extends($theme)
@section('meta_title',setMetaData()->e_create_title )
@section('meta_description',setMetaData()->e_create_desc)
@section('meta_keywords',setMetaData()->e_create_keyword)


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css" rel="stylesheet">

@section('content')
<style>
	.footer-1{
		display: none;
	}
.hidden{
display:none;
}
@media screen and (max-width: 600px){	
	
	.previewBox{
		padding-top:0px !important;
	    position: fixed;
    	top: 100px;
		visibility: hidden;
		z-index: 999
	}
	.previewBox .hover{
		position: relative !important
	}
	.previewBox .hover .box{
		 width: 330px !important;
	}
	.previewBox .hover .box .bunique {
    	padding-top: 310px !important;
	}
	
	.previewBox .hover .box #edate1{
		width: 42% !important
	}
	.previewBox .hover .box #edate2{
		width: 41% !important
	}	
	
	.previewthebox{
		display: block !important;
		position: fixed;
		top: 130px !important;
		right: 33px !important;
		left: unset !important;
		z-index: 9991 !important;	
		border-radius: 50%;
		background-color: #000d8c;
    	padding: 9px;
	}
	.previewthebox i{
		color: #FFFFFF; font-size: 16px;
	}
	
	.maskbox{
	  position: fixed;
	  top: 0;
	  bottom: 0;
	  left: 0;
	  right: 0;
	  background: rgba(0, 0, 0, 0.6);
	  transition: opacity 200ms;
		z-index: 9
	}
	
}	
</style>	
 

	{!! Form::open(['method'=>'post','route'=>'events.store', 'id'=>'eventForm', 'files'=>'true']) !!}


	<div class="previewthebox" style="display: none;">
      <a href="javascript:void(0)" id="searchButton"><i class="fa fa-eye" aria-hidden="true"></i></a>
    </div>
	<div class="container" style="margin-bottom: 80px">
		 <div class="row">
			<section class="topBan-ce alert-commision" style="margin-top: 15px;">
				@php $exemple = 10000  @endphp
				@lang('words.cre_eve_page.cre_fm_tit_text').
			</section>		
		</div>
		<div class="row">


			<div class="col-md-5 event-create" style="margin-bottom: 100px">
					<div class="text-center content-title">
					   <h1 style="margin-bottom: 0; font-size: 20px;" class="top-presta contact section-title">Créer un événement</h1>
						<p style="text-align: left; margin-top: 15px; color:#001c96">Développez des opportunités d'affaires en partageant votre savoir-faire au grand public et aux organisateurs d'événements.</p>
					</div>
				@if($error = Session::get('error'))
				<div class="alert alert-danger">
					{{ $error }}
				</div>
				@elseif($success = Session::get('success'))
				<div class="alert alert-success">
					{{ $success }}
				</div>
				@endif
				
				@if($errors->has('event_image')) <span class="error">{{ $errors->first('event_image') }}</span> @endif
				
				
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_title') <span class="text-danger">*</span></label>
					<input type="text" maxlength="60" name="event_name" id="event_name" class="form-control form-textbox" value="{{ Input::old('event_name') }}" required/>
					  <div style="font-size: 10px; padding: 10px 0;"><span id="rchars">50</span> Caractère(s) restant(s)</div>

					@if($errors->has('event_name')) <span class="error">{{ $errors->first('event_name') }}</span> @endif
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_loca') <span class="text-danger">*</span></label>
					<input type="text" name="event_location" placeholder="Localisation" class="form-control form-textbox" id="create_events" value="{{ Input::old('event_location') }}" required />

					{{--<input type="text" name="event_location" placeholder="Location" class="form-control form-textbox" id="header-location" value="{{ Input::old('event_location') }}" required />--}}
					@if($errors->has('event_location')) <span class="error">{{ $errors->first('event_location') }}</span> @endif
					<span class="form-note"> <input type="checkbox" value="1" {{ (! empty(Input::old('map_display')) ? '' : 'checked') }} name="map_display" class="form-textbox">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</span>
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 form-group" style="margin: 20px 0">
					<label class="label-text">MAP </label>
					<input type="hidden" name="event_latitude" id="latbox">
					<input type="hidden" name="event_longitude" id="lngbox">
					<div id="map" style="height: 400px;border:1px solid #F16334;"></div>
				</div>	
				
				<div class="col-lg-12 col-md-12 col-sm-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_cat') <span class="text-danger">*</span></label>
					<select class="form-control form-textbox k-state" name="event_category" id="event_category">
						<option value="">@lang('words.cre_eve_page.cre_fm_cap')</option>
						@foreach ($categories as $key => $values)

							@if($values->children->isEmpty())
							<option value="{!! $values['id'] !!}" @if(Input::old('event_category') ==  $values['id']) selected="selected" @endif >{!! $values->category_name !!}</option>
							@else
								@foreach ($values->children as $value)
								<option value="{!! $value['id'] !!}" @if(Input::old('event_category') ==  $value['id']) selected="selected" @endif >
									{!! $value->category_name !!}
								</option>
								@endforeach
							@endif

						@endforeach
					</select>
					@if($errors->has('event_category')) <span class="error">{{ $errors->first('event_category') }}</span> @endif
				</div>
				<div class="row" style="margin-right: 0px; margin-left: 0px;">
					<div class="col-lg-6 col-sm-12 col-md-12 form-group" style="padding-right: 5px !important;">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_sdate')<span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="start_date" class="form-control form-textbox datetimepickerMain1" value="{{ Input::old('start_date') }}" required data-toggle="datetimepicker" data-target=".datetimepickerMain1"/>
						@if($errors->has('start_date')) <span class="error">{{ $errors->first('start_date') }}</span> @endif
					</div>
					<div class="col-lg-6 col-sm-12 col-md-12 form-group" style="padding-left: 5px !important;">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_stime')<span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="start_time" class="form-control form-textbox time-1" value="{{ Input::old('start_time') }}" required id="timepicker_start_time"/>
						@if($errors->has('start_time')) <span class="error">{{ $errors->first('start_time') }}</span> @endif
					</div>
				</div>	
				<div class="row" style="margin-right: 0px; margin-left: 0px;">
					<!-- END DATE AND TIME -->
					<div class="col-lg-6 col-sm-12 col-md-12 form-group" style="padding-right: 5px !important;">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_edate') <span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepickerMain2" value="{{ Input::old('end_date') }}" required data-toggle="datetimepicker" data-target=".datetimepickerMain2"/>
						@if($errors->has('end_date')) <span class="error">{{ $errors->first('end_date') }}</span> @endif
					</div>
					<div class="col-lg-6 col-sm-12 col-md-12 form-group" style="padding-left: 5px !important;">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_etime')<span class="text-danger">*</span></label>
						<input type="text" autocomplete="off" name="end_time"  class="form-control form-textbox datetimepicker-input timepicker time-2"  value="{{ Input::old('end_time') }}" required id="timepicker_endtime"/>
						@if($errors->has('end_time')) <span class="error">{{ $errors->first('end_time') }}</span> @endif
					</div>
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 form-group">
					<label class="label-text">@lang('words.cre_eve_page.cre_fm_desc') <span class="text-danger">*</span></label>
					<textarea name="event_description" id="event_description" class="summernote form-control" required="">{{ Input::old('event_description') }}</textarea>
					@if($errors->has('event_description')) <span class="error">{{ $errors->first('event_description') }}</span> @endif
				</div>
				<!-- Select Pays -->
				 <div class="col-lg-12 col-md-12 col-sm-12 form-group" style="margin: 10px 0">
						<label class="label-text">@lang('words.cre_eve_page.cre_fm_ctry') <span class="text-danger">*</span></label>
						<select class="form-control form-textbox k-state" name="event_country" id="event_country">
						@foreach ($pays as $paysLists)
								<option id="<?php echo $paysLists['id_pays']; ?>" <?php 
									if(Input::old('nom_pays')){ if(Input::old('nom_pays') == $paysLists['id_pays']){ echo 'selected="selected"'; } }
									else if($paysLists['id_pays']==10){
										echo 'selected="selected"';
									} ?> 
									>{{ $paysLists['nom_pays'] }} </option>
						@endforeach
							<!-- Une liste d'option de pays existants -->
						</select>
						@if($errors->has('event_country')) <span class="error">{{ $errors->first('event_country') }}</span> @endif
				  </div>
				  <!-- Fin Select Pays -->
				
				
					<div class="col-lg-12 col-sm-12 col-md-12 form-group" style="margin: 20px 0">
						<div class="row">
							<div class="col-lg-12" style="margin: 5px 0">
								<label class="label-text">@lang('words.cre_eve_page.cre_fm_statu')</label>
								<div class="radio">
									<input type="radio" id="radio1" value="0" name="radio-group" class="event-status" {{ Input::old('radio-group') == 0? 'checked':'' }}>
									<label for="radio1">Public</label>
									<input type="radio" id="radio2" value="1" name="radio-group" class="event-status" {{ Input::old('radio-group') == 1 ?'checked':'' }}>
									<label for="radio2">{{--Private--}}@lang('words.cre_eve_page.cre_fm_priv')</label>
								</div>
							</div>
							<div class="col-lg-12" style="margin: 5px 0">
								<label class="label-text">Programmer une date de fermeture de la billeterie</label>
								<input type="text" autocomplete="off" name="eventEndDateBillet" id="timepicker_eventEndDateBillet" class="form-control form-textbox datetimepicker-input datetimepicker3"  value="{{ Input::old('eventEndDateBillet') }}" data-toggle="datetimepicker" data-target=".datetimepicker3"/>
							</div>
							<div class="col-lg-12" style="margin: 10px 0">
								<label class="label-text">Heure de fermeture de la billeterie</label>
								<input type="text" autocomplete="off" name="eventEndTimeBillet"  class="form-control form-textbox datetimepicker-input time-2 timepicker"  value="{{ Input::old('eventEndTimeBillet') }}" id="eventEndTimeBillet"/>
							</div>
						</div>
					</div>
				
					<div id="status-box" class="col-lg-12 col-sm-12 col-md-12 form-group" style="display:{{ Input::old('radio-group') == 1?'block':'none'}}">
							<div class="row">
								<div class="col-lg-4">
									<input type="text" name="event_code" class="form-control form-textbox" value="{{Input::old('event_code')}}" placeholder="Event Code" id="ecode">
									@if($errors->has('event_code')) <span class="error">{{ $errors->first('event_code') }}</span> @endif
								</div>
								<div class="col-lg-4">
									<input type="text" name="confirm_event_code" class="form-control form-textbox" value="{{Input::old('confirm_event_code')}}" placeholder="Confirm event code" id="cecode">
									@if($errors->has('confirm_event_code')) <span class="error">{{ $errors->first('confirm_event_code') }}</span> @endif
								</div>
							</div>
						</div>
					<div class="col-lg-12 col-md-12 col-sm-12 form-group">
						<label class="label-text"> @lang('words.cre_eve_page.cre_fm_org') <span class="text-danger">*</span></label>
						 <div class="row" style="margin: 0px;">
							<div class="col-lg-11 leftOrg">
								<select class="form-control form-textbox k-state" name="event_org_name" id="eventorg">
									<option value="">@lang('words.cre_eve_page.cre_fm_anp')</option>
									@foreach($listorg as $org)
										<option value="{!! $org['id'] !!}" @if(Input::old('event_org_name') == $org['id']) selected="selected" @endif >{!! $org['organizer_name'] !!}</option>
									@endforeach
								</select>
							</div> 
							<div class="col-lg-1 rightOrg"><a href="javascript:void(0)" id="openOrg"><i class="fa fa-plus-square" aria-hidden="true" style="font-size: 53px; color: #d600a9"></i></a></div>
							@if($errors->has('event_org_name')) <span class="error">{{ $errors->first('event_org_name') }}</span> @endif
						</div>
					</div>
<style>
	
.leftOrg{
	padding-left: 0px !important;
	padding-right: 0px !important;
	-ms-flex: 0 0 87% !important;
	flex: 0 0 87% !important;
	max-width: 87% !important;
}
.rightOrg{
    padding-right: 0px !important;
    -ms-flex: 0 0 13% !important;
    flex: 0 0 13% !important;
    max-width: 13% !important;
}
</style>	
 
				<div class="col-md-12">

					<div class="row">

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
								<label data-error="wrong" data-success="right" for="form29"><strong>Pas de remboursement: </strong>Aucun remboursement à tout moment.</label>
							</div>
						</div>
 
					</div>

					<br>
					<h2 class="profile-title profile-title-text page-header">@lang('words.cre_eve_page.eve_tik_cre_tit')</h2><br>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label class="">@lang('words.cre_eve_page.eve_tik_cre_tag')</label>
							<input type="hidden" name="tickets_commission" id="commission" value="{{ event_commission() }}" />
							<p class="alert alert-info"  >
								<b>@lang('words.cre_eve_page.cre_fm_Btext')</b>
							</p>
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
					@if($errors->has('ticket_title')) <span class="error">{{ $errors->first('ticket_title') }}</span> @endif
					<h2 class="profile-title profile-title-text page-header">@lang('words.cre_eve_page.add_seeting_tit') </h2><br>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label class="label-text"> @lang('words.cre_eve_page.add_seeting_fb')</label>
							<input type="text" name="event_facebook" class="form-control form-textbox" />
							@if($errors->has('event_facebook')) <span class="error">{{ $errors->first('event_facebook') }}</span> @endif
						</div>
						<!-- commnt -->
						{{--<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label class="label-text"> @lang('words.cre_eve_page.add_seeting_twi')</label>
							<input type="text" name="evetn_twitter" class="form-control form-textbox" />
							@if($errors->has('evetn_twitter')) <span class="error">{{ $errors->first('evetn_twitter') }}</span> @endif
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label class="label-text"> @lang('words.cre_eve_page.add_seeting_int')</label>
							<input type="text" name="event_instagaram" class="form-control form-textbox" />
							@if($errors->has('event_instagaram')) <span class="error">{{ $errors->first('event_instagaram') }}</span> @endif
						</div>--}}
						<!-- commnt -->
							<div class="col-lg-8 col-md-8 form-group">
								<label class=" label-text">@lang('words.cre_eve_page.add_seeting_pub') </label>
								<div class="toggal-switch" align="center">
									<input name="event_status" {{--value="1"--}}value="1" data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_iub')" data-off="@lang('words.cre_eve_page.add_seeting_dra')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox" checked="">
								</div>
							</div>
							{{--<div class="col-lg-4 col-md-4 form-group">--}}
								{{--<label class="label-text"> @lang('words.cre_eve_page.add_seeting_rea')</label>--}}
								{{--<div class="toggal-switch">--}}
									{{--<input name="event_remaining" value="1" {{ (! empty(Input::old('event_remaining')) ? 'checked' : '') }} data-toggle="toggle" data-on="@lang('words.cre_eve_page.add_seeting_yes')" data-off="@lang('words.cre_eve_page.add_seeting_not')" data-onstyle="togal-success" data-offstyle="togal-danger" type="checkbox">--}}

								{{--</div>--}}
							{{--</div>--}}
							{{--<div class="col-lg-12">--}}
								{{--@lang('words.cre_eve_page.add_seeting_sho')--}}
							{{--</div>--}}
							<div class="col-lg-12 form-group" align="center">
								<input type="Submit" value="@lang('words.cre_eve_page.add_seeting_btn')" class="submitme pro-choose-file" />
							</div>

					</div>
				</div>
		 			
				
			</div>
			<div class="col-md-7 previewBox">
				

					<div class="hover" style="position: fixed;">
            
							<div class="box" style="position: relative; height: 550px; width: 427px">
								
								<input type="file" name="event_image" id="imgCreate" style="display: none;" accept="image/x-png,image/gif,image/jpg,image/jpeg" required=""/>
								<a href="javascript:void(0)" onclick="document.getElementById('imgCreate').click();"><div class="bunique" id="ingOup" style="background-color: #d5d6e3; background: url('{{ url('/') }}/public/img/icoph.png'); background-position: center "></div></a>

								<div class="box-content card__padding">
									<div class="innercardbox">

										<div class="left_innerbox">
											<h4 class="card-title"><a href="javascript:void(0)"></a></h4>
											<div class="prix">
												<a href="javascript:void(0)" class=""><span class=""></span></a>
											</div> 
											<div class="card__location">
												<div class="card__location-content">
													<i class="fas fa-map-marker-alt primary-color"></i>
													<a href="" rel="tag" class="third-color bold"></a>
												</div>
											</div>
										</div>

										<div class="right_innerbox"> 
                    
											<div class="badge category col-sm-4 col-sm-offset-1" style="cursor: default">
												  <span class="">
												   Catégorie
												  </span>
											</div>   
											<div class="datexp">
												   
													<div id="edate1" style="float: left; width: 43%">
														<table cellpadding="0" cellspacing="0" border="0">                                   
															<tbody>
																 <tr><td id="jour" style="text-align: center">&nbsp;</td></tr>
																 <tr class="secdatexp"><td id="journ" style="text-align: center">&nbsp;</td></tr>
																 <tr><td id="mois" style="text-align: center">&nbsp;</td></tr>
																 <tr><td id="an" style="text-align: center">&nbsp;</td></tr>
                                    						</tbody>
														</table>                              
													</div>    
													<div class="sepa"><span class="separator">-</span></div>
													<div id="edate2" style="float: right; width: 43%">

														<table cellpadding="0" cellspacing="0" border="0">                                   
															<tbody>
																 <tr><td id="jour" style="text-align: center">&nbsp;</td></tr>
																 <tr class="secdatexp"><td id="journ" style="text-align: center">&nbsp;</td></tr>
																 <tr><td id="mois" style="text-align: center">&nbsp;</td></tr>
																 <tr><td id="an" style="text-align: center">&nbsp;</td></tr>
                                    						</tbody>
														</table>     

													</div>

											</div>

										</div>  

								   </div>
									<div style="clear:both;"></div>
								</div>
							</div>

						</div>
 		 		
				
			
			</div>
		</div>
				
						

	</div>
	<div class="maskbox" style="display: none"></div>	
	{!! Form::close() !!}

<style>
	.submitme.pro-choose-file{
		border-radius: 35px;
		width: 60%
	}

</style>


  

@endsection

@section('pageScript')
	<script type="text/javascript">
		$(document).ready(function(){

		$('#eventEndTimeBillet').mdtimepicker({format: 'hh:mm'}); 	

		$('#timepicker_endtime').mdtimepicker({format: 'hh:mm'}); //Initializes the time picker and uses the specified format (i.e. 23:30) 
		$('#timepicker_start_time').mdtimepicker({format: 'hh:mm'}); //Initializes the time picker and uses the specified format (i.e. 23:30)
		$('.event-status').change(function(){
			if($(this).val() == 1) {
				$('#status-box').show();
			}else{
				$('#status-box').hide();
			}
		});

		$('#eventForm').validate({
			rules: {
				// ticket_title[] : 'required',
				// ticket_qty[]: 'required',
				event_name : 'required',
				event_org_name : 'required',
				location : 'required',
				event_start_datetime : {
					required : true,
					date: true,
				},
				event_end_datetime : {
					required : true,
					date: true,
				},
				event_category : 'required',
				event_description : {
					required  : true,
					minlength  : 15,
				},
				/* event_address : {
				required : true,
				minlength : 5,
				},*/
				event_country : {
					required : true,
				},
				event_image : 'required',
				ticket_price : {
					required : true,
					min:1
				},
			},


			messages : {
				// ticket_title[] : 'Ce champ est requis.',
				// ticket_qty[] : 'Ce champ est requis.',
				event_name : "Le nom de l'événement est obligatoire, veuillez le saisir",
				event_org_name : "Un organisateur est requis. Veuillez en sélectionner un.",
				location : "Le lieu de l'événement requis",
				event_start_datetime: {
					required : "La date de début de l'événement est requise",
					date: "Veuillez entrer une date valide",
				},
				event_category : "La catégorie d'événement est obligatoire",
				event_end_datetime: {
					required : "La date de fin de l'événement est requise",
					date: "Veuillez entrer une date valide",
				},
				event_description : {
					required : "La description de l'événement est obligatoire",
					minlength : "Description requise minimum 15 caractères",
				},
				/*event_address : {
				required : "Enter event address",
				minlength : "Please enter at least 5 characters",
				},*/
				event_country : {
					required : "Entrez le pays de l'événement",
				},
				event_image : "Une image de l'événement est requise",
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
			<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" id=ticket_price placeholder="@lang('words.cre_eve_page.tik_box_txt_pr')" id="montantFcfa"  onchange="convertirEnEuro()" />
		</span>
		<span class="tpd">
			<label class="ticket-label">{{--Ticket Price--}} Prix du Ticket</label>
			<input type="text" name="ticket_price_actual[]" class="form-control form-textbox ticket-price" value="@lang('words.cre_eve_page.tik_fes_tik_dn')" readonly="" required/>
		</span>

		<div class="addeventtickets" style="border-radius: 10px">
			<div class="col-md-12 form-group">
				<label class="ticket-label">{{--Ticket Name--}}Nom du Ticket</label>
				<input type="text" name="ticket_title[]" maxlength="30" class="form-control ticket_title form-textbox required" placeholder="@lang('words.cre_eve_page.tik_box_txt_nm')" required/>
				<div style="font-size: 10px; padding: 10px 0;"><span id="rcharstitle" class="rcharstitle">30</span> Caractère(s) restant(s)</div>
			</div>
			<div class="col-md-3 form-group" style="margin-left: 0px">
				<label class="ticket-label">{{--Ticket Qty--}}Nbre de Ticket</label>
				<input type="text" name="ticket_qty[]" class="form-control form-textbox" placeholder="@lang('words.cre_eve_page.tik_box_txt_ty')" required/>
			</div>
			<div class="col-md-5 form-group tpfg">
				<span class="ticketpricttxt"></span>
				<span class="form-note bfees" id="bfees">@lang('words.cre_eve_page.tik_box_txt_bt') : <strong>00.00</strong> {{ use_currency()->symbol }}</span><br>
			</div>

			<div class="col-md-3 ticket-select-btn" style="margin-right: 0px">
				<a type="button" class="text-muted setting" style="line-height: 36px;"><i class="fa fa-cog"></i></a> | <a type="button" class="text-danger remove" style="line-height: 36px;"><i class="fa fa-times"></i></a> | <a type="button" class="addFields"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>

			</div>
			<div class="clearfix"></div>

			<div class="col-md-12 formFields" style="display:none">
				<div style="display: block"><a type="button" class="newfield"><i class="fa fa-plus-square" aria-hidden="true"></i> Ajouter un nouveau champ</a></div>
				
				<div class="fieldBlock" style="display: none">
					<input type="hidden" name="nbvalue[0]" class="nbvalue" value="0">
					<div class="form-group" style="width:48%; float:left">
						<label class="text-uppercase label-text">Type de champ</label>
						<select name="filed_type[0][]" class="form-control selectfiledtype form-textbox">
							<option value="">Sélectionner un type de champ</option>
							<option value="text">Texte</option>
							<option value="list">Liste</option>
							<option value="checkbox">Case à cocher</option>
							<?php /*?><option value="teaxtarea">Texte multiligne</option><?php */?>
						</select>
					</div>

					<div class="form-group" style="width:48%; float:right">
						<label class="text-uppercase label-text">Titre du champ</label>
						<input type="text" name="field_title[0][]" class="form-control fieldtitle form-textbox">					
					</div>
					<div class="form-group addoptions hidden">
						<label class="text-uppercase label-text">Valeurs du champ</label>
						<div class="morelines"><a type="button" class="removevalue"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
							<input type="text" name="value[0][0][0]" class="form-control values form-textbox"> 
							<a type="button" class="duplicatevalue"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
						</div>
					</div>
					
				</div>

			</div>
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
						<option value="2">Fermer le ticket</option>
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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.js"></script>



	<script type="text/javascript">
		$val1 = $(function () {
			$('#color1')
			.colorpicker({})
					.on('colorpickerChange', function (e) { //change the bacground color of the main when the color changes
				new_color = e.color.toString()
							$('#color1').css('background-color', new_color)
			})
		});
		
		$(document).ready(function() {
			
			$('#openOrg').on("click", function(){
				$('#orgModal').modal('show');
			});
			
			
			$('.datetimepickerMain1').datetimepicker({
				useCurrent: false,
				language: 'fr-FR',
				//format: 'MM/DD/YYYY',
				format: 'DD/MM/YYYY',
				minDate:new Date() 
			});
			
			$(".datetimepickerMain1").on("change.datetimepicker", function () {
				   var mdate=$(this).val(); 
				
				   var vals = mdate.split('/');
				   var year = vals[2];
				   var month = vals[1];
				   var day = vals[0];
					
					if(month<10){ month=parseInt(month); }
				
				   var d=new Date(year+"-"+month+"-"+day);
				   
				   var jour=['Dimanche', 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
				   var mois=['','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
				   $('#edate1 #jour').html(jour[d.getDay()]);
				   $('#edate1 #journ').html(day);
				   $('#edate1 #mois').html(mois[month]);
				   $('#edate1 #an').html(year);
			});			
			
			 
			$('.datetimepickerMain2').datetimepicker({
				useCurrent: false,
				language: 'fr',
				//format: 'MM/DD/YYYY',
				format: 'DD/MM/YYYY',
			});	
			
			$(".datetimepickerMain2").on("change.datetimepicker", function () {
				   var mdate=$(this).val(); 
				
				   var vals = mdate.split('/');
				   var year = vals[2];
				   var month = vals[1];
				   var day = vals[0];
					
				   //if(mdate)
				   if(mdate === $('.datetimepickerMain1').val()){
					   
					   $(".datexp > #edate1").addClass("date-times bold third-color");
					   $(".datexp > #edate1").attr("style"," ");
					   $(".datexp > #edate2").css("display","none");
					   $(".datexp > .sepa").css("display","none");
					   
				   }else{
					   
					   $(".datexp > #edate1").removeClass("date-times bold third-color");
					   $(".datexp > #edate1").attr("style","float: left; width: 43%");
					   $(".datexp > #edate2").css("display","block");
					   $(".datexp > .sepa").css("display","block");
				
					   if(month<10){ month=parseInt(month); }

					   var d=new Date(year+"-"+month+"-"+day);

					   var jour=['Dimanche', 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
					   var mois=['','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
					   $('#edate2 #jour').html(jour[d.getDay()]);
					   $('#edate2 #journ').html(day);
					   $('#edate2 #mois').html(mois[month]);
					   $('#edate2 #an').html(year);
					   
				   }

			});				 
			

		});
		


		$(function () {
			$('#color2').colorpicker({}).on('colorpickerChange', function (e) { //change the bacground color of the main when the color changes
				new_color = e.color.toString()
				$('#color2').css('background-color', new_color)
			});
			

		});
	</script>


	<!-- ***** ADD ORGANIZATION MODEL ***** -->
	<!-- ********************************** -->
	<script type="text/javascript">
		$(document).ready(function(){
			
 			$("#event_name").on("keyup", function(){
				$(".card-title").html($(this).val());
			});
			
			$("#create_events").on("keyup", function(){
				$(".card__location-content a").html($(this).val());
			});
			
			$("#event_category").on("change", function(){
				$(".badge.category span").html($("#event_category option:selected").text());
			});
			$('.previewthebox').on("click", function(){
				//$(".previewBox").toggle();
				if($(".previewBox").css("visibility") == "visible") {
					$(".previewBox").css("visibility","hidden");	
					$('.maskbox').css("display","none")
				}else{					
					/*$([document.documentElement, document.body]).animate({
						scrollTop: 0
					}, 1000);*/
					$(".previewBox").css("visibility","visible");	
					$('.maskbox').css("display","block");				
				}
			});
			
			/*$(".datetimepickerMain1").on( "dp.change", function(e){
				console.log(e.date.toString());
				console.log("+++++++++++++++++++++++") $(".previewthebox").css("visibility","visible");
				var mdate=$(this).val(); 
				alert(mdate);
				$(".datexp").html(mdate);
			});*/
		});
		
		
var maxLength = 60;
$('#event_name').keyup(function() {
  var textlen = maxLength - $(this).val().length;
  $('#rchars').text(textlen);
});
		
var maxLength = 30;
$(document).on('keyup', '.ticket_title', function() { 
  var textlen = maxLength - $(this).val().length;  
  $(this).parent().find('.rcharstitle').text(textlen);
});		
	</script>

@endsection