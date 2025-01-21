@extends($theme)

@section('meta_title',setMetaData()->bking_ticket_title.' - '.$bookingdata->event_name )
@section('meta_description',setMetaData()->bking_ticket_desc)
@section('meta_keywords',setMetaData()->bking_ticket_keyword)

@section('content')
@php
	Jenssegers\Date\Date::setLocale('fr');
	$startdate 	= ucwords(Jenssegers\Date\Date::parse($bookingdata->event_start_datetime)->format('l j F Y'));
	/*$enddate 	= Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('D, F j, Y');
	$starttime	= Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('h:i A');
	$endtime	= Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('h:i A');*/
	$enddate 	= ucwords(Jenssegers\Date\Date::parse($bookingdata->event_end_datetime)->format('l j F Y'));
	$starttime	= Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('H:i');
	$endtime	= Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('H:i');

	$order_t_id		= unserialize($bookingdata->order_t_id);
	$order_t_title 	= unserialize($bookingdata->order_t_title);
	$order_t_price 	= unserialize($bookingdata->order_t_price);
	$order_t_fees 	= unserialize($bookingdata->order_t_fees);
	$order_t_qty 	= unserialize($bookingdata->order_t_qty);
@endphp


<!--Cover-->
<div class="col-md-12 cover-img" style="background-image:url('{{asset('/img/rbg.png')}}'); border-bottom: 8px solid #FEB00A; margin-bottom: 25px; margin-top: 0px; height: 195px; color: #fff; text-align: center">

	<h3 class="text-uppercase about-title" style="color: #FFFFFF; padding-bottom: 15px;">@lang('words.events_booking_page.eve_book_tit')</h3>
	<div class="container countdown">
		<div class="row page-main-contain">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="alert alert-info text-center" style="background: none; color:#FFFFFF; border: none">
					<span id="timer"></span>
					<?php /*?><p>@lang('words.events_booking_page.eve_book_advise1')</p>
					<p>@lang('words.events_booking_page.eve_book_advise2')</p><?php */?>
				</div>
			</div>
		</div>
	</div>

</div>
<!--Cover-->
 
<style>
  
@media screen and (max-width: 600px) {

table { border: 0; }

table caption { font-size: 1.3em; }

table thead { display: none; }

table tr {
  border-bottom: 3px solid #ddd;
  display: block;
  margin-bottom: .625em;
}

table td {
  border-bottom: 1px solid #ddd;
  display: block;
  font-size: .8em;
  text-align: right;
}

table td:before {
  content: attr(data-label);
  float: left;
  font-weight: bold;
  text-transform: uppercase;
}

table td:last-child { border-bottom: 0; }
	
}
	.topcontain .event-image{
		height: 312px; overflow: hidden
	}	
</style>
 
<div class="container topcontain">
	<div class="row">
		<div class="col-lg-4">
			<div class="event-image">
				<img src="{!! getImage($bookingdata->event_image) !!}" class="image">
			</div>
		</div>
		
		<div class="col-lg-4">
			<div class="event-address booking-box htx">
				<h3 class="box-title text-center">DATE & LIEU</h3>
				<div class="box-descroptoin">
					<div class="row address">
						<div class="col-lg-4"><label>@lang('words.events_booking_page.eve_book_addre') :</label></div>
						<div class="col-lg-8"><span>{{ $bookingdata->event_location }}</span></div>
					</div>
					<div class="row date-time">
						<div class="col-lg-4"><label>Date & Heure :</label></div>
						<div class="col-lg-8">
							@if($startdate == $enddate)
							<p>Le {{ $startdate }} de {{ $starttime }} Ã  {{ $endtime }}</p>
							@else
								<p>Du {{ $startdate }} Ã  {{ $starttime }} </p>
								<p>{{--@lang('words.events_booking_page.eve_book_to')--}} Au </p>
								<p> {{ $enddate }} Ã  {{ $endtime }}</p>
							@endif	
						</div>
					</div>
					<div class="row orgby">
						<div class="col-lg-4"><label>Organis&eacute; par :</label></div>
						<div class="col-lg-8"><a href="{{ route('org.detail',$organization->url_slug) }}" target="_blank" >{{ $organization->organizer_name }}</a></div>
 
					</div>
				</div>

			</div>		
		</div>
		
		<div class="col-lg-4">
			 
			<div class="event-address booking-box htx"  style="min-height: 312px;">
				<h3 class="box-title text-center">ACHETEUR DU TICKET</h3>
				<div class="box-descroptoin" style="border-radius: 12px;">
 					<div class="row address">
						<div class="col-lg-4"><label>ID:</label></div>
						<div class="col-lg-8"><span>{{ isset($GuestUserData->guest_id)?$GuestUserData->guest_id:'-' }}</span></div>
					</div>
					<div class="row date-time">
						<div class="col-lg-4"><label>Nom & Pr&eacute;noms :</label></div>
						<div class="col-lg-8">
							{{ isset($GuestUserData->user_name)?$GuestUserData->user_name:'-' }}
						</div>
					</div>
					<div class="row orgby">
						<div class="col-lg-4"><label>Email :</label></div>
						<div class="col-lg-8">{{ isset($GuestUserData->guest_email)?$GuestUserData->guest_email:'-' }}</div>
 
					</div>
 				</div>

			</div>	
		 	
		</div>		
	</div>
</div>


<div class="container mb-5">
	<div class="row">
		<div class="clearfix"></div>
		
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="booking-event">
				  <?php $tfees=0; $subtotal=0; ?>
				<div class="event-address booking-box">
					<h3 class="box-title" style="background-color: #001C96">@lang('words.events_booking_page.eve_book_or_sum')</h3>
					<div class="box-descroptoin">
						<div class="table-responsive">
							<table class="table">
								<thead class="table-head">
									<tr>
										<th>@lang('words.events_booking_page.eve_book_tik_type')</th>
										<th class="text-right">@lang('words.events_booking_page.eve_book_tik_pr')</th>
										<th class="text-right">@lang('words.events_booking_page.eve_book_tik_fee')</th>
										<th class="text-center">@lang('words.events_booking_page.eve_book_tik_qty')</th>
										<th class="text-right">@lang('words.events_booking_page.eve_book_tik_stot')</th>
									</tr>
								</thead>
								<tbody>		
									@if(!empty($order_t_id))
										@foreach($order_t_id as $key => $ticket)	
									<?php
										$tfees=$tfees+floatval($order_t_fees[$key]);
										$subtotal=$subtotal+(floatval($order_t_price[$key]) + floatval($order_t_fees[$key])) * intval($order_t_qty[$key]);
									?>									
										<tr>
											<td width="45%" data-label="@lang('words.events_booking_page.eve_book_tik_type')">{{ $order_t_title[$key] }}</td>
											<td class="text-right" data-label="@lang('words.events_booking_page.eve_book_tik_pr')">{{ number_format($order_t_price[$key],0,',',' ')}} {!! use_currency()->symbol !!}</td>
											<td class="text-right" data-label="@lang('words.events_booking_page.eve_book_tik_fee')">{{ number_format($order_t_fees[$key],0,',',' ') }} {!! use_currency()->symbol !!}</td>
											<td class="text-center" data-label="@lang('words.events_booking_page.eve_book_tik_qty')">{{ $order_t_qty[$key] }}</td>
											<td class="text-right" data-label="@lang('words.events_booking_page.eve_book_tik_stot')">
												<?php $ft=number_format((floatval($order_t_price[$key]) + floatval($order_t_fees[$key])) * intval($order_t_qty[$key]),0,'.',' '); 
												$ft=($ft); echo $ft; ?> {!! use_currency()->symbol !!} 
												 
											</td>
										</tr>
										@endforeach
									@endif
								</tbody>
								<tfoot>
								 <?php 
                                        if(!empty($bookingdata->discount)){
											
											
									 ?>
                                    <tr>
										<th colspan="4" class="text-right">Sous-total</th>
										<th class="text-right">{{ number_format($subtotal,0,',',' ')}}  {!! use_currency()->symbol !!} </th>
									</tr>
                                    <?php		
                                            
                                            if($bookingdata->discount_type=='percentage'){
                                                $txtP=$bookingdata->discount."%";
                                            }else{
                                                $txtP="-".$bookingdata->discount." ".use_currency()->symbol;
                                            }
                                    ?>
                                    <tr>
										<th colspan="4" class="text-right">Remise</th>
										<th class="text-right"><?php echo $txtP ?></th>
									</tr>
                                    <?php } ?>
									<tr>
										<th colspan="4" class="text-right">@lang('words.events_booking_page.eve_book_tik_o_total')</th>
										<th class="text-right">{{ number_format($bookingdata->order_amount,0,'.',' ') }} {!! use_currency()->symbol !!}</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				
				
{!! Form::open(['method'=>'post','route'=>'ticket.payment', 'id'=>'booktickets','onSumit'=>'return checkTP();']) !!}
				<div class="regis-info booking-box">					
					<h3 class="box-title">Informations de facturation</h3>
					<div class="box-descroptoin">
						 
					<p style="padding-left: 15px;font-weight: bold;font-size: 15px;letter-spacing: normal;">Commander sans créer de compte!</p>
						<div class="row">
							<div class="col-lg-4">
	  <div id="result" class="form-group text-center">
			<input id="phone2" type="tel" name="guestUserPhone" value="" placeholder="0700000000" class="tel form-control form-textbox" minlength="10" maxlength="14" required style="width: 100%;margin:0 auto" />
			<span id="valid-msg" class="hide">✓ Valide</span>
			<span id="error-msg" class="hide"></span>
	  </div>
	   <div class="form-group text-center">
		  <input type="text" name="guestuserName" value="" placeholder="Nom & Prénom(s)" class="form-control form-textbox" style="width: 100%;margin:0 auto" required/>
	  </div>
							</div>
							<div class="col-lg-4">
								
	  <div class="form-group text-center">
		  <input type="text" name="guestUserEmail" value="" placeholder="@lang('words.guest_popup.pop_email')" class="form-control form-textbox" style="width: 100%;margin:0 auto" required/>
	  </div>
								
	<div class="form-group text-center">
		  <input type="text" name="confirmguestUserEmail" value="" placeholder="Confirmer adresse email" class="form-control form-textbox" style="width: 100%;margin:0 auto" required/>
	  </div>								
							
							</div> 
							
							<div class="col-lg-4" align="center" style="border-left: 1px solid #D7D7D7; padding-left: 20px">
								Ou <span style="font-weight: bold; font-size: 18px;">pour une meilleure expérience</span>, <br>
								<a href="javascript:void(0)" class="openConnexinBox closeme" title="Se connecter" tabindex="0">Connectez-vous</a>
								 
								<div style="padding-top: 5px;">ou alors <a href="javascript:void(0)" class="openRegisterBox">créez un compte</a></div>

							</div>
							
						</div>						
					</div>
				</div>
				
				
				<div class="ticket-info booking-box">
					<h3 class="box-title">@lang('words.eve_tik_info_tit')</h3>
					<div class="box-descroptoin">
						
 							<input type="hidden" name="event_id" value="{{ $bookingdata->event_id }}">
							<input type="hidden" name="order_id" value="{{ $bookingdata->order_id }}">
						 
							@if(!empty($order_t_id))
								@foreach($order_t_id as $key => $ticket)
									@for($i=1; $i<=$order_t_qty[$key]; $i++)
										<input type="hidden" name="ticket_id[]" value="{{ $ticket }}" />
						<!-- Ticket --- {{ $ticket }} -->
										<div class="form-ticket">
											<h4 class="ticket-title">{{ $order_t_title[$key] }}</h4>
											<p class="ticket-id">({{ $ticket }}-{{ $i }})</p>
											<p align="center"><a href="javascript:void(0)" onClick="customize('tick-{{ $i }}')"> Personnaliser les informations de ce ticket</a></p>
											<div id="tick-{{ $i }}" style="display: none;">
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">@lang('words.events_booking_page.eve_book_reg_nm')</label>
													</div>
													<div class="col-md-9 col-xs-12">
														<input type="text" name="fname_on_ticket[]" id="fname_on_ticket" value="{{ isset($GuestUserData->user_name)?$GuestUserData->user_name:'' }}" class="form-control form-textbox" required/>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">@lang('words.events_booking_page.eve_tik_info_tel')</label>
													</div>
													<div class="col-md-9 col-xs-12">
														<input id="phone3" type="tel" name="ot_cellphone[]" value="{{ isset($GuestUserData->cellphone)?$GuestUserData->cellphone:'' }}" placeholder="+2250000000000" class="tel form-control form-textbox" minlength="11" maxlength="14" pattern="^[0-9+]{14}+$" required/>
														<span id="valid-msg" style="right: 5% !important;" class="hide">✓ Valide</span>
														<span id="error-msg" class="hide"></span>
													</div>
												</div>
											</div>
											
											<?php
												$champ=$bookingdata->moreinfos_field;

												foreach($moTicket as $mtick){
													if($ticket==$mtick->ticket_id){
														$moreFields=$mtick->moreinfos_field;
													}
												}
												
												$Mainchamp=explode("|",$moreFields);
 
												for($z=0;$z<count($Mainchamp);$z++){
													$champ=explode("@",$Mainchamp[$z]);
													$nbc=count($champ);
													$vales=array();
													for($xx=0;$xx<$nbc;$xx++){
														$champx=explode("=",$champ[$xx]);
														if($champx[0]=='values'){
															$vales[]=$champx[1];  
														}
													 } 

													for($xx=0;$xx<$nbc;$xx++){
														$champ2=explode("=",$champ[$xx]);
 													
														if($champ2[0]=='type'){  
															if($champ2[1]=='text'){
																//$champ2
																$ctitle=explode("=",$champ[1]);
																$txtSlug1=str_slug($ctitle[1], '_');
													?>
													<div class="row form-group">
														<div class="col-md-3 col-xs-12">
															<label class="label-text"><?php echo $ctitle[1] ?></label>
														</div>
														<div class="col-md-9 col-xs-12">
															<input type="text" name="<?php echo $txtSlug1; ?>[]" value="" class="form-control form-textbox" required />
														</div>
													</div>
													<?php
															}

															if($champ2[1]=='list'){
																//$champ2
																$ctitle=explode("=",$champ[1]);
																$noption=explode("=",$champ[2]);
																$txtSlug=str_slug($ctitle[1], '_');
													?>
													<div class="row form-group">
														<div class="col-md-3 col-xs-12">
															<label class="label-text"><?php echo $ctitle[1] ?></label>
														</div>
														<div class="col-md-9 col-xs-12">
															<select name="<?php echo $txtSlug; ?>[]" value="" class="form-control form-textbox" required />
															<option value="">S&eacute;leciionnez</option>
																<?php for($v=0;$v<$noption[1];$v++){ ?>
																	<option><?php echo $vales[$v]; ?></option>													
																<?php } ?>
															</select>
														</div>
													</div>
													<?php
															}
															
															
															if($champ2[1]=='checkbox'){
																//$champ2
																$ctitle=explode("=",$champ[1]);
																$noption=explode("=",$champ[2]);
																$txtSlug=str_slug($ctitle[1], '_');
													?>
													<div class="row form-group">
														<div class="col-md-3 col-xs-12">
															<label class="label-text"><?php echo $ctitle[1] ?></label>
														</div>
														<div class="col-md-9 col-xs-12">
															 S&eacute;leciionnez<br>
																<?php for($v=0;$v<$noption[1];$v++){ ?>
																	<input type="hidden" name="<?php echo $txtSlug; ?>[]" value="<?php echo $vales[$v]; ?>" class="form-control form-textbox"> <?php echo $vales[$v]; ?>  						
																<?php } ?>
															 
														</div>
													</div>
													<?php
															}
															

														}
														
													}
												}
											?>
												
											
											
											@if ($bookingdata->event_id == 3513696401)
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">Votre choix d'atelier : </label>
													</div>
													<div class="col-md-9 col-xs-12">
														<select name="choix_atelier[]" class="form-control form-textbox" required>
															<option value="">S&eacute;lectionnez un atelier</option>
															<option>Workshop 1 : Enregistrement live podcast Choose Your Mentor sp&eacute;cial #abidjanaisesintech</option>
															<option>Workshop 2 : Workshop by Tech Republic | De l’id&eacute;e au prototype</option>
															<option>Workshop 3 : Bien-&ecirc;tre des femmes dans la Technologie : D&eacute;mystifier le paradigme de la #WomenInTech (Uniquement r&eacute;serv&eacute; aux femmes)</option>
															<option>Je ne souhaite pas faire d'atelier</option>
														</select>
													</div>
												</div>
											@endif	
											
											{{-- For special event with unique id = 2616775009 --}}
											@if ($bookingdata->event_id == 2616775009)
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">Sexe</label>
													</div>
													<div class="col-md-9 col-xs-12">
														<select name="gender_on_ticket[]" class="form-control form-textbox" required>
															<option value="M">Masculin</option>
															<option value="F">Féminin</option>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">Date de naissance</label>
													</div>
													<div class="col-md-9 col-xs-12">
														<input type="text" autocomplete="off" name="birthd_on_ticket[]" class="form-control form-textbox datetimepicker-input datetimepicker-0{{$i}}" required data-toggle="datetimepicker" data-target=".datetimepicker-0{{$i}}"/>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">Nationalité</label>
													</div>
													<div class="col-md-9 col-xs-12">
														<input type="text" name="nationality_on_ticket[]" class="form-control form-textbox" required/>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-3 col-xs-12">
														<label class="label-text" style="width:100%;">Club</label>
													</div>
													<div class="col-md-9 col-xs-12">
														<input type="text" name="club_on_ticket[]" class="form-control form-textbox" required/>
													</div>
												</div>
												@section('pageScript')
													@parent
													<script type="text/javascript">
														(function($) {
															$(document).ready(function(){
																$('.datetimepicker-input').datetimepicker({
																	viewMode: 'years',
																	locale: 'fr',
																	format: 'DD/MM/YYYY',
																});
															});
														})(jQuery);
													</script>
												@endsection
											@endif
											{{-- End for special event with unique id = 2616775009 --}}
										</div>
						<!-- Fin ticket --- {{ $ticket }} -->
									@endfor
								@endforeach
							@endif
					</div>
				</div>
				<input type="hidden" name="type-pay" id="type-pay" value="">
				<div class="ticket-info booking-box">
					<h3 class="box-title">PAIEMENT</h3>
					<div class="box-descroptoin">
							<div class="form-ticket invoice">
								<div class="create-invoice Custom validated">
									<label class="checkbox toggler-wrapper">
										<input class="form__input form__input-checkbox input-checkbox" id="createinvoice" type="checkbox" name="createinvoice" value="1">
										<span class="toggler-slider">
											<span class="wording1">@lang('words.eve_tik_info_inv1')</span>
											<span class="wording2">@lang('words.eve_tik_info_inv2')</span>
											<span class="toggler-knob"></span>
										</span>
									</label>
								</div>
							</div>
							<div class="form-ticket">
								<h4 class="ticket-title">@lang('words.events_booking_page.eve_other_info')</h4>
								<p class="policy"><input class="form__input form__input-checkbox input-checkbox" id="iaccept" type="checkbox" name="iaccept" required value="1">  @lang('words.events_booking_page.eve_other_info_ac')
								<a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation" target="_blank">@lang('words.events_booking_page.eve_other_info_tc')</a>
									@lang('words.events_booking_page.eve_other_info_re')
								<a href="https://myplace-events.com/fr/pages/politique-de-confidentialite-des-donnees-personnelles" target="_blank">@lang('words.events_booking_page.eve_other_info_pr')</a>
								@lang('words.events_booking_page.eve_other_info_pri')
								<!--<br/>@lang('words.events_booking_page.eve_other_info_ig') {{ forcompany() }} @lang('words.events_booking_page.eve_other_info_sh') @lang('words.events_booking_page.eve_other_info_wi')</p>-->
								
								<p style="padding: 12px 0"><input class="form__input form__input-checkbox input-checkbox" id="newsletter" type="checkbox" name="newsletter" value="1"> @lang('words.check_newsletter')</p>
								
							<div class="payment-btn">
								<a href="{{ route('order.cancel',$bookingdata->order_id) }}" class="btn-p btn-cancel text-uppercase">@lang('words.events_booking_page.eve_book_can_btn')</a>
							

							@if(intval($bookingdata->order_amount) <= 0)
								<input type="submit" name="paynow" class="btn-p btn-payment text-uppercase" onClick="setTypePay('')" value="R&eacute;server ma place" />
							@else
								<?php /*?><input type="submit" name="paynow" class="btn-p btn-payment text-uppercase" value="@lang('words.events_booking_page.eve_book_can_pay')" /><?php */?>

                            <!--Wallet-->
                            @if($wallet && $wallet >= $bookingdata->order_amount)
                            <button type="submit" id="paywithwallet" class="btn btform1 btn-success wallet" data-toggle="tooltip" data-placement="top" name="wallet" data-original-title="Wallet E.Dari">
                                <span><img src="{{ asset('/img/cat-img/cc-wallet.svg')}}" width="80" style="max-width: 30px"></span>
                                <span>@lang('words.events_booking_page.eve_book_bookingWallet')</span>
                            </button>

							<span>
								<img src="{{ asset('/images/imgpayment/visa-logo-0.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/Mastercard-logo.svg.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/wave-simple.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/mtnmoneylogo.jpg')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/orangemoneysansecriture.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/moov_moneylogo.png')}}" width="80" style="max-width: 30px">
							</span>
                            <!--Fin Wallet-->
                            @endif
                            <!--Cinetpay-->
                            <!-- <button type="submit" id="paywithcinetpat" class="btn btform1 btn-success cinetpay btn-payment" data-toggle="tooltip" data-placement="top" name="cinetpay" data-original-title="Mobile Money" style="border-radius: 3px !important;padding: 3px 11px;height: auto !important;margin-top: -1px;" onClick="setTypePay('mobilemoney')">
                                <span><img src="{{ asset('/img/cat-img/cc-mobile.svg')}}" width="80" style="max-width: 30px"></span>
                                <span>@lang('words.events_booking_page.eve_book_bookingCinet')</span>
                            </button> -->
                            <!--Fin Cinetpay-->
 							
							 <button type="submit" onClick="setTypePay('paystack')" class="btn btform1 btn-success paystack " data-toggle="tooltip" data-placement="top" name="paystack" data-original-title="Carte Visa" style="border-radius: 3px !important;padding: 3px 11px;height: auto !important;margin-top: -1px;">
									<span><img src="{{ asset('/img/cat-img/cc-visa.svg')}}" width="80" style="max-width: 30px"><img src="{{ asset('/img/cat-img/cc-mobile.svg')}}" width="80" style="max-width: 30px"></span>
									<span style="margin:0 5px">@lang('words.events_booking_page.eve_book_bookingPaystack')</span>
								</button>

								<h6></h6>
									<span>
								        <img src="{{ asset('/images/imgpayment/visa-logo-0.png')}}" width="80" style="max-width: 30px">
								        <img src="{{ asset('/images/imgpayment/Mastercard-logo.svg.png')}}" width="80" style="max-width: 30px">
								        <img src="{{ asset('/images/imgpayment/wave-simple.png')}}" width="80" style="max-width: 30px">
								        <img src="{{ asset('/images/imgpayment/mtnmoneylogo.jpg')}}" width="80" style="max-width: 30px">
								        <img src="{{ asset('/images/imgpayment/orangemoneysansecriture.png')}}" width="80" style="max-width: 30px">
								        <img src="{{ asset('/images/imgpayment/moov_moneylogo.png')}}" width="80" style="max-width: 30px">
							        </span>

                            <!--PAYSTACK-->
                            <?php
                                        // more details https://paystack.com/docs/payments/multi-split-payments/#dynamic-splits

                            $split = [
                                "type" => "percentage",
                                "currency" => "KES",
                                "subaccounts" => [
                                    [ "subaccount" => "ACCT_li4p6kte2dolodo", "share" => 10 ],
                                    [ "subaccount" => "ACCT_li4p6kte2dolodo", "share" => 30 ],
                                ],
                                "bearer_type" => "all",
                                "main_account_share" => 70
                            ];
                            $service_designation = "event_ticket";
                            ?>
                            <?php /*?><form method="POST" action="{{ route('paystack.sendform') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="hidden" name="email" value="{{empty($bookingdata->user_email) ? guestUserData($bookingdata->gust_id)->email : $bookingdata->user_email }}"> {{-- required --}}
                                        <input type="hidden" name="orderID" value="{{ $bookingdata->order_id }}">
                                        <input type="hidden" name="amount" value="{{ $montant_visa*100 }}"> {{-- required in kobo --}}
                                        <input type="hidden" name="quantity" value="{{ $bookingdata->order_t_qty }}">
                                        <input type="hidden" name="currency" value="XOF">
                                        @php
                                        $meta_data = ['designation' => $service_designation, 'order_id' => $bookingdata->order_id ]
                                        @endphp
                                        <input type="hidden" name="metadata" value="{{ json_encode($meta_data) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}

                                        <input type="hidden" name="split_code" value="SPL_EgunGUnBeCareful"> {{-- to support transaction split. more details https://paystack.com/docs/payments/multi-split-payments/#using-transaction-splits-with-payments --}}
                                        <input type="hidden" name="split" value="{{ json_encode($split) }}"> {{-- to support dynamic transaction split. More details https://paystack.com/docs/payments/multi-split-payments/#dynamic-splits --}}
                                        {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}
                                        <button type="submit" class="btn btform1 btn-success paystack" data-toggle="tooltip" data-placement="top" name="paystack" data-original-title="Carte Visa + 4%">
                                            <span><img src="{{ asset('/img/cat-img/cc-visa.svg')}}" width="80" style="max-width: 30px"></span>
                                            <span style="margin:0 5px">@lang('words.events_booking_page.eve_book_bookingPaystack')</span>
                                        </button>
                                    </div>
                                </div>
                            </form><?php */?>
                            <!--FIN PAYSTACK-->
                         				@endif			
									
								</div>

								
							</div>
					</div>
				</div>
				{!! Form::close() !!}

			</div>
		</div>		
		 
	</div>
</div>
@endsection

@section('pageScript')
<style>
.form-ticket {
    border-bottom: 1px solid #e1e1e1 !important;
}
</style>
<div id="order_session" style="display:none;">{{ $orderSessionTime }}</div>
<script src="{{ asset('/js/isValidNumber.js')}}"></script>
<script language="javascript">
	function customize(id){
		if($("#"+id).css("display")=="none"){
			$("#"+id).css("display","block");
		}else{
			$("#"+id).css("display","none");			
		}
	}
	
	function setTypePay(id){
		$("#type-pay").val(id);		
		$('.form-ticket input').each(function( index ){
			if($(this).attr('required')){
				$(this).attr('disabled','true');
			}
		});		
 	}
	
	function checkTP(){

		if(!$('#iaccept').is(":checked")){
			$('#iaccept').focus();
			return false;
		}
		<?php if(intval($bookingdata->order_amount) > 0){ ?>
			if($("#type-pay").val()==""){
				return false;
			}
		<?php } ?>
	}
</script>
@endsection