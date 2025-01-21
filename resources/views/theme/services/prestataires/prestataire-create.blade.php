@extends($theme)

@section('meta_title',setMetaData()->org_create_title)
@section('meta_description',setMetaData()->org_create_desc)
@section('meta_keywords',setMetaData()->org_create_keyword)

@section('content')


<section class="page-title page-title- fil-ariane-light">
	<div class="container">
		<div class="row">

			<div class="breadcrumb breadcrumb-2 text-left">
				<p id="breadcrumbs" style="border-bottom: 1px solid #a9a8a8; padding-bottom: 8px;"><span><span><a href="{{ url('/') }}{{--https://myplace-event.com/--}}">@lang('words.nav_bar.nav_bar_menu_1')</a> / <span><a href="{{--https://myplace-event.com/events/--}}{{ url('prestataire') }}">Prestataire</a> / <strong class="breadcrumb_last primary-color" aria-current="page">Créer un compte Prestataire</strong></span></span></span></p>
			</div>

		</div>
		<!--end of row-->
	</div>
	<!--end of container-->
</section>

{!! Form::open(['route'=>'pre.store','method'=>'post','files'=>'true']) !!}

		<div class="container">
			<div class="row">
			  <div class="col-lg-6 col-sm-12 col-md-12 text-center content-title">
				<h1 style="margin-bottom: 0;color: #D600A9 !important;" class="top-presta section-title">CREER UN PRESTATAIRE</h1>
			  </div>
				 <div class="col-lg-6 col-sm-12 col-md-12" style="margin-top: 35px;">
					<p class="profile-tag-line" style="font-size: 18px;">Développez des opportunités d’affaires en partageant votre
						savoir-faire au grand public et aux organisateurs d’événements.</p>
				</div>
			</div>
		</div>	
		<!--Cover-->
		@if($errors->any())
            <div class="error"><strong style="width: 100%;text-align: center;position: relative;display: block;"><font color="red">{{ implode('', $errors->all(':message')) }}</font></strong></div>
        @endif
		@if ($errors->has('cover'))<span class="help-block"><strong style="width: 100%;text-align: center;position: relative;display: block;"><font color="red">{{ $errors->first('cover') }}</font></strong></span>@endif
        <div class="col-md-12 cover-img coverme" style="background-color: #d5d6e3; ">
			<div class="container">
				<div class="editCover">
					<input type="file" name="cover" id="imgCover" style="display: none;" />
					<a href="javascript:void(0)" onclick="document.getElementById('imgCover').click();"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a></div>
				<br style="clear: both">
			</div>
		</div>
        <!--Cover-->		
		<div class="container" id="single-artistes">
			<div class="row">
				<!--Photo de profil-->
				<div class="col-lg-12 col-sm-12 col-xs-12 text-center">
					<div class="row">
						<div class="profile" style="margin-bottom: 25px;">
							<input type="file" name="profile_pics" id="imgInp" style="display: none;" />
							<img src="{{ url('/') }}/public/img/icoph.png" id="ingOup" class="img-fluid" onclick="document.getElementById('imgInp').click();">
							<a class="addimgp" href="javascript:void(0)" onclick="document.getElementById('imgInp').click();"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a></div>
						</div>
					 	@if($errors->has('profile_pics')) <span style="font-size: 17px;font-style: normal;text-align: center;width: 100%;font-weight: bold;color: red;" class="error">{{ $errors->first('profile_pics') }}</span> @endif
						<div style="font-size: 11px; font-style: italic; text-align: center; width: 100%;">JPG, GIF ou PNG inférieurs 1MB.<br> Les images carrées ont fière allure !</div>
					</div>
				</div>
			</div>
		 
<style>
	#single-artistes .profile, .profile-picture{	
    	margin-top: -260px;
	}
</style>
    <div class="container" style="margin-top: 50px; margin-bottom: 100px">
		<div class="row"> 
        @if($success = Session::get('success'))
            <div class="alert alert-success" style="margin-left:25px;">{{$success}}</div>
        @endif
        @if($error = Session::get('erreur'))
            <div class="alert alert-danger" style="margin-left:25px;">{{$error}}</div>
        @endif
        <div class="row container">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                       <div class="row"> &nbsp;</div>                        
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        @if($success = Session::get('success'))
                            <div class="alert alert-success">{{ $success }}</div>
                        @endif
                        <div class="form-group">
<div class="col-sm-12">
    <label class=" label-text">Prenoms *</label>
    <input type="text" name="lastname" class="form-control form-textbox" value="{{ Input::old('lastname') }}">
    @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }}</span> @endif
</div>
                        </div>
                        <div class="form-group">
						   <div class="col-sm-12">
							   <label class=" label-text">Nom *</label>
							   <input type="text" name="firstname" class="form-control form-textbox" value="{{ Input::old('firstname') }}">
							   @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }}</span> @endif
						   </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class=" label-text">Nom commercial</label>
                                <input type="text" name="pseudo" class="form-control form-textbox" value="{{ Input::old('pseudo') }}">
                                @if($errors->has('pseudo')) <span class="error">{{ $errors->first('pseudo') }}</span> @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 form-group">
                            <label class="label-text">Adresse géographique <span class="text-danger">*</span></label>
                            <input type="text" name="adresse_geo" placeholder="Localisation" class="form-control form-textbox" id="create_events" value="{{ Input::old('adresse_geo') }}" onkeypress="refuserToucheEntree(event);" required />

                            {{--<input type="text" name="event_location" placeholder="Location" class="form-control form-textbox" id="header-location" value="{{ Input::old('event_location') }}" required />--}}
                            @if($errors->has('adresse_geo')) <span class="error">{{ $errors->first('adresse_geo') }}</span> @endif
                            <span class="form-note"> <input type="checkbox" value="1" {{ (! empty(Input::old('map_display')) ? '' : 'checked') }} name="map_display" class="form-textbox">&nbsp;&nbsp; @lang('words.cre_eve_page.cre_fm_map')</span>
                        </div>
                        
                        <div class="form-group" style="margin-top: 30px">
							<div class="col-sm-12">
                            <label class=" label-text">Activités *</label>
                            <select name="activites" class="form-control form-textbox">
								<option>Choisir une Catgéorie</option>
								@if(!empty($catdata))
									@foreach($catdata as $cat)
											<option value="{{$cat->id}}" <?php if(Input::old('activites')){ if(Input::old('activites')==$cat->id) echo'selected'; } ?>> {{$cat->category_name}} </option>
									@endforeach
								@endif
 
                            </select>
                            @if($errors->has('activites')) <span class="error">{{ $errors->first('activites') }}</span> @endif
							</div>
                        </div>

                        <div class="form-group">
							<div class="col-sm-12">
								<label class=" label-text">Description *</label>
								<textarea class="summernote" name="descriptions">{{ Input::old('descriptions') }}</textarea>
								@if($errors->has('descriptions')) <span class="error">{{ $errors->first('descriptions') }}</span> @endif
							</div>
                        </div>
                        <div class="form-group" style="margin-top: 10px">
							<div class="col-sm-12">
                            	<input type="checkbox" name="affiche_desc" id="ck-box" value="1"> <label for="ck-box">@lang('words.create_org.org_use')</label>
							</div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class=" label-text">Indicatif</label>
                                        <input type="text" name="indicatif_1" class="form-control form-textbox" value="{{ Input::old('indicatif_1') }}">
                                    </div>
                                    <div class="col">
                                        <label class=" label-text">Telephone 1</label>
                                        <input type="text" name="telephone_1" class="form-control form-textbox" value="{{ Input::old('telephone_1') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="t label-text">Indicatif</label>
                                    <input type="text" name="indicatif_2" class="form-control form-textbox" value="{{ Input::old('indicatif_2') }}">
                                </div>
                                <div class="col">
                                    <label class=" label-text">Telephone 2</label>
                                    <input type="text" name="telephone_2" class="form-control form-textbox" value="{{ Input::old('telephone_2') }}">
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="form-group">
                        <div class="col-sm-12">
                            <label class="label-text">Adresse mail *</label>
                            <input type="text" name="adresse_mail"  class="form-control form-textbox" value="{{ Input::old('adresse_mail') }}">
                            @if($errors->has('adresse_mail')) <span class="error">{{ $errors->first('adresse_mail') }}</span> @endif
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class=" label-text"><i class="fab fa-facebook facebook-color"></i> Facebook :</label>
                                        <input type="text" name="facebook"  class="form-control form-textbox facebook-border" value="{{ Input::old('facebook') }}">
                                        @if($errors->has('facebook')) <span class="error">{{ $errors->first('facebook') }}</span> @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="t label-text"><i class="fab fa-instagram instagram-color"></i> Instagram :</label>
                                        <input type="text" name="instagram"  class="form-control form-textbox instagram-border" value="{{ Input::old('instagram') }}">
                                        @if($errors->has('instagram')) <span class="error">{{ $errors->first('instagram') }}</span> @endif
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class=" label-text"><i class="fab fa-twitter twitter-color"></i> Twitter :</label>
                                        <input type="text" name="twitter"  class="form-control form-textbox twitter-border" value="{{ Input::old('twitter') }}">
                                        @if($errors->has('twitter')) <span class="error">{{ $errors->first('twitter') }}</span> @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class=" label-text"><i class="fab fa-facebook-messenger  facebook-color"></i> Messenger :</label>
                                        <input type="text" name="messenger"  class="form-control form-textbox facebook-border" value="{{ Input::old('messenger') }}">
                                        @if($errors->has('messenger')) <span class="error">{{ $errors->first('messenger') }}</span> @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class=" label-text"><i class="fab fa-whatsapp  whatsapp-color"></i> WhatsApp +:</label>
                                        <input type="text" name="google" class="form-control form-textbox whatsapp-border" value="{{ Input::old('google') }}">
                                        @if($errors->has('google')) <span class="error">{{ $errors->first('google') }}</span> @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class=" label-text"><i class="fab fa-youtube youtube-color"></i> YouTube :</label>
                                        <input type="text" name="youtube"  class="form-control form-textbox youtube-border" value="{{ Input::old('youtube') }}">
                                        @if($errors->has('youtube')) <span class="error">{{ $errors->first('youtube') }}</span> @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class=" label-text">Site web :</label>
                                        <input type="text" name="website"  class="form-control form-textbox" value="{{ Input::old('website') }}">
                                        <h6>(eg : https://monsiteweb.com)</h6>
                                        @if($errors->has('website')) <span class="error">{{ $errors->first('website') }}</span> @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                         <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
                        <link type="text/css" rel="stylesheet" href="{{ asset('/uploader/image-uploader.min.css') }}">                             
                            <div class="col-md-12">
                            <label class="label-text">Réalisations :</label>
                                <div class="input-images"></div>
                                <h6 style="text-align: center; margin-top:10px">Vous pouvez ajouter jusqu'à six (6) réalisations.</h6>
                            </div>

                        </div>
                        <input type="hidden" name="id_frontusers" value="{{ auth()->guard('frontuser')->user()->id }}">
                        <div class="form-group" style="text-align: center; margin-top: 30px">
                            {!! Form::submit('Créer un compte prestataire',['class'=>'pro-choose-file presthover']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="row">
                            
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageScript')

<script type="text/javascript" src="{{ asset('/uploader/image-uploader.min.js') }}"></script>

    <script type="text/javascript">
    
    $('.input-images').imageUploader({
        label:"Faites glisser et déposez les fichiers ici ou cliquez pour parcourir",
        imagesInputName:"imgreal"
    });

		 

        $('#add_more').click(function() {
            "use strict";
            $(this).before($("<div/>", {
                id: 'filediv'
            }).fadeIn('slow').append(
                $("<input/>", {
                    name: 'file[]',
                    type: 'file',
                    id: 'file',
                    multiple: 'multiple',
                    accept: 'image/*'
                })
            ));
        });

        $('#upload').click(function(e) {
            "use strict";
            e.preventDefault();

            if (window.filesToUpload.length === 0 || typeof window.filesToUpload === "undefined") {
                alert("No files are selected.");
                return false;
            }

            // Now, upload the files below...
            // https://developer.mozilla.org/en-US/docs/Using_files_from_web_applications#Handling_the_upload_process_for_a_file.2C_asynchronously
        });

        deletePreview = function (ele, i) {
            "use strict";
            try {
                $(ele).parent().remove();
                window.filesToUpload.splice(i, 1);
            } catch (e) {
                console.log(e.message);
            }
        }

        $("#file").on('change', function() {
            "use strict";

            // create an empty array for the files to reside.
            window.filesToUpload = [];

            if (this.files.length >= 1) {
                $("[id^=previewImg]").remove();
                $.each(this.files, function(i, img) {
                    var reader = new FileReader(),
                        newElement = $("<div id='previewImg" + i + "' class='previewBox'><img /></div>"),
                        deleteBtn = $("<span class='delete' onClick='deletePreview(this, " + i + ")'>X</span>").prependTo(newElement),
                        preview = newElement.find("img");

                    reader.onloadend = function() {
                        preview.attr("src", reader.result);
                        preview.attr("alt", img.name);
                    };

                    try {
                        window.filesToUpload.push(document.getElementById("file").files[i]);
                    } catch (e) {
                        console.log(e.message);
                    }

                    if (img) {
                        reader.readAsDataURL(img);
                    } else {
                        preview.src = "";
                    }

                    newElement.appendTo("#filediv");
                });
            }
        });



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



@endsection