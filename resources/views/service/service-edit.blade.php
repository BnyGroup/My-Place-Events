@extends($AdminTheme)
@section('title','Service')
@section('content-header')
    <h1>Service - Modifier le service</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li><a href="#">{{--Events--}}Services</a></li>
        <li class="active">Modifier les services</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Mettre à jour le service</h3>
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

                    {!! Form::model($service,['method'=>'patch','route'=>['service.update',$service->id], 'class'=>'form-horizontal','files'=>'true']) !!}
                    <div class="form-group">
                        <label for="category_name" class="col-sm-3 control-label">{{--Category Name--}}Nom de la Catégorie</label>
                        <div class="col-sm-9">
                            {!! Form::text('service_title', $service->service_title, ['class'=>'form-control','placeholder'=>'Category Name' ,'autofocus','id'=>'service_title']) !!}
                            @if ($errors->has('service_title'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_title') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="service_short_desc" class="col-sm-3 control-label">Petite description</label>
                        <div class="col-sm-9">
                            {!! Form::textarea('service_short_desc',$service->service_short_desc,['class'=>'form-control','placeholder'=>'Description', 'id'=>'service_short_desc', 'rows' => 8 ]) !!}
                            @if ($errors->has('service_short_desc'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_short_desc') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="service_description" class="col-sm-3 control-label">Description du Service</label>
                        <div class="col-sm-9">
                            {!! Form::textarea('service_description',$service->service_description,['class'=>'form-control','placeholder'=>'Description', 'id'=>'service_description', 'rows' => 8 ]) !!}
                            @if ($errors->has('service_description'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_description') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Image</label>
                        <div class="col-sm-9">
                            {!! Form::hidden('old_image',$service->service_icon) !!}
                            <img src="{{ setThumbnail($service->service_icon) }}" alt="{{ $service->service_icon}}" width="100" />
                            {!! Form::file('service_icon',['class'=>'']) !!}
                            @if ($errors->has('service_icon'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_icon') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="service_status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                            <label>
                            <!--{{ Form::radio('service_status', '1', ($service->service_status == '1'?'checked':''), ['class'=>'minimal'])
						}} Active-->
                                <input type="radio" name="service_status" value="1" {{ $service->service_status== '1' ? 'checked' : '' }}>
                                Active
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label>
                            <!--{{ Form::radio('service_status', '0', ($service->service_status== '0'? 'checked':''), ['class'=>'minimal']) }} DisActive-->

                                <input type="radio" name="service_status" value="0"  {{ $service->service_status == '0' ? 'checked' : '' }}>
                                Désactiver
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            {{ link_to_route('service.index', $title = 'Go Back',  array(), ['class' => 'btn btn-primary btn-flat btn-block']) }}
                        </div>
                        <div class="col-sm-9">
                            {{ Form::submit('Modifier', ['class'=>'btn btn-primary btn-flat']) }}
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