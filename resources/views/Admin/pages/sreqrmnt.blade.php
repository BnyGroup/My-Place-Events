@extends($AdminTheme)
@section('title','Server Requiremnet Page')
@section('content-header')
<h1>{{--Server Requiremnet Page--}}Page de configuration requise pour le serveur</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Server Requiremnet Page--}}Page de configuration requise pour le serveur</a></li>
</ol>
@endsection
@section('content')
	@if($success = Session::get('success'))
		<div class="alert alert-success">{{ $success }}</div>
	@endif
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--Server Requiremnet--}}Configuration requise pour le serveur</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			{!! Form::open(array('route' => 'sreqrmnt.update','autocomplete'=>'off','files'=>'true','method'=>'post')) !!}
				<div class="form-group">
					<label class="form-label">{!! $settings['serverrequire-page-title']['name'] !!}</label>
					{!! Form::text($settings['serverrequire-page-title']['slug'], $settings['serverrequire-page-title']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['serverrequire-page-title']['slug']) !!}</font></strong></span>
				</div>
				
				<div class="form-group">
					<label class="form-label">{!! $settings['serverrequire-page-content']['name'] !!}</label>
					{!! Form::textarea($settings['serverrequire-page-content']['slug'], $settings['serverrequire-page-content']['value'], array('class' => 'form-control summernote')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['serverrequire-page-content']['slug']) !!}</font></strong></span>
				</div>
				<input type="submit"  value="Update" class="btn btn-flat btn-success">
			{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@endsection