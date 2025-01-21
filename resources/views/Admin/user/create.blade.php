@extends($AdminTheme)

@section('title','Create User')

@section('content-header')
<h1>{{--Create User--}}Creer un utilisateur</h1>
	<ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	  <li class="active">{{--User Create--}}Créer un utilisateur</li>
	</ol>
@endsection

@section('content')
	<div class="row">
	<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">{{--Create User--}}Créer un utilisateur</h3>
			</div>
			<div class="box-body">
				{!! Form::open(['method'=>'post','route'=>'users.store', 'class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label for="firstname" class="col-sm-3 control-label">{{--First Name--}}Nom</label>
					<div class="col-sm-9">
						{!! Form::text('firstname','',['class'=>'form-control','placeholder'=>'First Name' ,'autofocus','id'=>'firstname']) !!}
						@if ($errors->has('firstname'))<span class="help-block"><strong><font color="red">{{ $errors->first('firstname') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="lastname" class="col-sm-3 control-label">{{--Last Name--}}Prénoms</label>
					<div class="col-sm-9">
						{!! Form::text('lastname','',['class'=>'form-control','placeholder'=>'Last Name' ,'autofocus','id'=>'lastname']) !!}
						@if ($errors->has('lastname'))<span class="help-block"><strong><font color="red">{{ $errors->first('lastname') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="brith_date" class="col-sm-3 control-label">{{--Brith Date--}}Date de naissance</label>
					<div class="col-sm-9">
						{!! Form::text('brith_date','',['class'=>'form-control datepicker','placeholder'=>'Brith Date' ,'autofocus','id'=>'brith_date','readonly']) !!}
						@if ($errors->has('brith_date'))<span class="help-block"><strong><font color="red">{{ $errors->first('brith_date') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="role_id" class="col-sm-3 control-label">{{--Admin Type--}}Type Admin</label>
					<div class="col-sm-9">
						{!! Form::select('role_id',$data,null,['class'=>'form-control','placeholder'=>'Select Role','id'=>'admintype']) !!}
						@if ($errors->has('role_id'))<span class="help-block"><strong><font color="red">{{ $errors->first('role_id') }}</font></strong></span>@endif
					</div>
				</div>
				 <div class="form-group">
		          	<label for="inputEmail" class="col-sm-3 control-label">{{--Gender--}}Genre</label>
			          <div class="col-sm-9">
				            <label>
				              {{ Form::radio('gender', '0',true,['class'=>'minimal']) }} {{--Male--}}Masculin
				            </label>
			            		&nbsp;&nbsp;&nbsp;
				            <label>
				              {{ Form::radio('gender', '1',false,['class'=>'minimal']) }} {{--Female--}}Féminin
				            </label>
			          </div>
		        </div>
				 <div class="form-group">
					<label for="inputEmail" class="col-sm-3 control-label">Status</label>
					  <div class="col-sm-9">
							<label>
							  {{ Form::radio('status', '1',true,['class'=>'minimal']) }} Active
							</label>
								&nbsp;&nbsp;&nbsp;
							<label>
							  {{ Form::radio('status', '0',false,['class'=>'minimal']) }} {{--DisActive--}}Désactiver
							</label>
					  </div>
				 </div>
		        <div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-9">
						{!! Form::text('email','',['class'=>'form-control','placeholder'=>'Enter Email' ,'autofocus','id'=>'email']) !!}
						@if ($errors->has('email'))<span class="help-block"><strong><font color="red">{{ $errors->first('email') }}</font></strong></span>@endif
					</div>
				</div>
		        <div class="form-group">
			          <div class="col-sm-offset-3 col-sm-2">
			            {{ Form::submit('Submit', ['class'=>'btn btn-primary btn-flat']) }}
			          </div>
			    </div>
			    {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection