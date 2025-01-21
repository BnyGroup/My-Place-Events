@extends($AdminTheme)
@section('title','Pending Refund')
@section('content-header')
<h1>{{--Pending refund--}}Remboursement en attente</h1>
<ol class="breadcrumb">
	<li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li class="active">{{--Pending refund--}}Remboursement en attente</li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">{{--Refund order list --}}Liste de commande de remboursement</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">		
      	@if($success = Session::get('success'))
	      	<div class="alert alert-success">
				{{ $success }}
	    	</div>
    	@endif
		<div class="table-responsive">	
			<table id="datatable" class="datatables table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>{{--Event Name--}}Nom Event</th>
						<th>#{{--Order id--}}ID Commande</th>
						<th>{{--Username--}}Nom d'Utilisateur</th>
						<th>{{--Order Tickets--}}Commander des billets</th>
						<th>{{--Request Date--}}Date de la demande</th>
						<th>{{--Paid Amount--}}Montant payé</th>
						<th width="20%">Action</th>
					</tr>
				</thead>
				<tbody>
					@if(! $data->isEmpty())
					@foreach($data as $key => $value)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ $value->event_name }}</td>
						<td>{{ $value->order_id }}</td>
						<td>{{ user_data($value->user_id)->fullname }}</td>
						<td>{{ $value->order_tickets }}</td>
						<td>{{ \Carbon\Carbon::parse($value->transation_date)->format('d F, Y h:i A') }}</td>
						<td>{!! use_currency()->symbol !!} {{ number_format($value->order_amount,2) }}</td>
						<td>
							{!! Form::open(['route' => 'order.refund','method' => 'post','style' => 'display:inline-block']) !!}
							{!! Form::hidden('order_id',$value->order_id) !!}
							{!! Form::hidden('event_id',$value->event_id) !!}
							{!! Form::hidden('user_id',$value->user_id) !!}
							{!! Form::hidden('charge_id',$value->stripe_id) !!}
							{!! Form::hidden('pay',number_format($value->order_amount,2)) !!}
							<button class="btn btn-flat btn-success" type="submit">{{--Refund--}}Rembourser</button>
	                        {!! Form::close() !!}
							<button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#myModal{{ $value->id }}"><i class="fa fa-ban"></i> {{--Reject--}}Rejeter</button>
							@include('Admin.refund.model')
						</td>
					</tr>
					@endforeach
					@else
						<tr class="text-center">
							<td colspan="8">
								{{--Not Found.--}}Introuvable.
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
@endsection


  