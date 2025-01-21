@extends($AdminTheme)
@section('title','Reject request')
@section('content-header')
<h1>@lang('words_custom.refund_reject.title')</h1>
<ol class="breadcrumb">
	<li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i> {{--Home--}}@lang('words_custom.refund_reject.page')</a></li>
	<li class="active">{{--Reject request--}}@lang('words_custom.refund_reject.title')</li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">{{--Refund order list --}}@lang('words_custom.refund_reject.refund_list')</h3>
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
						<th>{{--Event Name--}}@lang('words_custom.refund_reject.event_name')</th>
						<th>#{{--Order id--}}@lang('words_custom.refund_reject.order_id')</th>
						<th>{{--Username--}}@lang('words_custom.refund_reject.username')</th>
						<th>{{--Order Tickets--}}@lang('words_custom.refund_reject.order_ticket')</th>
						<th>{{--Request Date--}}@lang('words_custom.refund_reject.request_date')</th>
						<th>{{--Paid Amount--}}@lang('words_custom.refund_reject.paid_amount')</th>
						<th width="20%">{{--Payment Status--}}@lang('words_custom.refund_reject.payment_status')</th>
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
								<button class="btn btn-flat btn-success" type="submit">{{--Refund--}}@lang('words_custom.refund_reject.refund')</button>
		                        {!! Form::close() !!}
								<button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#myModal{{ $value->id }}"><i class="fa fa-eye"></i>{{-- Reject Reason--}}@lang('words_custom.refund_reject.reject_reason')</button>
								@include('Admin.refund.reason')
							</td>
						</tr>
						@endforeach
					@else
						<tr class="text-center">
							<td colspan="8">
								{{--Not Found.--}}@lang('words_custom.refund_reject.not_found').
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