@extends($AdminTheme)
@section('title','Accepted Refund')
@section('content-header')
<h1>{{--Accepted refund--}}Remboursement accepté</h1>
<ol class="breadcrumb">
	<li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li class="active">{{--Accepted refund--}}Remboursement accepté</li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">{{--Refund order list--}}Liste de commande de remboursement </h3>
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
						<th>{{--Order id--}}ID Commande</th>
						<th>{{--Username--}}Nom d'utilisateur</th>
						<th>{{--Order Tickets--}}Commande de billets</th>
						<th>{{--Request Date--}}Date de la demande</th>
						<th>{{--Paid Amount--}}Montant payé</th>
						<th width="20%">{{--Payment Status--}}Status de paiement</th>
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
							<td><span class="label label-success">{{--Refunded--}}Remboursé</span></td>
						</tr>
						@endforeach
					@else
						<tr class="text-center">
							<td colspan="8">
								{{--Not Found.--}}Introuvable
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