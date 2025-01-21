@extends($theme)
@section('meta_title',setMetaData()->e_create_title )
@section('meta_description',setMetaData()->e_create_desc)
@section('meta_keywords',setMetaData()->e_create_keyword)

@section('css')
    <style>
        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: 50px auto;
        }
        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }
        .avatar-upload .avatar-edit input {
            display: none;
        }
        .avatar-upload .avatar-edit input + label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #ffffff;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }
        .avatar-upload .avatar-edit input + label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }
        .avatar-upload .avatar-edit input + label:after {
            content: "\f040";
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }
        .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border: 6px solid #f8f8f8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }
        .avatar-upload .avatar-preview > div {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

    </style>
@endsection

@section('content')
    <div class="container-fluid about-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
                    <h2 class="text-uppercase about-title">Mise à la une </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row page-main-contain boxed-box mise-la-une">
            <div class="col-md-12">
                <div class="alert alert-info">* Ce champ ne peut être vide.</div>
                @if($error = Session::get('error'))
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @elseif($success = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $success }}
                    </div>
                @endif
                <h2 class="profile-title profile-title-text page-header">Créer une mise à la une</h2>
                <br/>
                {{--@php

                $firstname = auth()->guard('frontuser')->user()->firstname;
                $lastname = auth()->guard('frontuser')->user()->lastname;
                $country = auth()->guard('frontuser')->user()->country;
                $city = auth()->guard('frontuser')->user()->city;
                $cellphone = auth()->guard('frontuser')->user()->cellphone;
                $email = auth()->guard('frontuser')->user()->email;

                @endphp--}}
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable-panel">
                                <div class="tabbable-line">
                                    @if(isset($input))
                                        <ul class="nav nav-tabs ">
                                            <li @if(isset($input) && $input['type_service']=='1')class=" pl-4 pr-4"@endif>
                                                <a href="#tab_default_1" data-toggle="tab">
                                                    Slider </a>
                                            </li>
                                            <li @if(isset($input) && $input['type_service']=='2')class=" pl-4 pr-4"@endif>
                                                <a href="#tab_default_2" data-toggle="tab">
                                                    Tête de liste </a>
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="nav nav-tabs ">
                                            <li class="pl-4 pr-4">
                                                <a href="#tab_default_1" data-toggle="tab" class="active">
                                                    Slider </a>
                                            </li>
                                            <li>
                                                <a href="#tab_default_2" data-toggle="tab">
                                                    Tête de liste </a>
                                            </li>
                                        </ul>
                                    @endif
                                    @if(isset($frontuser) && $frontuser != null)
                                        <div class="tab-content">
                                        <div class="tab-pane active" id="tab_default_1">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12 col-sm-12">
                                                    <h3 class="mt-4"> Slider </h3>
                                                </div>
                                            </div>
                                            {!! Form::open(['method'=>'post','route'=>'alu.store', 'id'=>'aluForm', 'files'=>'true']) !!}
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <input type="hidden" name="type_service" class="form-control form-textbox" value="slider"  id="S_type_service" required/>
                                                    @if(isset($input) && $input['type_service']== 1)
                                                        <input type="hidden" name="duree_service" class="form-control form-textbox" value="{{ $input['duree_service'] }}" id="SH_duree_service" required/>
                                                        <p id="SH_montant"></p>
                                                    @else
                                                        <label class="label-text pt-3" >Durée du service<span class="text-danger">*</span></label>
                                                        <input type="number" value="1" name="duree_service" style="text-align:center" id="formule2">
                                                        <input type="number" name="montant" value="{{ $serviceSlide->montant_service }}" readonly id="montant2" style="text-align:center; font-weight: bolder;border:none">
                                                        <input type="hidden" name="pu" value="{{ $serviceSlide->montant_service }}" id="pu2">
                                                        <input type="hidden" name="designation" value="slide">
                                                        {{--<select name="duree_service" class="form-control form-textbox" id="SS_duree_service">
                                                            <option value="1_semaine">1 Semaine</option>
                                                            <option value="2_semaines">2 Semaines</option>
                                                            <option value="3_semaines">3 Semaines</option>
                                                            <option value="4_semaines">4 Semaines</option>
                                                        </select>--}}
                                                        {{--<p id="SS_montant">5 000</p>--}}
                                                        @if($errors->has('duree_service')) <span class="error">{{ $errors->first('duree_service') }}</span> @endif
                                                    @endif
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Titre <span class="text-danger">*</span></label>
                                                    <input type="text" name="titre_slide" id="S_titre_slide" class="form-control form-textbox" value="{{ Input::old('titre_slide') }}" required/>
                                                    @if($errors->has('titre_slide')) <span class="error">{{ $errors->first('titre_slide') }}</span> @endif
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Description <span class="text-danger">*</span></label>
                                                    <input type="text" name="description_slide" id="S_description_slide" class="form-control form-textbox" value="{{ Input::old('description_slide') }}" required/>
                                                    @if($errors->has('description_slide')) <span class="error">{{ $errors->first('description_slide') }}</span> @endif
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Texte du bouton <span class="text-danger">*</span></label>
                                                    <input type="text" name="slide_btn_text" id="S_slide_btn_text" class="form-control form-textbox" value="{{ Input::old('slide_btn_text') }}" required/>
                                                    @if($errors->has('slide_btn_text')) <span class="error">{{ $errors->first('slide_btn_text') }}</span> @endif
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Lien de redirection  <span class="text-danger">*</span></label>
                                                    <input type="text" name="url_entete_slide" id="S_url_entete_slide" class="form-control form-textbox" value="{{ Input::old('url_entete_slide') }}" required/>
                                                    @if($errors->has('url_entete_slide')) <span class="error">{{ $errors->first('url_entete_slide') }}</span> @endif
                                                </div>
                                                {{--                                                <!-- START DATE AND TIME -->
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">Nom<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="on" name="firstname" class="form-control form-textbox" value=" {{ $firstname =(empty($firstname))?Input::old('firstname'):$firstname }} " required/>
                                                    @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">Prenoms<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="on" name="lastname" class="form-control form-textbox" value=" {{ $lastname =(empty($lastname))?Input::old('lastname'):$lastname }} " required/>
                                                    @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Pays <span class="text-danger">*</span></label>
                                                    <input type="text" name="country" id="S_country" class="form-control form-textbox" value="{{ $country =(empty($country))?Input::old('country'):$country }}" required/>
                                                    @if($errors->has('country')) <span class="error">{{ $errors->first('country') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Ville <span class="text-danger">*</span></label>
                                                    <input type="text" name="city" id="S_city" class="form-control form-textbox" value="{{ $city =(empty($city))?Input::old('city'):$city }}" required/>
                                                    @if($errors->has('city')) <span class="error">{{ $errors->first('city') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Cellphone <span class="text-danger">*</span></label>
                                                    <input type="text" name="cellphone" id="S_cellphone" class="form-control form-textbox" value="{{ $cellphone =(empty($cellphone))?Input::old('cellphone'):$cellphone }}" required/>
                                                    @if($errors->has('cellphone')) <span class="error">{{ $errors->first('cellphone') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Adresse mail <span class="text-danger">*</span></label>
                                                    <input type="text" name="email" id="S_email" class="form-control form-textbox" value="{{ $email =(empty($email))?Input::old('email'):$email}}" required/>
                                                    @if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span> @endif
                                                </div>
                                                <!-- START DATE AND TIME -->--}}
                                                {{--<!-- START DATE AND TIME -->
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_sdate')<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1" value="{{ Input::old('start_date') }}" required data-toggle="datetimepicker" data-target=".datetimepicker1"/>
                                                    @if($errors->has('start_date')) <span class="error">{{ $errors->first('start_date') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_stime')<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="start_time" class="form-control form-textbox datetimepicker-input time-1" value="{{ Input::old('start_time') }}" required id="timepicker_start_time"/>
                                                    @if($errors->has('start_time')) <span class="error">{{ $errors->first('start_time') }}</span> @endif
                                                </div>
                                                <!-- END DATE AND TIME -->
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_edate') <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2" value="{{ Input::old('end_date') }}" required data-toggle="datetimepicker" data-target=".datetimepicker2"/>
                                                    @if($errors->has('end_date')) <span class="error">{{ $errors->first('end_date') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_etime')<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="end_time"  class="form-control form-textbox datetimepicker-input time-2"  value="{{ Input::old('end_time') }}" required class="timepicker" id="timepicker_endtime"/>
                                                    @if($errors->has('end_time')) <span class="error">{{ $errors->first('end_time') }}</span> @endif
                                                </div>
                                                <!-- ------------------- -->
                                                <!-- START DATE AND TIME -->--}}
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group" >
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image_slide_entete"/>
                                                            <label for="imageUpload"><i class="fas fa-upload"></i></label>
                                                        </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url({{asset('/img/default-img-icon.jpg')}});">
                                                        </div>
                                                    </div>
                                                </div>
                                                    @if($errors->has('image_slide_entete')) <span class="error">{{ $errors->first('image_slide_entete') }}</span> @endif
                                                </div>
                                                <div class="col-lg-12 form-group" align="center">
                                                    <input type="submit" value="Proceder au paiement" class="pro-choose-file text-uppercase" />
                                                </div>
                                                {{--<div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_url') </label>
                                                    <input type="text" name="event_url" class="form-control form-textbox" value="{{ Input::old('event_url') }}"/>
                                                    @if($errors->has('event_url')) <span class="error">{{ $errors->first('event_url') }}</span> @endif
                                                </div>--}}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="tab-pane" id="tab_default_2">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12 col-sm-12 ">
                                                    <h3 class=" align-center mt-4"> Tête de Liste </h3>
                                                </div>
                                            </div>
                                            {!! Form::open(['method'=>'post','route'=>'alu.store', 'id'=>'aluForm', 'files'=>'true']) !!}
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <input type="hidden" name="type_service" class="form-control form-textbox" value="tete-de-liste"  id="T_type_service" required/>
                                                    @if(isset($input) && $input['type_service']== 2)
                                                        <input type="hidden" name="duree_service" class="form-control form-textbox" value="{{ $input['duree_service'] }}" required/>
                                                    @else
                                                        <label class="label-text pt-3" >Durée du service<span class="text-danger">*</span></label>
                                                        <input type="number" value="1" name="duree_service" style="text-align:center" id="formule">
                                                        <input type="number" name="montant" value="{{ $serviceListe->montant_service }}" readonly id="montant" style="text-align:center; font-weight: bolder;border:none">
                                                        <input type="hidden" name="pu" value="{{ $serviceListe->montant_service }}" id="pu">
                                                        <input type="hidden" name="designation" value="tete-de-liste">
                                                        {{--<select name="duree_service" class="form-control form-textbox" id="ST_duree_service">
                                                            <option value="1_semaine" selected="selected">1 Semaine</option>
                                                            <option value="2_semaines">2 Semaines</option>
                                                            <option value="3_semaines">3 Semaines</option>
                                                            <option value="4_semaines">4 Semaines</option>
                                                        </select>--}}
                                                        @if($errors->has('duree_service')) <span class="error">{{ $errors->first('duree_service') }}</span> @endif
                                                        {{--<p id="ST_montant">3 000</p>--}}
                                                    @endif
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Lien de redirection  <span class="text-danger">*</span></label>
                                                    <input type="text" name="url_entete_slide" id="url_entete_slide" class="form-control form-textbox" value="{{ Input::old('url_entete_slide') }}" required/>
                                                    @if($errors->has('url_entete_slide')) <span class="error">{{ $errors->first('url_entete_slide') }}</span> @endif
                                                </div>
                                                <!-- START DATE AND TIME -->
                                               {{-- <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">Nom<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="on" name="firstname" class="form-control form-textbox" value=" {{ $firstname =(empty($firstname))?Input::old('firstname'):$firstname }} " required/>
                                                    @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">Prenoms<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="on" name="lastname" class="form-control form-textbox" value=" {{ $lastname =(empty($lastname))?Input::old('lastname'):$lastname }} " required/>
                                                    @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Pays <span class="text-danger">*</span></label>
                                                    <input type="text" name="country" id="country" class="form-control form-textbox" value="{{ $country =(empty($country))?Input::old('country'):$country }}" required/>
                                                    @if($errors->has('country')) <span class="error">{{ $errors->first('country') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Ville <span class="text-danger">*</span></label>
                                                    <input type="text" name="city" id="city" class="form-control form-textbox" value="{{ $city =(empty($city))?Input::old('city'):$city }}" required/>
                                                    @if($errors->has('city')) <span class="error">{{ $errors->first('city') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Cellphone <span class="text-danger">*</span></label>
                                                    <input type="text" name="cellphone" id="cellphone" class="form-control form-textbox" value="{{ $cellphone =(empty($cellphone))?Input::old('cellphone'):$cellphone }}" required/>
                                                    @if($errors->has('cellphone')) <span class="error">{{ $errors->first('cellphone') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text"> Adresse mail <span class="text-danger">*</span></label>
                                                    <input type="text" name="email" id="email" class="form-control form-textbox" value="{{ $email =(empty($email))?Input::old('email'):$email }}" required/>
                                                    @if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span> @endif
                                                </div>--}}
                                                <!-- START DATE AND TIME -->
                                                {{--<!-- START DATE AND TIME -->
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_sdate')<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1" value="{{ Input::old('start_date') }}" required data-toggle="datetimepicker" data-target=".datetimepicker1"/>
                                                    @if($errors->has('start_date')) <span class="error">{{ $errors->first('start_date') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_stime')<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="start_time" class="form-control form-textbox datetimepicker-input time-1" value="{{ Input::old('start_time') }}" required id="timepicker_start_time"/>
                                                    @if($errors->has('start_time')) <span class="error">{{ $errors->first('start_time') }}</span> @endif
                                                </div>
                                                <!-- END DATE AND TIME -->
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_edate') <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2" value="{{ Input::old('end_date') }}" required data-toggle="datetimepicker" data-target=".datetimepicker2"/>
                                                    @if($errors->has('end_date')) <span class="error">{{ $errors->first('end_date') }}</span> @endif
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_etime')<span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" name="end_time"  class="form-control form-textbox datetimepicker-input time-2"  value="{{ Input::old('end_time') }}" required class="timepicker" id="timepicker_endtime"/>
                                                    @if($errors->has('end_time')) <span class="error">{{ $errors->first('end_time') }}</span> @endif
                                                </div>
                                                <!-- ------------------- -->
                                                <!-- START DATE AND TIME -->--}}
                                                <div class="col-lg-12 col-sm-12 col-md-12 form-group" >
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload2" accept=".png, .jpg, .jpeg" name="image_slide_entete"/>
                                                            <label for="imageUpload2"><i class="fas fa-upload"></i></label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview2" style="background-image: url({{asset('/img/default-img-icon.jpg')}});">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="col-lg-12 form-group" align="center">
                                                    <input type="Submit" value="Proceder au paiement" class="pro-choose-file text-uppercase" />
                                                </div>
                                                {{--<div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                    <label class="label-text">@lang('words.cre_eve_page.cre_fm_url') </label>
                                                    <input type="text" name="event_url" class="form-control form-textbox" value="{{ Input::old('event_url') }}"/>
                                                    @if($errors->has('event_url')) <span class="error">{{ $errors->first('event_url') }}</span> @endif
                                                </div>--}}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageScript')

<script type="text/javascript">
$(document).ready(function(){
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview2').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview2').hide();
                $('#imagePreview2').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload2").change(function() {
        readURL2(this);
    });

    /*$('#ST_duree_service').on('change', function(){
        if($(this).val() == '1_semaine') {
            $("#ST_montant").text('3 000');
        }else if($(this).val() == '2_semaines') {
            $("#ST_montant").text('6 000');
        }else if($(this).val() == '3_semaines') {
            $("#ST_montant").text('9 000');
        }else if($(this).val() == '4_semaines'){
            $("#ST_montant").text('12 000');
        }
    });

    $('#SS_duree_service').on('change', function(){
    if($(this).val() == '1_semaine') {
        $("#SS_montant").text('5 000');
    }else if($(this).val() == '2_semaines') {
        $("#SS_montant").text('10 000');
    }else if($(this).val() == '3_semaines') {
        $("#SS_montant").text('15 000');
    }else if($(this).val() == '4_semaines'){
        $("#SS_montant").text('20 000');
    }
    });*/

    $("#formule").on('change', function(){
        var pu = $('#pu').val();
        var formule = $(this).val();
        var montant = pu*formule;
        $("#montant").val(montant);
    });

    $("#formule2").on('change', function(){
        var pu = $('#pu2').val();
        var formule = $(this).val();
        var montant = pu*formule;
        $("#montant2").val(montant);
    });
});
</script>

@endsection