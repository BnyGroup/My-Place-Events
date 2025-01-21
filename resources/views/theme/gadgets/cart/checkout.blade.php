@extends($theme)

@section('meta_title',setMetaData()->e_list_title)
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)
 

@section('content')

@include('theme.gadgets.shop-header') 

<style>
	#toggle_login{
		color: #D600A9 !important;
	}
	.openConnexinBox{
		    z-index: 99;
		display: inline-block;
		position: relative;
	}
</style>
<div class="ns-exit" style="width: 100%; height: 100%; position: absolute; z-index: 0"></div>
    @if (!empty($all_cart_items) && count($all_cart_items))
        <div class="checkout-area-wrapper widt-coupon">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="checkout-inner-content">
                            <x-msg.flash />

							@if($errors->any())
							    <div class="alert alert-danger">
									{{$errors->first()}}
								</div>	
							@endif
							
							 
                            {{-- GLOBAL DATA STORE FOR CHANGABLE VALUES --}}
                            <form id="global_settings">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="gs_tax_amount" id="gs_tax_amount" value="0" />
                                <input type="hidden" name="gs_selected_shipping_id" id="gs_selected_shipping_id" value="{{ optional($default_shipping)->id }}" />
                                <input type="hidden" name="gs_selected_shipping_amount" id="gs_selected_shipping_amount" value="{{ $default_shipping_cost }}" />
                                <input type="hidden" name="gs_coupon_text" id="gs_coupon_text" value="{{ request()->coupon }}" />
                                <input type="hidden" name="gs_coupon_amount" id="gs_coupon_amount" value="{{ $coupon_amount }}" />
                                <input type="hidden" name="gs_subtotal" id="gs_subtotal" value="{{ $subtotal }}" />

                                <input type="hidden" name="gs_selected_country" id="gs_selected_country" value="{{ $subtotal }}" />
                                <input type="hidden" name="gs_selected_state" id="gs_selected_state" value="{{ $subtotal }}" />
                            </form>
                            {{-- ======================================= --}}
                            @if (!$user)
                                <p class="query">
                                    <i class="fa fa-question-circle" style="color: #fcbd0d;" aria-hidden="true"></i>
                                    @lang('words.shop.already_customer')
                                    <a href="#" id="toggle_login" class="openConnexinBox closeme">@lang('words.shop.click_sign_in')</a>
                                </p>
                                 
                            @endif
                            <?php /*?><p class="query">
                                <i class="las la-exclamation-circle icon"></i>
                                {!! filter_static_option_value('have_coupon_text', $setting_text, __('Have a coupon?')) !!}
                                <a href="#" class="toggle_coupon">{!! filter_static_option_value('enter_coupon_text', $setting_text, __('Click here to enter your code')) !!}</a>
                            </p><?php */?>
                            <?php /*?><!-- discount coupon area -->
                            <div class="discount-coupon-area margin-bottom-50 margin-top-20 coupon_section d-none">
                                <h4 class="title">{!! filter_static_option_value('coupon_title', $setting_text, __('coupon discount')) !!}</h4>
                                <p class="info">
                                    {!! filter_static_option_value('coupon_subtitle', $setting_text, 
                                            __('There are many variations of passages of Lorem Ipsum available, but the
                                            majority have suffered alteration in some.'
                                            )
                                        ) 
                                    !!}
                                </p>

                                <form action="{{ route('frontend.checkout.apply.coupon') }}" method="get" class="discount-coupon">
                                    <div class="form-group">
                                        <input type="text" name="coupon" class="form-control"
                                            placeholder="{!! filter_static_option_value('coupon_placeholder', $setting_text, __('Enter your coupon code')) !!}"
                                            value="{{ old('coupon') ?? request()->coupon }}">
                                    </div>
                                    <div class="btn-wrapper">
                                        <button class="default-btn" type="submit">{!! filter_static_option_value('apply_coupon_btn_text', $setting_text, __('apply coupon')) !!} </button>
                                    </div>
                                </form>
                            </div><?php */?>

                            <!-- billing details area -->
                            <div class="billing-details-area-wrapper">
                                <h3 class="title">@lang('words.shop.fact_detail')</h3>
                                <form action="{{ route('frontend.checkout') }}" method="POST" id="billing_info" onSubmit="return checkmyform()" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="coupon" id="coupon_code" value="{{ old('coupon') ?? request()->coupon }}">
                                    <input type="hidden" name="tax_amount">
                                    <input type="hidden" name="selected_shipping_option" value="{{ $default_shipping->id }}">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="f-name">@lang('words.shop.lname')</label>
                                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') ?? $user->lastname ?? '' }}">
                                        </div>
										
                                        <div class="form-group col-6">
                                            <label for="f-name">@lang('words.shop.fname')</label>
                                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') ?? $user->firstname ?? '' }}">
                                        </div>										
 

                                        <div class="form-group col-lg-6 col-6">
                                            <label for="address_amail">@lang('words.shop.email')</label>
                                            <input type="email" id="email" name="email" value="{{ old('email') ?? $user->email ?? '' }}" />
                                        </div>

                                        <div id="result" class="form-group col-lg-6 col-6">
                                            <label for="address_phone">@lang('words.shop.phone')</label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone') ?? $user->phone ?? '' }}"  class="tel form-control form-textbox" minlength="10" maxlength="14" required style="padding-left: 52px;" />
											<span id="valid-msg" class="hide posi">✓ Valide</span>
      										<span id="error-msg" class="hide posi"></span>
                                        </div>
										
										<div class="form-group col-6">
                                            <label for="country">@lang('words.shop.country')</label>
                                            <select name="country" id="country">
                                                <option value="">@lang('words.shop.select_country')</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id_pays }}" 
                                                        @if(isset($user) && isset($user->country) 
                                                            && $user->country == $country->nom_pays
                                                        ) selected @endif
                                                    >{{ $country->nom_pays }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-6">
                                            <label for="address_03">@lang('words.shop.city')</label>
                                            <input type="text" id="city" name="city" value="{{ old('city') ?? $user->city ?? '' }}">
                                        </div>                                        
										
										<div class="form-group col-12">
                                            <label for="address_01">@lang('words.shop.address')</label>
                                            <input type="text" id="address_01" name="address" value="{{ old('address') ?? $user->address ?? '' }}">
                                        </div>


                                        <?php /*?><div class="form-group col-lg-6 col-12">
                                            <label for="address_province_ship">{{ __('State') }}</label>
                                            <select id="state" name="state">
                                                <option value="">{{ __('Select State') }}</option>
                                                @if(isset($user) && isset($user->country))
                                                    @php
                                                        $states = \App\Country\State::where("country_id",$user->country)->where("status","publish")->select("id","name")->get();
                                                    @endphp
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}" {{ $state->id == $user->state ? "selected" : "" }}>{{ $state->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-12">
                                            <label for="address_zip_ship_2">{{ __('Zip Code') }}</label>
                                            <input type="text" id="zipcode" name="zipcode"
                                                value="{{ old('zipcode') ?? $user->zipcode ?? '' }}" />
                                        </div><?php */?>

                                        @if (!$user)
                                            <div class="form-group form-check col-12">
                                                <input type="checkbox" id="create_account" name="create_account"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="create_account">
                                                   @lang('words.shop.create_account')
                                                </label>
                                            </div>
                                            <div class="form-group col-lg-12 col-12" style="display: none">
                                                <label for="username">@lang('words.shop.username')</label>
                                                <input type="text" name="username" class="form-control" id="username">
                                            </div>
                                            <div class="form-group col-lg-6 col-12" style="display: none">
                                                <label for="password">@lang('words.shop.password')</label>
                                                <input type="password" name="password" class="form-control" id="password">
                                            </div>
                                            <div class="form-group col-lg-6 col-12" style="display: none">
                                                <label for="confirm_password">@lang('words.shop.confirm_password')</label>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    id="confirm_password">
                                            </div>
                                        @endif

                                        <div class="form-group col-12">
                                            <label for="order_note">@lang('words.shop.order_note')</label>
                                            <textarea class="form-control" id="order_note" name="order_note" rows="3"></textarea>
                                        </div>
                                        @if (auth('web')->check())
                                        <input type="hidden" name="shipping_address_id" id="shipping_address_id">
                                        <div class="form-group form-check col-12">
                                            <input type="checkbox" class="form-check-input" id="ship_another_address">
                                            <label class="form-check-label" for="ship_another_address">
                                                @lang('words.shop.exped_another')
                                            </label>
                                        </div>
                                        <div id="user_shipping_address_container" class="container-fluid" style="display: none">
                                            <div id="all_user_shipping_address_container">
                                                @if ($all_user_shipping)
                                                    @include('theme.gadgets.cart.checkout-user-shipping')
                                                @endif
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div id="user_shipping_address_form">
                                                        <div class="form-group">
                                                            <label for="user_shipping_name">@lang('words.shop.fl_name')</label>
                                                            <input type="text" class="form-control" id="user_shipping_name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="user_shipping_address">@lang('words.shop.address')</label>
                                                            <textarea id="user_shipping_address" cols="30" rows="5"></textarea>
                                                        </div>
                                                        <button id="new_user_shipping_address_form_submit_btn" class="btn btn-primary px-3">@lang('words.shop.add_new_shipaddr')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>

					<div class="col-lg-5" id="checkout_total_containeraaa">
                        <div class="order cart-total" style="background: url('{{asset('/img/bgmenuaccount.png')}}') repeat; border-radius: 15px">
							<div style="padding: 20px; border-radius: 15px; background-color: #FFFFFF">
								<div id="checkout_total_container">
									@include('theme.gadgets.cart.checkout-partial')
								</div>
								<div id="payment_method_input" class="row">
									<input type="hidden" name="paymode" id="paymode" value="">
									<div class="col-lg-6" id="paywithcinetpay" align="center">
										<img src="{{asset('/images/cinetpay.png')}}" style="height: 75px" id="cinetpay"></div>
							 		<div class="col-lg-6" id="paywithvisa" align="center">
										<img src="{{asset('/images/visa.png')}}" style="height: 75px" id="visa"></div>

								</div>
								<div class="sum-bar"></div>
								<div class="form-group form-check col-12">
									@php
										$checkout_page_terms_text = trans_choice('words.shop.terms',1);
										$checkout_page_terms_link_url = url('/')."/p/terms-and-conditions/1";
										$checkout_page_terms_link_url = $checkout_page_terms_link_url ? url($checkout_page_terms_link_url) : "#";

										$terms_text = str_replace(['[lnk]', '[/lnk]'], ["<a class='terms' href='$checkout_page_terms_link_url'>", "</a>"], $checkout_page_terms_text);
									@endphp
									
								<label class="form-check-label" for="Checkhh">
								<p style="padding: 12px 0"><input type="checkbox" class="form-check-input" name="agree" id="Checkhh">
										@lang('words.events_booking_page.eve_other_info_ac')
								<a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation" target="_blank">@lang('words.events_booking_page.eve_other_info_tc')</a>
									@lang('words.events_booking_page.eve_other_info_re')
								<a href="https://myplace-events.com/fr/pages/politique-de-confidentialite-des-donnees-personnelles" target="_blank">@lang('words.events_booking_page.eve_other_info_pr')</a>
								@lang('words.events_booking_page.eve_other_info_pri')
								<!--<br/>@lang('words.events_booking_page.eve_other_info_ig') {{ forcompany() }} @lang('words.events_booking_page.eve_other_info_sh') @lang('words.events_booking_page.eve_other_info_wi')</p>-->
								
								<p style="padding: 12px 0"><input class="form-check-input" id="newsletter" type="checkbox" name="newsletter" value="1"> @lang('words.check_newsletter')</p>
									</label>
								</div>
								<div class="btn-wrapper btn-top">
									<button type="submit" class="default-btn">@lang('words.shop.pay_now')</button>
								</div>
								<?php /*?><div class="btn-wrapper ">
									<a href="{{ route('frontend.products.cart') }}" class="default-btn reverse">
									   Retourner au panier
									</a>
								</div><?php */?>
							</div>
                        </div>

                    </div>
                   
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="only-img-page-wrapper cart" style="margin-top: 90px 0 90px 0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="img-box" align="center">
                            <img src="{{ asset('/img/empty_cart.png') }}">
                        </div>
                        <div class="content" align="center">
                            <p class="info">Aucun produit dans votre panier !</p>
                            <div class="btn-wrapper" style="text-align: center">
                                <a href="{{ route('index') }}" class="default-btn">Retour à l'accueil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

<style>
.checkout-inner-content .billing-details-area-wrapper .form-group input{
  padding: 23px 10px;    
  border-radius: 5px !important;
}
.checkout-inner-content .billing-details-area-wrapper .form-group select{
  padding: 3px 10px;    
  border-radius: 5px !important;
}	
	.checkout-inner-content .billing-details-area-wrapper .form-group textarea{
		height: auto !important
	}	
.posi{
	right: 8% !important;
	top: 30px !important;
}	
.shipping-cost{
	text-align: right
}
#cinetpay, #visa{
	cursor: pointer
}	
#payment_method_input input[type="radio"]:checked + img {
  background-color: #aaa;
}
.selected{
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;	
	padding: 10px;
	border-radius: 5px;
}	
#paywithcinetpay:before :has(div.selected){
  content: "✓";
  background-color: grey;
  transform: scale(1);
}	
</style>

    <x-loader.html />
@endsection
 
@section('pageScript')
    <link rel="stylesheet" href="{{ asset('/assets/common/js/toastr.min.js') }}">
    <script src="{{ asset('/js/isValidNumber.js')}}"></script>
    <script>
		$(document).ready(function (){
			$("#cinetpay").on("click", function(){
				$(this).addClass('selected')
				$('#visa').removeClass('selected')
				$("#paymode").val("cinetpay")
			});
			$("#visa").on("click", function(){
				$(this).addClass('selected')
				$("#cinetpay").removeClass('selected')				
				$("#paymode").val("visa")
			});
			
			
		});
		
		function checkmyform(){  
			if(!$('#Checkhh').is(':checked')){
				alert('Veuillez lire et accepter les conditions d\'utilisation du site ainsi que la politique de confidentialité.');
				$('#Checkhh').focus();
				return false;
			}
			
			if($("#paymode").val()===""){
				alert('Veuillez choisir au moins un mode de paiement.');
				return false;
			}
			
		}
		
		
       <?php /*?> $(document).ready(function (){
            let id = $("#state").val();
            $.get('{{ route('state.info.ajax') }}', {
                id: id
            }).then(function(data) {
                $('#tax_amount').text(site_currency_symbol + Number(data.tax).toFixed(
                    2));
                calculateTotal();
            });
        });<?php */?>
    </script>
@endsection
