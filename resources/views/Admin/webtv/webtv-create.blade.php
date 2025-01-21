@extends($AdminTheme)

@section('title','Create Video')

@section('content-header')
    <h1>Ajouter une vidéo</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">Ajouter une vidéo</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter une vidéo</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['method'=>'post','route'=>'webtv.store', 'class'=>'form-horizontal']) !!}
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="titre" class="control-label">Titre</label>
                            {!! Form::text('titre','',['class'=>'form-control','placeholder'=>'Enter Title' ,'autofocus','id'=>'titre']) !!}
                            @if ($errors->has('titre'))<span class="help-block"><strong><font color="red">{{ $errors->first('titre') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="lien_poster" class="control-label">Url {{--Poster--}}Affiche</label>
                            {!! Form::url('lien_poster','',['class'=>'form-control','placeholder'=>'URL' ,'autofocus','id'=>'lien_poster']) !!}
                            @if ($errors->has('lien_poster'))<span class="help-block"><strong><font color="red">{{ $errors->first('lien_poster') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="lien_video" class="control-label">Url Vidéo</label>
                            {!! Form::url('lien_video','',['class'=>'form-control','placeholder'=>'URL' ,'autofocus','id'=>'lien_video']) !!}
                            @if ($errors->has('lien_video'))<span class="help-block"><strong><font color="red">{{ $errors->first('lien_video') }}</font></strong></span>@endif
                        </div>
                    </div>
                    {{--<div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_desc" class="control-label">Description</label>
                            {!! Form::textarea('slide_desc','',['class'=>'form-control','size'=>'3x5','placeholder'=>'Enter Description']) !!}
                            @if ($errors->has('slide_desc'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_desc') }}</font></strong></span>@endif
                        </div>
                    </div>--}}

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="slide_status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Activer</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="status" name="slide_status" value="0">
                                <label class="form-check-label" for="status">Desactiver</label>
                            </div>
                            @if ($errors->has('status'))<span class="help-block"><strong><font color="red">{{ $errors->first('status') }}</font></strong></span>@endif
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