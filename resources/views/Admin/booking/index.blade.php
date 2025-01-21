@inject('dataCount','App\Booking')
@inject('guestInfo','App\GuestUser')
@inject('frontusers','App\Frontuser')

@extends($AdminTheme)

@section('title','Events Booking List')
@section('content-header')
<h1>{{--Booking List--}}Liste d'achat</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
	<li><a href="#"> Liste d'achat</a></li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<?php /*?>@php
		$compteur = 0;
		$orders_id = '';
	@endphp
	@foreach($dataCount->getDataforDashThree() as $key => $val)
		@if($val->delivred_status == 0 && Carbon\Carbon::parse($val->created_at)->addMinutes(10) < Carbon\Carbon::now() && $val->order_status != 4)
			@php
				$orders_id .=$val->order_id.'-';
				$compteur++;
			@endphp
		@endif
	@endforeach
	@php $orders_id .='#' @endphp
	<div class="box-header">
		<p class="box-title">
			<strong>{{ $compteur }} </strong> ticket.s à régulariser
			<a class="btn btn-warning" href="{{ $route = ($orders_id != '#')?route('order.regularise',$orders_id):'#' }}"> Régulariser maintenant </a>
		</p>
	</div><?php */ ?>
	<div class="box-header">
		<h3 class="box-title">Réservation d'événements </h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		@if($error = Session::get('error'))
			<div class="alert alert-danger">
				{{ $error }}
			</div>
      	@elseif($success = Session::get('success'))
	      	<div class="alert alert-success">
				{{ $success }}
	    	</div>
    	@endif
			@php $noRepeatController2 = array(); @endphp
    <div class="table-responsive">
		<ul class="nav nav-tabs">
			<li class="active"><a href="{{ route('booking.user') }}">Paiement reussi</a></li>
			<li><a href="{{ route('paiement-gratuit') }}">Commande reussie - Gratuit</a></li>
			<li><a href="{{ route('paiement-echoue') }}">Paiement echoué</a></li>
		</ul>
		<?php /*?><div class="row">
			<div class="col-sm-12" style="text-align: right">
				<div id="datatable_filter" class="dataTables_filter"><label style="text-align: left;">Recherche:<input type="search" id="keyword" class="form-control input-sm" placeholder="" aria-controls="datatable" name="" style="display: inline-block;"></label></div>
			</div>
		</div><?php */?>
		<div class="tab-content">
			<div id="success" class="tab-pane fade in active">
				<table id="AllempTable" class="AllempTable table table-bordered table-striped ">
					<thead>
					<tr>
						<th>No</th>
						<th>ID RÉSERVATION</th>
						<th>{{--EVENT--}} ID EVENEMENT</th>
						<th>{{--EVENT TITLE--}}TITRE EVENEMENT</th>
						<th>{{--TICKET BUYER--}}TICKET ACHETEUR</th>
						<th>{{--TICKET BUYER--}}INFO ACHETEURS</th>
						<th>{{--BOOKING DATE--}}DATE DE RÉSERVATION</th>
						<th>{{--NO OF TICKETS--}}No DE TICKETS</th>
						<th>{{--PAID AMOUNT--}}MONTANT PAYE</th>
						<th>{{--PAID AMOUNT--}}MOYEN DE PAIEMENT</th>
						<th>{{--PAYMENT STATUS--}}STATUS PAIEMENT</th>
						<th>{{--FACTURE--}}FACTURE</th>
						<th class="text-center">{{--Action--}}ACTION</th>
					</tr>
					</thead>
					 
				</table>
				
				<?php /*?><div style="padding: 10px 0">
					 { !! $data->render() !! }

				</div><?php */?>
			</div>

			<div id="free" class="tab-pane fade">
				 
			</div>


			<div id="failed" class="tab-pane fade">
				 
			</div>
		</div>
	</td>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
	
	
	<style>
		/*.dataTables_paginate .pagination{
			display: none;
		}*/
	</style>

@endsection

@section('page-level-script')


<!-- Modal -->
<div class="modal fade" id="empModal" >
	<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			   <div class="modal-header">
					<h4 class="modal-title">Détails de la réservation</h4>
				   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
			   </div>
			   <div class="modal-body">

			   </div>
			   <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			   </div>
		  </div>
	</div>
</div>

<script type="text/javascript"> 

		
	$(document).ready(function(){


			$(document).on("click",".viewdetails",function() { 
		 
				 var orderid = $(this).data('order');

				 // AJAX request
				 $.ajax({
					   url: '{{route("booking.vieworderdetails")}}',
					   type: 'get',
					   data: {orderid: orderid, _token: "{{ csrf_token() }}"},
					   success: function(response){ 
							// Add response in Modal body
							$('#empModal .modal-body').html(response);

							// Display Modal
							$('#empModal').modal('show'); 
					   },
					 error:function(e){
						 alert("Une erreur est survenur")
					 }
				 });
			});

	});
	
	 $(document).ready(function(){

         // DataTable
        $('#AllempTable').DataTable({
             processing: true,
             serverSide: true,
			 initComplete:function(){onint();},
			 search: {
					return: true
				},
			 pageLength: 30,
             ajax: "{{route('booking.getallorders')}}",
             columns: [
                 { data: 'key' },
                 { data: 'order_id' },
                 { data: 'event_id' },
                 { data: 'eventname' },
                 { data: 'Username' },
                 { data: 'gateway' },
                 { data: 'updated_at' },
                 { data: 'order_tickets' },
                 { data: 'stusP' },
                 { data: 'gtway' },
                 { data: 'paymentstatus' },
                 { data: 'createinvoice' },				 
                 { data: 'action' },				 
             ]
         });

      });
	
       function onint(){
         // take off all events from the searchfield
         $("#AllempTable_wrapper input[type='search']").off();
         // Use return key to trigger search
         $("#AllempTable_wrapper input[type='search']").on("keydown", function(evt){
              if(evt.keyCode == 13){
                $("#AllempTable").DataTable().search($("input[type='search']").val()).draw();
              }
         });
          
       }	
</script>
@endsection
