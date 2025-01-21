@extends($AdminTheme)
@section('title')
    {{__('Nouveau Produit')}}
@endsection
@section('style')

 
<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/custom-style.css">
<link rel="stylesheet" href="{{ url('/') }}/public/assets/common/css/flatpickr.min.css">

<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/dropzone.css">
<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/media-uploader.css">    

<style>
	.additional_info_container {
	margin-top: 55px;
	}
	.additional_info {
	margin-top: 35px;
	}
	.add_more_info_btn {
	align-items: center;
	margin-bottom: 10px;
	}
	.remove_this_info_btn {
	align-items: center;
	margin-bottom: 10px;
	}
</style>   

<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/nice-select.css">    
<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/bootstrap-tagsinput.css">
<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/summernote-bs4.css">    

<style>
	#attribute_price_container {
		display: none;
	}
</style>

<style>
	#attribute_price_container {
		display: none;
	}
</style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('message'))
<div class="alert alert-{{ session()->get('type') }}">
{{ session()->get('message') }}
</div>
@endif
                </div>
            </div>
            <div class="col-lg-12">
                <div class="text-right mb-5">
                    <a href="{{ route('admin.products.all') }}" class="btn btn-primary px-4">{{ __('Tous les Produits') }}</a>
                </div>
                <form action="{{ route('admin.products.new') }}" method="POST">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body p-5">
                                    <h5 class="mb-5">{{ __('Informations sur les Produits') }}</h5>
                                    <div class="form-group">
                                        <label for="title">{{ __('Nom') }}</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">{{ __('Slug') }}</label>
                                        <input type="text" name="slug" id="slug" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="summary">{{ __('Résumé') }}</label>
                                        <textarea class="form-control" name="summary" id="summary" cols="30" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea class="form-control summernote" name="description" id="description" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="form-group " id="blog_tag_list">
                                        <label for="tags">{{__('Tags')}}</label>
                                        <input type="text" class="form-control tags_filed"
                                               name="tags" id="datetimepicker1">

                                            <div id="show-autocomplete" style="display: none;">
                                                <ul class="autocomplete-warp" ></ul>
                                            </div>
                                    </div>
                                    <div id="attribute_price_container">
                                        <h5 class="my-3">{{ __('Attributs') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-body px-5 pb-5">
                                    <div class="additional_info_container">
                                        <h5 class="mb-5">{{ __('Informations Complémentaires') }}</h5>
                                        <div class="additional_info">
											
                                            <div class="additional_info">
												<div class="additional_info_repeater">
													<div class="form-row">
														<div class="col-md-5">
															<input type="text" name="info_title[]" class="form-control" placeholder="Titre de l'information">
														</div>
														<div class="col-md-5">
															<input type="text" name="info_text[]" class="form-control" placeholder="Texte d'information">
														</div>
														<div class="col-md-2">
															<button type="button" class="btn btn-sm btn-success add_more_info_btn"> + </button>
															<button type="button" class="btn btn-sm btn-danger remove_this_info_btn" disabled=""> - </button>
														</div>
													</div>
												</div>
											</div>	
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="mb-5 mt-3">{{ __('Information sur le Stock') }}</h5>
                                    <div class="form-group">
                                        <label for="sku">{{ __('Référence SKU du produit') }}</label>
                                        <input type="text" id="sku" name="sku" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_count">{{ __('Articles en stock') }}</label>
                                        <input type="number" id="stock_count" name="stock_count" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-5 mt-3">{{ __('Plus d\'informations') }}</h5>
                                    <div class="form-row mb-3">
                                        <div class="col">
                                            <label for="price">{{ __('Prix régulier') }}</label>
                                            <input type="number" name="price" id="price" step="0.01" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label for="sale_price">{{ __('Prix de vente') }}</label>
                                            <input type="number" name="sale_price" id="sale_price" step="0.01" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="attributes_options">{{ __('Attributs') }}</label>
                                        <div class="form-row">
                                            <div class="col">
                                                <select class="form-control" name="attributes_options" id="attributes_options">
                                                    <option value="">{{ __('Sélectionnez l\'attribut') }}</option>
                                                    @foreach ($all_attribute as $attribute)
                                                    <option value="{{ $attribute->id }}" data-terms="{{ $attribute->terms }}">{{ $attribute->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="attribute_container"></div>
                                    <div class="form-group">
                                        <label for="category_id">{{ __('Catégorie') }}</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">Sélectionnez une catégorie</option>
                                            @foreach ($all_category as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="form-group" id="event_products" style="display:none">
                                        <label for="products">{{__('Evènements')}}</label>
                                        <select name="products[]" id="products" class="form-control nice-select wide" multiple></select>
                                    </div>
                                    
                                    <?php /*<div class="form-group">
                                        <label for="sub_category_id">{{ __('Sous-catégorie') }}</label>
                                        <select class="form-control nice-select wide" name="sub_category_id[]" id="sub_category_id" multiple>
                                            @foreach ($all_sub_category as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->title }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-secondary">{{ __('Pressez ') }} <kbd>{{ __('Ctrl') }}</kbd> {{ __(' et Cliquez pour sélectionner plusieurs options') }}</span>
                                    </div>*/ ?>
									
									<div class="form-group">
										<label for="image">Image</label>
										<div class="media-upload-btn-wrapper">
											<div class="img-wrap"></div>
											<br>
											<input type="hidden" name="image" value="">
											<button type="button" class="btn btn-info media_upload_form_btn2" data-btntitle="Sélectionner une image" data-modaltitle="Télécharger une image" data-imgid="" data-toggle="modal" data-target="#media_upload_modal2">
												Télécharger une image
											</button>
										</div>
										<small>La taille d'image recommandée est 1280x1280</small>
									</div>
									
									<div class="form-group ">
<label for="image">Galerie d'Image</label>
<div class="media-upload-btn-wrapper">
<div class="img-wrap">
</div>
<input type="hidden" name="image_gallery">
<button type="button" class="btn btn-info media_upload_form_btn2" data-btntitle="Sélectionner Image" data-modaltitle="Sélectionner Image" data-toggle="modal" data-mulitple="true" data-target="#media_upload_modal2">
Télécharger une image
</button>
</div>
</div>
																		
                                    <div class="form-group">
                                        <label for="badge">{{ __('Badge') }}</label>
                                        <input type="text" name="badge" id="badge" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ __('Statut') }}</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="draft">{{ __('Brouillon') }}</option>
                                            <option value="publish">{{ __('Publier') }}</option>
                                        </select>
                                    </div>
                                    <div class="text-center mt-5">
                                        <button class="btn btn-primary">{{ __('Créer un produit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<style>
	h5.mb-5{
		font-size: 26px;
		font-weight: 600;
		margin-bottom: 25px;
	}
	
#media_upload_modal2 .modal-dialog {
    max-width: calc(100% - 40px) !important;
    width: 100%;
}
</style>
<div class="modal" id="media_upload_modal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Téléchargements de médias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="upload_media_image" data-toggle="tab" href="#upload_files" role="tab" aria-selected="true">Uploader des fichiers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#media_library" role="tab" id="load_all_media_images" aria-controls="media_library" aria-selected="false">Médiathèque</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="upload_files" role="tabpanel">
                        <div class="dropzone-form-wrapper">
                            <form action="{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/media-upload" method="post" id="placeholderfForm" class="dropzone dz-clickable" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="dz-default dz-message"><span>Drop files here to upload</span> <span class="xg-accept-files">Support Formats ( jpg, png, jpeg, gif )</span> <span class="xg-accept-files">Max Upload Size: 10MB</span> <span class="xg-accept-files">Max Upload Files: 50</span></div></form>
                        </div>
                    </div>
                    <div class="tab-pane" id="media_library" role="tabpanel">
                        <div class="all-uploaded-images">

                            <div class="main-content-area-wrap">
                                <div class="image-preloader-wrapper">
                                    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div>
                               <div class="image-list-wr5apper">
                                   <ul class="media-uploader-image-list"> </ul>
                                   <div id="loadmorewrap"><button type="button">Charger Plus</button></div>
                               </div>
                                <div class="media-uploader-image-info">
                                    <div class="img-wrapper">
                                        <img src="" alt="">
                                    </div>
                                    <div class="img-info">
                                        <h5 class="img-title"></h5>
                                        <ul class="img-meta" style="display: none">
                                            <li class="date"></li>
                                            <li class="dimension"></li>
                                            <li class="size"></li>
                                            <li class="image_id" style="display:none;"></li>
                                            <li class="imgsrc"></li>
                                            <li class="imgalt">
                                               <div class="img-alt-wrap">
                                                   <input type="text" name="img_alt_tag" placeholder="alt">
                                                   <button class="btn btn-success img_alt_submit_btn"><i class="ti-check"></i></button>
                                               </div>
                                            </li>
                                        </ul>
                                        <a tabindex="0" style="display: none" class=" btn btn-lg btn-danger btn-sm mb-3 mr-1" id="media_library_image_delete_btn">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary media_upload_modal_submit_btn" style="display: none">Set Image</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page-level-script')
 

<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/responsive.jqueryui.min.css">

<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/dropzone.css">
<link rel="stylesheet" href="{{ url('/') }}/public/assets/backend/css/media-uploader.css"> 

<script src="{{ url('/') }}/public/assets/backend/js/sweetalert2.js"></script>
<script src="{{ url('/') }}/public/assets/common/js/toastr.min.js"></script>
 

<script src="{{ url('/') }}/public/assets/common/js/bootstrap.min.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/sweetalert2.js"></script>
 
<script src="{{ url('/') }}/public/assets/backend/js/dropzone.js"></script>

 
<script src="{{asset('/assets/backend/js/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('/assets/common/js/typeahead.bundle.min.js')}}"></script>

<script>

$('#category_id').on('change', function () {
    loadProductHtml(this, '#event_products select', true, []);
});


        function loadProductHtml(context, target_selector, is_edit, values) {
            let product_select = $(target_selector);

            let selector_prefix = '';
            if (is_edit) {
                selector_prefix = 'edit_';
            }

           
            if ($(context).val() == '37') {
                $('.lds-ellipsis').show();
                $.get('{{ route("coupons.listallevents") }}').then(function (data) {
                    $('.lds-ellipsis').hide();

                    let options = '';
                    let discountd_products = [];

                    if (values.length) {
                        discountd_products = values;
                    }

                    if (data.length) {
                        data.forEach(function (product) {
                            let selected_class = '';
 
                            if (discountd_products.indexOf(product.id) > -1 || discountd_products.indexOf(String(product.id)) > -1) {
                                selected_class = 'selected';
                            }
                            options += '<option value="'+product.id+'" '+selected_class+'>'+product.event_name+' ('+product.ticket_id+')</option>';
                        });

                        product_select.html('');
                        product_select.html(options);
                        product_select.parent().show(500);
                        product_select.addClass('nice-select')

                        if ($('.nice-select').length) {
                            if ($('.nice-select.form-control.wide.has-multiple').length) {
                                $('.nice-select.form-control.wide.has-multiple').remove();
                            }
                            $('.nice-select').niceSelect();
                        }
                    }
                }).catch(function (err) {
                    $('.lds-ellipsis').hide();
                });
            }else{
                $("#event_products").hide()
            }
        }


    ;(function () {
        "use strict";

        $(document).ready(function (){
        var mainUploadBtn = '';

        //after select image
        $(document).on('click','.media_upload_modal_submit_btn',function (e) {
            e.preventDefault();
            var allData = $('.media-uploader-image-list li.selected');
            if( typeof allData != 'undefined'){
                mainUploadBtn.parent().find('.img-wrap').html('');
                var imageId = '';
                $.each(allData,function(index,value){
                    var el = $(this).data();
                    var separator = allData.length == index ? '' : '|';
                    imageId += el.imgid + separator;
                    mainUploadBtn.prev('input').attr('data-imgsrc',el.imgsrc);
                    mainUploadBtn.parent().find('.img-wrap').append('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img src="'+el.imgsrc+'"></div></div></div>');
                });
                 mainUploadBtn.prev('input').val(imageId.substring(0,imageId.length -1));

            }
            $('#media_upload_modal2').modal('hide');
            $('.media_upload_form_btn2').text('Change Image');
        });


        //delete image form media uploader
        $(document).on('click','#media_library_image_delete_btn',function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Vous ne seriez pas en mesure de revenir sur cette action !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/media-upload/delete",
                        data: {
                            _token: "{{ csrf_token() }}",
                            img_id : $('#media_library_image_delete_btn').attr('data-id')
                        },
                        success: function (data) {
                            $('.media-uploader-image-info a,.media-uploader-image-info .img-meta').hide();
                            $('.media-uploader-image-list li.selected').remove();
                            $('.media-uploader-image-info .img-wrapper img').attr('src','');
                            $('.media-uploader-image-info .img-info .img-title').text('');
                        },
                        error: function (error) {

                        }
                    });
                }
            });

        });


        $(document).on('click','.media-upload-btn-wrapper .img-wrap .rmv-span',function (e) {
            //imlement remove image icon
            var el = $(this);
            el.parent().parent().find('input[type="hidden"]').val('');
            el.parent().parent().find('.attachment-preview').html('');
            el.parent().parent().find('.media_upload_form_btn2').attr('data-imgid','');
            el.hide();
        })

        $(document).on('click','.media_upload_form_btn2',function (e) {
            e.preventDefault();
 
 $('#media_upload_modal2').modal("show");
            var parent = $('#media_upload_modal2');
            var el = $(this);
            var imageId = el.prev('input').val();
            mainUploadBtn = el;
            var loadAllImage = $('#load_all_media_images');

            parent.find('.media_upload_modal_submit_btn').text(el.data('btntitle'));
            parent.find('.modal-title').text(el.data('modaltitle'));

            if(el.data('mulitple')){
                parent.attr('data-mulitple','true')
            }else{
                parent.removeAttr('data-mulitple');
            }
            loadAllImage.attr('data-selectedimage','');
            if(imageId =! ''){
                loadAllImage.attr('data-selectedimage',el.prev('input').val());
                loadAllImage.trigger('click');
            }
        });

        $('body').on('click', '.media-uploader-image-list > li', function (e) {
            e.preventDefault();
            var el = $(this);
            var allData = el.data();

            if( typeof $('#media_upload_modal2').attr('data-mulitple') == 'undefined'){
                el.toggleClass('selected').siblings().removeClass('selected');
            }else{
                el.toggleClass('selected');
            }

            $('.media-uploader-image-info a,.media-uploader-image-info .img-meta,.delete_image_form').show();

            var parent = $('.img-meta');
            parent.children('.date').text(allData.date);
            parent.children('.dimension').text(allData.dimension);
            parent.children('.size').text(allData.size);
            parent.children('.imgsrc').text(allData.imgsrc);
            parent.children('.image_id').text(allData.imgid);
            parent.find('input[name="img_alt_tag"]').val(allData.alt);
            parent.parent().find('input[name="img_id"]').val(allData.imgid);

            $('#media_library_image_delete_btn').attr('data-id',allData.imgid);

            $('.img_alt_submit_btn').html('<i class="fa fa-check"></i>');
            $('.img-info .img-title').text(allData.title)
            $('.media-uploader-image-info .img-wrapper img').attr('src',allData.imgsrc);
        });

        Dropzone.options.placeholderfForm = {
            dictDefaultMessage: "Drag or Select Your Image",
            maxFiles: 50,
            maxFilesize: 10, //MB
            acceptedFiles: 'image/*',
            success: function (file, response) {
                if (file.previewElement) {
                    return file.previewElement.classList.add("dz-success");
                }
                $('#load_all_media_images').trigger('click');
                $('.media-uploader-image-list li:first-child').addClass('selected');
            },
            error: function (file, message) {
                if (file.previewElement) {
                    file.previewElement.classList.add("dz-error");
                    if ((typeof message !== "String") && message.error) {
                        message = message.error;
                    }
                    for (let node of file.previewElement.querySelectorAll("[data-dz-errormessage]")) {
                        node.textContent = message.errors.file[0];
                    }
                }
            }
        };


        $(document).on('click', '#upload_media_image', function (e) {
            e.preventDefault();
            $('.media_upload_modal_submit_btn').hide();
        });


        $(document).on('click', '#load_all_media_images', function (e) {
            e.preventDefault();
            loadAllImages();
        });
        $(document).on('click', '.img_alt_submit_btn', function (e) {
            e.preventDefault();
            //admin.upload.media.file.alt.change
            var parent = $(this).parent().parent().parent();
            var alt = $(this).prev('input').val();
            var imgId = parent.find('.image_id').text();

            $.ajax({
                type: "POST",
                url: "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/media-upload/alt",
                data: {
                    _token: "{{ csrf_token() }}",
                    imgid: parseInt(imgId),
                    alt: alt
                },
                success: function (data) {
                    $('.img_alt_submit_btn').html('<i class="fa fa-check-circle"></i>');
                    $('.media-uploader-image-list li[data-imgid="'+imgId+'"]').data('alt',alt);
                }
            });
        });

        function loadAllImages() {
            
            var selectedImage = $('#load_all_media_images').attr('data-selectedimage');
            $.ajax({
                type: "POST",
                url: "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/media-upload/all",
                data: {
                    _token: "{{ csrf_token() }}",
                    'selected' : selectedImage
                },
                success: function (data) {
                    $('.media-uploader-image-list').html('');
                    $.each(data,function (index,value) {
 
                        $('.media-uploader-image-list').append('<li data-date="'+value.upload_at+'" data-imgid="'+value.image_id+'" data-imgsrc="'+value.img_url+'" data-size="'+value.size+'" data-dimension="'+value.dimensions+'" data-title="'+value.title+'" data-alt="'+value.alt+'">\n' +
                            '<div class="attachment-preview">\n' +
                            '<div class="thumbnail">\n' +
                            '<div class="centered">\n' +
                            '<img src="'+value.img_url+'" alt="">\n' +
                            '</div>\n' +
                            '</div>\n' +
                            '</div>\n' +
                            '</li>');

                    });
                    hidePreloader();
                    $('.media_upload_modal_submit_btn').show();
                    selectOldImage();
                    $('#loadmorewrap button').show();
                },
                error: function (error) {

                }
            });
        }


        /**
         * hide preloader
         * @since  2.2
         * */
        function hidePreloader() {
            $('.image-preloader-wrapper').hide(300);
        }

        /**
         * Select preveiously selected image
         * @since  2.2
         * */
        function selectOldImage(){
            var imageId = mainUploadBtn.prev('input').val();
            var matches = imageId.match(/([|])/g);
            if(matches != null){
                var imgArr = imageId.split('|');
                var filtered = imgArr.filter(function (el) {
                    return el != "";
                });
                $.each(filtered,function(index,value){
                    $('.media-uploader-image-list li[data-imgid="'+value+'"]').trigger('click');
                });
            }else{
                $('.media-uploader-image-list li[data-imgid="'+imageId+'"]').trigger('click').siblings().removeClass('selected');
            }

        }

        /* loadmore image  */
            $(document).on('click','#loadmorewrap',function (){
                var mediaImageWrapper = $('#media_library');
                var skipp = mediaImageWrapper.find('ul.media-uploader-image-list li').length - 1;
                $('#loadmorewrap button').append(' <i class="fa fa-spinner fa-spin"></i>');
                $.ajax({
                    type: "POST",
                    url: "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/media-upload/loadmore",
                    data: {
                        _token: "{{ csrf_token() }}",
                        'skip' : skipp
                    },
                    success: function (data) {
                        $.each(data,function (index,value) {
                            mediaImageWrapper.find('.media-uploader-image-list').append('<li data-date="'+value.upload_at+'" data-imgid="'+value.image_id+'" data-imgsrc="'+value.img_url+'" data-size="'+value.size+'" data-dimension="'+value.dimensions+'" data-title="'+value.title+'" data-alt="'+value.alt+'">\n' +
                                '<div class="attachment-preview">\n' +
                                '<div class="thumbnail">\n' +
                                '<div class="centered">\n' +
                                '<img src="'+value.img_url+'" alt="">\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '</li>');
                        });
                        if(data == ''){
                            $('#loadmorewrap button').hide();
                        }
                        $('#loadmorewrap button i').remove();
                    },
                    error: function (error) {

                    }
                });
            });
        });
    })();
</script>

<script>
    (function ($) {
        "use strict"
        $(document).ready(function () {
            $(document).on('click', '.add_more_info_btn',function () {
                $(this).closest('.additional_info').append(`<div class="additional_info_repeater">
					<div class="form-row">
						<div class="col">
							<input type="text" name="info_title[]" class="form-control" placeholder="Info Title" >
						</div>
						<div class="col">
							<input type="text" name="info_text[]" class="form-control" placeholder="Info Text" >
						</div>
						<div class="col-auto">
							<button type="button" class="btn btn-sm btn-success add_more_info_btn"> + </button>
							<button type="button" class="btn btn-sm btn-danger remove_this_info_btn"  > - </button>
						</div>
					</div>
				</div>
				`);
            });

            $(document).on('click', '.remove_this_info_btn',function () {
                $(this).closest('.additional_info_repeater').remove();
            });
        });
    })(jQuery);
</script>

<script src="{{ url('/') }}/public/assets/backend/js/jquery.nice-select.min.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/summernote-bs4.js"></script>

<script>
    (function($){
    "use strict";
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 200,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            callbacks: {
                onChange: function(contents, $editable) {
                    $(this).prev('input').val(contents);
                }
            }
        });
        if($('.summernote').length > 1){
            $('.summernote').each(function(index,value){
                $(this).summernote('code', $(this).data('content'));
            });
        }
    });
            
    })(jQuery);        
</script>


<script>
    (function ($) {
        "use strict"
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 500,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            $('#attributes_options').on('change', function () {
                let title = $('#attributes_options').find(':selected').text();
                let title_id = $('#attributes_options').val();
                let terms = $('#attributes_options').find(':selected').data('terms');
                let options = '';

                terms.forEach(e => {
                    options += `<option value="${e}">${e}</option>`;
                });

                let html =  `<div class="form-group">
                               <label>${title}</label>
                               <select class="form-control" data-attr-id="${title_id}" data-attr-name="${title}" multiple>
                                   ${options}
                               </select>
                               <small class="text-secondary">Double click on an option to add</small>
                            </div>`;

                $('#attribute_container').html(html);
            });

            if ($('.nice-select').length) {
                $('.nice-select').niceSelect();
            }

            $('#title').on('keyup', function () {
                let title_text = $(this).val();
                $('#slug').val(convertToSlug(title_text))
            });

            $(document).on('click', '.remove_attribute', function () {
                $(this).closest('.row').remove();
                if ($('#attribute_price_container .row').length < 1) {
                    $('#attribute_price_container').hide();
                }
            });

            $(document).on('dblclick', '#attribute_container select option', function (e) {
                let attribute_title = $(e.target).parent().data('attrName');
                let attribute_id = $(e.target).parent().data('attrId');
                let selected_attribute_value = e.target.value;

                $('#attribute_price_container').append(
                    `<div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Attribut</label>
                                <input type="hidden" name="attribute_id[]" value="${attribute_id}" />
                                <input type="hidden" name="attribute_selected[]" value="${selected_attribute_value}" />
                                <input type="hidden" name="attribute_name[]" value="${attribute_title}" />
                                <input type="text" class="form-control font-weight-bold" value="${attribute_title}: ${selected_attribute_value}" disabled="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Additional price amount</label>
                                <input type="number" class="form-control" name="attr_additional_price[]" value="0">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
        <label for="attribute_image[]">Attribute Image</label>
                <div class="media-upload-btn-wrapper">
            <div class="img-wrap">
                                            </div>
            <br>
            <input type="hidden" name="attribute_image[]" value="">
            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-imgid="" data-toggle="modal" data-target="#media_upload_modal2">
                Upload Image
            </button>
        </div>
        <small>Recommended image size is  1280x1280</small>
            </div>

                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-danger margin-top-30 remove_attribute">-</button>
                        </div>
                    </div>`);
 
                if ($('#attribute_price_container .row').length > 0) {
                    $('#attribute_price_container').show();
                }
            });

            function convertToSlug(slug) {
                let finalSlug = slug.replace(/[^a-zA-Z0-9]/g, ' ');
                //remove multiple space to single
                finalSlug = slug.replace(/  +/g, ' ');
                // remove all white spaces single or multiple spaces
                finalSlug = slug.replace(/\s/g, '-').toLowerCase().replace(/[^\w-]+/g, '-');
                return finalSlug;
            }

            let all_tags = ["T-Shirt","Healty","comfortable","yellow","frock","kameez","denim","shirt","winter","men","mens"];

            let bindTagList = function () {
                // Call TagsInput on the input, and set the typeahead source to our data
                $('#tags').tagsinput({
                    typeahead: {
                        source: all_tags
                    }
                });

                $('#tags').on('itemAdded', function (event) {
                    // Hide the suggestions menu
                    $('.typeahead.dropdown-menu').css('display', 'none')
                    // Clear the typed text after a tag is added
                    $('.bootstrap-tagsinput > input').val("");
                });
            }

            bindTagList();

            /** 
             * ----- Tags input -----
             */
            let blogTagInput = $('#blog_tag_list .tags_filed');
            let oldTag = '';
            blogTagInput.tagsinput();
            //For Tags
            $(document).on('keyup', '#blog_tag_list .bootstrap-tagsinput input[type="text"]', function (e) {
                e.preventDefault();
                let el = $(this);
                let inputValue = $(this).val();
                $.ajax({
                    type: 'get',
                    url: "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/products/tags/get-tags",
                    async: false,
                    data: {
                        tag_query: inputValue
                    },
                    success: function (data) {
                        oldTag = inputValue;
                        let html = '';
                        let showAutocomplete = '';

                        $('#show-autocomplete').html('<ul class="autocomplete-warp"></ul>');

                        if (el.val() != '' && data.markup != '') {
                            data.result.map(function (tag, key) {
                                html += '<li class="tag_option" data-id="' + tag.id + '"  data-val="' + tag.tag + '">' + tag.tag + '</li>'
                            });

                            $('#show-autocomplete ul').html(html);
                            $('#show-autocomplete').show();
                        } else {
                            $('#show-autocomplete').hide();
                            oldTag = '';
                        }
                    },
                    error: function (res) {
                        err_msg = 'error';
                    }
                });
            });

            $(document).on('click', '.tag_option', function (e) {
                e.preventDefault();

                let id = $(this).data('id');
                let tag = $(this).data('val');
                blogTagInput.tagsinput('add', tag);
                $(this).parent().remove();
                blogTagInput.tagsinput('remove', oldTag);
            });

        });
    })(jQuery)
</script>
<script src="{{ url('/') }}/public/assets/backend/js/plugins.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/scripts.js"></script>
<script src="{{ url('/') }}/public/assets/common/js/flatpickr.js"></script>
<script>
    (function ($){
        "use strict";

        $('#reload').on('click', function(){
            location.reload();
        })

        $(document).on('click','.swal_delete_button',function(e){
          e.preventDefault();
            Swal.fire({
              title: 'Are you sure?',
              text: 'You would not be able to revert this item!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "Yes, delete it!"
            }).then((result) => {
              if (result.isConfirmed) {
                $(this).next().find('.swal_form_submit_btn').trigger('click');
              }
            });
        });

        $('input[name=countdown_time]').flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "F j, Y H:i",
        });

    })(jQuery);
</script>
@endsection
