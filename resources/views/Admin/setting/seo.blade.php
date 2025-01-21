@extends($AdminTheme)


@section('title','SEO Meta Settings')

@section('content-header')
<h1>Paramètres Seo Meta {{--Settings--}}</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
		<li><a href="#">Paramètres Seo Meta{{--Seo Meta Settings--}}</a></li>
	</ol>
@endsection

@section('content')
	@if($data = \Session::get('success'))
		<div class="alert alert-success">{{ $data }}</div>
	@endif

	<div class="box-group" id="accordion">
		@foreach($seometa  as $key => $value)

		{!! Form::open(['method' => 'POST','route'=>['seo.update',$key],'autocomplete'=>'off']) !!}
		<div class="box box-info">
			<div class="box-header">
				<h3 class="box-title" style="display:block;">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$key}}" style="display:block;">
						<i class="fa fa-cog"></i>&nbsp;&nbsp; {!! $value['name'] !!}
	              	</a>
				</h3>
			</div>
			<div id="collapse-{{$key}}" class="panel-collapse collapse">
				<div class="box-body">
					<div class="row">
						<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
							<div class="form-group">
								<label class="form-label">{{--Title--}}Titre</label>
								{!! Form::text('title',$value['title'], array('class' => 'form-control')) !!}
								<span class="help-block"><strong><font color="red">{!! $errors->first($key) !!}</font></strong></span>
							</div>
							<div class="form-group">
								<label class="form-label">{{--Keyword--}}Mot-clé</label>
								{!! Form::text('keyword',$value['keyword'], array('class' => 'form-control')) !!}
								<span class="help-block"><strong><font color="red">{!! $errors->first($key) !!}</font></strong></span>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
							<div class="form-group">
								<label class="form-label">Description</label>
								{!! Form::textarea('desc',$value['desc'],array('class'=>'form-control','size'=>'3x4')) !!}
								<span class="help-block"><strong><font color="red">{!! $errors->first($key) !!}</font></strong></span>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 text-right">
							<input type="submit"  value="Update" class="btn btn-flat btn-success">
							<input type="reset"  value="Reset" class="btn btn-flat btn-default">
						</div>
					</div>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
		@endforeach
	</div>
@endsection