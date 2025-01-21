@extends($AdminTheme)
@section('title','Order wise earning')
@section('content-header')
<h1>{{--Order earning--}}Prise de commande</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Order earning--}}Prise de commande</a></li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<table class="out-orrder table table-bordered table-striped text-center">
				<thead>
					<tr>
						<th>{{--Select--}}Selectionner</th>
						<th>{{--# Order ID--}}# ID Commande</th>
						<th>{{--Order Date--}}Date Commande</th>
						<th>{{--Total QTY--}}QTE Total</th>
						<th>{{--Order Amount--}}Montant Commande</th>
						<th>{{--Order Commission--}}Commission Commande</th>
						<th>{{--Organisation Amount--}}Montant Organisation</th>
						<th>Status</th>
						<th>{{--Order tickets--}} Ticket Commandé</th>
					</tr>
				</thead>
				<tbody>
					@php
						$datas = [];
					@endphp
					@if(! $data->isEmpty())
						
						@foreach($data as $key => $orders)
							@php
								$tiktype = unserialize($orders->order_t_qty);
								$tiktname = unserialize($orders->order_t_title);
								$datas['total_tickets'][$key]		= $orders->order_tickets;
								$datas['total_amount'][$key]		= $orders->order_amount;
								$datas['total_commission'][$key]	= $orders->order_commission;
								$datas['total_org_amount'][$key]	= $orders->order_amount - $orders->order_commission;
							@endphp
						<tr>
							<td>
								@if($orders->order_paymets != 1)
									@if($datas['total_org_amount'][$key] > 0)
									<input type="checkbox" name="paid[]" value="{{$datas['total_org_amount'][$key]}}" data-orderid="{{ $orders->order_id }}" class="paid-order" data-currency="{{ use_currency()->symbol }}">
									@endif
								@endif
							</td>
							<td>{{ $orders->order_id }}</td>
							<td>{{ dateFormat($orders->created_at) }}</td>
							<td>
								<b>{{ $orders->order_tickets }}</b>
								<br>
								@php
									$myarray = [];
									foreach($tiktname as $tikcono => $tikcets){
										$myarray[$key][$tikcono] = ucfirst($tikcets).'-'.$tiktype[$tikcono];
									}
									echo implode(',',$myarray[$key]);
								@endphp
							</td>
							<td>{{ use_currency()->symbol }} {{ number_format($datas['total_amount'][$key],2) }}</td>
							<td>{{ use_currency()->symbol }} {{ number_format($datas['total_commission'][$key],2) }}</td>
							<td>{{ use_currency()->symbol }} {{ number_format($datas['total_org_amount'][$key],2) }}</td>
							<td>
								@if($datas['total_org_amount'][$key] > 0)
									{{ paymentstatus($orders->order_paymets) }}
								@else
									<label class="label label-success">Paid</label>
								@endif
							</td>
							<td>
								<button class="btn btn-flat btn-info" data-target="#{{ $orders->order_id }}"  data-toggle="modal"><i class="fa fa-ticket"></i> {{--Order tickets--}}Tickets Commandés</button>
								@include('Admin.soldearning.model')
							</td>
						</tr>
						@endforeach
					@endif
				</tbody>
				{{--@isset($datas)
				<tfoot>
				<tr>
					<th colspan="2"></th>
					<th>Total</th>
					<th>{{ array_sum($datas['total_tickets']) }}</th>
					<th>{{ use_currency()->symbol }} {{ number_format(array_sum($datas['total_amount']),2) }}</th>
					<th>{{ use_currency()->symbol }} {{ array_sum($datas['total_commission']) }} </th>
					<th>{{ use_currency()->symbol }} {{ number_format(array_sum($datas['total_org_amount']),2) }}</th>
					<th colspan="2"></th>
				</tr>
				</tfoot>
				@endisset--}}
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-5">
		<div class="box box-primary">
			<div class="box-body">
				<form>
					<table class="text-center table table-bordered" id="order-tbl">
						<thead>
							<th>{{--Total Tickets--}}Tickets Total</th>
							<th>{{--Order Amount--}}Montant Commande</th>
							<th>{{--Order Commission--}}Commande Commission</th>
							<th>{{--Organisation Amount--}}Montant Organisation</th>
						</thead>
						<tbody>
							<tr>
								@php
									$total = isset($datas['total_tickets'])?array_sum($datas['total_tickets']):0;
									$amount = isset($datas['total_amount'])?number_format(array_sum($datas['total_amount']),2):0;
									$commission = isset($datas['total_commission'])?array_sum($datas['total_commission']):0;
									$orgamoj = isset($datas['total_org_amount'])?number_format(array_sum($datas['total_org_amount'])):0;
								@endphp
								<td>{{ $total }}</td>
								<td>{{ use_currency()->symbol }} {{ $amount }}</td>
								<td>{{ use_currency()->symbol }} {{ $commission }} </td>
								<td>{{ use_currency()->symbol }} {{ $orgamoj }}</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="row" style="display: none;" id="order-box">
	<div class="col-lg-3">
		<div class="box box-primary">
			<div class="box-body">
				<form id="order-form">
					<table class="table table-bordered" id="order-tbl">
						<thead>
							<th># {{--Order ID--}}ID Commande</th>
							<th>{{--Organization Amount--}}Montant Organisation</th>
						</thead>
						<tbody>
							<tr></tr>
						</tbody>
						<tfoot>
						    <tr>
						      <th>Totals</th>
						      <th>{{ use_currency()->symbol }} <span id="tot">0.00</span></th>
							  <input type="hidden" name="total" value="0.00" id="txtGrandTotal">
						    </tr>
					  </tfoot>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('page-level-script')
<!-- <script type="text/javascript">
	$(document).ready(function() {
    $('.earaning-example').DataTable({
    		'paging'      : true,
			'lengthChange': true,
			'searching'   : true,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true,
        "footerCallback": function ( row, data, start, end, display ) {
	       var api = this.api(), data; 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotal = api
	                .column( 4, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Update footer
	            $( api.column( 4 ).footer() ).html(
	                '$'+ pageTotal +' ( $'+ total +' total)'
	            );


	            Ttotal = api
	                .column( 3 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );

	            TikTotal = api
	                .column( 3, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );

	            $( api.column( 3 ).footer() ).html(
	                TikTotal +' ('+Ttotal +' total)'
	            );
	        }
	    });
	} );
</script> -->
@endsection