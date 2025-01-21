@extends($AdminTheme)

@section('title',/*'Create Services'*/'Créer un Service')

@section('content-header')
    <h1>{{--Create Service--}}Créer un Service</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">{{--Create Service--}}Créer un Service</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{--Create Service--}}Créer un Service</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['method'=>'post','route'=>'service.store', 'class'=>'form-horizontal','files'=>'true']) !!}
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="service_icon" class="col-sm-3 control-label">Image</label>
                            {!! Form::file('service_icon',['class'=>'']) !!}
                            @if ($errors->has('service_icon'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_icon') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="service_title" class="control-label">Titre de l'image</label>
                            {!! Form::text('service_title','',['class'=>'form-control','placeholder'=>'Titre' ,'autofocus','id'=>'service_title']) !!}
                            @if ($errors->has('service_title'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_title') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="service_short_desc" class="control-label">Petite Description</label>
                            {!! Form::textarea('service_short_desc','',['class'=>'form-control','size'=>'3x5','placeholder'=>'Entrer Description']) !!}
                            @if ($errors->has('service_short_desc'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_short_desc') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="service_description" class="control-label">Description</label>
                            {!! Form::textarea('service_description','',['class'=>'form-control','size'=>'3x5','placeholder'=>'Entrer Description']) !!}
                            @if ($errors->has('service_description'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_description') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="service_status" name="service_status" value="1" checked>
                                <label class="form-check-label" for="service_status">Activer</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="service_status" name="service_status" value="0">
                                <label class="form-check-label" for="service_status">Desactiver</label>
                            </div>
                            @if ($errors->has('service_status'))<span class="help-block"><strong><font color="red">{{ $errors->first('service_status') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
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