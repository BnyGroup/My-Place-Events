@extends($theme)

@section('meta_title',setMetaData()->org_create_title)
@section('meta_description',setMetaData()->org_create_desc)
@section('meta_keywords',setMetaData()->org_create_keyword)

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
    <div class="container">
        <div class="row page-main-contains">
            <div class="col-lg128 col-md-12 col-sm-12"><h1 class="profile-title">@lang('words.create_org.crea_org_tit')</h1></div>
            <div class="col-lg-12 col-sm-12 col-md-12">
                <p class="profile-tag-line text-capitalize">@lang('words.create_org.crea_org_tag')</p>
            </div>
        </div>
        <div class="row page-main-contains">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        {!! Form::model($data,['route'=>['pre.update',$data->id],'method'=>'patch','files'=>'true','id'=>'prestForm']) !!}
                        <div class="col-sm-9">
                            <a href="#" class="btn btn-site-dft btn-sm"><i class="fa fa-plus"></i>
                                <label for="imageUpload" class="col-sm-12 control-label">Photo de profil</label>
                            </a>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="profile_pics"/>
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ setThumbnail($data->profile_pic) }});">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-center profile-ins-text">@lang('words.create_org.org_pro_detis')</p>
                        <div class="form-textbox">
                            <a href="#" class="btn btn-site-dft btn-sm"><i class="fa fa-plus"></i>
                                <label for="imageUpload2" class="col-sm-12 control-label">Photo de couverture</label>
                            </a>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload2" accept=".png, .jpg, .jpeg" name="cover"/>
                                    <label for="imageUpload2"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview2" style="background-image: url({{ url($data->cover) }});">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        @if($success = Session::get('success'))
                            <div class="alert alert-success">{{ $success }}</div>
                        @endif
                        <div class="form-group">
                            <label class="text-uppercase label-text">Prenoms *</label>
                            <input type="text" name="lastname" class="form-control form-textbox" value="{{ $data->lastname }}">
                            @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase label-text">Nom *</label>
                            <input type="text" name="firstname" class="form-control form-textbox" value="{{ $data->firstname }}">
                            @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase label-text">Nom commercial</label>
                            <input type="text" name="pseudo" class="form-control form-textbox" value="{{ $data->pseudo }}">
                            @if($errors->has('pseudo')) <span class="error">{{ $errors->first('pseudo') }}</span> @endif
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                            <label class="label-text">Adresse geographique <span class="text-danger">*</span></label>
                            <input type="text" name="adresse_geo" placeholder="Location" class="form-control form-textbox" id="create_events" value="{{ $data->adresse_geo }}" onkeypress="refuserToucheEntree(event);" required />

                            {{--<input type="text" name="event_location" placeholder="Location" class="form-control form-textbox" id="header-location" value="{{ Input::old('event_location') }}" required />--}}
                            @if($errors->has('adresse_geo')) <span class="error">{{ $errors->first('adresse_geo') }}</span> @endif
                            <span class="form-note"> <input type="checkbox" value="{{ $data->map_display }}" {{ (!empty($data->map_display) ? '' : 'checked') }} name="map_display" class="form-textbox">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</span>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                            <label class="label-text">MAP </label>
                            <input type="hidden" name="latitude" id="latbox">
                            <input type="hidden" name="longitude" id="lngbox">
                            <div id="map" style="height: 400px;border:1px solid #F16334;"></div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase label-text">Activités * </label>
                            <select name="activites" class="form-control form-textbox">
                                <option @if($data->activites == 'Acrobaties')selected="selected" @endif > Acrobaties </option>
                                <option @if($data->activites == 'Beauté') selected="selected" @endif > Beauté </option>
                                <option @if($data->activites == 'Cuisine') selected="selected" @endif > Cuisine </option>
                                <option @if($data->activites == 'Danse') selected="selected" @endif > Danse </option>
                                <option @if($data->activites == 'Décoration') selected="selected" @endif > Décoration </option>
                                <option @if($data->activites == 'Humour') selected="selected" @endif > Humour </option>
                                <option @if($data->activites == 'Musique') selected="selected"  @endif > Musique </option>
                                <option > Autres </option>
                            </select>
                            @if($errors->has('activites')) <span class="error">{{ $errors->first('activites') }}</span> @endif
                        </div>

                        <div class="form-group">
                            <label class="text-uppercase label-text">A propos *</label>
                            <textarea class="summernote" name="descriptions">{{ $data->descriptions }}</textarea>
                            @if($errors->has('descriptions')) <span class="error">{{ $errors->first('descriptions') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="affiche_desc" id="ck-box" value="{{ $data->affiche_desc }}"> <label for="ck-box">@lang('words.create_org.org_use')</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="text-uppercase label-text">Indicatif</label>
                                        <input type="text" name="indicatif_1" class="form-control form-textbox" value="{{ $data->indicatif_1 }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="text-uppercase label-text">Telephone 1</label>
                                        <input type="text" name="telephone_1" class="form-control form-textbox" value="{{ $data->telephone_1 }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="text-uppercase label-text">Indicatif</label>
                                        <input type="text" name="indicatif_2" class="form-control form-textbox" value="{{ $data->indicatif_2 }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="text-uppercase label-text">Telephone 2</label>
                                        <input type="text" name="telephone_2" class="form-control form-textbox" value="{{ $data->telephone_2 }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-uppercase label-text">Adresse mail *</label>
                            <input type="text" name="adresse_mail"  class="form-control form-textbox" value="{{ $data->adresse_mail }}">
                            @if($errors->has('adresse_mail')) <span class="error">{{ $errors->first('adresse_mail') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="text-uppercase label-text">Facebook :</label>
                                        <input type="text" name="facebook"  class="form-control form-textbox" value="{{ $data->facebook }}">
                                        @if($errors->has('facebook')) <span class="error">{{ $errors->first('facebook') }}</span> @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="text-uppercase label-text">Messenger :</label>
                                        <input type="text" name="messenger"  class="form-control form-textbox" value="{{ $data->messenger }}">
                                        @if($errors->has('messenger')) <span class="error">{{ $errors->first('messenger') }}</span> @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="text-uppercase label-text">Twitter :</label>
                                        <input type="text" name="twitter"  class="form-control form-textbox" value="{{ $data->twitter }}">
                                        @if($errors->has('twitter')) <span class="error">{{ $errors->first('twitter') }}</span> @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="text-uppercase label-text">Instagram :</label>
                                        <input type="text" name="instagram"  class="form-control form-textbox" value="{{ $data->Instagram }}">
                                        @if($errors->has('instagram')) <span class="error">{{ $errors->first('instagram') }}</span> @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="text-uppercase label-text">Google +:</label>
                                        <input type="text" name="google"  class="form-control form-textbox" value="{{ $data->google }}">
                                        @if($errors->has('google')) <span class="error">{{ $errors->first('google') }}</span> @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="text-uppercase label-text">YouTube :</label>
                                        <input type="text" name="youtube"  class="form-control form-textbox" value="{{ $data->youtube }}">
                                        @if($errors->has('youtube')) <span class="error">{{ $errors->first('youtube') }}</span> @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="text-uppercase label-text">Website :</label>
                                        <input type="text" name="website"  class="form-control form-textbox" value="{{ $data->website }}">
                                        @if($errors->has('website')) <span class="error">{{ $errors->first('website') }}</span> @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                            <label class="label-text">Réalisations :</label>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="file" class="form-control" id="images" name="images[]" onchange="preview_images();" multiple/>
                                    <span style="font-size:0.8em;">Taille maximale : 2MB</span>
                                    @if($errors->has('images')) <span class="error">{{ $errors->first('images') }}</span> @endif
                                </div>

                            </div>
                            <div class="form-group">
                                @if(!empty($P_realisations))
                                        @foreach($P_realisations as $realisation)
                                            <div>
                                                <img src="{{ getImage($realisation->realisation) }}" style="width: 50%; height: auto" />
                                            </div>
                                            <a href="{{ route('rea.delete',[$realisation->id, $data->url_slug]) }}" class="btn btn-site-dft btn-sm" onclick=" return confirm('are you sure Delete this item ?')"><i class="fa fa-trash"></i> @lang('words.mng_eve.mng_eve_del')</a>
                                        @endforeach
                                @endif
                            </div>
                        <input type="hidden" name="id_frontusers" value="{{ auth()->guard('frontuser')->user()->id }}">
                        <div class="form-group">
                            {!! Form::submit('Mettre à jour',['class'=>'pro-choose-file text-uppercase']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="col-lg-3 col-md-3 col-sm-12 org-emenu">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <h3 class="orh-menu-title">@lang('words.create_org.org_tit_list')</h3>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-md-12">
                                <ul class="list-inline org-menu">
                                    @foreach($prestList as $key => $val)
                                        <li><a href="{{ route('pre.edit',$val->url_slug) }}" data-toggle="tooltip" title="{{ $val->firstname }}" data-placement="right"><i class="fa fa-hand-o-right" aria-hidden="true"></i>{{ str_limit($val->firstname,22) }}</a></li>
                                    @endforeach
                                </ul>
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
        function refuserToucheEntree(event)
        {
            // Compatibilité IE / Firefox
            if(!event && window.event) {
                event = window.event;
            }
            // IE
            if(event.keyCode == 13) {
                event.returnValue = false;
                event.cancelBubble = true;
            }
            // DOM
            if(event.which == 13) {
                event.preventDefault();
                event.stopPropagation();
            }
        }
    </script>
    <script type="text/javascript">
    $(function(){
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
    });
    </script>



@endsection