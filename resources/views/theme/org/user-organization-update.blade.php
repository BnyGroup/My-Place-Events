@extends($theme)

@section('meta_title',setMetaData()->org_update_title )
@section('meta_description',setMetaData()->org_update_desc)
@section('meta_keywords',setMetaData()->org_update_keyword)

@section('content')
<div class="container">
	<div class="row page-main-contains">
		<div class="col-lg128 col-md-12 col-sm-12"><h1 class="profile-title">@lang('words.create_org.org_tit_lists')</h1></div>
		<div class="col-lg-12 col-sm-12 col-md-12">
			<p class="profile-tag-line">@lang('words.create_org.crea_org_tag')</p>
		</div>
	</div>
	{!! Form::model($data,['route'=>['org.update',$data->id],'method'=>'patch','files'=>'true']) !!}
	<div class="row page-main-contains">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-12">
					<div class="form-textbox">
						<input type="file" name="profile_pics" id="imgInp" style="display: none;" />
						@if(($data->oauth_provider)== null)
							<img src="{{ setThumbnail($data->profile_pic) }}"
								 id="ingOup" class="img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 255px;min-width:255px;">
						@else
							<img src="{{ url($data->profile_pic) }}"
								 id="ingOup" class="img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 255px;min-width:255px;">
						@endif
						{{--<img src="{{ setThumbnail($data->profile_pic) }}" id="ingOup" class="img-thumbnail" onclick="document.getElementById('imgInp').click();" style="height: 255px;min-width:255px;" />--}}
						<input type="hidden" name="old_image" value="{{ $data->profile_pic }}">
						<input type="hidden" name="old_cover" value="{{ $data->cover }}">
						<input type="hidden" name="url_slug" value="{{ $data->url_slug }}">
						<input type="hidden" name="id" value="{{ $data->id }}" id="id">
					</div>
					@if($errors->has('profile_pics')) <span class="error">{{ $errors->first('profile_pics') }}</span> @endif
					<p class="text-center profile-ins-text">@lang('words.create_org.org_pro_detis')</p>
				</div>
				<div class="col-lg-6 col-md-8 col-sm-12" style="padding-left: 0px">
					@if($success = Session::get('success'))
					<div class="alert alert-success">{{ $success }}</div>
					@endif
					@if($error = Session::get('error'))
					<div class="alert alert-danger">{{ $error }}</div>
					@endif
					
					<?php
						if(!empty($data->cover)){
							$dtCover=getImage($data->cover);
						}else{
							$dtCover=asset('/img/icoph.png');
						}
					
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
						<input type="text" name="organizer_name" class="form-control form-textbox" value="{{$data->organizer_name}}">
						@if($errors->has('organizer_name')) <span class="error">{{ $errors->first('organizer_name') }}</span> @endif
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_about') :</label>
						<textarea class="summernote" name="about_organizer">{!! $data->about_organizer !!}</textarea>
						@if($errors->has('about_organizer')) <span class="error">{{ $errors->first('about_organizer') }}</span> @endif
					</div>
					<div class="form-group">
						@if($data->display_dis == 1)
						<input type="checkbox" name="display_dis" id="ck-box" value="1" checked> <label for="ck-box">@lang('words.create_org.org_use')</label>
						@else
							<input type="checkbox" name="display_dis" id="ck-box"> <label for="ck-box">@lang('words.create_org.org_use')</label>
						@endif
					</div>
					{{--
						@if(! is_null($data->url_slug))
						<div class="form-group">
							<label class="text-uppercase label-text">@lang('words.create_org.org_use_web') :</label>
							<br>
							<a href="{{route('org.detail',$data->url_slug)}}" class="edit-slug">{{ route('org.detail',$data->url_slug) }} </a>
							<i class="fa fa-pencil slug-edit"></i>
						</div>
						<div id="edit-slug-hide" style="display: none;">
							<div class="form-group app-url">
								<input type="text" class="form-control form-textbox url-apps" value="{{ isset($data->url_slug)?$data->url_slug:'' }}">
								<p class="form-textbox apps-url">{{ env('APP_URL') }}/</p>
								<a href="javascript:void(0)" class="slug-edit-btn">Update</a>
							</div>
						</div>
						@endif
					--}}

					<div class="form-group">
						@php							
							$customeLink = (isset($data->org_link_slug)&&$data->org_link_slug!='')?$data->org_link_slug:$data->url_slug 
						@endphp
						<label class="text-uppercase label-text">{{--Custom Link--}}Lien personnalisé :</label><br>
						<a href="{{route('org.detail',$data->url_slug)}}">{{ URL::to('/') . '/' . $customeLink }}</a>						
					</div>
					<div class="form-group">
						<div class="input-group">
						 	<div class="input-group-prepend">
								<span class="input-group-text form-textbox" id="basic-addon3">{{URL::to('/')}}/</span>
						  	</div>
						  	<input type="text" name="org_link_slug" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="{{ $customeLink }}">	
					  	</div>
						@if($errors->has('org_link_slug')) <span class="error">{{ $errors->first('org_link_slug') }}</span> @endif
					</div>




					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_use_pg') :</label>
						<input type="text" name="website"  class="form-control form-textbox" value="{{ $data->website }}">
						@if($errors->has('website')) <span class="error">{{ $errors->first('website') }}</span> @endif
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_use_sta'):</label>
						<br/>
						<label class="chked_togal_switch">
						  <input name="status" type="checkbox" value="1" id="status" {{ ($data->status == 1)?'checked':'' }}>
						  <div class="chked_active_togal round"><span class="chk-on">Publié</span><span class="chk-off">Brouillon</span><!--END--></div>
						</label>
					</div>
					<div class="form-group">
						<h5 class="label-text-title-social">@lang('words.create_org.org_tit_tag')</h5>
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_tit_fb') :</label>
						<div class="facebook-box">
							<?php $page_url = str_replace('facebook.com/','',$data->facebook_page);?>
							<input type="text" name="facebook_page" class="form-control form-textbox prefix-fb" value="{{ $page_url }}">
							<span class="fb-prefix">facebook.com/</span>
						</div>
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text">@lang('words.create_org.org_tit_twit') :</label>
						<div class="facebook-box twitter-s">
							<?php $tweet = str_replace('@','',$data->twitter)?>
							<input type="text" name="twitter" class="form-control form-textbox prefix-fb tweiiter-fx" value="{{ $tweet }}">
							<span class="fb-prefix tewi">@</span>
						</div>
					</div>
					<div class="form-group">
						<label class="text-uppercase label-text"> Instagram :</label>
						<div class="facebook-box twitter-s">
							<?php $insta = str_replace('@','',$data->instagram)?>
							<input type="text" name="instagram" class="form-control form-textbox prefix-fb tweiiter-fx" value="{{ $insta }}">
							<span class="fb-prefix tewi">@</span>
						</div>
					</div>
					<input type="hidden" name="user_id" value="{{ auth()->guard('frontuser')->user()->id }}">
					<div class="form-group">
						{!! Form::submit(trans('words.edt_eve_page.edt_eve_btn'),['class'=>'pro-choose-file text-uppercase']) !!}
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
	</div>
	{!! Form::close() !!}
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
@section('pageScript')
<script type="text/javascript">

	$('body').on('click','.slug-edit',function(){
		$('#edit-slug-hide').toggle()
	})

	$('body').on('click','.slug-edit-btn',function(){
		var appurl = $('.url-apps').val();
		var id = $('#id').val();
		$.ajax({
			url: "{{ route('update.org.slug') }}",
			type: 'GET',
			dataType:'json',
			data: {slug:appurl,id:id},
			success:function(data){
				if (data.success == undefined) {
					swal("Cancelled",data, "error");
				}else{
					swal("Good job!",data.success, "success")
					$('.edit-slug').html(' ');
					$('.edit-slug').html(data.data);
					$('#edit-slug-hide').toggle()

					window.location.href = data.url
				}
			}
		})		
	})

</script>
@endsection