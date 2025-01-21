@extends($theme)

@section('meta_title',setMetaData()->org_create_title)
@section('meta_description',setMetaData()->org_create_desc)
@section('meta_keywords',setMetaData()->org_create_keyword)

@section('content')
<div class="container">
	<div class="row page-main-contains">
		<div class="col-lg128 col-md-12 col-sm-12"><h1 class="profile-title">@lang('words.create_org.crea_org_tit')</h1></div>
		<div class="col-lg-12 col-sm-12 col-md-12">
			<p class="profile-tag-line">@lang('words.create_org.crea_org_tag')</p>
		</div>
	</div>
	<div class="row page-main-contains">
				{!! Form::open(['route'=>'org.store','method'=>'post','files'=>'true']) !!}
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-12">
					<div class="form-textbox">
						<input type="file" name="profile_pics" id="imgInp" style="display: none;" />
						<img src="{{ asset('/default/user.png') }}" id="ingOup" class="img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 255px;min-width:255px;" />
					</div>
					@if($errors->has('profile_pics')) <span class="error">{{ $errors->first('profile_pics') }}</span> @endif
					<p class="text-center profile-ins-text">@lang('words.create_org.org_pro_detis')</p>
				</div>
				<div class="col-lg-6 col-md-8 col-sm-12">
					@if($success = Session::get('success'))
					<div class="alert alert-success">{{ $success }}</div>
					@endif
					
					
					<?php
						 
							$dtCover=asset('/img/icoph.png');
 					
					?>
					
					
					<div class="form-group" style="margin-bottom: 10px;">
						<label for="imageUpload" class="col-sm-12 control-label">Photo de couverture</label>
						<div class="text-uppercase label-text" style="padding-left: 15px; margin-bottom: 10px;">@lang('words.create_org.org_pro_detis') :</div>		 
						<div class="form-textbox" align="center" style="height: 255px;min-width:100%;background-color: #d5d6e3; overflow: hidden; border-radius: 5px; padding: 0px;">
							<input type="file" name="cover" id="imgInp2" style="display: none;" />
							<img src="{{ $dtCover }}" id="ingOup2" class="img-thumbnail" align="center" onclick="document.getElementById('imgInp2').click();" style="height: 255px; border: #d5d6e3; background-color: #d5d6e3; " />
						</div>
						@if($errors->has('cover')) <span class="error">{{ $errors->first('cover') }}</span> @endif
					</div>
					
					
 					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_name') :</label>
						<input type="text" name="organizer_name" class="form-control form-textbox" value="{{ Input::old('organizer_name') }}">
						@if($errors->has('organizer_name')) <span class="error">{{ $errors->first('organizer_name') }}</span> @endif
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_about') :</label>
						<textarea class="summernote" name="about_organizer">{{ Input::old('about_organizer') }}</textarea>
						@if($errors->has('about_organizer')) <span class="error">{{ $errors->first('about_organizer') }}</span> @endif
					</div>
					<div class="form-group">
						<input type="checkbox" name="display_dis" id="ck-box" value="1"> <label for="ck-box">@lang('words.create_org.org_use')</label>
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_use_web') :</label>
						<input type="text" name="website"  class="form-control form-textbox" value="{{ Input::old('website') }}">
						@if($errors->has('website')) <span class="error">{{ $errors->first('website') }}</span> @endif
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">{{--Custom Link--}}Lien personnalisé :</label>
						<div class="input-group">
						 	<div class="input-group-prepend form-textbox">
								<span class="input-group-text form-textbox" id="basic-addon3">{{ URL::to('/') }}/</span>
						  	</div>
				  			<input type="text" name="org_link_slug" class="form-control form-textbox" id="basic-url" aria-describedby="basic-addon3">
					  	</div>
					</div>
					
					<label class="text-uppercase label-text">@lang('words.create_org.org_use_sta') :</label>
					<div class="form-group">
						<label class="chked_togal_switch">
							<input name="status" type="checkbox" value="1" {{ (! empty(Input::old('status')) ? 'checked' : '') }}  checked>
							<div class="chked_active_togal round"><span class="chk-on">Publié</span><span class="chk-off">Brouillon</span><!--END--></div>
						</label>
					</div>	
						
					<div class="form-group">
						<h5 class="label-text-title-social">@lang('words.create_org.org_tit_tag')</h5>
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_tit_fb') :</label>
						<div class="facebook-box">
							<input type="text" name="facebook_page" class="form-control form-textbox prefix-fb" value="{{ Input::old('facebook_page') }}">
							<span class="fb-prefix">facebook.com/</span>
						</div>
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_tit_twit') :</label>
						<div class="facebook-box twitter-s">
							<input type="text" name="twitter" class="form-control form-textbox prefix-fb tweiiter-fx" value="{{ Input::old('twitter') }}">
							<span class="fb-prefix tewi">@</span>
						</div>
					</div>
					<input type="hidden" name="user_id" value="{{ auth()->guard('frontuser')->user()->id }}">
					<div class="form-group">
						{!! Form::submit(trans('words.user_create.user_cn_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 org-emenu">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
							<h3 class="orh-menu-title">@lang('words.create_org.org_tit_list')</h3>
						</div>
						<div class="col-sm-12 col-lg-12 col-md-12">
							<ul class="list-inline org-menu">
								@foreach($orglist as $key => $val)
								<li><a href="{{ route('org.edit',$val->url_slug) }}" data-toggle="tooltip" title="{{ $val->organizer_name }}" data-placement="right"><i class="fa fa-hand-o-right" aria-hidden="true"></i>{{ str_limit($val->organizer_name,22) }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
				{!! Form::close() !!}
	</div>
</div>
<style>
	.form-group .facebook-box .form-control {
		height: 40px!important;
	}
	.facebook-box .prefix-fb {
		padding-left: 140px !important;
	}
	.facebook-box {
		height: 40px;
	}
	.page-main-contains{
		margin-bottom: 25px;
	}
	.pro-choose-file{
		margin-top: 10px;
	}
</style>
@endsection