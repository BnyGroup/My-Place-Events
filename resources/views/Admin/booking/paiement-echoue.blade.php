@inject('dataCount','App\Booking')
@inject('guestInfo','App\GuestUser')
@inject('frontusers','App\Frontuser')

@extends($AdminTheme)

@section('title','Events Booking List')
@section('content-header')
<h1>{{--Booking List--}}Liste d' achat</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Booking list--}}Liste d'achat</a></li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	@php
		$compteur = 0;
		$orders_id = '';
	@endphp
	@foreach(/*$dataCount->getDataforDashLevelTwo()*/$dataCount->getDataforDashThree() as $key => $val)
		@if($val->delivred_status == 0 && Carbon\Carbon::parse($val->created_at)->addMinutes(10) < Carbon\Carbon::now() && $val->order_status != 4 /*$val->delivred_status == 0 && Carbon\Carbon::parse($val->created_at)->addMinutes(10) < Carbon\Carbon::now()*/)
			@php
				$orders_id .=$val->order_id.'-';
				$compteur++;
			@endphp
		@endif
	@endforeach
	@php $orders_id .='#' @endphp
	<div class="box-header">
		<p class="box-title">{{--Events Booking--}}
			<strong>{{ $compteur }} </strong> ticket.s à régulariser
			<a class="btn btn-warning" href="{{ $route = ($orders_id != '#')?route('order.regularise',$orders_id):'#' }}"> Régulariser maintenant </a>
		</p>
	</div>
	<div class="box-header">
		<h3 class="box-title">{{--Events Booking--}} Réservation d'événements </h3>
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
			<li><a href="{{ route('booking.user') }}">Paiement reussi</a></li>
			<li><a href="{{ route('paiement-gratuit') }}">Commande reussie - Gratuit</a></li>
			<li class="active"><a href="{{ route('paiement-echoue') }}">Paiement echoué</a></li>
		</ul>

		<div class="tab-content">
			<div id="success" class="tab-pane fade in active">
			 
				<table id="AllempTable" class="AllempTable table table-bordered table-striped ">
					<thead>
					<tr>
						<th>No</th>
						<th>ID RÉSERVATION</th>
						<th>ID EVENEMENT</th>
						<th>TITRE EVENEMENT</th>
						<th>TICKET ACHETEUR</th>
						<th>CONTACT</th>
						<th>DATE DE RÉSERVATION</th>
						<th>No DE TICKETS</th>
						<th>MONTANT PAYE</th>
						<th>STATUS PAIEMENT</th>
						<th class="text-center">ACTION</th>
					</tr>
					</thead>
					 
				</table>
				 
			</div>
		</div>
	</td>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
	
 
@endsection
	
	

@section('page-level-script')

<script type="text/javascript"> 
     $(document).ready(function(){

         // DataTable
        $('#AllempTable').DataTable({
             processing: true,
             serverSide: true,
			 pageLength: 30,
             ajax: "{{route('booking.getfailedorders')}}",
             columns: [
                 { data: 'key' },
                 { data: 'order_id' },
                 { data: 'event_id' },
                 { data: 'eventname' },
                 { data: 'Username' },
                 { data: 'contact' },
                 { data: 'updated_at' },
                 { data: 'order_tickets' },
                 { data: 'stusP' },
                 { data: 'paymentstatus' },
                 { data: 'action' },				 
             ]
         });

      });
</script>


@endsection
	