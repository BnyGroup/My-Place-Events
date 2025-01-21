@extends($theme)

@section('meta_title',setMetaData()->pass_reset_title)
@section('meta_description',setMetaData()->pass_reset_desc)
@section('meta_keywords',setMetaData()->pass_reset_keyword)

@section('content')
<div class="container page-main-contain">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12 signup-title text-center">
			<h1>@lang('words.update_pwd.upd_pwd_tit')</h1>
		</div>
	</div>
	<div class="row sign-in-form">
		<div class="col-md-12 col-sm-12 col-lg-12">
			{!! Form::model($token,['route'=>['reset.password','token'=>$token],'method'=>'patch','class'=>'contact-form']) !!}
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 form-group">
						{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.signin_page_content.signin_field_e')]) !!}
						@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12 form-group">
						{!! Form::password('password',['class'=>'form-control form-textbox','placeholder'=>trans('words.signin_page_content.signin_field_p')]) !!}
						@if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span> @endif
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12 form-group">
						{!! Form::password('confirmation_password',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_create.user_cn_cpwd')]) !!}
						@if($errors->has('confirmation_password')) <span class="error">{{ $errors->first('confirmation_password') }}</span> @endif
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12">
						{!! Form::submit(trans('words.update_pwd.upd_pwd_tit'),['class'=>'pro-choose-file text-uppercase']) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection