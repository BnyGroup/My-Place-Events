@extends($AdminTheme)
@section('title','Admin')
@section('content-header')
<h1>{{--Events - Create Category--}}Événements - Créer une catégorie</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Events--}}Evénements</a></li>
	<li class="active">{{--Category Create--}}Catégorie Créer</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">{{--Create Event Category--}}Créer une catégorie d'événement</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				 @if($error = Session::get('error'))
		              <div class="alert alert-danger">
		                  {{ $error }}
		              </div>
		          @elseif($success = Session::get('success'))
		          <div class="alert alert-success">
		                  {{ $success }}
		              </div>
		          @endif
				{!! Form::open(['method'=>'post','route'=>'categories.store', 'class'=>'form-horizontal','files'=>'true']) !!}
				<div class="form-group">
					<label for="category_name" class="col-sm-3 control-label">{{--Parent Category--}}Catégorie Parente</label>
					<div class="col-sm-9">
						{!! Form::select('category_parent',$data, null, ['class' => 'form-control', 'placeholder' => 'Select Category...']); !!}
					</div>
				</div>
				<div class="form-group">
					<label for="category_name" class="col-sm-3 control-label">{{--Category Name--}}Nom de la catégorie</label>
					<div class="col-sm-9">
						{!! Form::text('category_name', null,['class'=>'form-control','placeholder'=>'Category Name' ,'autofocus','id'=>'category_name']) !!}
						@if ($errors->has('category_name'))<span class="help-block"><strong><font color="red">{{ $errors->first('category_name') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="category_description" class="col-sm-3 control-label">{{--Category Description--}}Description Catégorie</label>
					<div class="col-sm-9">
						{!! Form::textarea('category_description',null,['class'=>'form-control','placeholder'=>'Description', 'id'=>'category_description', 'rows' => 8 ]) !!}
						@if ($errors->has('category_description'))<span class="help-block"><strong><font color="red">{{ $errors->first('category_description') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="image" class="col-sm-3 control-label">Image</label>
					<div class="col-sm-9">
						{!! Form::file('image',['class'=>'']) !!}
						@if ($errors->has('image'))<span class="help-block"><strong><font color="red">{{ $errors->first('image') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="category_status" class="col-sm-3 control-label">Status</label>
					<div class="col-sm-9">
						<label>
							{{ Form::radio('category_status', '1', true, ['class'=>'minimal']) }} Active
						</label>
						&nbsp;&nbsp;&nbsp;
						<label>
							{{ Form::radio('category_status', '0', '', ['class'=>'minimal']) }} {{--DisActive--}}Désactivé
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-3">
						{{ link_to_route('categories.index', $title = 'Go Back',  array(), ['class' => 'btn btn-primary btn-flat btn-block']) }}
					</div>
					<div class="col-sm-9">
						{{ Form::submit('Add Event category', ['class'=>'btn btn-primary btn-flat']) }}
					</div>
				</div>
				{!! Form::close() !!}
				
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</div>
<!-- /.box -->
@endsection