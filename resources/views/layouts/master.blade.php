@if(auth()->guard('frontuser')->check())
  @if(auth()->guard('frontuser')->user()->status != 1)
      @php auth()->guard('frontuser')->logout() @endphp
      <script type="text/javascript">
        window.location = "{{ url('/') }}";
      </script>
  @endif
@endif
@inject('sdata',App\Setting)
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->

    <!-- SEO DATA OK -->

    <title> @if(request()->is('fr/event/*')) Reserve Tes Places | @yield('meta_title') @else My Place Events - Votre billetterie événementielle 100% numérique @yield('meta_title') @endif</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
   <meta property="og:image" content="@yield('og_image', for_logo())" />
   
    <meta property="og:url" content="https://myplace-events.com/fr">
    <!-- SEO DATA -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base target="_parent">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/intlTelInput.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/special-event.css')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
	<script src="{{ asset('public/js/menu-scroll.js') }}"></script>

    <!-- @yield('recaptcha') -->
    @include('layouts.css')
    @yield('css')
      
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">

	<style>
		@media only screen and (max-width: 480px) {
			.right_innerbox .datexp .sepa {
				transform: scale(0.8);
				left: 0px !important;
				margin-left: auto;
				margin-right: auto;
				left: 0;
				right: 0;
				text-align: center;
				position: absolute;
			}
		}

	</style>
	  
  </head>
  <body class="@yield('body_class')">
@inject(countries,'App\PaysList')  
@inject(services,'App\Service')      
@inject(eventCat,'App\EventCategory')

@inject('datacout',App\Booking)      
	  
	 	  
    <div class="img-loeader" style="display: none;">
      <img src="{{ asset('/default/loader.svg') }}">
    </div>
    <div id="fb-root"></div>
      
    <!-- Search icon & Panel -->  
    <div class="searchButt">
      <a href="javascript:void(0)" id="searchButton"><img src="<?php echo url("/"); ?>/public/img/search-ico.png" style="height:33px;"></a>
    </div>
      
    <section id="searchpanel" class="searchpanel">
     @include("theme.events.event-searchpanel-form-home")
    </section>      
    <!-- End Search icon & Panel --> 
      
    <!-- Left menu Panel my local {{ Lang::locale() }} -->  
    <section id="LeftMenuPanel" class="LeftMenuPanel <?php if(auth()->guard('frontuser')->check()){ echo'bgc'; } ?>">  
        
        <div class="leftPanelContent">
			<?php 
			if(!auth()->guard('frontuser')->check()){
 
				$link = session('link_2');
				if(!isset($link))
					session(['link_2' => url()->previous()]);			
			?>
				<div class="getLogin">

						<div class="col-md-12">
							{!! Form::open(['route'=>'signin.postAjax','method'=>'post','class'=>'contact-form','id'=>'signinAjax']) !!}
							<div class="row">
								<div id="errors-list" class="errors-list"></div>

								<div class="col-md-12 form-group">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=> trans('words.signin_page_content.signin_field_e')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif <?php } ?>
								</div>

								<div class="col-md-12 form-group passwordFieldClass">
									<input type="password" name="password" value="" class="form-control form-textbox" id="passwordField" placeholder="{{ trans('words.user_create.user_cn_pwd') }}">
									<!-- Bouton/icône pour basculer la visibilité du mot de passe -->
									<span class="input-group-text" id="togglePassword" style="cursor:pointer;">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</span>
									<?php if(isset($errors)){ if($errors->has('password')){ ?><span class="error">{{ $errors->first('password') }}</span> <?php } } ?>
								</div>
								<div class="col-md-12">
									{!! Form::submit(trans('words.signin_page_content.signin_form_button'),['class'=>'pro-choose-file text-uppercase']) !!}
								</div>
								<div class="col-md-12">
									<a href="javascript:void(0)" class="resetLink openResetLink">@lang('words.signin_page_content.password_forget')</a>
								</div>

							</div>
							{!! Form::close() !!}
							<div class="form-row">
								<div class="col-md-12">
									<hr class="mt10">
									<div class="orConnectWith" style="font-size: 12px;">@lang('words.left_panel.or_connect')</div>
								</div>
								<div class="facebook-login auth-social mb10 col-md-12">
									<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"> Facebook</a>
								</div>
								<div class="google-login auth-social col-md-12">
									<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"> Google </a>
								</div>

								<div class="col-md-12 regBox"> 
									@lang('words.left_panel.not_register') <a href="javascript:void(0)" class="openRegisterLink">@lang('words.left_panel.register')</a>
								</div>
							</div>
						</div>				

				</div>
			
				<div class="getRegister">
						<div class="col-md-12 col-sm-12 col-lg-12">
							{!! Form::open(['route'=>'signup.postAjax','method'=>'post','class'=>'contact-form','id'=>'registerAjax']) !!}

							<div id="errors-list3" class="errors-list3"></div>
							<div id="success-list3" class="success-list3"></div>

							<div class="form-row">
								<div class="col-md-12 form-group">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_email')]) !!}
									<?php if(isset($errors)){ ?>@if($errors->has('email')) <span class="error">{{ $errors->first('email') }} </span> @endif <?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 form-group">
									{!! Form::text('lastname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_lnm')]) !!}
								</div>
								<div class="col-md-12 form-group">
									{!! Form::text('firstname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_fnm')]) !!}
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-sm-12 col-lg-12">
									<?php if(isset($errors)){ ?> @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }} </span> @endif <?php } ?>
									<?php if(isset($errors)){ ?> @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }} </span> <br>@endif <?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 form-group">
                                    {!! Form::text('mobile','',['class'=>'form-control form-textbox','placeholder'=>'Mobile', 'id'=>'phone', 'required']) !!}
									<?php if(isset($errors)){ ?>@if($errors->has('mobile')) <span class="error">{{ $errors->first('mobile') }} </span> @endif <?php } ?>
                                    <span id="valid-msg" class="hide">✓ Valide</span>
			                        <span id="error-msg" class="hide"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('password')) <span class="error">{{ $errors->first('password') }} </span> @endif<?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::password('confirm_password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('confirm_password'))<span class="error">{{ $errors->first('confirm_password') }} </span> @endif<?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<p class="sign-up-links"><input class="form-checkbox" type="checkbox" value="accept" name="accept" required="required"style="width: auto"> @lang('words.left_panel.while_register')  <a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation/" target="_blank">@lang('words.left_panel.cdt')</a> @lang('words.left_panel.of_mpe')</p>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									{!! Form::submit(trans('words.left_panel.i_register'),['class'=>'pro-choose-file text-uppercase']) !!}
								</div>
							</div>
							{!! Form::close() !!}
							<div class="form-row">
								<div class="col-md-12">
									<hr class="mt10">
									<div class="orConnectWith" style="font-size: 12px;">@lang('words.left_panel.or_connect')</div>
								</div>
								<div class="facebook-login auth-social mb10 col-md-12">
									<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"> Facebook</a>
								</div>
								<div class="google-login auth-social col-md-12">
									<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"> Google </a>
								</div>

								<div class="col-md-12 regBox"> 
									@lang('words.left_panel.have_account') <a href="javascript:void(0)" class="openLoginLink">@lang('words.left_panel.connect')</a>
								</div>
							</div>
						</div>

				</div>

				<div class="getResetPswd">

					<div class="col-md-12 col-sm-12 col-lg-12">
						{!! Form::open(['route'=>'reset.postAjax','method'=>'post','class'=>'contact-form','id'=>'resetPswdAjax']) !!}
							<div class="row">
								<div id="errors-list2" class="errors-list2"></div>
								<div id="success-list" class="success-list"></div>

								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_reset_page.reset_filed_pla')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif <?php } ?>
								</div>
								<div class="col-md-12 col-sm-12 col-lg-12">
									{!! Form::submit(trans('words.user_reset_page.reset_form_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
								</div>		
								<div class="col-md-12 regBox"> 
									@lang('words.left_panel.remember') <a href="javascript:void(0)" class="openBackLoginLink">@lang('words.left_panel.connect')</a>
								</div>
							</div>
						{!! Form::close() !!}
					</div>


				</div>
			
			<?php 
				
	
			}else{ 

				if(auth()->guard('frontuser')->user()->status == 1){
				$id = auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'';
				$upcount = $datacout->upCounts($id);
				Jenssegers\Date\Date::setLocale('fr');			
			?>
	
				
			<div class="getAccount">
				<div class="accountPanel"> 
					<ul class="">
						<li>
							<a href="{{ route('user.bookmarks','upcoming') }}">@lang('words.user_menus.usr_mnu_log_1')
								<span class="label">{{ $upcount }}</span>
							</a>
						</li>
						<li>
							<a href="{{ route('user.bookmarks','saved') }}">@lang('words.user_menus.usr_mnu_log_2')</a>
						</li>
						<li><a href="{{ route('events.manage') }}">@lang('words.user_menus.usr_mnu_log_3')</a></li>
						<li><a href="{{ route('shop.item.manage') }}">@lang('words.user_menus.usr_mnu_log_10')</a></li>
						<li><a href="{{ route('alu.index') }}">@lang('words.user_menus.usr_mnu_log_5')</a></li>
						<li><a href="{{ route('users.pro','profile') }}">@lang('words.user_menus.usr_mnu_log_8')</a></li>
						<li><a href="{{ route('org.index') }}">@lang('words.user_menus.usr_mnu_log_6')</a></li>
						<li><a href="{{ route('user.logout') }}">@lang('words.user_menus.usr_mnu_log_9')</a></li>
					</ul>				
				</div>
			
			</div>
	
	
			<?php } } ?>
			
				<div class="quick-cart bgc">
                        <div class="arrow-up"></div>
                        <div id="top_minicart_container">
                            <div id="top_cart_item_box"></div>
                            <div class="total-pricing">
                                <div class="total">
                                    <span class="total">@lang('words.shop.sub_total2'):</span>
                                    <span class="amount" id="top_cart_subtotal">00.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrapper">
							  <a href="javascript:void(0)" class="default-btn closeCart continueshop">@lang('words.shop.continue_shop')</a>
                            <a href="{{ route('frontend.checkout') }}" class="default-btn">@lang('words.shop.order')</a>
                        </div>
                    </div>
        </div>
        
        <div class="LeftpanelMenu">
        
			<div class="dropdown langs">
				<a class="btn btn-primary btn-lg dropdown-toggle langMenu" data-toggle="dropdown" href="javascript:void(0)" 
				   id="dropdownMenuButton1" data-bs-toggle="dropdown" data-currentlang="{{ Lang::locale() }}" aria-expanded="false">
					<?php $clang=""; if(Lang::locale()=="fr"){ ?><img src="{{ asset('/img/Fr.png') }}" width="30px" alt="" />
					<?php }else{ ?><img src="{{ asset('/img/En.png') }}" width="30px" alt="" /><?php } ?></a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
					@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

						@if($properties['native'] === 'Français')
						<li class="lang {{ $localeCode }}">
							<a class="dropdown-item dropdownlang-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" title="@lang('words.header.Français')" data-placement="bottom">
								<img src="{{ asset('/img/Fr.png') }}" width="35px" alt="" />
							</a>
						</li>
						@elseif($properties['native'] === 'English')
						<li class="lang {{ $localeCode }}">
							<a class="dropdown-item dropdownlang-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" title="@lang('words.header.Anglais')" data-placement="bottom">
								<img src="{{ asset('/img/En.png') }}" width="35px" alt="" />
							</a> 
						</li>
						@endif

					@endforeach
				</ul>

			</div>

			<div class="dropdown-divider"></div>

			<div class="parts-left">
			<a href="javascript:void(0)" class="openConnexinBox closeme"><img src="{{ asset('/img/mon_compte.svg') }}" class="imgLeftPanel"><br>@lang('words.left_panel.my_account')</a>
			</div>

			<div class="dropdown-divider"></div>

			<div class="parts-left">
			<a href="javascript:void(0)" class="openCart"><img src="{{ asset('/img/mon_panier.svg') }}" class="imgLeftPanel"><br>@lang('words.left_panel.my_cart') <span class="cart-badge" id="cart_badge">{{ __('0') }}</span></a>
			</div>

			<div class="dropdown-divider"></div>

			<div class="parts-left">
				<ul class="navbar-nav mr-auto leftPanelsn">
					 <li class="nav-item">
						<a class="nav-link" href="https://www.facebook.com/myplaceeventscom/" target="_blank" data-toggle="tooltip" title="Facebook" data-placement="bottom"><i class="ti-facebook"></i></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="https://www.instagram.com/myplace_events/" target="_blank" data-toggle="tooltip" title="Instagram" data-placement="bottom"><i class="ti-instagram"></i></a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank" data-toggle="tooltip" title="Youtube" data-placement="bottom"><i class="ti-youtube"></i></a>
					</li>    
					<li class="nav-item">
						<a class="nav-link" href="https://www.linkedin.com/company/my-place-events" target="_blank" data-toggle="tooltip" title="LinkedIn" data-placement="bottom"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
					</li>  
					<li class="nav-item">
						<a class="nav-link" href="https://api.whatsapp.com/send?phone=2250747974505" target="_blank" data-toggle="tooltip" title="WhatsApp" data-placement="bottom"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
					</li>  
				</ul>
			</div>
        
        </div>
		<div class="openLeftPan" style="height:506px; cursor:pointer" onMouseOver="openLeftBoxpan()">
			<div style="position: absolute;right: 6px; top: 50%;  -ms-transform: translateY(-50%);
  transform: translateY(-50%);"><a href="javascript:void(0)"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
		</div>
    </section>            
    <!-- End Left menu Panel -->    
      
	
	  
    <div class="mainMenu row" >
        <div class="firstcol col-md-2">
            <a href="{{ url('/') }}">
                <img src="{{ for_logo() }}">
            </a> 
        </div>
        <div class="secCol col-md-10">
            
            <div class="row">
                <div class="col-md-8" style="text-align: center;">            
                 <ul class="main-menu text-capitalize" id="menu">

    <?php
    $currentPageURL = URL::current();
    $pageArray = explode('/', $currentPageURL);
    $pageArray[3] = !isset($pageArray[3]) ? '':$pageArray[3];
    $pageActive = isset($pageArray[3]) ? $pageArray[3] : '';
    $pageActive_sub = isset($pageArray[5]) ? $pageArray[5] : '';
    $pageActive_subsub = isset($pageArray[6]) ? $pageArray[6] : '';
    ?>

                  @php $class = 'active' @endphp
                  {{--{{ dd($pageActive) }}--}}
                 <?php /*?> <li style="border-top:0;" class="{{ $pageActive == 'accueil'?$class:'' }}"><a href="{{ route('index') }}">@lang('words.nav_bar.nav_bar_menu_1')</a></li><?php */?>
                  <li style="border-top:0;" class="{{ $pageActive == 'events'?$class:'' }}"><a href="{{ route('events') }}">@lang('words.nav_bar.nav_bar_menu_2')</a></li>
                  <li style="border-top:0;" class="{{ $pageActive == 'prestataire'?$class:'' }}"><a href="{{ route('prestataire') }}">@lang('words.nav_bar.nav_bar_menu_3')</a></li>
                  {{--<li style="border-top:0;" class="{{ $pageActive == 'services'?$class:'' }}"><a href="{{ route('services') }}">@lang('words.nav_bar.nav_bar_menu_4')</a></li>--}}
                  <li style="border-top:0;" class="{{ $pageActive == 'shop'?$class:'' }}"><a href="{{ route('shop') }}">@lang('words.nav_bar.nav_bar_menu_8')</a></li>
                  {{--<li style="border-top:0;" class="{{ $pageActive == 'farafi_tv'?$class:'' }}"><a href="{{ route('farafi_tv') }}">@lang('words.nav_bar.nav_bar_menu_5')</a></li>--}}
                  {{--<li style="border-top:0;" class="{{ $pageActive == 'blog'?$class:'' }}"><a href="https://blog.myplace-events.com/">@lang('words.nav_bar.nav_bar_menu_7')</a></li>--}}
                  <li><a href="{{ route('contacts.index') }}">@lang('words.nav_bar.nav_bar_menu_6')</a></li>
                </ul>     
                </div>
                 <div class="col-md-4" style="text-align: center;">
					 <?php $cln="";
					 if(auth()->guard('frontuser')->check()){ $lnks=route('events.create'); $cln=""; }
					 else{ $lnks="javascript:void(0)"; $cln="closeme"; };?>
                    <a href="{{$lnks}}" class="createEventBut {{$cln}}">+ @lang('words.left_panel.create_event')</a> 
                </div>        
            </div>
        </div>
      </div>

      
      
<style>

	  .abonnement{
	position:fixed;
	top:600px;
	right:0px;
	box-shadow: 8px 0 18px -22px #000000, -8px 0 18px -22px #000000;
	z-index: 99999999;
	
	
	}

	.right_innerbox .datexp .sepa{
		    position: absolute;
    	    margin-left: auto;
			margin-right: auto;
			left: 0;
			right: 0;
			text-align: center;
	}
    .widget-visible iframe{
            bottom: 30px !important;
    }
    .leftPanelContent{
        float: left;
        min-width: 350px;
        min-height: 200px;
        margin-right: 10px;
        display: none;
    }
    .LeftpanelMenu{
        float: left;
		background-color: #fff;
    	padding: 10px;
		    border-right: 1px solid #f1f1f1;
    }
    
    .leftPanelsn, .leftPanelsn li{
        list-style: none;
        display: block
    }
    .leftPanelsn li a{
        background: #001c96 !important;
		color: #fff !important;
		width: 30px;
		height: 30px;
		margin: 0px auto;
		font-size: 16px;
		margin-bottom: 10px;
    }
    .imgLeftPanel{
        height: 48px;
    }
    
    .parts-left{
        width: 70px;
        display: block;
        padding: 8px 0px;
        text-align: center;
        
    }
    .parts-left a{
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: normal;
        color: #00024F;
        font-weight: bold;
    }
    .dropdown.langs .dropdown-menu{
        max-width: 56px !important;
        min-width: 21px;
		left: 7px;
    }
    .dropdown.langs .dropdown-menu li.lang {
        font-weight: bold;
        padding: 10px !important;
        width: 56px;
    }
    .dropdown.langs .dropdown-menu li.lang a{
     padding: unset !important   
    }
    .dropdown.langs .dropdown-menu li.lang a:hover{
        background: unset !important
    }
    .dropdown.langs{
        width: 70px
    }
    .langMenu{
        min-width: 88px;
        display: block;
        padding-left: 6px;
        background: unset !important;
        color: #000 !important;
    }
    
    .LeftMenuPanel{
      position: fixed;
      min-width: 92px;
      background-color: #fff;
      overflow: hidden !important;        
      box-shadow: 8px 0 18px -22px #000000, -8px 0 18px -22px #000000;
      left: 0px !important;
      top: 50% !important;
      z-index: 99999999;
      padding: 0px;
      min-height: 400px;
      transform: translate(0%, -50%);
      border-top-right-radius: 13px;
        border-bottom-right-radius: 13px;
    }
	.leftPanelContent{
		max-height: 660px;
		overflow-y:auto; 		
	}
	
	.leftPanelContent::-webkit-scrollbar {
	  width: 8px;
	}
	.leftPanelContent::-webkit-scrollbar-track {
	  background-color: #e4e4e4;
  	  border-radius: 100px;
	}	
	.leftPanelContent::-webkit-scrollbar-thumb {
	 background-color:#fcbd0d;
  		border-radius: 100px;
	}	
	.bgc{
		background: url({{url('public/img/bgmenuaccount.png')}}) repeat
	}
	
	
	
	
	
	
	
	
	

    .searchpanel #home-searchpanel-form .form-row button{
        background-color: #D600A9 !important
    }
    ul#forDateContent{
        width: 86% !important;
        bottom: 137px;
        background-color: rgb(245 245 245) !important;
    }
    #home-searchpanel-form .form-row .form-group{
        margin-bottom: 15px;
    }
    #home-searchpanel-form .form-row input, #home-searchpanel-form .form-row select, #home-searchpanel-form .form-row button{
        border-radius: 28px !important;
        width: 100%;
    }
    .searchpanel {
      width: 330px !important;
      background-color: #fff;
      overflow: hidden !important;
      z-index: 150000;
      box-shadow: 8px 0 8px -10px #000000,-8px 0 8px -10px #000000;
      position: fixed;
      top: 50%;
    left: 50%;
    transform: translate(-50%, 6%);
      bottom: 0px !important;
      z-index: 1999999999;
      text-align: left;
      pointer-events: auto;
      max-height: 100vh;
      display: none;
      flex-direction: column;
      padding: 10px;
      border-top-left-radius: 13px;
      border-top-right-radius: 13px;
      height: 360px;
    }
    
    body{
        background-color: #F0F1FA;
    }
    
    
    .createEventBut{
        border-radius: 50px;
        padding: 15px;
        background-color: #fcbd0d;
        color: #000d8c;
        top: 25px;
        position: relative;
        font-weight: 600;
		letter-spacing: normal
    }
    
    .secCol .main-menu li a {
        color: #FFFFFF;
        text-decoration: none;
        padding: 25px 5px 7px 23px;
    }
     
    .mainMenu{

		position: fixed;
		bottom : 30px;
		border-radius: 50px;
		background-color: #ffffff;
		width: 1000px;
		z-index: 999999;
		left: 0px;
		right: 0px;
		margin: 0px auto;
		height: 70px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    } 
	
	
    .firstcol{
        max-width: 14%;
        padding-right: 0;
    }
    .firstcol a{
       display: block;
       margin: 5px 25px;
    }
    .firstcol a img{
        height: 60px;
    }
    .secCol{
        padding: 0px;
         position: absolute;
   		 right: -1px;
    }
    .secCol .row{
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;
        /*background-color: #001C96;
        max-width: 105%;*/
        padding-bottom: 15px;
    }

	/* Password field*/
	.passwordFieldClass {
		display: flex;
		flex-direction: row;  
	}

	#togglePassword, #togglePasswordMobile{
		position: absolute;
		right: 13px;
		height: 100%;
		background: #e8f0fe;
		border-radius: 0 20px 20px 0;
		border: 0;
	}
</style>

    
    
    <div id="main-container">

			<header class="mobileheader">
				<div class="container">
					<div class="main-bar">
						<div class="left-content">
							<a href="{{url('/')}}"><img src="{{ for_logo() }}" style="height: 50px"></a>
						</div>
						<div class="mid-content">
						</div>
						<div class="right-content d-flex align-items-center">
						    
						<?php if(!auth()->guard('frontuser')->check()){ ?>
						<a href="javascript:void(0)" class="openConnexinBox closeme"><img src="{{ asset('/images/user.png') }}" style="height:26px; right: 55px;position: relative;" class="imgLeftPanel"></a>
							
					<!-- 	<a href="javascript:void(0)" class="openConnexinBox closeme"><img src="{{ asset('/images/add.png') }}" style="height:26px; right: 50px;position: relative;" class="imgEvent"></a> -->
						<!-- <a href="javascript:void(0)" class="openConnexinBox closeme"  style="height:26px; right: 50px;position: relative;font-size:10px; "class="imgEvent" >Creer événement</a>	 -->

						<button style="height:26px; right: 40px;position: relative;font-size:10px;border-radius:10px 10px 10px 10px; background-color: #ffc107; color:rgba(0, 13, 136, 1); "class="imgLeftPanel" class="primary">
							<a href="javascript:void(0)" class="openConnexinBox closeme" style="color: #060697; font-weight: 800px;"><strong>+Créer un événement</trong></a></button>

						<?php }else{  ?> 
<!-- 
						<a href="https://myplace-events.com/fr/e/create" class=""><img src="{{ asset('/images/add.png') }}" style="height:26px; right: 50px;position: relative;" class="imgLeftPanel"></a> -->
						<button style="height:26px; right: 50px;position: relative;font-size:10px;border-radius:10px 10px 10px 10px; background-color: #ffc107; color:rgba(0, 13, 136, 1); font-weight: 800px; " class="imgLeftPanel" class="primary">
							<a href="https://myplace-events.com/fr/e/create" class="" style="color: #060697; font-weight: 800px;"><strong>+Créer un événement</trong></a></button>
						<?php } ?>
						    
							<a href="javascript:void(0)" class="nav-link scart openCartmob" style="right: 40px;position: relative;top: 15px;">
                				<img src="{{ asset('/images/shopping-bag.png') }}" style="height:26px;" class="imgLeftPanel">
                				<span class="cart-badge" id="cart_badge2">{{ __('0') }}</span>
                			</a>							

							<a href="javascript:void(0);" class="bell-icon menu-toggler" style="position:relative;left: 10px;bottom: 15px; ">
								<img src="{{asset('/img/menu.png')}}"style="height: 30px;">
							</a>
						</div>
					</div>
				</div>
			</header>	  
			<div class="dark-overlay"></div>
		
	<!-- Sidebar -->
    <div class="sidebar">
		<?php if(auth()->guard('frontuser')->check()){ ?>
		<div class="author-box">
			<div class="dz-media">
				<img src="{{ asset('/img/plecy.png') }}" style="width: 100%" alt="User">
			</div>
			<div class="dz-info">
				<span>Bienvenue</span>
				<h5 class="name">{{ auth()->guard('frontuser')->user()->name }}</h5>
			</div>
		</div>
		<?php }else{ ?>
		<div class="author-box">
			<div class="dz-media">
				<img src="{{ asset('/img/plecy.png') }}" style="width: 100%" alt="User">
			</div>
			<div class="dz-info">
				<span style="letter-spacing: normal">Bienvenue sur<br> My Place Events</span>
			</div>
		</div>	
		<?php
		} 
		?>
		<ul class="nav navbar-nav" style="margin-bottom: 0px">	
	 
			<?php if(auth()->guard('frontuser')->check()){ ?>
            	<li class="nav-label">Mon Compte</li>
            	<li>
					<a class="nav-link" href="{{ route('user.bookmarks','upcoming') }}">@lang('words.user_menus.usr_mnu_log_1')
						<span class="label">{{ $upcount }}</span>
					</a>
				</li>
				<li><a class="nav-link" href="{{ route('user.bookmarks','saved') }}"><span>@lang('words.user_menus.usr_mnu_log_2')</span></a></li>
				<li><a class="nav-link" href="{{ route('events.manage') }}"><span>@lang('words.user_menus.usr_mnu_log_3')</span></a></li>
				<li><a class="nav-link" href="{{ route('shop.item.manage') }}"><span>@lang('words.user_menus.usr_mnu_log_10')</span></a></li>
				<li><a class="nav-link" href="{{ route('alu.index') }}"><span>@lang('words.user_menus.usr_mnu_log_5')</span></a></li>
				<li><a class="nav-link" href="{{ route('users.pro','profile') }}"><span>@lang('words.user_menus.usr_mnu_log_8')</span></a></li>
				<li><a class="nav-link" href="{{ route('org.index') }}"><span>@lang('words.user_menus.usr_mnu_log_6')</span></a></li>
				<li><a class="nav-link" href="{{ route('user.logout') }}"><span>@lang('words.user_menus.usr_mnu_log_9')</span></a></li>
			<?php } ?>			
			
			<li class="nav-label">Menu Principal</li>
			<li><a class="nav-link" href="{{ url('/') }}">
				<i class="fa fa-home dz-icon"></i>
				<span>Accueil</span>
			</a></li>
			<li><a class="nav-link" href="{{ route('events') }}">
				<i class="fa fa-calendar-check-o dz-icon" aria-hidden="true"></i>
				<span>Evénements</span>
			</a></li>
			<li><a class="nav-link" href="{{ route('prestataire') }}">
				<i class="fa fa-briefcase dz-icon" aria-hidden="true"></i>
				<span>Prestataires</span>
			</a></li>
			<li><a class="nav-link" href="{{ route('shop') }}">
				<i class="fa fa-shopping-bag dz-icon" aria-hidden="true"></i>
				<span>Boutique</span>
			</a></li>
			<li><a class="nav-link" href="{{ route('contacts.index') }}">
				<i class="fa fa-envelope dz-icon" aria-hidden="true"></i>
				<span>Contacts</span>
			</a></li>
		
		</ul>
		<div class="dropdown-divider" style="0px 20px"></div>
		<div class="sidebar-bottom">

			<ul class="navbar-nav mr-auto leftPanelsn" style="margin-bottom: 0px">
					 <li class="nav-item">
						<a class="nav-link" href="https://www.facebook.com/myplaceeventscom/" target="_blank" data-toggle="tooltip" title="Facebook" data-placement="bottom"><i class="ti-facebook"></i></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="https://www.instagram.com/myplace_events/" target="_blank" data-toggle="tooltip" title="Instagram" data-placement="bottom"><i class="ti-instagram"></i></a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank" data-toggle="tooltip" title="Youtube" data-placement="bottom"><i class="ti-youtube"></i></a>
					</li> 
					<li class="nav-item">
						<a class="nav-link" href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank" data-toggle="tooltip" title="LinkedIn" data-placement="bottom"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
					</li>  
					<li class="nav-item">
							<a class="nav-link" href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank" data-toggle="tooltip" title="WhatsApp" data-placement="bottom"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
					</li>  
				</ul>
			
			<div class="dropdown-divider" style="margin-bottom: 18px"></div>
			
		   <span style="display: inline-flex">Langues :</span><a class="nav-link dropdown-toggle langMenu" data-toggle="dropdown" style="right: -5px;position: relative;display: inline-flex;top: 6px;" href="javascript:void(0)" 
				   id="dropdownMenuButton1" data-bs-toggle="dropdown" data-currentlang="{{ Lang::locale() }}" aria-expanded="false">
					<?php $clang=""; if(Lang::locale()=="fr"){ ?><img src="{{ asset('/img/Fr.png') }}" width="24px" alt="" />
					<?php }else{ ?><img src="{{ asset('/img/En.png') }}" width="24px" alt="" /><?php } ?></a>
        				<ul class="dropdown-menu menuLangMob" aria-labelledby="dropdownMenuButton1">
        					@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        
        						@if($properties['native'] === 'Français')
        						<li class="lang {{ $localeCode }}">
        							<a class="dropdown-item dropdownlang-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" title="@lang('words.header.Français')" data-placement="bottom">
        								<img src="{{ asset('/img/Fr.png') }}" width="30px" alt="" />
        							</a>
        						</li>
        						@elseif($properties['native'] === 'English')
        						<li class="lang {{ $localeCode }}">
        							<a class="dropdown-item dropdownlang-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" title="@lang('words.header.Anglais')" data-placement="bottom">
        								<img src="{{ asset('/img/En.png') }}" width="30px" alt="" />
        							</a> 
        						</li>
        						@endif
        
        					@endforeach
        				</ul>
		    
		    <div class="dropdown-divider" style="margin-bottom: 18px"></div>

			<h6 class="name">2023 &copy; My Place Events - BNY Group</h6>
			<span class="ver-info">Mobile Version 1.0</span>
        </div>
    </div>
    <!-- Sidebar End -->		
      <div>
		  <div class="ns-exit" style="width: 100%; height: 200%; position: absolute; z-index: 0"></div>
          @yield('content')
      </div>
    </div>
	  
    <div class="container-fluid footer-wrapper ns-exit">@include('layouts.footer')</div>
	  
	  
	  
	  
	  
<?php /*  
<div class="menubar-area">
		<div class="toolbar-inner menubar-nav">
			<a href="{{url('/')}}" class="nav-link active">
				<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" xmlns:v="https://vecta.io/nano"><path d="M21.44 11.035a.75.75 0 0 1-.69.465H18.5V19a2.25 2.25 0 0 1-2.25 2.25h-3a.75.75 0 0 1-.75-.75V16a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75v4.5a.75.75 0 0 1-.75.75h-3A2.25 2.25 0 0 1 3.5 19v-7.5H1.25a.75.75 0 0 1-.69-.465.75.75 0 0 1 .158-.818l9.75-9.75A.75.75 0 0 1 11 .246a.75.75 0 0 1 .533.222l9.75 9.75a.75.75 0 0 1 .158.818z" fill="#b5b5b5"></path></svg>
			</a>
			
            <a href="javascript:void(0)" class="nav-link openConnexinBox">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="21" fill="#b5b5b5" xmlns:v="https://vecta.io/nano"><path d="M8 7.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 1 0 0 7.5zm7.5 9v1.5c-.002.199-.079.39-.217.532C13.61 20.455 8.57 20.5 8 20.5s-5.61-.045-7.282-1.718C.579 18.64.501 18.449.5 18.25v-1.5a7.5 7.5 0 1 1 15 0z"></path></svg>
			</a>
			
			<a href="{{ route('events.create') }}" class="nav-link add-post">
				<i class="fa-solid fa-plus"></i>
			</a>	
			
			<a href="javascript:void(0)" class="nav-link scart openCart">
				<i class="fa fa-shopping-bag" aria-hidden="true"></i>
				<span class="cart-badge" id="cart_badge2">{{ __('0') }}</span>
			</a>

			<a class="nav-link dropdown-toggle langMenu" data-toggle="dropdown" style="margin-top: -10px" href="javascript:void(0)" 
				   id="dropdownMenuButton1" data-bs-toggle="dropdown" data-currentlang="{{ Lang::locale() }}" aria-expanded="false">
					<?php $clang=""; if(Lang::locale()=="fr"){ ?><img src="{{ asset('/img/Fr.png') }}" width="24px" alt="" />
					<?php }else{ ?><img src="{{ asset('/img/En.png') }}" width="24px" alt="" /><?php } ?></a>
				<ul class="dropdown-menu menuLangMob" aria-labelledby="dropdownMenuButton1">
					@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

						@if($properties['native'] === 'Français')
						<li class="lang {{ $localeCode }}">
							<a class="dropdown-item dropdownlang-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" title="@lang('words.header.Français')" data-placement="bottom">
								<img src="{{ asset('/img/Fr.png') }}" width="30px" alt="" />
							</a>
						</li>
						@elseif($properties['native'] === 'English')
						<li class="lang {{ $localeCode }}">
							<a class="dropdown-item dropdownlang-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" title="@lang('words.header.Anglais')" data-placement="bottom">
								<img src="{{ asset('/img/En.png') }}" width="30px" alt="" />
							</a> 
						</li>
						@endif

					@endforeach
				</ul>
			
			 
			
		</div>
	</div>	  
*/ ?>
	  
	<div class="bottomPanel" style="display: none">
	  
		 <div class="leftPanelContent">
			 <div class="topbclose"><a href="javascript:void(0)" class="closebpanel"><i class="fa fa-times" aria-hidden="true" style="font-size: 20px;"></i></a></div>
			<?php 
			if(!auth()->guard('frontuser')->check()){
 
				$link = session('link_2');
				if(!isset($link))
					session(['link_2' => url()->previous()]);			
			?>
				<div class="getLogin">

						<div class="col-md-12">
							{!! Form::open(['route'=>'signin.postAjax','method'=>'post','class'=>'contact-form','id'=>'signinAjax']) !!}
							<div class="row">
								<div id="errors-list" class='errors-list'></div>

								<div class="col-md-12">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=> trans('words.signin_page_content.signin_field_e')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif <?php } ?>
								</div>

								<div class="col-md-12 passwordFieldClass">
									<input type="password" name="password" value="" class="form-control form-textbox" id="passwordFieldMobile" placeholder="{{ trans('words.user_create.user_cn_pwd') }}">
									<span class="input-group-text" id="togglePasswordMobile" style="cursor:pointer;">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</span>
									<?php if(isset($errors)){ ?> @if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span> @endif <?php } ?>
								</div>
								<div class="col-md-12">
									{!! Form::submit(trans('words.signin_page_content.signin_form_button'),['class'=>'pro-choose-file text-uppercase']) !!}
								</div>
								<div class="col-md-12">
									<a href="javascript:void(0)" class="resetLink openResetLink">@lang('words.signin_page_content.password_forget')</a>
								</div>

							</div>
							{!! Form::close() !!}
							<div class="form-row">
								<div class="col-md-12">
									<hr class="mt10">
									<div class="orConnectWith" style="font-size: 12px;">@lang('words.left_panel.or_connect')</div>
								</div>
								<div class="facebook-login auth-social mb10 col-md-12">
									<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"> Facebook</a>
								</div>
								<div class="google-login auth-social col-md-12">
									<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"> Google </a>
								</div>

								<div class="col-md-12 regBox"> 
									@lang('words.left_panel.not_register') <a href="javascript:void(0)" class="openRegisterLink">@lang('words.left_panel.register')</a>
								</div>
							</div>
						</div>				

				</div>
<style>
    .getRegister #phone{
        padding-left: 100px;
    }
</style>			
				<div class="getRegister" style="width: 100px;">
						<div class="col-md-12 col-sm-12 col-lg-12">
							{!! Form::open(['route'=>'signup.postAjax','method'=>'post','class'=>'contact-form','id'=>'registerAjax']) !!}

							<div id="errors-list3" class="errors-list3"></div>
							<div id="success-list3" class="success-list3"></div>

							<div class="form-row">
								<div class="col-md-12">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_email')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('email')) <span class="error">{{ $errors->first('email') }} </span> @endif <?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12" style="margin-bottom:10px;">
									{!! Form::text('lastname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_lnm')]) !!}
								</div>
								<div class="col-md-12">
									{!! Form::text('firstname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_fnm')]) !!}
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-sm-12 col-lg-12">
									<?php if(isset($errors)){ ?> @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }} </span> @endif <?php } ?>
									<?php if(isset($errors)){ ?> @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }} </span> <br>@endif <?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 form-group">
									{!! Form::text('mobile','',['class'=>'form-control form-textbox','placeholder'=>'          0123456789', 'id'=>'phone2', 'required']) !!}
									<?php if(isset($errors)){ ?>@if($errors->has('mobile')) <span class="error">{{ $errors->first('mobile') }} </span> @endif <?php } ?>
                                    <span id="valid-msg" class="hide">✓ Valide</span>
			                        <span id="error-msg" class="hide"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12">
									{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('password')) <span class="error">{{ $errors->first('password') }} </span> @endif <?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 col-lg-12 col-sm-12">
									{!! Form::password('confirm_password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('confirm_password'))<span class="error">{{ $errors->first('confirm_password') }} </span> @endif <?php } ?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<p class="sign-up-links"><input class="form-checkbox" type="checkbox" value="accept" name="accept" required="required"> @lang('words.left_panel.while_register')  <a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation/" target="_blank">@lang('words.left_panel.cdt')</a> @lang('words.left_panel.of_mpe')</p>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									{!! Form::submit(trans('words.left_panel.i_register'),['class'=>'pro-choose-file text-uppercase']) !!}
								</div>
							</div>
							{!! Form::close() !!}
							<div class="form-row">
								<div class="col-md-12">
									<hr class="mt10">
									<div class="orConnectWith" style="font-size: 12px;">@lang('words.left_panel.or_connect')</div>
								</div>
								<div class="facebook-login auth-social mb10 col-md-12">
									<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"> Facebook</a>
								</div>
								<div class="google-login auth-social col-md-12">
									<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"> Google </a>
								</div>

								<div class="col-md-12 regBox"> 
									@lang('words.left_panel.have_account') <a href="javascript:void(0)" class="openLoginLink">@lang('words.left_panel.connect')</a>
								</div>
							</div>
						</div>

				</div>

				<div class="getResetPswd">

					<div class="col-md-12 col-sm-12 col-lg-12">
						{!! Form::open(['route'=>'reset.postAjax','method'=>'post','class'=>'contact-form','id'=>'resetPswdAjax']) !!}
							<div class="row">
								<div id="errors-list2" class="errors-list2"></div>
								<div id="success-list2" class="success-list2"></div>

								<div class="col-md-12 col-lg-12 col-sm-12 form-group">
									{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_reset_page.reset_filed_pla')]) !!}
									<?php if(isset($errors)){ ?> @if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif <?php } ?>
								</div>
								<div class="col-md-12 col-sm-12 col-lg-12">
									{!! Form::submit(trans('words.user_reset_page.reset_form_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
								</div>		
								<div class="col-md-12 regBox"> 
									@lang('words.left_panel.remember') <a href="javascript:void(0)" class="openBackLoginLink">@lang('words.left_panel.connect')</a>
								</div>
							</div>
						{!! Form::close() !!}
					</div>


				</div>
			
			<?php 
	
			}else{ 

				if(auth()->guard('frontuser')->user()->status == 1){
$id = auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'';
$upcount = $datacout->upCounts($id);
Jenssegers\Date\Date::setLocale('fr');			
			?>
	
			<div class="getAccount">
				<div class="accountPanel"> 
					<ul class="">
						<li>
							<a href="{{ route('user.bookmarks','upcoming') }}">@lang('words.user_menus.usr_mnu_log_1')
								<span class="label">{{ $upcount }}</span>
							</a>
						</li>
						<li>
							<a href="{{ route('user.bookmarks','saved') }}">@lang('words.user_menus.usr_mnu_log_2')</a>
						</li>
						<li><a href="{{ route('events.manage') }}">@lang('words.user_menus.usr_mnu_log_3')</a></li>
						<li><a href="{{ route('shop.item.manage') }}">@lang('words.user_menus.usr_mnu_log_10')</a></li>
						<li><a href="{{ route('alu.index') }}">@lang('words.user_menus.usr_mnu_log_5')</a></li>
						<li><a href="{{ route('users.pro','profile') }}">@lang('words.user_menus.usr_mnu_log_8')</a></li>
						<li><a href="{{ route('org.index') }}">@lang('words.user_menus.usr_mnu_log_6')</a></li>
						<li><a href="{{ route('user.logout') }}">@lang('words.user_menus.usr_mnu_log_9')</a></li>
					</ul>				
				</div>
			
			</div>
	
			<?php } 
				
			} ?>
			
				<div class="quick-cart bgc">
                        <div class="arrow-up"></div>
                        <div id="top_minicart_container2">
                            <div id="top_cart_item_box"></div>
                            <div class="total-pricing">
                                <div class="total">
                                    <span class="total">@lang('words.shop.sub_total2'):</span>
                                    <span class="amount" id="top_cart_subtotal">00.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrapper">
							  <a href="javascript:void(0)" class="default-btn closeCart continueshop">@lang('words.shop.continue_shop')</a>
                            <a href="{{ route('frontend.checkout') }}" class="default-btn">@lang('words.shop.order')</a>
                        </div>
                    </div>
        </div>	  
	</div>
	   
    @include('layouts.script')

<script>
    
   if ($(window).width() <= 600) 
   {  
	   
	    $( ".box" ).each(function( index ) {
		   var v=$(this).find(".datexp .both:first-child table tr:first-child td").text();
		   var v2=v.substring(0, 3);
		   $(this).find(".datexp .both:first-child table tr:first-child td").text(v2);
			
		   var b=$(this).find(".datexp .both:first-child table tr:nth-child(3) td").text();
		   var b2=b.substring(0, 3);
		   $(this).find(".datexp .both:first-child table tr:nth-child(3) td").text(b2);
		});
	   
	   	$( ".box" ).each(function( index ) {
		   var v=$(this).find(".datexp .both:last-child table tr:first-child td").text();
		   var v2=v.substring(0, 3);
		   $(this).find(".datexp .both:last-child table tr:first-child td").text(v2);
			
		   var b=$(this).find(".datexp .both:last-child table tr:nth-child(3) td").text();
		   var b2=b.substring(0, 3);
		   $(this).find(".datexp .both:last-child table tr:nth-child(3) td").text(b2);
		});
       
   }
	
	<?php if(Lang::locale()=="en"){  ?>
	
		$( ".box" ).each(function( index ) {
		   var v=$(this).find(".datexp .both:first-child table tr:first-child td").text();
		   var v2=v.substring(0, 3);
		   $(this).find(".datexp .both:first-child table tr:first-child td").text(v2);
			
		   var b=$(this).find(".datexp .both:first-child table tr:nth-child(3) td").text();
		   var b2=b.substring(0, 3);
		   $(this).find(".datexp .both:first-child table tr:nth-child(3) td").text(b2);
		});
	   
	   	$( ".box" ).each(function( index ) {
		   var v=$(this).find(".datexp .both:last-child table tr:first-child td").text();
		   var v2=v.substring(0, 3);
		   $(this).find(".datexp .both:last-child table tr:first-child td").text(v2);
			
		   var b=$(this).find(".datexp .both:last-child table tr:nth-child(3) td").text();
		   var b2=b.substring(0, 3);
		   $(this).find(".datexp .both:last-child table tr:nth-child(3) td").text(b2);
		});
		
	
	<?php } ?>
	
	
	
	
	
 
            $('#searchButton').on("click", function(){
              $('#searchpanel').hide().slideDown( "slow" );
            });
        
            $('.ns-exit').on("click", function(){
				 
                $('#searchpanel').slideUp("slow");
				
				if($('.leftPanelContent').length!=0){

					if($('.leftPanelContent').css('display') != 'none'){ 
					    $('.leftPanelContent').slideToggle("slow");
					    $(".LeftMenuPanel").css("margin-left","-87px");
						$(".leftPanelContent > div").css("display","none");
 					} 
				}
            });
		
		
       function refreshShippingDropdown() {
            $.ajax({
                url: '{{ route("cart.info.ajax") }}',
                type: 'GET',
                success: function (data) {
                    $('#cart_badge, #cart_badge2').text(data.item_total);
                    $('#top_minicart_container, #top_minicart_container2').html(data.cart);
                },
                erorr: function (err) {
                    toastr.error('{{ __("Une erreur s\'est produite") }}');
                }
            });
        }
		
		refreshShippingDropdown();
		
		$(document).on('click', '.remove_cart_item', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let attributes = $(this).data('attr');
                $('.lds-ellipsis').show();

                $.ajax({
                    url: '<?php echo e(route("cart.ajax.remove")); ?>',
                    type: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        id: id,
                        product_attributes: attributes
                    },
                    success: function (data) {
                        $('.lds-ellipsis').hide(300);
                        $('#cart-container').html(data);
                        refreshShippingDropdown();
                    },
                    error: function (err) {
                        toastr.error('<?php echo e(__("Une erreur s\'est produite")); ?>');
                        $('.lds-ellipsis').hide(300);
                    }
                });
            });
</script>
<script>
	
	$(".openCart, .closeCart" ).click(function() {

  
		if($('.leftPanelContent').css('display') != 'none' && $(".quick-cart").css('display') == 'none'){	
			
			$(".quick-cart").slideToggle("slow");
			$(".getLogin").css("display","none");
			$(".getResetPswd").css("display","none");
			$(".getRegister").css("display","none");
			$(".getAccount").css("display","none"); 
			
		}else if($('.leftPanelContent').css('display') == 'none' && $(".quick-cart").css('display') != 'none'){
			
			$(".quick-cart").css("display","block")
			$(".getLogin").css("display","none")
			$(".getRegister").css("display","none")
			$(".getResetPswd").css("display","none")
			$( ".leftPanelContent" ).slideToggle( "slow");
			
		}else{
			$( ".leftPanelContent" ).slideToggle("slow", function(){  
				$(".quick-cart").css("display","block");
				$(".getLogin").css("display","none");
				$(".getResetPswd").css("display","none");
				$(".getRegister").css("display","none")	  
				$(".getAccount").css("display","none");	  
		    });
		}

	});
	 	
	$(document).ready(function () {    
												
		$("body").on("click",".quant .changek a",function(e){  
			  e.preventDefault();
			  var _this=$(this);

			  var id = _this.closest('.changek').data('id');
			  var way= _this.data("way");

			  qt_change(way,id)
		 });

 	});
	
	
	function qt_change(way, id){
		 var qte=0;

          var quantity = $('#input-'+id).val(); 
          if(way=='up'){
              quantity++; qte=1;
          } else {
              quantity--; qte=-1
          }
          if(quantity<1){
            quantity = 1;
          }
           
          $('#input-'+id).val(quantity);
 		  updateCart(id, qte)

    }
	
	function updateCart(product_id,qte){
 
		$.ajax({
			url: '<?php echo e(route("add.to.cart.ajax")); ?>',
			type: 'POST',
			data: {
				product_id: product_id,
				quantity: qte,
				product_attributes: [],
				_token: '<?php echo e(csrf_token()); ?>'
			},
			success: function (data) {
				refreshShippingDropdown();
			},
			erorr: function (err) {
				alert('<?php echo e(__("Quelque chose s'est mal passé !! Essayez à nouveau")); ?>');
			}
		});
	}

<?php 
	
if(!Auth::guard('frontuser')->check()){ 
?>
	function openConnexinBox(){  
            
            	if($('.leftPanelContent').css('display') != 'none' && $(".getLogin").css('display') == 'none'){
            		 
            			$(".LeftMenuPanel ").css("margin-left","0")
            			$(".getLogin").slideToggle("slow")
            			$(".getRegister").css("display","none")
            			$(".quick-cart").css("display","none")
            			$(".getResetPswd").css("display","none")
            	}else if($('.leftPanelContent').css('display') == 'none' && $(".getLogin").css('display') != 'none'){
            		 
            			$(".LeftMenuPanel ").css("margin-left","0")
            			$(".getLogin").css("display","block")
            			$(".getRegister").css("display","none")
            			$(".quick-cart").css("display","none")
            			$(".getResetPswd").css("display","none")
            			$( ".leftPanelContent" ).slideToggle( "slow");
            	}else{
            		 
            		  $( ".leftPanelContent" ).slideToggle( "slow", function() {  
            			$(".LeftMenuPanel ").css("margin-left","0")
            			$(".getLogin").css("display","block")
            			$(".getRegister").css("display","none")
            			$(".quick-cart").css("display","none")
            			$(".getResetPswd").css("display","none")
            			
            		  });
            	}
            	$('#signupAlertLike').modal('toggle')
            	    
	}
	
	
	function openRegisterBox(){  
            
            	if($('.leftPanelContent').css('display') != 'none' && $(".getLogin").css('display') == 'none'){
            		 
            			$(".LeftMenuPanel ").css("margin-left","0")
            			$(".getLogin").css("display","none")
            			$(".getRegister").slideToggle("slow")
            			$(".quick-cart").css("display","none")
            			$(".getResetPswd").css("display","none")
            	}else if($('.leftPanelContent').css('display') == 'none' && $(".getLogin").css('display') != 'none'){
            		 
            			$(".LeftMenuPanel ").css("margin-left","0")
            			$(".getLogin").css("display","none")
            			$(".getRegister").css("display","block")
            			$(".quick-cart").css("display","none")
            			$(".getResetPswd").css("display","none")
            			$( ".leftPanelContent" ).slideToggle( "slow");
            	}else{
            		 
            		  $( ".leftPanelContent" ).slideToggle( "slow", function() {  
            			$(".LeftMenuPanel ").css("margin-left","0")
            			$(".getLogin").css("display","none")
            			$(".getRegister").css("display","block")
            			$(".quick-cart").css("display","none")
            			$(".getResetPswd").css("display","none")
            			
            		  });
            	}
            	$('#signupAlertLike').modal('toggle');
            	    
	}	

	
$( ".openConnexinBox.closeme" ).on("click", function() {
	
 
	if ($(window).width() <= 600){
		$(".bottomPanel").slideToggle("slow");
		$('.bottomPanel .leftPanelContent').slideToggle("slow");
	}else{
		//$(".LeftMenuPanel").slideToggle("slow");
        $('.leftPanelContent').slideToggle("slow");
	}
	
	if($(".getLogin").css('display') == 'none'){
 			$(".getLogin").css("display","block")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","none")
			$(".getResetPswd").css("display","none")
			$(".bottomPanel .LeftMenuPanel ").css("margin-left","0");
			$(".LeftMenuPanel").attr('style','margin-left: 0px !important');
    }else{
		 	$(".getLogin").css("display","none")
	} 
	
	$(".openConnexinBox").removeClass("closeme");
	$(this).addClass("open");
	
});	
	
$( ".openConnexinBox.open" ).click(function() {
	if ($(window).width() <= 600){
		$(".bottomPanel").slideToggle("slow");
		$('.bottomPanel .leftPanelContent').slideToggle("slow");
	}else{
		//$(".LeftMenuPanel").slideToggle("slow");
        $('.leftPanelContent').slideToggle("slow");
	}
	
	if($(".getLogin").css('display') == 'none'){
 			$(".getLogin").slideToggle("slow");
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","none")
			$(".getResetPswd").css("display","none")
			$(".bottomPanel .LeftMenuPanel ").css("margin-left","0");		
    } 
	
	$(".openConnexinBox").removeClass("open");
	$(this).addClass("closeme");
	
});	
	
		
	
$( ".createEventBut.closeme" ).on("click", function() {
	 
	if ($(window).width() <= 600){
		$(".bottomPanel").slideToggle("slow");
		$('.bottomPanel .leftPanelContent').slideToggle("slow");
	}else{
		//$(".LeftMenuPanel").slideToggle("slow");
        $('.leftPanelContent').slideToggle("slow");
	}
 	
	if($(".getLogin").css('display') == 'none'){
 			$(".getLogin").css("display","block")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","none")
			$(".getResetPswd").css("display","none")
			$(".LeftMenuPanel").attr('style','margin-left: 0px !important');
			//$(".LeftMenuPanel").css("margin-left","0px !important");		
     }else{
		  	$(".getLogin").css("display","none")
	 }
	 
	
});		
	
	/*$( ".openConnexinBox.close" ).click(function() {
	
	if ($(window).width() <= 600){
		$(".bottomPanel").slideToggle("slow");
		$('.bottomPanel .leftPanelContent').slideToggle("slow");
	}else{
		//$(".LeftMenuPanel").slideToggle("slow");
        $('.leftPanelContent').slideToggle("slow");
	}
	
	if($(".getLogin").css('display') == 'none'){
 			$(".getLogin").slideToggle("slow")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","none")
			$(".getResetPswd").css("display","none")
			$(".bottomPanel .LeftMenuPanel ").css("margin-left","0");
		
    }else if($(".getLogin").css('display') != 'none'){
 			$(".getLogin").slideToggle("slow")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","none")
			$(".getResetPswd").css("display","none")
			//$( ".leftPanelContent" ).slideToggle( "slow");
			$(".bottomPanel .LeftMenuPanel ").css("margin-left","-87px")
	}else{
 		  $( ".bottomPanel .leftPanelContent" ).slideToggle( "slow", function() {  
			$(".getLogin").css("display","none")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","none")
			$(".getResetPswd").css("display","none")
			$(".LeftMenuPanel ").css("margin-left","0")
		  });
	}
	
});	*/

	
	
$( ".openRegisterLink" ).click(function() {
	$( ".getLogin" ).slideToggle( "slow");
	$(".getRegister").slideToggle( "slow");
});
	
$(".openLoginLink").click(function() {
  	$(".getRegister").slideToggle( "slow");
    $(".getLogin").slideToggle( "slow");
});	
	
$( ".openResetLink" ).click(function() {
	$(".getLogin").slideToggle( "slow");
    $(".getResetPswd").slideToggle( "slow");
});		

$( ".openBackLoginLink" ).click(function() {
  	$(".getResetPswd").slideToggle( "slow");
	$(".getLogin").css("display","block")
});	
<?php }else{
?>
 
$( ".openConnexinBox" ).click(function() {
 
	if($('.leftPanelContent').css('display') == 'none' && $(".getAccount").css('display') == 'none'){

		  $( ".leftPanelContent" ).slideToggle( "slow", function() {
			$(".getAccount").css("display","block");
			$(".quick-cart").css("display","none"); 
		  });
		
	}else if($('.leftPanelContent').css('display') != 'none' && $(".getAccount").css('display') != 'none'){

		  $( ".leftPanelContent" ).slideToggle( "slow", function() {
			$(".getAccount").css("display","none");
			$(".quick-cart").css("display","none"); 
		  });
		
	}else{	

		$(".getAccount").css("display","block");
		$(".quick-cart").css("display","none"); 
		
	}
});	
	
<?php	
}  ?>
	 

$( ".openCartmob" ).click(function() {
	
    $(".bottomPanel").slideToggle("slow")
    $(".bottomPanel .leftPanelContent").slideToggle("slow")
	
	if($(".quick-cart").css('display') == 'none'){
			$(".getAccount").css("display","none")
			$(".getRegister").css("display","none")
			$(".quick-cart").slideToggle("slow")
			$(".getResetPswd").css("display","none")
			$(".LeftMenuPanel ").css("margin-left","0")
		
    }else if($(".quick-cart").css('display') != 'none'){
			$(".getLogin").css("display","none")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","block")
			$(".getResetPswd").css("display","none")
			$(".LeftMenuPanel ").css("margin-left","-87px")
		
	}else{
		
		  $( ".leftPanelContent" ).slideToggle( "slow", function() {  
			$(".getLogin").css("display","none")
			$(".getRegister").css("display","none")
			$(".quick-cart").css("display","block")
			$(".getResetPswd").css("display","none")
			$(".LeftMenuPanel ").css("margin-left","0")
		  });
	}
	
});		
		
	
 function openLeftBoxpan(){
		var attr_=$("#LeftMenuPanel").attr("style");
		console.log(attr_)
		if(attr_=='margin-left: -87px;'){
			$("#LeftMenuPanel").animate({
					'margin-left' : '0px','position':'relative'
			});  			
		}else{
			$("#LeftMenuPanel").animate({
					'margin-left' : '-87px','position':'relative'
			});  
			$('.leftPanelContent').css("display","none")
		}  
	} 
	  
 $(document).ready(function() {
		   $("#LeftMenuPanel").animate({
				'margin-left' : '-87px','position':'relative'
		   });    
		  
		  $('.leftPanelContent').css("display","none");
		  
		  $(".closebpanel").on("click", function(){
			  console.log("Close bottom panel")
 			$(".getLogin").css("display","none");
			$(".getRegister").css("display","none");
			$(".quick-cart").css("display","none");
			$(".getResetPswd").css("display","none");

			$(".bottomPanel").slideToggle("slow");
			$('.bottomPanel .leftPanelContent').slideToggle("slow");
 			 
	  	  });
	});
        
        
</script>
<?php if(!Auth::guard('frontuser')->check()){ ?>
<script type="text/javascript">

 
  $(function() {

      /*------------------------------------------
      --------------------------------------------
       Signin AJAX
      --------------------------------------------
      --------------------------------------------*/
      $(document).on("submit", "#signinAjax", function() {
          var e = this;
 
          $("#signinAjax input[type='submit']").attr("value", "Connexion en cours...");
  			$('#errors-list').fadeOut();
          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
              success: function (data) {
  			   $(".alert").remove();
               $("#signinAjax input[type='submit']").attr("value", "Se connecter");
  
                if (data.status) {
                    window.location = data.redirect;
                }else{
                    $.each(data.errors, function (key, val) {
						$('.errors-list').fadeIn();
                        $("#errors-list, .errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
               
              },
			  error: function(jqXHR){
				  var msg=jqXHR.responseText;
				  console.log("Connexion failed : "+jqXHR.responseText)
					$("#resetPswdAjax input[type='submit']").attr("value", "{{trans('words.user_reset_page.reset_form_btn')}}");

					$(".alert").remove();
					$.each(msg.errors, function (key, val) {
						$("#errors-list, .errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
					});
			  } 
			 
			  
          })/*.fail(function(jqXHR) {
			   var msg=jqXHR.responseText;
			  console.log("Connexion failed : "+jqXHR.responseText)
				$("#resetPswdAjax input[type='submit']").attr("value", "{{trans('words.user_reset_page.reset_form_btn')}}");

				$(".alert").remove();
				$.each(msg.errors, function (key, val) {
					$("#errors-list, errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
				});
		  })*/
  
           return false;
		  
      });
	  
	  /*------------------------------------------
      --------------------------------------------
       Reset Pswd AJAX
      --------------------------------------------
      --------------------------------------------*/
      $(document).on("submit", "#resetPswdAjax", function() {
          var e = this;
  
          $("#resetPswdAjax input[type='submit']").attr("value", "Opération en cours...");
  
          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
			  cache: false,
              success: function (data) {
  
	       $(".alert").remove();
               $("#resetPswdAjax input[type='submit']").attr("value", "{{trans('words.user_reset_page.reset_form_btn')}}");

                if(data.status) {
                    $.each(data.success, function (key, val) {
                        $("#success-list, .success-list2").append("<div class='alert alert-success'>" + val + "</div>");
                    });
					
                }else{  
                    $.each(data.errors, function (key, val) {
                        $("#errors-list2, .errors-list2").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
               
              }			  
			  
          }).fail(function(jqXHR) {
			  var msg=$.parseJSON(jqXHR.responseText);
			  
			  		$("#resetPswdAjax input[type='submit']").attr("value", "{{trans('words.user_reset_page.reset_form_btn')}}");
			  
					$(".alert").remove();
                    $.each(msg.errors, function (key, val) {
                        $("#errors-list2, .errors-list2").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
		  });
  
          return false;
      });
	  
	  
  	  /*------------------------------------------
      --------------------------------------------
       Register AJAX
      --------------------------------------------
      --------------------------------------------*/
      $(document).on("submit", "#registerAjax", function() {
          var e = this;
  
          $("#registerAjax input[type='submit']").attr("value", "Inscription en cours...");
  
          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
			  cache: false,
              success: function (data) {
  
               $("#registerAjax input[type='submit']").attr("value", "JE M’INSCRIS");

                if(data.status) {
                    $(".alert").remove();
                    $.each(data.success, function (key, val) {
                        $("#success-list3, .success-list3").append("<div class='alert alert-success'>" + val + "</div>");
                    });
					$('#registerAjax')[0].reset();
					
                }else{  
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $(".errors-list3").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
               
              }			  
			  
          }).fail(function(jqXHR) {
			  var msg=$.parseJSON(jqXHR.responseText);
 			  
			  		$("#registerAjax input[type='submit']").attr("value", "JE M’INSCRIS");
			  
					$(".alert").remove();
                    $.each(msg.errors, function (key, val) {
                        $(".errors-list3").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
			   
		  });
  
          return false;
      });
	  
  });


  	/*------------------------------------------
      --------------------------------------------
       Show/Hide Password field
      --------------------------------------------
      --------------------------------------------*/
  	const togglePassword = document.getElementById('togglePassword');
    const passwordField  = document.getElementById('passwordField');
	const togglePasswordMobile = document.getElementById('togglePasswordMobile');
	const passwordFieldMobile  = document.getElementById('passwordFieldMobile');

    togglePassword.addEventListener('click', function () {
      // On récupère l'icône
      const icon = this.querySelector('i');

      if (passwordField.type === 'password' ) {
        // Si c’est un champ "password", on le passe en "text"
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        // Sinon, on fait l’inverse
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

	togglePasswordMobile.addEventListener('click', function () {
      // On récupère l'icône
      const icon = this.querySelector('i');

      if (passwordFieldMobile.type === 'password' ) {
        // Si c’est un champ "password", on le passe en "text"
        passwordFieldMobile.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        // Sinon, on fait l’inverse
        passwordFieldMobile.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

</script>

<?php } ?>
 
    @yield('pageScript')
    @yield('topPageScript')
    </body>
</html>