@extends($AdminTheme)

@section('title','Create Sliders')

@section('content-header')
    <h1>Create Sliders</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">Cr�er un slide</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Cr�ation de sliders</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['method'=>'post','route'=>'sliders.store', 'class'=>'form-horizontal','files'=>'true']) !!}
                    <div class="form-group">
                        <label for="slide_img" class="col-sm-3 control-label">Image</label>
                        <div class="col-sm-4">
                            {!! Form::file('slide_img',['class'=>'']) !!}
                            @if ($errors->has('slide_img'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_img') }}</font></strong></span>@endif
                        </div>
                        <div class="col-sm-6">
                            <label for="slide_img_url" class="control-label">Url de l'image</label>
                            {!! Form::url('slide_img_url','',['class'=>'form-control','placeholder'=>'URL' ,'autofocus','id'=>'slide_img_url']) !!}
                            @if ($errors->has('slide_img_url'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_img_url') }}</font></strong></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_title" class="control-label">{{--Title--}}Titre</label>
                            {!! Form::text('slide_title','',['class'=>'form-control','placeholder'=>'Enter Title' ,'autofocus','id'=>'slide_title']) !!}
                            @if ($errors->has('slide_title'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_title') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_desc" class="control-label">Description</label>
                            {!! Form::textarea('slide_desc','',['class'=>'form-control','size'=>'3x5','placeholder'=>'Enter Description']) !!}
                            @if ($errors->has('slide_desc'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_desc') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_text_btn" class="control-label">Texte du Bouton</label>
                            {!! Form::text('slide_text_btn','',['class'=>'form-control','placeholder'=>'Enter Button Text' ,'autofocus','id'=>'slide_text_btn']) !!}
                            @if ($errors->has('slide_text_btn'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_text_btn') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_btn_url" class="control-label">Url du bouton</label>
                            {!! Form::text('slide_btn_url','',['class'=>'form-control','placeholder'=>'Enter Button Url' ,'autofocus','id'=>'slide_btn_url']) !!}
                            @if ($errors->has('slide_btn_url'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_btn_url') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="slide_status" name="slide_status" value="1" checked>
                                <label class="form-check-label" for="slide_status">Activer</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="slide_status" name="slide_status" value="0">
                                <label class="form-check-label" for="slide_status">Desactiver</label>
                            </div>
                            @if ($errors->has('slide_status'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_status') }}</font></strong></span>@endif
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