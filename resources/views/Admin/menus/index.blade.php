@extends($AdminTheme)
@section('title','Menu Settings')
@section('content-header')
<h1>{{--Menu Settings--}}Paramètres du Menu</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Menu Settings--}}Paramètres du Menu</a></li>
</ol>
@endsection
@section('content')
	@if($success = Session::get('success'))
		<div class="alert alert-success">{{ $success }}</div>
	@endif

	
				
	<!-- Footer Menu Box -->
	<div class="col-md-5 col-lg-5 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">{{--Footer Menu--}}Menu de pied de page</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				{!! Form::open(['method'=>'post','route'=>['menus.store','footer']]) !!}
				<div class="row">
					<div class="col-md-7 col-lg-7 col-xs-12">
						<label>{{--Page Listing--}}Liste de page</label>
						@foreach($data as $key => $value)
						<div class="form-group">
							<input type="checkbox" name="page[{{$key}}]" id="{{ $value->id }}-" value="{{ $value->id }}"  {{ in_array($value->id,$menu_fotaer)?'checked':'' }}/>
							<label for="{{$value->id}}-">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $value->page_title }}</label><br>
						</div>
						@if ($errors->has('page'))
						<span class="help-block"><strong><font color="red">{{ $errors->first('page') }}</font></strong></span>
						@endif
						@endforeach
					</div>
					<div class="col-md-4 col-lg-4 col-xs-12">
						<label>{{--Page Ordering--}}Commande de page</label>
						@foreach($data as $key => $value)
						<div class="form-group">
							@if(in_array($value->id,array_keys($mford)))
							<input type="number" name="order[{{$key}}]" min="1" max="20" value="{{$mford[$value->id]}}" />
							@else
							<input type="number" name="order[{{$key}}]" min="1" max="20"/>
							@endif
						</div>
						@endforeach
					</div>
					<div class="col-md-12 col-lg-12 col-xs-12">
						<input type="submit"  class="btn btn-primary btn-flat" value="Update Footer Menu">
						<input type="reset"  class="btn btn-default btn-flat" value="Reset Footer Menu">
					</div>
				</div>
				{!! Form::close() !!}
			</div>
			<!-- /.box-body -->
		</div>
	
	<!-- Footer Menu box -->

</div>


@endsection