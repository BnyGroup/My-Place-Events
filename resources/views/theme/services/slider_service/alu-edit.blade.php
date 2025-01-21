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
        <div class="row page-main-contain boxed-box">
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
                <h2 class="profile-title profile-title-text page-header">Modification de la mise à la une</h2>
                <br/>
                @if(isset($infoService))
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tabbable-panel">
                                    <div class="tabbable-line">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_default_1">
                                                @if($infoService->type_service == 'Slider')
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-sm-12">
                                                            <h3 class=""> Slider </h3>
                                                        </div>
                                                    </div>
                                                    {!! Form::model($infoService,['route'=>['alu.update',$infoService->id],'method'=>'patch','files'=>'true','id'=>'aluForm']) !!}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <input type="hidden" name="type_service" value="{{ $infoService->type_service}}">
                                                            <label class="label-text pt-3" >Durée du service<span class="text-danger">*</span></label>
                                                            <input type="number" value="{{ $infoService->duree_service }}" name="duree_service" style="text-align:center" id="formule">
                                                            <input type="number" name="montant" value="{{ $infoService->montant }}" readonly id="montant" style="text-align:center; font-weight: bolder;border:none">
                                                            <input type="hidden" name="pu" value="{{ $serviceSlide->montant_service }}" id="pu">
                                                            <input type="hidden" name="slug" value="{{ $infoService->slug}}">
                                                                {{--<select name="duree_service" class="form-control form-textbox" id="SS_duree_service">
                                                                    <option value="1_semaine" @if($infoService->type_service == 1) selected @endif>1 Semaine</option>
                                                                    <option value="2_semaines" @if($infoService->type_service == 2) selected @endif>2 Semaines</option>
                                                                    <option value="3_semaines" @if($infoService->type_service == 3) selected @endif>3 Semaines</option>
                                                                    <option value="4_semaines" @if($infoService->type_service == 4) selected @endif>4 Semaines</option>
                                                                </select>
                                                                <p id="SS_montant">{{ $infoService->montant }}</p>--}}
                                                                @if($errors->has('duree_service')) <span class="error">{{ $errors->first('duree_service') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <label class="label-text"> Titre <span class="text-danger">*</span></label>
                                                            <input type="text" name="titre_slide" id="S_titre_slide" class="form-control form-textbox" value="{{ $infoService->titre_slide}}" required/>
                                                            @if($errors->has('titre_slide')) <span class="error">{{ $errors->first('titre_slide') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <label class="label-text"> Description <span class="text-danger">*</span></label>
                                                            <input type="text" name="description_slide" id="S_description_slide" class="form-control form-textbox" value="{{ $infoService->description_slide }}" required/>
                                                            @if($errors->has('description_slide')) <span class="error">{{ $errors->first('description_slide') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <label class="label-text"> Text du bouton <span class="text-danger">*</span></label>
                                                            <input type="text" name="slide_btn_text" id="S_slide_btn_text" class="form-control form-textbox" value="{{ $infoService->slide_btn_text }}" required/>
                                                            @if($errors->has('slide_btn_text')) <span class="error">{{ $errors->first('slide_btn_text') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <label class="label-text"> Lien de redirection  <span class="text-danger">*</span></label>
                                                            <input type="text" name="url_entete_slide" id="S_url_entete_slide" class="form-control form-textbox" value="{{ $infoService->url_entete_slide }}" required/>
                                                            @if($errors->has('url_entete_slide')) <span class="error">{{ $errors->first('url_entete_slide') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group" >
                                                            @if ($errors->has('slide_img'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_img') }}</font></strong></span>@endif
                                                            <div class="avatar-upload">
                                                                <div class="avatar-edit">
                                                                    {!! Form::hidden('old_image',$infoService->image_slide_entete) !!}
                                                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image_slide_entete"/>
                                                                    <label for="imageUpload"></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview" style="background-image: url({{ url($infoService->image_slide_entete) }});">
                                                                    </div>
                                                                    <h6 style="text-align: center;color: black;">( Reselectionner l'image avant de valider la mise à jour )</h6>
                                                                </div>
                                                            </div>
                                                            @if($errors->has('image_slide_entete')) <span class="error">{{ $errors->first('image_slide_entete') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 form-group" align="center">
                                                            <div class="form-group">
                                                                {!! Form::submit('Metrre à jour',['class'=>'pro-choose-file text-uppercase']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                    </div>
                                                @else
                                                <div class="tab-pane" id="tab_default_2">
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
                                                            <h2 class="text-uppercase about-title align-center"> Tête de Liste </h2>
                                                        </div>
                                                    </div>
                                                    {!! Form::model($infoService,['route'=>['alu.update',$infoService->id],'method'=>'patch','files'=>'true','id'=>'aluForm']) !!}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <input type="hidden" name="type_service" value="{{ $infoService->type_service}}">
                                                            <label class="label-text pt-3" >Durée du service<span class="text-danger">*</span></label>
                                                            <input type="number" value="{{ $infoService->duree_service }}" name="duree_service" style="text-align:center" id="formule2">
                                                            <input type="number" name="montant" value="{{ $infoService->montant }}" readonly id="montant2" style="text-align:center; font-weight: bolder;border:none">
                                                            <input type="hidden" name="pu" value="{{ $serviceListe->montant_service }}" id="pu2">
                                                            <input type="hidden" name="slug" value="{{ $infoService->slug}}">
                                                            {{--<select name="duree_service" class="form-control form-textbox" id="SS_duree_service">
                                                                <option value="1_semaine" @if($infoService->type_service == 1) selected @endif>1 Semaine</option>
                                                                <option value="2_semaines" @if($infoService->type_service == 2) selected @endif>2 Semaines</option>
                                                                <option value="3_semaines" @if($infoService->type_service == 3) selected @endif>3 Semaines</option>
                                                                <option value="4_semaines" @if($infoService->type_service == 4) selected @endif>4 Semaines</option>
                                                            </select>
                                                            <p id="SS_montant">{{ $infoService->montant }}</p>--}}
                                                            @if($errors->has('duree_service')) <span class="error">{{ $errors->first('duree_service') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <label class="label-text"> Lien de redirection  <span class="text-danger">*</span></label>
                                                            <input type="text" name="url_entete_slide" id="S_url_entete_slide" class="form-control form-textbox" value="{{ $infoService->url_entete_slide }}" required/>
                                                            @if($errors->has('url_entete_slide')) <span class="error">{{ $errors->first('url_entete_slide') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-md-12 form-group" >
                                                            @if ($errors->has('slide_img'))<span class="help-block"><strong><font color="red">{{ $errors->first('slide_img') }}</font></strong></span>@endif
                                                            <div class="avatar-upload">
                                                                <div class="avatar-edit">
                                                                    {!! Form::hidden('old_image',$infoService->image_slide_entete) !!}
                                                                    <input type='file' id="imageUpload2" accept=".png, .jpg, .jpeg" name="image_slide_entete"/>
                                                                    <label for="imageUpload2"></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview2" style="background-image: url({{ url($infoService->image_slide_entete) }});">
                                                                    </div>
                                                                </div>
                                                                <h6 style="text-align: center;color: black;">( Reselectionner l'image avant de valider la mise à jour )</h6>
                                                            </div>
                                                            @if($errors->has('image_slide_entete')) <span class="error">{{ $errors->first('image_slide_entete') }}</span> @endif
                                                        </div>
                                                        <div class="col-lg-12 form-group" align="center">
                                                            <div class="form-group">
                                                                {!! Form::submit('Metrre à jour',['class'=>'pro-choose-file text-uppercase']) !!}
                                                            </div>
                                                        </div>
                                                        {{--<div class="col-lg-12 col-sm-12 col-md-12 form-group">
                                                            <label class="label-text">@lang('words.cre_eve_page.cre_fm_url') </label>
                                                            <input type="text" name="event_url" class="form-control form-textbox" value="{{ Input::old('event_url') }}"/>
                                                            @if($errors->has('event_url')) <span class="error">{{ $errors->first('event_url') }}</span> @endif
                                                        </div>--}}
                                                    </div>
                                                    {!! Form::close() !!}
                                                    </div>
                                            @endif
                                                </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            @endif
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