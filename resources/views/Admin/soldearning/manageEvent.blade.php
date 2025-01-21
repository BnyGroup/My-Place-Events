@extends($AdminTheme)
@section('title',$event->event_name.' '.'Sales Manage')
@section('content-header')
<h1>{{$event->event_name}} {{--Sales Manage--}}Gestion des ventes</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Manage Events--}}Gérer les événements</a></li>
</ol>
<style type="text/css">
	.progress-activebc-change{
		background: #222D32;
	}
</style>
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-success">
				<div class="box-header with-border">
		            <i class="fa fa-ticket"></i>
		            <h3 class="box-title">{{--Ticket Sales--}}Tickets Vendu</h3>
        		</div>
				<div class="box-body">
					@php
						$ticket_qty = array_column(array_flatten($tickets), 'ticket_qty');
						$remaning_qty = array_column(array_flatten($tickets), 'ticket_remaning_qty');
						$totalTickets = array_sum($ticket_qty);
						$totalRemaning	= array_sum($remaning_qty);
						$totalSoldTickets = $totalTickets - $totalRemaning;
					@endphp
					<div class="progess-text">
				    	<label>Total Ticket</label><br>
			    		<strong>{{ $totalOrderTickss->TOTAL_ORDER_TICKETS }}</strong> @lang('words.manage_dash.mng_sol_toal') / <strong>{{ $event_tickets->TOTAL_TICKETS }}</strong>
				    </div>
				    <div class="progress active progress-activebc-change">
				 		@php $j=1  @endphp
				 		@foreach($eventOrderTickets as $ticket)
				 			@php
				    			$total = number_format(($ticket->NUMBER_OF_ORDER / $event_tickets->TOTAL_TICKETS) * 100, 4);
				    		@endphp
				 			@if($j==1)
								<div class="progress-bar progress-bar-striped" data-toggle="tooltip" data-placement="top" data-original-title="{{  number_format($total,2) }}%" style="width:{{  $total }}%; background-color:#f07322;"></div>
							@elseif($j==2)
							  	<div class="progress-bar progress-bar-striped" data-toggle="tooltip" data-placement="top" data-original-title="{{  number_format($total,2) }}%" style="width:{{  $total }}%; background-color:#0095da;"></div>
						  	@elseif($j==3)
							  	<div class="progress-bar progress-bar-striped" data-toggle="tooltip" data-placement="top" data-original-title="{{  number_format($total,2) }}%" style="width:{{  $total }}%; background-color:#ce242c;"></div>
						  	@elseif($j==4)
							  	<div class="progress-bar progress-bar-striped" data-toggle="tooltip" data-placement="top" data-original-title="{{  number_format($total,2) }}%" style="width:{{  $total }}%; background-color:#00924c;"></div>
						  	@else
							  	<div class="progress-bar progress-bar-striped" data-toggle="tooltip" data-placement="top" data-original-title="{{  number_format($total,2) }}%" style="width:{{  $total }}%; background-color:#fbb413;"></div>
						  	@endif
						  	@php $j++  @endphp
					  	@endforeach
					</div> 
					<hr>
					@if(!empty($eventOrderTickets))
						@php $i=1  @endphp
						@foreach($eventOrderTickets as $ticket)
						<div class="t-types">
						    <div class="progess-text">
						    	<label>{{ $ticket->TICKE_TITLE }}</label><br>
					    		<strong>{{($ticket->NUMBER_OF_ORDER)}}</strong> @lang('words.manage_dash.mng_sol_toal') / <strong>{{ $ticket->TICKE_QTY }}</strong>
					    		@php
					    			$total = number_format(($ticket->NUMBER_OF_ORDER / $ticket->TICKE_QTY) * 100, 4);
					    		@endphp
						    </div>
							<div class="progress active progress-activebc-change">
							    @if($i==1)
							    	<div class="progress-bar progress-bar-striped" style="width:{{  $total }}%; background-color:#f07322"> {{ number_format($total) }}% </div>
							    @elseif($i==2)
							    	<div class="progress-bar progress-bar-striped" style="width:{{  $total }}%; background-color:#0095da"> {{  number_format($total) }}% </div>
							    @elseif($i==3)
							    	<div class="progress-bar progress-bar-striped" style="width:{{ $total }}%; background-color:#ce242c"> {{ number_format($total) }}% </div>
							    @elseif($i==4)
							    	<div class="progress-bar progress-bar-striped" style="width:{{ $total }}%; background-color:#00924c"> {{ number_format($total) }}% </div>
						    	@else
							    	<div class="progress-bar progress-bar-striped" style="width:{{ $total }}%; background-color:#fbb413"> {{ number_format($total) }}% </div>
						    	@endif
						  	</div>
						</div>
						@php $i++  @endphp
						<hr>
						@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="box box-success">
				<div class="box-header with-border">
		            <i class="fa fa-download"></i>
		            <h3 class="box-title">{{--Download Attendee list--}}Télécharger la liste des participants</h3>
        		</div>
				<div class="box-body">
					<a href="{{ route('admin.events.attendee',$event->event_unique_id) }}" class="btn btn-flat btn-success">{{--Get Attendee list--}}Obtenir la liste des participants</a>
				</div>
			</div>
		</div>
	</div>
@endsection