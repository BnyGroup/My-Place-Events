@extends($theme)

@section('meta_title',setMetaData()->pass_update_title)
@section('meta_description',setMetaData()->pass_update_desc)
@section('meta_keywords',setMetaData()->pass_update_keyword)

@section('content')
<div class="container page-main-contain">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12 signup-title text-center">
			<h1>@lang('words.user_reset_page.reset_pwd_title')</h1>
		</div>
	</div>
	<div class="row sign-in-form">
		<div class="col-md-12 col-sm-12 col-lg-12">
			{!! Form::open(['route'=>'reset.post','method'=>'post','class'=>'contact-form']) !!}
				<div class="row">
					@if($error = \Session::get('error'))
						<div class="col-md-12 col-sm-12 col-lg-12">
							<div class="alert alert-info">{{ $error }}</div>
						</div>
					@endif
					@if($success = Session::get('success'))
						<div class="col-md-12 col-sm-12 col-lg-12"><div class="alert alert-success">{{ $success }}</div></div>
					@endif
					<div class="col-md-12 col-lg-12 col-sm-12 form-group">
						{!! Form::email('email','',['class'=>'form-control form-textbox','placeholder'=>trans('words.user_reset_page.reset_filed_pla')]) !!}
						@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12">
						{!! Form::submit(trans('words.user_reset_page.reset_form_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
					</div>	
					<div class="col-sm-12 col-md-12 col-lg-12">
						<br>
						<a href="{{ route('user.login') }}">@lang('words.user_reset_page.back_to_home')</a>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection