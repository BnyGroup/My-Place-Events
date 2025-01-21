@extends($AdminTheme)
@section('title','About Us Page')
@section('content-header')
<h1>{{--About us Page--}}Page à propos de nous</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--About Us Page--}}Page à propos de nous</a></li>
</ol>
@endsection
@section('content')
	@if($success = Session::get('success'))
		<div class="alert alert-success">{{ $success }}</div>
	@endif
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--About Us--}}A propos de nous</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			{!! Form::open(array('route' => 'aboutus.update','autocomplete'=>'off','files'=>'true','method'=>'post')) !!}
				<div class="form-group">
					<label class="form-label">{!! $settings['aboutus-page-title']['name'] !!}</label>
					{!! Form::text($settings['aboutus-page-title']['slug'], $settings['aboutus-page-title']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['aboutus-page-title']['slug']) !!}</font></strong></span>
				</div>
				
				<div class="form-group">
					<label class="form-label">{!! $settings['aboutus-page-content']['name'] !!}</label>
					{!! Form::textarea($settings['aboutus-page-content']['slug'], $settings['aboutus-page-content']['value'], array('class' => 'form-control summernote')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['aboutus-page-content']['slug']) !!}</font></strong></span>
				</div>
				<input type="submit"  value="Update" class="btn btn-flat btn-success">
			{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@endsection