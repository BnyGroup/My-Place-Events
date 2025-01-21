@extends($theme)
@section('meta_title',setMetaData()->org_title )
@section('meta_description',setMetaData()->org_desc)
@section('meta_keywords',setMetaData()->org_keyword)
@section('content')
<div class="col-md-12 page-section" style="border-top: 1px solid #dfdfdf;">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-lg-10 col-12">
			<div class="row">
				<div class="col-sm-4">
					<h2 class="events-title font-weight-bold" style="padding-left:20px;">@lang('words.organizer_page.org_title') </h2>
				</div>
				<div class="col-sm-8 text-right">
					<h2 class="events-title font-weight-bold">
					{{--@if(count($datas) < 10)--}}
					<a href="{{ route('org.create') }}" class="btn add-bun"><i class="fa fa-plus"></i> @lang('words.organizer_page.org_btn_title')</a>
					{{--@else
					<span class="error">@lang('words.organizer_page.org_btn_full')</span>
					@endif--}}
					</h2>
				</div>
			</div>
			<br>
			<!--box start-->
			@if($success = Session::get('success'))
			<div class="alert alert-success" style="margin-left:25px;">{{$success}}</div>
			@endif
			<div class="col-lg-12">
				<div class="row">
					@foreach($datas as $key => $val)
					<div class="col-lg-4 col-sm-6 col-xs-12 col-md-6">
						<div class="row rev-box org-box">
							<div class="col-lg-3 col-sm-12 col-md-4 box-imager-wrapper">
								{{--<img src="{{ setThumbnail($val->profile_pic) }}" class="box-image-rev">--}}
								@if(($val->oauth_provider)== null)
									<img src="{{ setThumbnail($val->profile_pic) }}"
										 class="box-image-rev">
								@else
									<img src="{{ url($val->profile_pic) }}"
										 class="box-image-rev">
								@endif
							</div>
							<div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
								<p class="text-uppercase box-rev-box-title">{{ /*date_format($val->created_at,'D, M d h:i A')*/ ucwords(Jenssegers\Date\Date::parse($val->created_at)->format('l j F Y H:i')) }}</p>
								<h5 class="text-capitalize box-conetent-title">{{ $val->organizer_name }}</h5>

								<br>

								<a href="https://web.facebook.com/{{ $val->facebook_page }}" class="btn btn-sm btn-rds fb" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-facebook-square"></i></a>

								<a href="https://twitter.com/{{ $val->twitter }}" class="btn btn-sm btn-rds twt" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-twitter"></i></a>

							</div>
							<div class="col-lg-12 col-sm-12 col-md-12">
								<div class="row">
									<div class="col-lg-12 col-xs-12 col-md-12 col-sm-12 valuse-box-org">
										<a href="{{route('org.edit',$val->url_slug) }}" class="btn btn-site-dft btn-sm"><i class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
										<a href="{{ route('org.detail',$val->url_slug) }}" class="btn btn-site-dft btn-sm"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
										<a href="{{ route('org.delete',$val->id) }}" class="btn btn-site-dft btn-sm" onclick=" return confirm('are you sure Delete this item ?')"><i class="fa fa-trash"></i> @lang('words.mng_eve.mng_eve_del')</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<br/>
			<!--box end-->
		</div>
	</div>
</div>
@endsection