@extends($AdminTheme)

@section('title','Edit Roles')

@section('content-header')
<h1>{{--Edit Roles--}}Modifier les Roles</h1>
	<ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	  <li class="active">{{--Edit Roles--}}Modifier les Roles</li>
	</ol>
@endsection

@section('content')
	<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">{{--Edit Roles--}}Modifier les Roles</h3>
			</div>
			<div class="box-body">
				{!! Form::model($role,['method'=>'patch','route'=>['roles.update',$role->id]]) !!}
				<div class="form-group">
					<div class="col-sm-6">
					<label for="name" class="control-label">{{--Name--}}Nom</label>
						{!! Form::text('name',$role->name,['class'=>'form-control','placeholder'=>'Enter Name' ,'autofocus','id'=>'firstname']) !!}
						@if ($errors->has('name'))<span class="help-block"><strong><font color="red">{{ $errors->first('name') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6">
					<label for="display_name" class="control-label">{{--Display Name--}}Afficher le Nom</label>
						{!! Form::text('display_name',$role->display_name,['class'=>'form-control','placeholder'=>'Enter Display name' ,'autofocus','id'=>'display_name']) !!}
						@if ($errors->has('display_name'))<span class="help-block"><strong><font color="red">{{ $errors->first('display_name') }}</font></strong></span>@endif
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-12">
					<label for="description" class="control-label">Description</label>
						{!! Form::textarea('description',$role->desription,['class'=>'form-control','size'=>'3x5','placeholder'=>'Enter Description']) !!}
						@if ($errors->has('description'))<span class="help-block"><strong><font color="red">{{ $errors->first('description') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<br>
						<label>Permission :</label>
					</div>
					@foreach($permission as $value)
						<div class="col-md-2" style="margin-bottom:20px;">				
                    		<input <?php echo in_array($value->id, $rolePermissions) ? 'checked' : false ?> data-toggle="toggle" data-size="small" type="checkbox" value="{{ $value->id }}" name="permission[]"  {{($value->id <= 6 && $role->id == 1)?'disabled':''}}>
                            	{{ $value->display_name }}
                        </div>
                	@endforeach
                	<div class="clearfix"></div> 
            			@if ($errors->has('permission'))<span class="help-block"><strong><font color="red">{{ $errors->first('permission') }}</font></strong></span>@endif
				</div>
		        <div class="form-group" >
			          <div class="col-md-12">
		        	<br>
			            {{ Form::submit('Submit', ['class'=>'btn btn-primary btn-flat']) }}
			          </div>
			    </div>
				</div>
			    {!! Form::close() !!}
			</div>
		</div>
	</div>
	
@endsection
