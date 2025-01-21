@extends($theme)

@section('meta_title',setMetaData()->user_signup_title)
@section('meta_description',setMetaData()->user_signup_desc)
@section('meta_keywords',setMetaData()->user_signup_keyword)

@section('content')
<div class="container page-main-contain">
<div col-md-6 col-sm-12 col-lg-6>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12 signup-title text-center">
			<h1>@lang('words.user_create.user_cn_title')</h1>
			<p>@lang('words.user_create.user_cn_tag')</p>
		</div>
	</div>
	<div class="row sign-in-form">
		<div class="col-md-12 col-sm-12 col-lg-12">
			{!! Form::open(['route'=>'signup.post','method'=>'post','class'=>'contact-form']) !!}
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 form-group">
					{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_email')]) !!}
					@if($errors->has('email')) <span class="error">{{ $errors->first('email') }} </span> @endif
				</div>
				<div class="col-md-6 col-lg-6 col-sm-12 form-group">
					{!! Form::text('lastname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_lnm')]) !!}
				</div>				
				
				<div class="col-md-6 col-lg-6 col-sm-12 form-group">
					{!! Form::text('firstname','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_fnm')]) !!}
				</div>

				<div class="col-md-12 col-sm-12 col-lg-12">
					@if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }} </span> @endif
					@if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }} </span> @endif <br>
				</div>
				<div class="col-md-12 col-lg-12 col-sm-12 form-group">
					{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!}
					@if($errors->has('password')) <span class="error">{{ $errors->first('password') }} </span> @endif
				</div>
				<div class="col-md-12 col-lg-12 col-sm-12 form-group">
					{!! Form::password('confirm_password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
					@if($errors->has('confirm_password'))	 <span class="error">{{ $errors->first('confirm_password') }} </span> @endif
				</div>
				<div class="col-md-12 col-ms-12 col-lg-12">
					<p class="sign-up-links">@lang('words.user_create.user_box_con1') {{ forcompany() }} @lang('words.user_create.user_box_con2')<a href="">@lang('words.user_create.user_box_ter')</a>, <a href="">@lang('words.user_create.user_box_pri')</a>, @lang('words.user_create.user_box_guad')</p>
				</div>
				<div class="col-md-5 col-ms-12 col-lg-5">
					{!! Form::submit(trans('words.user_create.user_cn_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		<div class="facebook-login auth-social" id="twitter-btn">
			<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded"><i class="fa fa-facebook"></i> Facebook</a>
		</div>
		<div class="google-login auth-social" id="twitter-btn">
			<a href="{{url('oauth/google')}}" class="btn btn-block btn-lg google custom-rounded"><i class="fa fa-google"></i> Google</a>
		</div>
	</div>

</div>
<div col-md-6 col-sm-12 col-lg-6>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-lg-12 signup-title text-center">
				<h1>@lang('words.signin_page_content.signin_form_title')</h1>
				<p>@lang('words.signin_page_content.signin_form_tag')</p>
			</div>
		</div>

		<div class="row sign-in-form">
			<div class="col-md-12 col-sm-12 col-lg-12">
				{!! Form::open(['route'=>'signin.post','method'=>'post','class'=>'contact-form']) !!}
				<div class="row">
					@if($success = Session::get('success'))
						<div class="col-md-12 col-sm-12 col-lg-12"><div class="alert alert-success">{{ $success }}</div></div>
					@endif
					@if($error = Session::get('error'))
						<div class="col-md-12 col-sm-12 col-lg-12"><div class="alert alert-danger">{{ $error }}</div></div>
					@endif
					@if($errorsa = Session::get('errorsa'))
						<div class="col-md-12 col-sm-12 col-lg-12"><div class="alert alert-danger">{{ $errorsa }}</div></div>
					@endif

					<div class="col-md-12 col-lg-12 col-sm-12 form-group">
						{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=> trans('words.signin_page_content.signin_field_e')]) !!}
						@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
					</div>

					<div class="col-md-12 col-lg-12 col-sm-12 form-group">
						{{--{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_pwd')]) !!} --}}
						<input type="password" name="password" value="" class="form-control form-textbox" placeholder="{{ trans('words.user_create.user_cn_pwd') }}">
						@if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span> @endif
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12">
						{!! Form::submit(trans('words.signin_page_content.signin_form_button'),['class'=>'pro-choose-file text-uppercase']) !!}
					</div>
					<div class="col-sm-12 col-md-5 col-lg-5">
						<br>
						<a href="{{ route('reset.link') }}">@lang('words.signin_page_content.password_forget')</a>
					</div>
					<div class="col-md-7 col-sm-12 col-lg-7 text-right text-capitalize">
						<br>
						<a href="{{ route('user.signup') }}">@lang('words.signin_page_content.create_new_user')</a>
					</div>
				</div>
				{!! Form::close() !!}
				<div class="facebook-login auth-social" id="twitter-btn">
					<a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded"><i class="fa fa-facebook"></i> Facebook</a>
				</div>
				<div class="google-login auth-social" id="twitter-btn">
					<a href="{{url('oauth/google')}}" class="btn btn-block btn-lg google custom-rounded"><i class="fa fa-google"></i> Google </a>
				</div>
				@if(siteSetting()->google_login != 0 || siteSetting()->linkedin_login != 0 || siteSetting()->twitter_login != 0)
					<div class="socail-login text-center">
						<ul class="list-inline">
							{{--
                                @if(siteSetting()->google_login != 0)
                                <li><a href="{{ route('provieder','google') }}"><i class="fa fa-google-plus" data-onsuccess="onSignIn"></i></a></li>
                                <li><a href="javascript:void(0);" onclick="onSignIn(data)"><i class="fa fa-google"></i></a></li>
                                <div class="g-signin2" data-onsuccess="onSignIn"></div>
                            @endif
                            --}}
							@if(siteSetting()->linkedin_login != 0 && siteSetting()->linkedin_client_id != '' && siteSetting()->linkedin_redirect_url !='' && siteSetting()->linkedin_secret_id !='')
								<li><a href="{{ route('provieder','linkedin') }}"><i class="fa fa-linkedin"></i></a></li>
							@endif
							@if(siteSetting()->twitter_login != 0 )
								<li><a href="{{ route('provieder','twitter') }}"><i class="fa fa-twitter"></i></a></li>
							@endif
						</ul>
					</div>
				@endif
			</div>
		</div>
</div>
</div>
@endsection