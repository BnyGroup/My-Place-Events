@extends($AdminTheme)
@section('title')
    {{__('Gestion des Produits')}}
@endsection

@section('content-header')
    <h1>Tous les produits </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">Tous les produits</li>
    </ol>
@endsection

@section('style')
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Tous les Produits')}}</h4>
                        
                        <div class="text-right">
                            <a href="{{ route('admin.products.new') }}" class="btn btn-primary">{{ __('Ajouter un nouveau Produit') }}</a>
                        </div>
                         
                        <div class="bulk-delete-wrapper my-3">
							<div class="select-box-wrap">
								<select name="bulk_option" id="bulk_option">
									<option value="">Action groupée</option>
									<option value="delete">Supprimé</option>
								</select>
								<button class="btn btn-primary btn-sm" id="bulk_delete_btn">Appliquer</button>
							</div>
						</div>
						
                        <div class="table-wrap table-responsive">
                            <table class="table table-default">
                                <thead>
                                    <th class="no-sort sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 28.3438px;">
										<div class="mark-all-checkbox">
											<input type="checkbox" class="all-checkbox">
										</div>
									</th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Nom du produit')}}</th>
                                    <th>{{__('Catégorie')}}</th>
                                    <th>{{__('Prix')}}</th>
                                    <th>{{__('Statut')}}</th>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Action')}}</th>
                                </thead>
                                <tbody>
                                    @foreach($all_products as $product)
                                    <tr>
										<td>
											<div class="bulk-checkbox-wrapper">
												<input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$product->id}}">
											</div>
										</td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <h6>{{ html_entity_decode($product->title) }}</h6>
                                            @if(!empty($product->inventory))
                                                <small><strong>{{__('Stock')}}:</strong> {{optional($product->inventory)->stock_count}}</small>
                                                <small><strong>{{__('Sold')}}:</strong> {{optional($product->inventory)->sold_count}}</small>
                                            @endif
                                        </td>
                                        <td>{{ optional($product->category)->title }}</td>
                                        <td>{{ amount_with_currency_symbol($product->sale_price) }}</td>
                                        <td>
											<?php if($product->status=='publish'){ echo'<span class="alert alert-success">Publié</span>'; }
											else{ echo'<span class="alert alert-warning">Brouillon</span>'; } ?>
                                        </td>
										<td>
                                            <div class="img-wrap">
                                                <?php
                                                    $event_img = get_attachment_image_by_id($product->image, 'thumbnail', true);
                                                    $img_url = $event_img['img_url'];
                                                 
													if (!empty($event_img)){
														 echo render_attachment_preview_for_admin($product->image);
													}
												?>
                                            </div>
                                        </td>
                                        <td>
											
                                         <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1 swal_delete_button"><i class="fa fa-trash"></i></a>
										<form method="post" action="{{route('admin.products.delete', $product->id)}}" class="d-none">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<br>
											<button type="submit" class="swal_form_submit_btn d-none"></button>
										</form>
										<a class="btn btn-primary btn-xs mb-3 mr-1" href="{{ route('admin.products.edit', $product->id) }}"><i class="fa fa-pencil"></i></a>
											
										<form action="{{ route('admin.products.clone', $product->id) }}" method="post" style="display: inline-block">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">    
										<input type="hidden" name="item_id" value="{{$product->id}}">
										<button type="submit" title="clone this to new draft" class="btn btn-xs btn-secondary btn-sm mb-3 mr-1">
										<i class="fa fa-clone"></i>
										</button>
										</form>
											
										<?php /*?><a class="btn btn-info btn-xs mb-3 mr-1" href="{{route('frontend.products.single', $product->slug)}}" target="_blank"><i class="fa fa-eye"></i></a>	<?php */?>										
											
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
	$(document).ready(function () {
		$(document).on('click','.product_edit_btn',function(){
			let el = $(this);
			let id = el.data('id');
			let name = el.data('name');
			let modal = $('#product_edit_modal');

			modal.find('#product_id').val(id);
			modal.find('#edit_name').val(name);

			modal.show();
		});
	});
</script>


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
    <script>
(function ($) {
    "use strict"
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            Swal.fire({
                title: "Do you want to delete this item?",
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dd3333',
                }).then((result) => {
                if (result.isConfirmed) {
                    let route = $(this).data('route');
                    $.post(route, {_token: '{{ csrf_token() }}'}).then(function (data) {
                        if (data) {
                            Swal.fire('Deleted!', '', 'success');
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
                    'url': "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/products/deleted/bulk-action",
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
    
    <script>
        $(document).ready(function () {
            $('.swal-restore').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Voulez-vous restaurer cet élément ?",
                    showCancelButton: true,
                    confirmButtonText: 'Restaurer',
                    confirmButtonColor: '#43A047',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let route = $(this).data('route');
                        $.post(route, {_token: '{{ csrf_token() }}'}).then(function (data) {
                            if (data) {
                                Swal.fire('Restauré!', '', 'success');
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    }
                });
            });
        });
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
              text: 'Vous ne pourrez pas revenir sur cette action !',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "Oui, supprimez-le!"
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
