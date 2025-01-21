@extends($AdminTheme)

@section('title','Bank Form')

@section('content-header')
<h1>{{--Bank Form--}}Formulaire bancaire</h1>
	<ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	  <li class="active">{{--Bank Form--}}Formulaire bancaire</li>
	</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		@if($success = Session::get('success'))
			<div class="alert alert-success">{{$success}}</div>
		@endif
		<div class="box box-primary"> 
			<div class="box-header with-border">
				<h3 class="box-title">{{--Create Bank Form--}}Créer Formulaire Bancaire </h3>
			</div>
			<div class="box-body">
				{!! Form::open(['method'=>'post','route'=>'bank.store']) !!}
				<div class="form-group col-lg-6 col-md-6 col-sm-12">
					<label for="firstname">{{--Field Name--}}Champs Nom:</label>
						{!! Form::text('fieldname','',['class'=>'form-control','placeholder'=>'Field Name' ,'autofocus','id'=>'firstname']) !!}
						@if ($errors->has('fieldname'))<span class="help-block"><strong><font color="red">{{ $errors->first('fieldname') }}</font></strong></span>@endif
				</div>
		        <div class="form-group col-sm-12 col-lg-6 col-md-6">
					<label for="email">{{--Field Type--}}Champs Type:</label>
						<select class="form-control" name="type">
							<option disabled="" selected="">{{--Select Type--}}Choisir le Type</option>
							<option>text</option>
							<option>textarea</option>
							<!-- <option>numeric</option> -->
							<option>email</option>
						</select>
						@if ($errors->has('type'))<span class="help-block"><strong><font color="red">{{ $errors->first('type') }}</font></strong></span>@endif
					</div>

				<div class="form-group col-lg-6 col-md-6 col-sm-12">
					<label for="note">Note:</label>
						{!! Form::text('note','',['class'=>'form-control','placeholder'=>'Note' ,'autofocus','id'=>'note']) !!}
				</div>
				<div class="form-group col-lg-6 col-md-6 col-sm-12">
					<label for="Placeholder">Placeholder:</label>
						{!! Form::text('placeholder','',['class'=>'form-control','placeholder'=>'Placeholder' ,'autofocus','id'=>'Placeholder']) !!}
				</div>
		        <div class="form-group pull-right">
			          <div class="col-sm-12 col-md-12 col-lg-12">
			            {{ Form::submit('Submit', ['class'=>'btn btn-primary btn-flat']) }}
			            {{ Form::reset('Reset', ['class'=>'btn btn-default btn-flat']) }}
			          </div>
			    </div>
			</div>
			    {!! Form::close() !!}
			</div>
		</div>
</div>


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">{{--Bank Form--}}Formulaire bancaire</h3>
			</div>
			@if(!empty($data) && count($data) > 0)
			<div class="box-body">
				<div class="col-md-8 col-lg-8 col-sm-12">
					<div class="col-md-12 col-lg-12 col-sm-12"><h3>{{--Bank Account Details --}}Détails de compte en banque:</h3></div>
					
					@foreach($data as $key => $val)			
						@if($val['type'] == 'text')
							<div class="form-group filed col-lg-6">
								<label>{{ $val->fieldname }}</label> <span style="color: red;margin-left:10px;"><b>{{ $val->note }} </b></span>
								<input type="{{$val->type}}" name="{{$val->slug}}" placeholder="{{ $val->placeholder }}" class="form-control"><a href="{{ route('bank.delete',$val->id) }}" onclick="return confirm('Are you Sure Delete This Field ?')" class="btncrios"><i class="fa fa-times" aria-hidden="true"></i></i></a>
							</div>
						@endif
					
						@if($val['type'] == 'email')
							<div class="form-group filed col-lg-6">
								<label>{{ $val->fieldname }}</label> <span style="color: red;margin-left:10px;"><b>{{ $val->note }} </b></span>
								<input type="{{$val->type}}" name="{{ $val->slug }}" class="form-control" placeholder="{{ $val->placeholder }}" ><a href="{{ route('bank.delete',$val->id) }}" onclick="return confirm('Are you Sure Delete This Field ?')" class="btncrios"><i class="fa fa-times" aria-hidden="true"></i></i></a>
							</div>
						@endif
					
						@if($val['type'] == 'textarea')
							<div class="col-md-12 col-sm-12 col-lg-12 form-group filed">
								<label>{{$val->fieldname}}</label> <span style="color: red;margin-left:10px;"><b>{{ $val->note }} </b></span>
								<textarea name="{{ $val->slug }}" class="form-control" placeholder="{{ $val->placeholder }}"></textarea><a href="{{ route('bank.delete',$val->id) }}" onclick="return confirm('Are you Sure Delete This Field ?')" class="btncrios"><i class="fa fa-times" aria-hidden="true"></i></i></a>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>
		@else
		<div class="text-center">{{--Not Found.--}}Introuvable</div>
		@endif
</div>

<style type="text/css">
	.filed{
		position: relative;
	}
	.btncrios{
		height:20px;
		width:20px;
		background: #3C8DBC;
		color:#fff;
		text-align: center;
		border-radius:50%;  
		top:16px;
		right:6px; 
		position: absolute;
	}
</style>
@endsection
