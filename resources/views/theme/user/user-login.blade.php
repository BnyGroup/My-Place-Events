@extends($theme)

@section('meta_title',setMetaData()->user_loging_title)
@section('meta_description',setMetaData()->user_loging_desc)
@section('meta_keywords',setMetaData()->user_loging_keyword)

@section('recaptcha')
{!! htmlScriptTagJsApi(['action' => 'homepage',]) !!}
@endsection

@section('content')
<div class="light-bg">
	<div class="container page-main-contain">
		<div class="row">
			<div class="col-md-12 mb20">
				<h2 class="primary-color mobile-title fw-light title-large-40" align="center"> Lancez-vous !</h2>
			</div>
		</div>
		<div class="row">

	<!--Connexion Mobile--->
	<div class="col-md-12 d-block d-sm-none">
		<!-- Nav pills -->
		<ul class="nav nav-pills justify-content-center">
			<li class="nav-item">
				<a class="nav-link active text-uppercase nav-connexion" data-toggle="pill" href="#connexion-mobile">Connexion</a>
			</li>
			<li class="nav-item">
				<a class="nav-link nav-inscription" data-toggle="pill" href="#inscription-mobile">Inscription</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane container active" id="connexion-mobile">
				<div class="col-md-12">
					{!! Form::open(['route'=>'signin.post','method'=>'post','class'=>'contact-form']) !!}
					<div class="row">
						@if($success = Session::get('success'))
						<div class="col-md-12"><div class="alert alert-success">{{ $success }}</div></div>
						@endif
						@if($error = Session::get('error'))
						<div class="col-md-12"><div class="alert alert-danger">{{ $error }}</div></div>
						@endif
						@if($errorsa = Session::get('errorsa'))
						<div class="col-md-12"><div class="alert alert-danger">{{ $errorsa }}</div></div>
						@endif

						<div class="col-md-12 form-group">
							{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=> trans('words.signin_page_content.signin_field_e')]) !!}
							@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
						</div>

						<div class="col-md-12  form-group">
							{{--{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!} --}}
							<input type="password" name="password" value="" class="form-control form-textbox" placeholder="{{ trans('words.user_create.user_cn_pwd') }}">
							@if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span> @endif
						</div>
						<div class="col-md-12">
							{!! Form::submit(trans('words.signin_page_content.signin_form_button'),['class'=>'pro-choose-file text-uppercase']) !!}
						</div>
						<div class="col-sm-12 col-md-5 col-lg-5">
							<br>
							<a href="{{ route('reset.link') }}">@lang('words.signin_page_content.password_forget')</a>
						</div>
						
					</div>
					{!! Form::close() !!}
					<div class="form-row">
						<div class="col-md-12">
							<hr class="mt10">
							<div class="ou" style="background: #f5f5f5;">Ou</div>
						</div>
						<div class="facebook-login auth-social mb10 col-md-12">
							<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"><i class="fab fa-facebook"></i> Facebook</a>
						</div>
						<div class="google-login auth-social col-md-12">
							<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"><i class="fab fa-google"></i> Google </a>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane container fade" id="inscription-mobile">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-lg-12">
						{!! Form::open(['route'=>'signup.post','method'=>'post','class'=>'contact-form']) !!}
						<div class="form-row">
							<div class="col-md-12 form-group">
								{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_email')]) !!}
								@if($errors->has('email')) <span class="error">{{ $errors->first('email') }} </span> @endif
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
								@if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }} </span> @endif
								@if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }} </span> <br>@endif
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 col-lg-12 col-sm-12 form-group">
								{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!}
								@if($errors->has('password')) <span class="error">{{ $errors->first('password') }} </span> @endif
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 col-lg-12 col-sm-12 form-group">
								{!! Form::password('confirm_password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
								@if($errors->has('confirm_password'))<span class="error">{{ $errors->first('confirm_password') }} </span> @endif
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<p class="sign-up-links"><input class="form-control form-checkbox" type="checkbox" value="accept" name="accept" required="required"> En m'inscrivant j'accepte les  <a href="https://blog.myplace-events.com/condition-generales-dutilisation/" target="_blank">Conditions Générales d'utilisation</a> de My Place Events</p>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								{!! Form::submit(trans('words.user_create.user_cn_btn'),['class'=>'pro-choose-file text-uppercase secondary-bg']) !!}
							</div>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Connexion Mobile--->


	<!-- Connexion-->
	<div class="col-lg-6 d-none d-sm-block">
		<div class="col-md-12 login-content connexion">
			<div class="row">
				<div class="col-lg-12 signup-title text-center">
					<h1 class="primary-color"><i class="fas fa-sign-in-alt"></i> @lang('words.signin_page_content.signin_form_title')</h1>
					<p>@lang('words.signin_page_content.signin_form_tag')</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					{!! Form::open(['route'=>'signin.post','method'=>'post','class'=>'contact-form']) !!}
					<div class="row">
						@if($success = Session::get('success'))
						<div class="col-md-12"><div class="alert alert-success">{{ $success }}</div></div>
						@endif
						@if($error = Session::get('error'))
						<div class="col-md-12"><div class="alert alert-danger">{{ $error }}</div></div>
						@endif
						@if($errorsa = Session::get('errorsa'))
						<div class="col-md-12"><div class="alert alert-danger">{{ $errorsa }}</div></div>
						@endif

						<div class="col-md-12 form-group">
							{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=> trans('words.signin_page_content.signin_field_e')]) !!}
							@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
						</div>

						<div class="col-md-12  form-group">
							{{--{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!} --}}
							<input type="password" name="password" value="" class="form-control form-textbox" placeholder="{{ trans('words.user_create.user_cn_pwd') }}">
							@if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span> @endif
						</div>
						<div class="col-md-12">
							{!! Form::submit(trans('words.signin_page_content.signin_form_button'),['class'=>'pro-choose-file text-uppercase']) !!}
						</div>
						<div class="col-sm-12 col-md-5 col-lg-5">
							<br>
							<a href="{{ route('reset.link') }}">@lang('words.signin_page_content.password_forget')</a>
						</div>
					</div>
					{!! Form::close() !!}
					<div class="form-row">
						<div class="col-md-12">
							<hr class="mt10">
							<div class="ou">Ou</div>
						</div>
						<div class="facebook-login auth-social mb10 col-md-12">
							<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg"><i class="fab fa-facebook"></i> Facebook </a>
						</div>
						<div class="google-login auth-social col-md-12">
							<a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"><i class="fab fa-google"></i> Google </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Fin Connexion-->

	<!--Inscription-->
	<div class="col-lg-6 d-none d-sm-block">
		<div class="col-md-12 login-content inscription ">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12 signup-title text-center">
					<h1 class="secondary-color"><i class="fas fa-user-plus"></i>  @lang('words.user_create.user_cn_title')</h1>
					<p>@lang('words.user_create.user_cn_tag')</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					{!! Form::open(['route'=>'signup.post','method'=>'post','class'=>'contact-form']) !!}
					<div class="form-row">
						<div class="col-md-12 form-group">
							{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_email')]) !!}
							@if($errors->has('email')) <span class="error">{{ $errors->first('email') }} </span> @endif
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
							@if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }} </span> @endif
							@if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }} </span> <br>@endif
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 col-lg-12 col-sm-12 form-group">
							{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!}
							@if($errors->has('password')) <span class="error">{{ $errors->first('password') }} </span> @endif
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 col-lg-12 col-sm-12 form-group">
							{!! Form::password('confirm_password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
							@if($errors->has('confirm_password'))	 <span class="error">{{ $errors->first('confirm_password') }} </span> @endif
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12">
							<p class="sign-up-links"><input class="form-checkbox mr-2" type="checkbox" value="accept" name="accept" required="required">En m'inscrivant j'accepte les  <a href="https://blog.myplace-events.com/condition-generales-dutilisation/" target="_blank">Conditions Générales d'utilisation</a> de My Place Events</p>
						</div>
					</div>
					<div class="g-recaptcha2" data-sitekey="{{ config('services.google.google_recaptcha_key') }}">
					</div>
					<div class="form-row">
						<div class="col-md-12">
							{!! Form::submit(trans('words.user_create.user_cn_btn'),['class'=>'pro-choose-file text-uppercase secondary-bg']) !!}
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<!--FIN Inscription-->
	</div>
	<div class="row">
	</div>
</div>
</div>
</div>

<!-- <script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="1083235206498-bs5l822q87cde3uj3858bn6044f7ck9b.apps.googleusercontent.com">
{{--<div class="g-signin2" data-onsuccess="onSignIn"></div>--}}


<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();

  var id 	= profile.getId();
  var name 	= profile.getName();
  var image = profile.getImageUrl();
  var email = profile.getEmail();
  var fnm 	= profile.getGivenName();
  var lnm 	= profile.getFamilyName();       
  var id_token = googleUser.getAuthResponse().id_token;


  $.ajax({
	  	url: "{{--{{ route('google.login') }}--}}",
	  	type: 'post',
	  	dataType: 'json',
	  	data: {_token:"{{--{{ csrf_token() }	}--}}",id:id_token,name:name,image:image,email:email,fnm:fnm,lnm:lnm},
	  	success:function(data){
	  		window.location.href = data;
	  	}
  	}) 
}
</script> -->
{{--<script src='https://www.google.com/recaptcha/api.js'></script>--}}
@endsection