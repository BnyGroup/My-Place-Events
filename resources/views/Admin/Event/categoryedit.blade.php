@extends($AdminTheme)
@section('title','Admin')
@section('content-header')
<h1>{{--Events--}}Evénements - {{--Create Category--}}Créer une Catégorie</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Events--}}Evénements </a></li>
	<li class="active">{{--Category Create--}}Créer une Catégorie</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">{{--Update Event Category--}}Mettre à jour la catégorie d'événement</h3>
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

				{!! Form::model($category,['method'=>'patch','route'=>['categories.update',$category->id], 'class'=>'form-horizontal','files'=>'true']) !!}
				<div class="form-group">
					<label for="category_name" class="col-sm-3 control-label">{{--Parent Category--}}Catégorie Parente</label>
					<div class="col-sm-9">
						{!! Form::select('category_parent',$partent_cat, null, ['class' => 'form-control', 'placeholder' => 'Select Category...']); !!}
					</div>
				</div>
				<div class="form-group">
					<label for="category_name" class="col-sm-3 control-label">{{--Category Name--}}Nom de catégories</label>
					<div class="col-sm-9">
						{!! Form::text('category_name', $category->category_name, ['class'=>'form-control','placeholder'=>'Category Name' ,'autofocus','id'=>'category_name']) !!}
						@if ($errors->has('category_name'))<span class="help-block"><strong><font color="red">{{ $errors->first('category_name') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="category_description" class="col-sm-3 control-label">{{--Category Description--}}Description de la Catégorie</label>
					<div class="col-sm-9">
						{!! Form::textarea('category_description',$category->category_description ,['class'=>'form-control','placeholder'=>'Description', 'id'=>'category_description', 'rows' => 8 ]) !!}
						@if ($errors->has('category_description'))<span class="help-block"><strong><font color="red">{{ $errors->first('category_description') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="image" class="col-sm-3 control-label">Image</label>
					<div class="col-sm-9">
						{!! Form::hidden('old_image',$category->category_image) !!}
						<img src="{{ setThumbnail($category->category_image) }}" alt="{{ $category->category_name }}" width="100" /> 
						{!! Form::file('image',['class'=>'']) !!}
						@if ($errors->has('image'))<span class="help-block"><strong><font color="red">{{ $errors->first('image') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="category_status" class="col-sm-3 control-label">Status</label>
					<div class="col-sm-9">
						<label>
							<!--{{ Form::radio('category_status', '1', ($category->category_status == '1'?'checked':''), ['class'=>'minimal']) 
						}} Active-->
						<input type="radio" name="category_status" value="1" {{ $category->category_status == '1' ? 'checked' : '' }}>
							Active
						</label>
						&nbsp;&nbsp;&nbsp;
						<label>
							<!--{{ Form::radio('category_status', '0', ($category->category_status == '0'? 'checked':''), ['class'=>'minimal']) }} DisActive-->

						<input type="radio" name="category_status" value="0"  {{ $category->category_status == '0' ? 'checked' : '' }}>
							Desactive
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-3">
						{{ link_to_route('categories.index', $title = 'Go Back',  array(), ['class' => 'btn btn-primary btn-flat btn-block']) }}
					</div>
					<div class="col-sm-9">
						{{ Form::submit('Update Event category', ['class'=>'btn btn-primary btn-flat']) }}
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