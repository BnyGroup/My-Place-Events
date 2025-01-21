@extends($AdminTheme)
@section('title')
    {{__('Tags de Produits')}}
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
                        <h4 class="header-title">{{__('Toutes les tags de produits')}}</h4>
                        <div class="bulk-delete-wrapper my-3">
							<div class="select-box-wrap">
								<select name="bulk_option" id="bulk_option">
									<option value="">Action groupée</option>
									<option value="delete">Supprimée</option>
								</select>
								<button class="btn btn-primary btn-sm" id="bulk_delete_btn">Appliquer</button>
							</div>
						</div>
                        <div class="table-wrap table-responsive">
                            <table class="table table-default">
                                <thead>
                                    <th class="no-sort sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 106.609px;">
										<div class="mark-all-checkbox">
											<input type="checkbox" class="all-checkbox">
										</div>
									</th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Nom du tags')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </thead>
                                <tbody>
                                    @foreach($all_tag as $tag)
                                    <tr>
										<td>
											<div class="bulk-checkbox-wrapper">
												<input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$tag->id}}">
											</div>
										</td>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$tag->tag_text}}</td>
                                        <td>
											 <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1 swal_delete_button">
												<i class="fa fa-trash" aria-hidden="true"></i>
											</a>
											<form method="post" action="{{ route('admin.products.tag.delete', $tag->id) }}" class="d-none">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<br>
												<button type="submit" class="swal_form_submit_btn d-none"></button>
											</form>
											 
                                            
                                            <a href="#"
                                                data-toggle="modal"
                                                data-target="#tag_edit_modal"
                                                class="btn btn-primary btn-xs mb-3 mr-1 tag_edit_btn"
                                                data-id="{{$tag->id}}"
                                                data-name="{{$tag->tag_text}}">
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
                        <h4 class="header-title">{{__('Ajouter un nouveau tag')}}</h4>
                        <form action="{{route('admin.products.tag.new')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="name">{{__('Nom du tag')}}</label>
                                <input type="text" class="form-control"  id="name" name="title" placeholder="{{__('Nom du tag')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Ajouter nouveau')}}</button>
                        </form>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
     
    <div class="modal fade" id="tag_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Mettre le Tag à jour')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.products.tag.update')}}"  method="post">
                    <input type="hidden" name="id" id="tag_id">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="edit_name">{{__('Nom du tag')}}</label>
                            <input type="text" class="form-control"  id="edit_name" name="title" placeholder="{{__('Name')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Fermer')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Enregistrer')}}</button>
                    </div>
                </form>
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
<script>
(function ($) {
    "use strict"
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            Swal.fire({
                title: "Voulez-vous supprimer cet élément ?",
                showCancelButton: true,
                confirmButtonText: 'Delete',
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
                $(this).text('Suppresion en cours...');
                $.ajax({
                    'type': "POST",
                    'url': "{{ url('/') }}/fr/ub7qfzTBzX8JXdr8V4kV7sq/products/tags/bulk-action",
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
		$(document).on('click','.tag_edit_btn',function(){
			let el = $(this);
			let id = el.data('id');
			let name = el.data('name');
			let modal = $('#tag_edit_modal');

			modal.find('#tag_id').val(id);
			modal.find('#edit_name').val(name);

			modal.show();
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
              title: 'Êtes-vous sûr?',
              text: 'Vous ne pourrez pas annuler cet action!',
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

   
    })(jQuery);
</script>

@endsection
