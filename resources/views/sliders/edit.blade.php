@extends($AdminTheme)

@section('title','Edit Sliders')

@section('content-header')
    <h1>Edit Roles</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">{{--Edit Sliders--}}Modifier les Slides</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{--Edit Sliders--}}Modifier les Slides</h3>
                </div>
                <div class="box-body">
                    {!! Form::model($slider,['method'=>'patch','route'=>['sliders.update',$slider->id], 'class'=>'form-horizontal','files'=>'true']) !!}
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_title" class="control-label">Titre</label>
                            {!! Form::text('slide_title',$slider->slide_title,['class'=>'form-control','placeholder'=>'Enter Title' ,'autofocus','id'=>'slide_title']) !!}
                            @if ($errors->has('slide_title'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_title') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="slide_img" class="col-sm-3 control-label">Image</label>
                        <div class="col-sm-9">
                            {!! Form::hidden('old_image',$slider->slide_img) !!}
                            <img src="{{ url($slider->slide_img) }}" alt="{{ $slider->slide_img }}" width="100" />
                            {{--<input type="file" class="" value="{{  }}" />--}}
                            {!! Form::file('slide_img',['class'=>'',]) !!}
                            @if ($errors->has('slide_img'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_img') }}</font></strong></span>@endif
                        </div>
                        <div class="col-sm-6">
                            <label for="slide_img_url" class="control-label">Url de l'image</label>
                            {!! Form::url('slide_img_url',$slider->slide_img_url,['class'=>'form-control','placeholder'=>'URL' ,'autofocus','id'=>'slide_img_url']) !!}
                            @if ($errors->has('slide_img_url'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_img_url') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_desc" class="control-label">Description du slide</label>
                            {!! Form::text('slide_desc',$slider->slide_desc,['class'=>'form-control','placeholder'=>'Enter Slide description' ,'autofocus','id'=>'slide_desc']) !!}
                            @if ($errors->has('slide_desc'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_desc') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_text_btn" class="control-label">Texte du bouton</label>
                            {!! Form::text('slide_text_btn',$slider->slide_text_btn,['class'=>'form-control','placeholder'=>'Enter Button Text' ,'autofocus','id'=>'slide_text_btn']) !!}
                            @if ($errors->has('slide_text_btn'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_text_btn') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="slide_btn_url" class="control-label">Url du bouton</label>
                            {!! Form::text('slide_btn_url',$slider->slide_btn_url,['class'=>'form-control','placeholder'=>'Enter Button Url' ,'autofocus','id'=>'slide_btn_url']) !!}
                            @if ($errors->has('slide_btn_url'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_btn_url') }}</font></strong></span>@endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="slide_status" name="slide_status" value="1" @if($slider->slide_status == 1 ) checked @endif>
                                <label class="form-check-label" for="slide_status">Activer</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="slide_status" name="slide_status" value="0" @if($slider->slide_status == 0 ) checked @endif>
                                <label class="form-check-label" for="slide_status">Desactiver</label>
                            </div>
                            @if ($errors->has('slide_status'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_status') }}</font></strong></span>@endif
                        </div>
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
