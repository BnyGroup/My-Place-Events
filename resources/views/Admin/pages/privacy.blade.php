@extends($AdminTheme)
@section('title','Privacy Policy Page')
@section('content-header')
<h1>{{--Privacy Policy Page--}}Page Politique de confidentialité</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="#">>Page Politique de confidentialité{{--Privacy Policy Page--}}</a></li>
</ol>
@endsection
@section('content')
	@if($success = Session::get('success'))
		<div class="alert alert-success">{{ $success }}</div>
	@endif
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--Privacy Policy--}}Politique de confidentialité</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			{!! Form::open(array('route' => 'privacy.update','autocomplete'=>'off','files'=>'true','method'=>'post')) !!}
				<div class="form-group">
					<label class="form-label">{!! $settings['privacy-page-title']['name'] !!}</label>
					{!! Form::text($settings['privacy-page-title']['slug'], $settings['privacy-page-title']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['privacy-page-title']['slug']) !!}</font></strong></span>
				</div>
				
				<div class="form-group">
					<label class="form-label">{!! $settings['privacy-page-content']['name'] !!}</label>
					{!! Form::textarea($settings['privacy-page-content']['slug'], $settings['privacy-page-content']['value'], array('class' => 'form-control summernote')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['privacy-page-content']['slug']) !!}</font></strong></span>
				</div>
				<input type="submit"  value="Update" class="btn btn-flat btn-success">
			{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@endsection