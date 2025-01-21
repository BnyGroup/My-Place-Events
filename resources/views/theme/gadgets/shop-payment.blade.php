@extends('layouts.master')
@section('meta_title',"Payez par Paystack" )
@section('meta_description',setMetaData()->bking_payment_desc)
@section('meta_keywords',setMetaData()->bking_payment_keyword)


@section('content')
@php
  
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
				 
							
					<?php if($typepay=="visa"){ ?>
						<!--PAYSTACK-->
						<?php
 	
						$montant_visa = $datas['montant_visa'];
 
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
						$service_designation = "shop";
						?>
						<h2 class="center-screen">Redirection vers PAYSTACK...</h2>
						<form method="POST" action="{{ route('paystack.sendpay') }}" accept-charset="UTF-8" class="form-horizontal" role="form" id="booktickets">
							<div class="row">
								<div class="col-md-8 col-md-offset-2">
									<input type="hidden" name="email" value="{{ $datas['email'] }}"> {{-- required --}}
									<input type="hidden" name="orderID" value="{{ $datas['orderID'] }}">
									<input type="hidden" name="amount" value="{{ $montant_visa*100 }}"> {{-- required in kobo --}}
									<input type="hidden" name="quantity" value="{{ $datas['quantity'] }}">
									<input type="hidden" name="currency" value="XOF">
									@php
									$meta_data = ['designation' => $service_designation, 'order_id' => $datas['orderID'] ]
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
  
@endsection
 