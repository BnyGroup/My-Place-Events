@extends($theme)
@section('meta_title',setMetaData()->bking_order_title.$bookingdata->order_id )
@section('meta_description',setMetaData()->bking_order_desc)
@section('meta_keywords',setMetaData()->bking_order_keyword)
@section('content')
<div class="container-fluid about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
				<h2 class="text-uppercase about-title">@lang('words.user_ord_page.ord_pg_tit') - #{{ $bookingdata->order_id }}</h2>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row page-main-contain">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<h2 class="order-titles">@lang('words.user_ord_page.ord_pg_for') <a href="{{ route('events.details',$bookingdata->event_slug) }}" target="_blank">{{ $bookingdata->event_name }}</a></h2>
						<p class="order-details">@lang('words.user_ord_page.ord_pg_ord') #{{ $bookingdata->order_id }} on {{ Carbon\Carbon::parse($bookingdata->upat)->format('F d, Y') }}
							<br>
						@php
							$startdate 	= Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('l, F j, Y');
							$enddate 	= Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('l, F j, Y');
							$starttime	= Carbon\Carbon::parse($bookingdata->event_start_datetime)->format('h:i A');
							$endtime	= Carbon\Carbon::parse($bookingdata->event_end_datetime)->format('h:i A');
						@endphp
						@if($startdate == $enddate)
							{{ $startdate }}
							{{ $starttime }} To {{ $endtime }}
						@else
							{{ $startdate }}, {{ $starttime }} To
							 {{ $enddate }}, {{ $endtime }}
						@endif
						</p>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<br>
						<div class="row">
							@if(! empty($refund))
								@if($refund->refund_status == 'Pending')
								<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
									<div class="alert alert-info">{{--Your refund request successfully submitted.--}}Votre demande de remboursement a été soumise avec succès.</div>
								</div>
								@elseif ($refund->refund_status == 'Reject')
								<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
									<div class="alert alert-danger">{{--Your refund request rejected.--}}Votre demande de remboursement rejetée.
										<br>
										<label>{{--Reason--}}Raison : </label>
										<p>{!! $refund->reject_note !!}</p>
									</div>
								</div>
								@else
								<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
									<div class="alert alert-success">{{--Your refund request accepted.--}}Votre demande de remboursement acceptée.</div>
								</div>
								@endif
							@endif
							<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" id="refund" style="display: none;">
								<div class="alert alert-info">{{--Your refund request successfully submitted.--}}Votre demande de remboursement a été soumise avec succès.</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-sm-12 col-xs-12 col-lg-3 order-boxes
					order-btn-books text-center"> 
					<div>
						<a class="pro-choose-file text-uppercase" href="{{ asset('/upload/ticket-pdf/'.$bookingdata->order_id.'-'.$bookingdata->event_id.'-'.$bookingdata->orderid.'.pdf') }}" target="_blank">@lang('words.user_ord_page.ord_pr_btn')</a> </div>
					<br/> 
					<div>
						<a class="pro-choose-file " data-toggle="modal" data-target="#myModal-contact" href="javaScript:void(0);">@lang('words.user_ord_page.ord_co_btn')</a>
					</div> 
					@php 
						$stdate = \Carbon\Carbon::parse($bookingdata->event_start_datetime); 
						$now =\Carbon\Carbon::now(); $testdate   = $now->diffInDays($stdate); 
					@endphp
					<div>
						<br>
						@if($bookingdata->refund_policy != 3 && $stdate > $now && $bookingdata->order_amount > 0)
							@if(empty($refund) && $testdate > refund($bookingdata->refund_policy)->day)
								<a href="javascript:void(0);" class="text-uppercase refund-request pro-choose-file" onClick="" data-order-id="{{ $bookingdata->order_id }}" data-event-id="{{ $bookingdata->event_id }}" data-user-id="{{ $bookingdata->event_create_by }}">Order Cancel & Refund</a>
							@endif
						@endif
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-lg-9 order-boxes col-md-9 order-details-box">
						@php 
							$tickets 	= unserialize($bookingdata->order_t_id);
							$ttitle		= unserialize($bookingdata->order_t_title);
							$tqty		= unserialize($bookingdata->order_t_qty);
							$tprice		= unserialize($bookingdata->order_t_price);
							$tfees		= unserialize($bookingdata->order_t_fees);
				 		@endphp
				 		<p class="tickets-pays">@lang('words.user_ord_page.ord_tik_tb')</p>
							<table class="table">
								<thead class="text-center">
									<th>@lang('words.user_ord_page.ord_tik_nm')</th>
									<th>@lang('words.user_ord_page.ord_tik_pr')</th>
									<th>@lang('words.user_ord_page.ord_tik_qt')</th>
									<th>@lang('words.user_ord_page.ord_tik_su')</th>
								</thead>
								<tbody>
								@foreach($tickets as $key => $ticket)
								    <tr class="text-center">
								      <td>{{$ttitle[$key]}}</td>
									  	<td>
									  		{!! use_currency()->symbol !!} {{ (floatval($tprice[$key]) == 0 )?'Free': floatval($tprice[$key]) /*+ floatval($tfees[$key]) */}}
										</td>
								      <td>{{ $tqty[$key] }}</td>
								      <td>{!! use_currency()->symbol !!} {{ (floatval($tprice[$key]) == 0 )?'Free': (floatval($tprice[$key]) /*+ floatval($tfees[$key]) */) * intval($tqty[$key]) }}</td>
								    </tr>
								@endforeach		
                                    <?php 
                                        if(!empty($bookingdata->discount)){
                                            
                                            if($bookingdata->discount_type=='percentage'){
                                                $txtP=$bookingdata->discount."%";
                                            }else{
                                                $txtP="-".$bookingdata->discount." ".use_currency()->symbol;
                                            }
                                            
                                    ?>
                                    <tr>
										<th colspan="3" class="text-right">Remise</th>
										<th class="text-right"><?php echo $txtP ?></th>
									</tr>
                                    <?php } ?>
								<tr>
									<th colspan="3" class="text-right">@lang('words.user_ord_page.ord_tik_ot')</th>
									<th class="text-center">{!! use_currency()->symbol !!} {{ $bookingdata->order_amount }}</th>
								</tr>
								  </tbody>
							</table>
					</div>
					<div class="col-xs-12 col-sm-12 col-lg-9 order-boxes col-md-9">
						<a href="{{ route('user.bookmarks','upcoming') }}" class="back-page-selected"><i class="fa fa-arrow-left"></i> @lang('words.user_ord_page.ord_bck_li') </a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Model Cialm -->
<div class="modal fade bd-example-modal-lg" id="myModal-contact" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{--Contact Organizer--}}Contacter l'Organisateur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="JavaScript:void(0);" id="claim-form">
		    <div class="modal-body">
	        	<div class="row">
    				{{ csrf_field() }}
	        		<div class="col-lg-6 col-md-6 col-sm form-group">
						<input type="hidden" name="org_id" value="{{ $bookingdata->user_id }}" readonly="">
			            <label for="recipient-name" class="label-text text-uppercase">{{--First Name--}}Nom :</label>
			            <input type="text" class="form-control form-textbox" id="recipient-name" name="firstname">
	        		</div>
	        		<div class="col-lg-6 col-md-6 col-sm form-group">
			            <label for="message-text" class="label-text text-uppercase">{{--Last Name--}}Prenoms :</label>
			            <input type="text" class="form-control form-textbox" id="message-text" name="lastname">
	        		</div>
	        		<div class="col-lg-6 col-md-6 col-sm form-group">
			            <label for="email" class="label-text text-uppercase">Email :</label>
			            <input type="email" class="form-control form-textbox" id="email" name="email">
	        		</div>
	        		<div class="col-lg-6 col-md-6 col-sm form-group">
			            <label for="phone_number" class="label-text text-uppercase">{{--Phone Number--}}Téléphone :</label>
			            <input type="text" class="form-control form-textbox" id="phone_number" name="phone_number">
	        		</div>
	        		<div class="col-lg-12 col-md-12 col-sm form-group">
			            <label for="about_us" class="label-text text-uppercase">Messages :</label>
			            <textarea class="form-control form-textbox" id="about_us" name="about_us" style="resize: none;" rows="5"></textarea>
	        		</div>
	        	</div>
		    </div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{--Close--}}Fermer</button>
		        <button type="submit" class="btn btn-primary claim-this-profile">{{--Send message--}}Envoyer le message</button>
			</div>
        </form>
    </div>
  </div>
</div>
<!-- Model Cialm -->
@endsection
@section('pageScript')
<script type="text/javascript">
	   $('.refund-request').click(function() {
		var orderid = $(this).data('order-id');
		var event_id = $(this).data('event-id');
		var user_id = $(this).data('user-id');

		 swal({
		    title: "Are you sure?",
		    text: "",
		    type: "info",
		    showCancelButton: true,
		    confirmButtonColor: '#9C1C25',
		    confirmButtonText: 'Request',
		    cancelButtonText: "cancel",
		    closeOnConfirm: false,
		    closeOnCancel: false
		 },function(isConfirm){
		   if (isConfirm){
			     $.ajax({
			        url: "{{ route('refund.request') }}",
			        type: 'POST',
			        data: {_token:"{{ csrf_token() }}",orderid:orderid,event_id:event_id,event_ower_id:user_id},
			        dataType: 'json',
			        success:function(data){
			          $('.refund-request').hide();
			          $('#refund').show();
		     			swal("Refund Request", "Request send successfully!", "success");
			        },error: function(jqXhr, textStatus, errorThrown){
			            console.log(errorThrown);
			        }
			    });
		    } else {
		      swal("Cancelled", "Your request is cancel", "error");
		    }
	 });
		});

	// $(document).on("input", "#phone_number", function() {
	//     this.value = this.value.replace(/\D/g,'');
	// });


</script>
@endsection