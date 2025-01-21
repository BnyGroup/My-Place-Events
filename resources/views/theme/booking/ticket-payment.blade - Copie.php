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

<!--Cover-->
<div class="col-md-12 cover-img" style="background-image:url('{{asset('/img/rbg.png')}}'); border-bottom: 8px solid #FEB00A; margin-bottom: 25px; margin-top: 0px; height: 295px; color: #fff; text-align: center">

	<h3 class="text-uppercase about-title" style="color: #FFFFFF; padding-bottom: 15px;">@lang('words.events_booking_page.eve_book_tit')</h3>
	<div class="container countdown">
		<div class="row page-main-contain">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="alert alert-info text-center" style="background: none; color:#FFFFFF; border: none">
					<span id="timer"></span>
					<p>@lang('words.events_booking_page.eve_book_advise1')</p>
					<p>@lang('words.events_booking_page.eve_book_advise2')</p>
				</div>
			</div>
		</div>
	</div>

</div>
<!--Cover-->
 
<div class="container">
    <div class="row page-main-contain">
        <div class="clearfix"></div>
        <div class="col-lg-12 col-sm-12">
            <div class="booking-event">
                <div class="alert alert-success" style="display: none">
                    Le code est bien appliqué !
                </div>
                
                <h3 class="event-title wordwap" style="padding-bottom:15px;">
                    @lang('words.booking_payment_page.book_pay_for') : {{ $bookingdata->event_name }}</h3>
                    <div class="alert alert-danger two" style="display: none">
                        Le code est invalide !
                    </div>
                    <div class="event-address booking-box">
                        <h3 class="box-title">@lang('words.booking_payment_page.book_pay_info') </h3>
                        <div class="box-descroptoin">
                            <div class="table-responsive">
                                <table class="table">
                                    @if(auth()->guard('frontuser')->check())
                                    <tr>
                                        <th style="width:25%">@lang('words.booking_payment_page.book_pay_by')</th>
                                        <td>{{ auth()->guard('frontuser')->user()->firstname }}
                                            {{ auth()->guard('frontuser')->user()->lastname }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th style="width:25%">@lang('words.events_booking_page.eve_tik_info_email')</th>
                                        @if(auth()->guard('frontuser')->check())
                                        <td>{{ auth()->guard('frontuser')->user()->email }}</td>
                                        @else
                                        <td>{{ guestUserData($bookingdata->gust_id)->email }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <table class="table">
                                            <tr>
                                                <td class="box-title" colspan="4" style="background-color: #001C96">@lang('words.booking_payment_page.book_pay_total') <span style="font-size: 12px;color: #FFFFFF;display: block;line-height: 1;">Choisissez un moyen de paiement</span></td>
                                            </tr>
                                            @if($wallet && $wallet >= $bookingdata->order_amount)
                                            <tr>   
                                                @php
                                                $montant_wallet = $bookingdata->order_amount;
                                                @endphp
                                                <th>E.Dari</th>
                                                @if($wallet && $wallet >= $bookingdata->order_amount)
                                                <td style="text-align: right;font-weight: bold;">{{ number_format($montant_wallet,0,',',' ') }} {!!
                                                    use_currency()->symbol !!}
                                                </td>
                                                @endif
                                            </tr>
                                            @endif
                                            <tr>   
                                                @php
                                                $montant_cinetpay = arrondi_entier_sup(1.035*$bookingdata->order_amount);
                                                @endphp
                                                <th>Mobile Money</th>
                                                <td style="text-align: right;font-weight: bold;">{{ number_format($montant_cinetpay,0,',',' ') }} {!!
                                                    use_currency()->symbol !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                @php
                                                $montant_visa = $bookingdata->order_amount + arrondi_entier_sup(0.04*$bookingdata->order_amount);
                                                @endphp
                                                <th>Carte Visa</th>
                                                <td style="text-align: right;font-weight: bold;">{{ number_format($montant_visa,0,',',' ') }} {!!
                                                    use_currency()->symbol !!}
                                                </td>
                                            </tr>
                                        </table>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row payaction" style="padding-bottom: 5%">
                        <div class="Decided col-lg-2 col-md-2" style="display: flex;align-items: center">
                            <a href="{{ route('order.cancel',$bookingdata->order_id) }}" class="btn btform1 btn-cancel text-uppercase">@lang('words.events_booking_page.eve_book_can_btn')</a>
                        </div>

                        <div class="Pay_ActBut col-lg-10 col-md-10">
							<?php
								$mm="";$moreinfos="";								 
								if(!empty($bookingdata->moreinfos)){ 
 									
									for($x=0;$x<count($bookingdatasAll);$x++){
										$moreinfos=(array)json_decode($bookingdatasAll[$x]->moreinfos);
										$keys=array_keys($moreinfos);
										if($keys!=null){
											foreach ($moreinfos as $k=>$v){	
												$mm.="- ".$k.": ".$v." - ";
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
							?>
                            @php
                            $event_title = unserialize($bookingdata->order_t_title);
                            $custom_data = json_encode(array("user_id" => $bookingdata->user_id ,
                            "event_id" => $bookingdata->event_name,
                            "amount" => $montant_cinetpay,
                            "event_booking_id" => $bookingdata->order_id,
                            "designation" => "event_ticket",
                            "identifiant_payeur" => "id : ".$bookingdata->order_id ." | email : ".$bookingdata->user_email." |
                            Username : ".$bookingdata->lnm." ".$bookingdata->fnm." ".$mm." | event_name : ".$bookingdata->event_name));
                            @endphp
                            {!! Form::open(array('route' => 'wallet_cinetpay.paiement', 'method' => 'POST', 'id' => 'booktickets'))
                            !!}
                            {!! Form::hidden('order_data', $custom_data) !!}
                            {!! Form::hidden('order_id', $bookingdata->order_id) !!}

                            <!--Wallet-->
                            @if($wallet && $wallet >= $bookingdata->order_amount)
                            <button type="submit" class="btn btform1 btn-success wallet" data-toggle="tooltip" data-placement="top" name="wallet" data-original-title="Wallet E.Dari">
                                <span><img src="{{ asset('/img/cat-img/cc-wallet.svg')}}" width="80" style="max-width: 30px"></span>
                                <span>@lang('words.events_booking_page.eve_book_bookingWallet')</span>
                            </button>
                            <!--Fin Wallet-->
                            @endif
                            <!-- Cinetpay-->
                            <!-- <button type="submit" class="btn btform1 btn-success cinetpay" data-toggle="tooltip" data-placement="top" name="cinetpay" data-original-title="Mobile Money +3.5%">
                                <span><img src="{{ asset('/img/cat-img/cc-mobile.svg')}}" width="80" style="max-width: 30px"></span>
                                <span>@lang('words.events_booking_page.eve_book_bookingCinet')</span>
                            </button> -->
                            <!--Fin Cinetpay -->

                            {!! Form::close() !!}

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
                            <form method="POST" action="{{ route('paystack.sendform') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
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
                            </form>
                            <!--FIN PAYSTACK-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="demo"></div>
</div>
@endsection

@section('pageScript')
<div id="order_session" style="display:none;">{{ $orderSessionTime }}</div>
 
<script>
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
{{--<script type='text/javascript'>function miseenattente(){ setTimeOut(fonctionAExecuter, 5000); } function fonctionAExecuter(){ document.getElementById('booktickets').click(); /* document.getElementsByClassName('cpButton').click();*/} miseenattente();</script>--}}

<!-- Paywith checkout -->
{{--<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>
<script src="https://js.braintreegateway.com/web/3.46.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.46.0/js/paypal-checkout.min.js"></script>
<script src="{{ asset('/js/paypal-checkout.js') }}" type="text/javascript"></script>--}}

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
                            value: '{{ number_format(($bookingdata->order_amount/650)*1.06, 2) }}',
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
                        .then(console.log);*/
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
        }*/
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
 }*/
</script>

<!-- Paywith checkout -->
@endsection



<?php  ?>
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
    amount: "{{ number_format($bookingdata->order_amount, 2, '', '') }}",
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
</script>
{{--<input type="submit" name="paydoor" class="btn-p btn-payment text-uppercase" value="Pay at Door" />--}}
<?php   ?>