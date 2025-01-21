@extends($AdminTheme)
@section('title','Gestion des Codes Coupons')
@section('content-header')
@php
  
@endphp

 <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        padding: 0 !important;
    }
    div.dataTables_wrapper div.dataTables_length select {
        width: 60px;
        display: inline-block;
    }
    table.dataTable{
        width: 100% !important;
    }
     .content-wrapper{
         height: 100%;
        display: table;
        width: 100%;
        padding-bottom: 50px;
     }
     tbody tr td{
         text-align: center;
     }
.d-none {
    display: none!important;
}
    .select-box-wrap select {
        height: 40px;
        border: none;
        position: relative;
        top: 2px;
        width: 150px;
        border: 1px solid #e2e2e2;
    }
.content-wrapper {
    width: 88% !important;
}    
</style>    
 
<link rel="stylesheet" href="{{ asset('/AdminTheme/xx/nice-select.css')}}">
    <style>
        #form_category, #edit_#form_category,
        #form_subcategory, #edit_#form_subcategory,
        #form_products, #edit_#form_products {
            display: none;
        }

        .lds-ellipsis {
            position: fixed;
            width: 80px;
            height: 80px;
            left: 50vw;
            top: 40vh;
            z-index: 50;
            display: none;
        }
        .lds-ellipsis div {
            position: absolute;
            top: 33px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }
        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }
        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0);
            }
        }
        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(24px, 0);
            }
        }
    </style>
 
<h1>Gestionnaire de Codes et Coupons</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}} Accueil</a></li>
  <li class="active">Gestion des Code Coupons</li>
</ol>
@endsection
@section('content')
 <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
             
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Tous les codes coupons')}}</h4>
                        @can('product-coupon-delete')
                        <x-bulk-action.dropdown />
                        @endcan
                          <div class="table-wrap table-responsive">
                                <table class="table table-default">
                                    <thead>
                                        <th class="no-sort">
                                            <div class="mark-all-checkbox">
                                                <input type="checkbox" class="all-checkbox">
                                            </div>                              
                                        </th>                                     
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Code')}}</th>
                                        <th>{{__('Remise')}}</th>
                                        <th>{{__('Date d\'expiration')}}</th>
                                        <th>{{__('Statut')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($all_product_coupon as $data)
                                        <tr>
                                            <td>
                                                <div class="bulk-checkbox-wrapper">
                                                    <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{ $data->id }}">
                                                </div>
                                            </td>
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->code}}</td>
                                            <td>@if($data->discount_type == 'percentage') {{$data->discount}}% @else {{amount_with_currency_symbol($data->discount)}} @endif</td>
                                            <td>{{ date('d M Y', strtotime($data->expire_date)) }}</td>
                                            <td>
                                                <?php if($data->status=="publish"){ ?>
                                                    <span class="alert btn-sm alert-success" style="padding: 5px 30px;">Publié</span>
                                                <?php
                                                   }else if($data->status=="used"){
                                                ?>
                                                <span class="alert alert-warning" style="padding: 5px 30px;">Utilisé</span>
                                                <?php }else{?>
                                                    <span class="alert alert-danger" style="padding: 5px 30px;">Désactivé</span>
                                                <?php
                                                   }
                                                ?>
                                            </td>
                                            <td>
                                               <?php /*?> @ can('product-coupon-delete')
                                                <x-delete-popover :url="route('admin.products.coupon.delete', $data->id)"/>
                                                @endcan<?php */?>
                                                
                                                <a href="#" tabindex="0" class="btn-danger btn-sm mb-3 mr-1 swal_delete_button">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                                <form method='post' action='{{ route("coupon.delete") }}' class="d-none">
                                                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <br>
                                                    <button type="submit" class="swal_form_submit_btn d-none"></button>
                                                </form>
                                                &nbsp;
                                                <a href="#"
                                                   data-toggle="modal"
                                                   data-target="#category_edit_modal"
                                                   class="btn-primary btn-sm mb-3 mr-1 category_edit_btn"
                                                   data-id="{{$data->id}}"
                                                   data-title="{{$data->title}}"
                                                   data-code="{{$data->code}}"
                                                   data-discount_on="{{$data->discount_on}}"
                                                   data-discount_on_details="{{$data->discount_on_details}}"
                                                   data-discount="{{$data->discount}}"
                                                   data-discount_type="{{$data->discount_type}}"
                                                   data-expire_date="{{$data->expire_date}}"
                                                   data-status="{{$data->status}}">
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
                        <h4 class="header-title">{{__('Ajouter nouveau Code Coupon')}}</h4>
                        <form action="{{route('coupon.new')}}" method="post" enctype="multipart/form-data" style="padding-right: 25px">
                             <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="title">{{__('Titre du Coupon')}}</label>
                                <input type="text" class="form-control"  id="title" name="title" placeholder="{{__('Titre du Coupon')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="code">{{__('Code Coupon')}}</label>
                                <input type="text" class="form-control"  id="code" name="code" placeholder="{{__('Code Coupon')}}" required>
                                <span id="status_text" class="text-danger" style="display: none"></span>
                            </div>
                            <div class="form-group">
                                <label for="discount_on">{{__('Remise sur')}}</label>
                                <select name="discount_on" id="discount_on" class="form-control">
                                    <option value="">{{ __('Choisir une option') }}</option>
                                    @foreach ($coupon_apply_options as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="form_category">
                                <label for="category">{{__('Catégorie')}}</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">{{ __('Choisir une catégorie') }}</option>
                                    @foreach ($all_categories as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group" id="form_products">
                                <label for="products">{{__('Evènements')}}</label>
                                <select name="products[]" id="products" class="form-control nice-select wide" multiple>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="discount">{{__('Remise')}}</label>
                                <input type="number" class="form-control"  id="discount" name="discount" placeholder="{{__('Remise')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="discount_type">{{__('Coupon Type')}}</label>
                                <select name="discount_type" class="form-control" id="discount_type" required>
                                    <option value="percentage">{{__("Percentage")}}</option>
                                    <option value="amount">{{__("Montant forfaitaire")}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="expire_date">{{__('Date d\'Expire')}}</label>
                                <input type="date" class="form-control flatpickr"  id="expire_date" name="expire_date" placeholder="{{__('Date d\'Expire')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="status">{{__('Statut')}}</label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="publish">{{__("Publier")}}</option>
                                    <option value="draft">{{__("Brouillon")}}</option>
                                </select>
                            </div>
                            <button type="submit" id="coupon_create_btn" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Ajouter Nouveau Coupon')}}</button>
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
                    <h5 class="modal-title">{{__('Mettre à jour un Coupon')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('coupon.update')}}"  method="post">
                    <input type="hidden" name="id" id="coupon_id">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="title">{{__('Titre du coupon')}}</label>
                            <input type="text" class="form-control"  id="edit_title" name="title" placeholder="{{__('Titre du coupon')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_code">{{__('Code Coupon')}}</label>
                            <input type="text" class="form-control"  id="edit_code" name="code" placeholder="{{__('Code Coupon')}}">
                            <span id="status_text" class="text-danger" style="display: none"></span>
                        </div>
                        <div class="form-group">
                            <label for="discount_on">{{__('Remise sur')}}</label>
                            <select name="discount_on" id="edit_discount_on" class="form-control">
                                <option value="">{{ __('Choisir une option') }}</option>
                                @foreach ($coupon_apply_options as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="edit_form_category">
                            <label for="category">{{__('Category')}}</label>  
                                <select name="category" id="edit_category" class="form-control">
                                <option value="">{{ __('Choisir une catégorie') }}</option>
                                @foreach ($all_categories as $key => $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                         
                        <div class="form-group" id="edit_form_products">
                            <label for="products">{{__('Evènements')}}</label>
                            <select name="products[]" id="products" class="form-control nice-select wide" multiple>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_discount">{{__('Remise')}}</label>
                            <input type="number" class="form-control"  id="edit_discount" name="discount" placeholder="{{__('Remise')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_discount_type">{{__('Type de Coupon')}}</label>
                            <select name="discount_type" class="form-control" id="edit_discount_type">
                                <option value="percentage">{{__("Pourcentage")}}</option>
                                <option value="amount">{{__("Montant forfaitaire")}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_expire_date">{{__('Date d\'Expire')}}</label>
                            <input type="date" class="form-control flatpickr"  id="edit_expire_date" name="expire_date" placeholder="{{__('Date d\'Expire')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Statut')}}</label>
                            <select name="status" class="form-control" id="edit_status">
                                <option value="draft">{{__("Brouillon")}}</option>
                                <option value="publish">{{__("Publier")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Fermer')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Sauvegarder')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
@endsection

@section('page-level-script')
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
                title: "Voulez-vous supprimer cet élément ?",
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
                    'url': "http://localhost/zaika/admin-home/products/coupons/bulk-action",
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
        
                
    $(document).on('click','.swal_delete_button',function(e){
      e.preventDefault();
        Swal.fire({
          title: 'Êtes-vous sûr?',
          text: 'Vous ne pourrez pas annuler cette action!',
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

</script>
    <script src="{{ asset('/AdminTheme/xx/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('/AdminTheme/xx/flatpickr.js')}}"></script>
    <script src="{{ asset('/AdminTheme/xx/sweetalert2.js')}}"></script>

  
    <script>
        $(document).ready(function () {
             

            $(document).on('click','.category_edit_btn',function() {
                let el = $(this);
                let id = el.data('id');
                let status = el.data('status');
                let modal = $('#category_edit_modal');
                let discount_on = el.data('discount_on');
                let discount_on_details = el.data('discount_on_details');

                modal.find('#coupon_id').val(id);
                modal.find('#edit_status option[value="'+status+'"]').attr('selected',true);
                modal.find('#edit_code').val(el.data('code'));
                modal.find('#edit_discount').val(el.data('discount'));
                modal.find('#edit_discount_type').val(el.data('discount_type'));
                modal.find('#edit_expire_date').val(el.data('expire_date'));
                modal.find('#edit_discount_type[value="'+el.data('discount_type')+'"]').attr('selected',true);
                modal.find('#edit_title').val(el.data('title'));
                modal.find('#edit_discount_on').val(el.data('discount_on'));

                $('#edit_form_category').hide();
                $('#edit_form_subcategory').hide();
                $('#edit_form_products').hide();

                if (discount_on == 'product') {
                    $('#edit_form_products').hide();
                    loadProductDiscountHtml($('#edit_discount_on'), '#edit_form_products select', true, discount_on_details);
                } else {
                    if (discount_on_details != '') {
                        $('#edit_form_'+discount_on+' option[value='+discount_on_details+']').attr('selected', true);
                        $('#edit_form_' + discount_on).show();
                    }
                }

                flatpickr(".flatpickr", {
                    altInput: true,
                    altFormat: "F j, Y",
                    dateFormat: "Y-m-d",
                });
            }); // category_edit_btn function end

            $('#code').on('keyup', function() {
                validateCoupon(this);
            });

            $('#edit_code').on('keyup', function() {
                validateCoupon(this);
            });

            $('#discount_on').on('change', function () { 
                loadProductDiscountHtml(this, '#form_products select', false, []);
            });

            $('#edit_discount_on').on('change', function () {
                loadProductDiscountHtml(this, '#edit_form_products select', true, []);
            });
        });

        function loadProductDiscountHtml(context, target_selector, is_edit, values) {
            let product_select = $(target_selector);

            let selector_prefix = '';
            if (is_edit) {
                selector_prefix = 'edit_';
            }

            $('#'+selector_prefix+'form_category').hide();
            $('#'+selector_prefix+'form_subcategory').hide();
            $('#'+selector_prefix+'form_products').hide();

            if ($(context).val() == 'category') {
                $('#'+selector_prefix+'form_category').show(500);
            } else if ($(context).val() == 'subcategory') {
                $('#'+selector_prefix+'form_subcategory').show(500);
            } else if ($(context).val() == 'product') {
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
            }
        }

        function validateCoupon(context) {
            let code = $(context).val();
            let submit_btn = $(context).closest('form').find('button[type=submit]');
            let status_text = $(context).siblings('#status_text');
            status_text.hide();

            if (code.length) {
                submit_btn.prop("disabled", true);

                $.get("{{ route('coupon.check') }}", {code: code}).then(function (data) {
                    if (data>=1) {
                        let msg = "{{ __('Ce coupon est déjà pris') }}";
                        status_text.removeClass('text-success').addClass('text-danger').text(msg).show();
                        submit_btn.prop("disabled", true);
                    } else {
                        let msg = "{{ __('Ce coupon est disponible') }}";
                        status_text.removeClass('text-danger').addClass('text-success').text(msg).show();
                        submit_btn.prop("disabled", false);
                    }
                });
            }
        }
    </script>
@endsection
