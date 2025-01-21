@extends($theme)
@section('meta_title',setMetaData()->bking_payment_title.$bookingdata->event_name )
@section('meta_description',setMetaData()->bking_payment_desc)
@section('meta_keywords',setMetaData()->bking_payment_keyword)


@section('content')
@php
/*$startdate = Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('D, F j, Y');
$enddate = Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('D, F j, Y');
$starttime = Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('h:i A');
$endtime = Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('h:i A');*/
Jenssegers\Date\Date::setLocale('fr');
$startdate = ucwords(Jenssegers\Date\Date::parse($bookingdata->event_start_datetime)->format('l j F Y'));
$enddate = ucwords(Jenssegers\Date\Date::parse($bookingdata->event_end_datetime)->format('l j F Y'));
$starttime = Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('H:i');
$endtime = Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('H:i');

if(isset($payment_completed) && $payment_completed){
    redirect()->route('ticket.oderdone',$bookingdata->order_id);
}

@endphp

 
 
<div class="container">
    <div class="row page-main-contain">
        <div class="clearfix"></div>
        <div class="col-lg-12 col-sm-12">
            <div class="booking-event">
    
 
                    <div class="row payaction" style="padding-bottom: 5%">
 
                        <div class="col-lg-12 col-md-12" style="text-align: center;">
							<?php
								$mm="";$moreinfos="";								 
								if(!empty($bookingdata->moreinfos)){ 
 									if(count($bookingdatasAll)>0){
										for($x=0;$x<count($bookingdatasAll);$x++){
											$moreinfos=(array)json_decode($bookingdatasAll[$x]->moreinfos);
											$keys=array_keys($moreinfos);
											if($keys!=null){
												foreach ($moreinfos as $k=>$v){	
													$mm.="- ".$k.": ".$v." - ";
												}
											}
										}
									}
									/* $moreinfos_=json_decode($bookingdata->moreinfos);
									 if($moreinfos_->choix_atelier){
 										 $mm.=" - Choix d'atelier : ".$moreinfos_->choix_atelier;
									 }*/
									/*if($moreinfos->gender_on_ticket=='M'){$sx="Homme"; }else{ $sx="Femme"; } choix_atelier
									$mm=" - Sexe : ".$sx.' - Date de naissance : '.stripslashes($moreinfos->birthd_on_ticket)." - Nationalité : ".$moreinfos->nationality_on_ticket." - Club: ".$moreinfos->club_on_ticket;*/
								}
						
							
						$tfees=0; $subtotal=0; $tt=0;
						$order_t_id		= unserialize($bookingdata->order_t_id);
						$order_t_title 	= unserialize($bookingdata->order_t_title);
						$order_t_price 	= unserialize($bookingdata->order_t_price);
						$order_t_fees 	= unserialize($bookingdata->order_t_fees);
						$order_t_qty 	= unserialize($bookingdata->order_t_qty);
						if(!empty($order_t_id)){
								foreach($order_t_id as $key => $ticket){
								 
									$tfees=$tfees+floatval($order_t_fees[$key]);
									$subtotal=$subtotal+(floatval($order_t_price[$key]) + floatval($order_t_fees[$key])) * intval($order_t_qty[$key]);
                            
                                    if($bookingdata->discount_type=='percentage'){
                                        $tt=$subtotal-(($subtotal*$bookingdata->discount)/100);
                                    }else{
                                        $tt=$subtotal-$bookingdata->discount;
                                     }
                                    $subtotal=$tt;											
                                }
			
                        }

								 
					?>
					@php
					$montant_cinetpay = arrondi_entier_sup($subtotal);		
					$event_title = unserialize($bookingdata->order_t_title);
					$custom_data = json_encode(array("user_id" => $bookingdata->user_id ,
					"gust_id" => $bookingdata->gust_id,
					"event_id" => $bookingdata->event_name,
					"amount" => $montant_cinetpay,
					"event_booking_id" => $bookingdata->order_id,
					"designation" => "event_ticket",
					"identifiant_payeur" => "id : ".$bookingdata->order_id ." | email : ".$bookingdata->user_email." |
					Username : ".$bookingdata->lnm." ".$bookingdata->fnm." ".$mm." | event_name : ".$bookingdata->event_name));
					@endphp
					
					<?php if($typepay=="mobilemoney"){ ?>
					{!! Form::open(array('route' => 'wallet_cinetpay.paiement', 'method' => 'POST', 'id' => 'booktickets'))
					!!}
					{!! Form::hidden('order_data', $custom_data) !!}
					{!! Form::hidden('order_id', $bookingdata->order_id) !!}

					<!--Wallet-->
					@if($wallet && $wallet >= $subtotal)
					<button type="submit" class="btn btform1 btn-success wallet" data-toggle="tooltip" data-placement="top" name="wallet" data-original-title="Wallet E.Dari">
						<span><img src="{{ asset('/img/cat-img/cc-wallet.svg')}}" width="80" style="max-width: 30px"></span>
						<span>@lang('words.events_booking_page.eve_book_bookingWallet')</span>
					</button>
					<!--Fin Wallet-->
					@endif
					<!--Cinetpay-->
					<!-- <input type="hidden" name="cinetpay">		
					<h2 class="center-screen">Redirection vers CINETPAY...</h2>
					<button type="submit" class="btn btform1 btn-success cinetpay" data-toggle="tooltip" data-placement="top" name="cinetpaybutton" data-original-title="Mobile Money">
						<span><img src="{{ asset('/img/cat-img/cc-mobile.svg')}}" width="80" style="max-width: 30px"></span>
						<span>@lang('words.events_booking_page.eve_book_bookingCinet')</span>
					</button> -->
					<!--Fin Cinetpay-->

					{!! Form::close() !!}
					
					<?php } ?>
							
							
					<?php if($typepay=="paystack"){ ?>
						<!--PAYSTACK-->
						<?php
							$montant_visa = arrondi_entier_sup($subtotal);
	
							$montant_visa = $subtotal;

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
							<h2 class="center-screen">Redirection vers PAYSTACK...</h2>
						<form method="POST" action="{{ route('paystack.sendform') }}" accept-charset="UTF-8" class="form-horizontal" role="form" id="booktickets">
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
									<button type="submit" class="btn btform1 btn-success paystack" data-toggle="tooltip" data-placement="top" name="paystack" data-original-title="Carte Visa">
										<span><img src="{{ asset('/img/cat-img/cc-visa.svg')}}" width="80" style="max-width: 30px"></span>
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
								</div>
							</div>
						</form>
						<!--FIN PAYSTACK-->
						<?php } ?>
							
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
.center-screen {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  min-height: 100vh;
}
</style>
@endsection

@section('pageScript')
<div id="order_session" style="display:none;">{{ $orderSessionTime }}</div>
 
<script>
	function redir(){
		$("#booktickets").submit(); 
	}
	
	setTimeout(redir,1000)
    $(() => {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        function reset() {
            $('#code').removeClass('input-invalid');
            $('.alert').hide();
            $('.two').hide();
        }
        $('#maform').submit((e) => {
            let that = e.currentTarget;
            e.preventDefault();
            $.ajax({
                method: $(that).attr('method'),
                url: $(that).attr('action'),
                data: $(that).serialize()
            })
            .done((data) => {
                $('.alert').show('slow');
                $('.two').hide();
            })
            .fail((data) => {
                if(data.status == 422) {
                    $.each(data.responseJSON.errors, function (i, error) {
                        $('form')
                        .find('[name="' + i + '"]')
                        .addClass('input-invalid')
                        .next()
                        .append(error[0]);
                    });
                    $('.two').show('slow');
                    $('.alert').hide();
                }
            });
        });
    });
</script>
 
<?php /*?>
<script
src="https://www.paypal.com/sdk/js?client-id=ATuPPG_J-jsM5kc238QWjRvNzxRGcgwYC8FI4HwH_QrzpH5fQQa8LDU75WXlxOaQUSosdxid0XwO0MkT&currency=EUR">
</script>
<script type="text/javascript">
    $(function() {
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ number_format(($subtotal/650)*1.06, 2) }}',
                            currency: '{{ Config::get('
                            services.paypal.currency ') }}',
                            reference_id: '{{ $bookingdata->order_id }}',
                            description: '{{ $bookingdata->event_name }}',
                            invoice_id: '{{ $bookingdata->order_id }}',
                        }
                    }],
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Paiement effectué par ' + details.payer.name.given_name +
                        '. Cliquez sur OK et patientez quelques instants');
                // Call your server to save the transaction
                fetch('{{ url('
                    paypal - transaction - complete /
                    ') }}/{{ $bookingdata->order_id }}/' + data.orderID, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID
                        })
                    }).then(response => {
                        if (response.ok) {
                        /*response.json()
                        .then(console.log);* /
                        window.location.href =
                        "{{ route('ticket.oderdone',$bookingdata->order_id) }}";
                    } else {
                        window.location.href =
                        "{{ route('order.cancel',$bookingdata->order_id) }}";
                        //console.error('server response : ' + response.status);
                    }
                });
                })
            }
        /*onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaction completed by ' + details.payer.name.given_name);
                // Call your server to save the transaction
                if(fetch('{{--{{ url('paypal-transaction-complete/'.$bookingdata->order_id) }}--}}/'+data.orderID, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                }))
                {
                    window.location.href = "{{--{{ route('ticket.oderdone',$bookingdata->order_id) }}--}}";
                }
            });
        }* /
    }).render('#paypal-button-container');
    });
/* if(window.fetch){
     window.fetch('}}', {
         method: 'post',
         headers: {
             'content-type': 'application/json'
         },
         body: JSON.stringify({
             orderID: data.details
         })
     })
 }* /
</script><?php */?>

<!-- Paywith checkout -->
@endsection


 
{{--<input type="submit"  name="paywitstripe" class="btn-p btn-payment text-uppercase" id="paywithStripe" value="Pay With Card" />--}}
{{--<input type="hidden" name="stripeToken" id="stripeToken" />--}}
{{--<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript">
    var handler = StripeCheckout.configure({
        key : '{{ config('services.stripe.key') }}',
        image : '{{ asset("/img/".siteSetting()->favilogo) }}',
        locale : 'auto',
        zipCode : true,
        capture : true,
    });
    document.getElementById('paywithStripe').addEventListener('click', function(e) {
// Open Checkout with further options:
handler.open({
    name: "{{ $bookingdata->event_name }}",
    description: "Order Id : {{ $bookingdata->order_id }}",
    currency: "{{ config('services.stripe.currency') }}",
    amount: "{{ number_format($subtotal, 2, '', '') }}",
    token: handleToken
});
e.preventDefault();
});
    function handleToken(response) {
        var token = response.token;
        var $form = $('#booktickets');
        if (response) {
            $('#stripeToken').val(JSON.stringify(response))
            console.log(response);
// Submit the form:
$form.get(0).submit();
}
}
// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
    handler.close();
});
</script>--}}