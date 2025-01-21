@extends($AdminTheme)
@section('title')
    {{__('Catégories de Produits')}}
@endsection

@section('content-header')
    <h1>Catégories de produits</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">Catégories de produits</li>
    </ol>
@endsection

@section('style')
    <x-media.css />
    <x-datatable.css />
    <x-bulk-action.css />
@endsection
@section('content')

    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40">
                    <x-msg.error />
                    <x-msg.flash />
                </div>
            </div>
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Toutes les catégories produits')}}</h4>
                         
                        <div class="bulk-delete-wrapper my-3">
							<div class="select-box-wrap">
								<select name="bulk_option" id="bulk_option">
									<option value="">Action groupée</option>
									<option value="delete">Supprimer</option>
								</select>
								<button class="btn btn-primary btn-sm" id="bulk_delete_btn">Appliquer</button>
							</div>
						</div>
                        
                        <div class="table-wrap table-responsive">
                            <table class="table table-default">
                                <thead>
                                    <th class="no-sort sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 33.9688px;">
										<div class="mark-all-checkbox">
											<input type="checkbox" class="all-checkbox">
										</div>
									</th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Nom de la catégorie')}}</th>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Statut')}}</th>
                                    <th>{{__('Action')}}</th>
                                </thead>
                                <tbody>
                                    @foreach($all_category as $category)
                                    <tr>
										<td>
											<div class="bulk-checkbox-wrapper">
												<input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$category->id}}">
											</div>
										</td>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$category->title}}</td>
                                        <td>
                                            <div class="img-wrap">
                                                <?php
                                                    $event_img = get_attachment_image_by_id($category->image, 'thumbnail', true);
                                                    $img_url = $event_img['img_url'];
                                                 
													if (!empty($event_img)){
														 echo render_attachment_preview_for_admin($category->image);
													}
												?>
                                            </div>
                                        </td>
                                        <td><?php if($category->status=='publish'){ echo'<span class="alert alert-success">Publié</span>'; }
											else{ echo'<span class="alert alert-warning">Brouillon</span>'; } ?>
                                        </td>
                                        <td>
                                            
											
											<a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1 swal_delete_button"><i class="fa fa-trash" aria-hidden="true"></i></a>
											<form method="post" action="{{ route('admin.products.category.delete', $category->id) }}" class="d-none">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<br>
												<button type="submit" class="swal_form_submit_btn d-none"></button>
											</form>
											
                                            <a href="#"
                                                data-toggle="modal"
                                                data-target="#category_edit_modal"
                                                class="btn btn-primary btn-xs mb-3 mr-1 category_edit_btn"
                                                data-id="{{$category->id}}"
                                                data-name="{{$category->title}}"
                                                data-status="{{$category->status}}"
                                                data-imageid="{{$category->image}}"
                                                data-image="{{$img_url}}"
                                            >
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                             
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Ajouter une nouvelle catégorie')}}</h4>
                        <form class="addCategory" action="{{route('admin.products.category.new')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="name">{{__('Nom de la catégorie')}}</label>
                                <input type="text" class="form-control"  id="name" name="title" placeholder="{{__('Nom de la catégorie')}}">
                            </div>
                            <x-media-upload :title="__('Image')" :name="'image'" :dimentions="'200x200'"/>
							
							<div class="form-group">
								<label for="image">Image</label>
								 <div class="media-upload-btn-wrapper">
									<div class="img-wrap"> </div>
									<br>
									<input type="hidden" name="image" value="">
									<button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Télécharger une image" data-imgid="" data-toggle="modal" data-target="#media_upload_modal">
										Télécharger une image
									</button>
								</div>
								<small>La taille d'image recommandée est 200x200</small>
							</div>
							
                            <div class="form-group">
                                <label for="status">{{__('Statut')}}</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="publish">{{__("Publié")}}</option>
                                    <option value="draft">{{__("Brouillon")}}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Ajouter nouveau')}}</button>
                        </form>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
     
    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Mettre à jour la catégorie')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.products.category.update')}}"  method="post">
                    <input type="hidden" name="id" id="category_id">
                    <div class="modal-body">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="edit_name">{{__('Nom de la catégorie')}}</label>
                            <input type="text" class="form-control"  id="edit_name" name="title" placeholder="{{__('Nom de la catégorie')}}">
                        </div>
                        <x-media-upload :title="__('Image')" :name="'image'" :dimentions="'200x200'"/>
                        <div class="form-group">
                            <label for="edit_status">{{__('Statut')}}</label>
                            <select name="status" class="form-control" id="edit_status">
                                <option value="draft">{{__("Brouillon")}}</option>
                                <option value="publish">{{__("Publié")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Fermer')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Sauvegarder Changements')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="media_upload_modal" tabindex="-1" role="dialog" style="padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Media Uploads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="upload_media_image" data-toggle="tab" href="#upload_files" role="tab" aria-selected="true">Upload Files</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  data-toggle="tab" href="#media_library" role="tab" id="load_all_media_images" aria-controls="media_library" aria-selected="false">Media Library</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="upload_files" role="tabpanel" >
                        <div class="dropzone-form-wrapper">
                            <form action="{{url('/')}}/media-upload" method="post" id="placeholderfForm" class="dropzone" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
							</form>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="media_library" role="tabpanel" >
                        <div class="all-uploaded-images">

                            <div class="main-content-area-wrap">
                                <div class="image-preloader-wrapper">
                                    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div>
                               <div class="image-list-wr5apper">
                                   <ul class="media-uploader-image-list"> </ul>
                                   <div id="loadmorewrap"><button type="button">LoadMore</button></div>
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
                                        <a tabindex="0" style="display: none" class=" btn btn-lg btn-danger btn-sm mb-3 mr-1" id="media_library_image_delete_btn" >
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
                <button type="button" class="btn btn-primary media_upload_modal_submit_btn" style="display: none">Sélectionner l'image</button>
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

<!-- Start datatable js -->
<script src="{{ url('/') }}/public/assets/backend/js/jquery.dataTables.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/dataTables.responsive.min.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/responsive.bootstrap.min.js"></script>
<script>
     (function($){
        "use strict";

        $(document).ready(function() {
            $('.table-wrap > table').DataTable( {
                "order": [[ 1, "desc" ]],
                'columnDefs' : [{
                    'targets' : 'no-sort',
                    "orderable" : false
                }]
            } );
        } );

    })(jQuery)
</script>
<script src="{{ url('/') }}/public/assets/backend/js/dropzone.js"></script>

<script>
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
            $('#media_upload_modal').modal('hide');
            $('.media_upload_form_btn').text('Change Image');
        });


        //delete image form media uploader
        $(document).on('click','#media_library_image_delete_btn',function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You would not be able to revert this item!',
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
            el.parent().parent().find('.media_upload_form_btn').attr('data-imgid','');
            el.hide();
        })

        $(document).on('click','.media_upload_form_btn',function (e) {
            e.preventDefault();

            var parent = $('#media_upload_modal');
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

            if( typeof $('#media_upload_modal').attr('data-mulitple') == 'undefined'){
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
        $('.swal-delete').on('click', function () {
            Swal.fire({
                title: "Voulez-vous supprimer cet élément ?",
                showCancelButton: true,
                confirmButtonText: 'Supprimer',
                confirmButtonColor: '#dd3333',
                }).then((result) => {
                if (result.isConfirmed) {
                    let route = $(this).data('route');
                    $.post(route, {_token: '{{ csrf_token() }}'}).then(function (data) {
                        if (data) {
                            Swal.fire('Supprimé!', '', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    });
                }
            });
        });
    });
})(jQuery)
</script>
<script>
(function($) {
    $(document).ready(function() {
        $(document).on('click', '#bulk_delete_btn', function(e) {
            e.preventDefault();

            var bulkOption = $('#bulk_option').val();
            var allCheckbox = $('.bulk-checkbox:checked');
            var allIds = [];
            allCheckbox.each(function(index, value) {
                allIds.push($(this).val());
            });
            if (allIds != '' && bulkOption == 'delete') {
                $(this).text('Suppression en cours...');
                $.ajax({
                    'type': "POST",
                    'url': "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/products/categories/bulk-action",
                    'data': {
                        _token: "{{ csrf_token() }}",
                        ids: allIds,
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        });

        $('.all-checkbox').on('change', function(e) {
            e.preventDefault();
            var value = $('.all-checkbox').is(':checked');
            var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
            //have write code here fr
            if (value == true) {
                allChek.prop('checked', true);
            } else {
                allChek.prop('checked', false);
            }
        });
    });
})(jQuery);
</script>	
	
	
<script src="{{ url('/') }}/public/assets/backend/js/plugins.js"></script>
<script src="{{ url('/') }}/public/assets/backend/js/scripts.js"></script>
<script src="{{ url('/') }}/public/assets/common/js/flatpickr.js"></script>


    @can('product-category-delete')
    <x-bulk-action.js :route="route('admin.products.category.bulk.action')" />
    @endcan

    <script>
        $(document).ready(function () {
            $(document).on('click','.category_edit_btn',function(){
                let el = $(this);
                let id = el.data('id');
                let name = el.data('name');
                let status = el.data('status');
                let modal = $('#category_edit_modal');

                modal.find('#category_id').val(id);
                modal.find('#edit_status option[value="'+status+'"]').attr('selected',true);
                modal.find('#edit_name').val(name);

                let image = el.data('image');
                let imageid = el.data('imageid');

                if (imageid != '') {
                    modal.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                    modal.find('.media-upload-btn-wrapper input').val(imageid);
                    modal.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }

            });
        });
    </script>

<script>
    (function ($){
        "use strict";

        $('#reload').on('click', function(){
            location.reload();
        })
        
        $(document).on('click','.swal_delete_button',function(e){ 
          e.preventDefault();
            Swal.fire({
              title: 'Es-tu sûr?',
              text: 'Vous ne seriez pas en mesure de revenir sur cette catégorie !',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "Oui, supprimez-le !"
            }).then((result) => {
              if (result.isConfirmed) {
                $(this).next().find('.swal_form_submit_btn').trigger('click');
              }
            });
        });

        $(document).on('click','.swal_change_language_button',function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Êtes-vous sûr de faire de cette langue la langue par défaut ?',
                text: 'Les langues seront à leur tour modifiées par défaut',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Oui, changez-le!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).next().find('.swal_form_submit_btn').trigger('click');
                }
            });
        });

        $(document).on('click','.swal_change_approve_payment_button',function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Êtes-vous sûr d\'approuver ce paiement ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Oui, acceptez-le !"
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
