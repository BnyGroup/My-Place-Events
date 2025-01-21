@extends($theme)
@section('meta_title',setMetaData()->e_deshbrd_title.' - '.$event->event_name )
@section('meta_description',setMetaData()->e_deshbrd_desc)
@section('meta_keywords',setMetaData()->e_deshbrd_keyword)
@section('content')
<div class="page-main-contain">
	<section class="user-events">
		<div class="container">
			@if($event->ban == 1)
			<div class="alert alert-danger">
				<ul style="padding-left:10px;">
					<li>@lang('words.ban_reason.ban_text_1')</li>
					<li>@lang('words.ban_reason.ban_text_2')</li>
					<li>@lang('words.ban_reason.ban_text_3') {{frommail()}}</li>
				</ul>
			</div>
			@endif
			<h2 class="text-heading">{{--Ticket Refund--}}Remboursement de billet</h2>
			<hr/>
			<div class="row">
				<div class="col-md-12">
					<div class="eventbox">
						<h3 class="event-title">{{ $event->event_name }} </h3>
						<p class="event-location"><strong>@lang('words.events_booking_page.eve_book_loc')</strong> : {{ $event->event_location }} </p>

						<?php
							$startdate 	= Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y');
							$enddate 	= Carbon\Carbon::parse($event->event_end_datetime)->format('D, F j, Y');
							$starttime	= Carbon\Carbon::parse($event->event_start_datetime)->format('h:i A');
							$endtime	= Carbon\Carbon::parse($event->event_end_datetime)->format('h:i A');
						?>
						@if($startdate == $enddate)
							<p class="event-time">{{ $startdate }} - {{ $starttime }} <b>TO</b> {{ $endtime }}</p>
						@else
							<p class="event-time">{{ $startdate }}, {{ $starttime }} <b>TO</b>  {{ $enddate }}, {{ $endtime }}</p>
						@endif
						<div class="event-label">
							@if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
								<label class="event-label label-status">@lang('words.events_tab.today')</label>
							@elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
								<label class="event-label label-status">@lang('words.mng_eve.mng_eve_fea')</label>
							@else 
								<label class="event-label label-status">@lang('words.mng_eve.mng_eve_past')</label>
							@endif
							@if($event->event_status == 1)
								<label class="event-label label-publish">@lang('words.mng_eve.mng_eve_pus')</label>
							@else
								<label class="event-label label-draft">@lang('words.mng_eve.mng_eve_drf')</label>
							@endif
							@if($event->ban == 1)
								<label class="event-label label-ban"><i class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')</label>
							@endif
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-12">
					<div class="event-sidebar">
						<ul class="nav nav-tabs text-capitalize">
							<li>
								<a class="{{ Request::is('e/refund/*/pending')?'refund-active':'' }}" href="{{ route('events.refund',[$event->event_unique_id,'pending']) }}">{{--Pending Refund--}}Remboursement en attente</a>
							</li>
							<li>
								<a class="{{ Request::is('e/refund/*/accepted')?'refund-active':'' }}" href="{{ route('events.refund',[$event->event_unique_id,'accepted']) }}">{{--Accepted Refund--}}Remboursement accepté</a>
							</li>
							<li>
								<a class="{{ Request::is('e/refund/*/rejected')?'refund-active':'' }}" href="{{ route('events.refund',[$event->event_unique_id,'rejected']) }}">{{--Rejected Refund--}}Remboursement refusé</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-9 col-md-8 col-sm-12">
					<div class="tab-content">
						<div id="item1" class="tab-pane fade {{ Request::is('e/refund/*/pending')?'in active':'' }}">
							<div class="tickets-type">
								<div class="header">
									<h3>{{--Pending refund--}}Remboursement en attente</h3>
								</div>
								<div class="table-responsive">
									<table class="table">
										<thead class="table-head">
											<tr>
												<th>No.</th>
												<th>{{--Event Name--}}Nom de l'événement</th>
												<th>{{--#Order id--}} #Commande</th>
												<th>Username</th>
												<th>{{--Order Tickets--}}Commande de Tickets</th>
												<th>{{--Request Date--}}Date de Demande</th>
												<th>{{--Paid Amount--}}Montant Payé</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											@if(! $pending->isEmpty())
												@foreach($pending as $pkey => $pend)
												<tr>
													<td>{{ ($pending->currentpage()-1) * $pending->perpage() + $pkey + 1 }}</td>
													<td>{{ $pend->event_name }}</td>
													<td>{{ $pend->order_id }}</td>
													<td>{{ user_data($pend->user_id)->fullname }}</td>
													<td>{{ $pend->order_tickets }}</td>
													<td>{{ \Carbon\Carbon::parse($pend->transation_date)->format('d F, Y h:i A') }}</td>
													<td>{!! use_currency()->symbol !!} {{ number_format($pend->order_amount,2) }}</td>
													<td>{{--Pending--}}En Attente</td>
												</tr>
												@endforeach
											@else
												<tr class="text-center">
													<td colspan="8">{{--Not Found.--}}Aucun</td>
												</tr>
											@endif
										</tbody>
									</table>
								</div>
								{{ $pending->render() }}
							</div>
						</div>
						<div id="item2" class="tab-pane fade {{ Request::is('e/refund/*/accepted')?'in active':'' }}">
							<div class="tickets-type">
								<div class="header">
									<h3>Accepted Refund</h3>
								</div>
								<div class="table-responsive">
									<table class="table">
										<thead class="table-head">
											<tr>
												{{--<th>No.</th>
												<th>Event Name</th>
												<th>#Order id</th>
												<th>Username</th>
												<th>Order Tickets</th>
												<th>Request Date</th>
												<th>Paid Amount</th>
												<th>Status</th>--}}
												<th>No.</th>
												<th>{{--Event Name--}}Nom de l'événement</th>
												<th>{{--#Order id--}} #Commande</th>
												<th>Username</th>
												<th>{{--Order Tickets--}}Commande de Tickets</th>
												<th>{{--Request Date--}}Date de Demande</th>
												<th>{{--Paid Amount--}}Montant Payé</th>
												<th>Status</th>
											</tr>

										</thead>
										<tbody>
											@if(! $accept->isEmpty())
												@foreach($accept as $akey => $accp)
												<tr>
													<td>{{ ($accept->currentpage()-1) * $accept->perpage() + $akey + 1 }}</td>
													<td>{{ $accp->event_name }}</td>
													<td>{{ $accp->order_id }}</td>
													<td>{{ user_data($accp->user_id)->fullname }}</td>
													<td>{{ $accp->order_tickets }}</td>
													<td>{{ \Carbon\Carbon::parse($accp->transation_date)->format('d F, Y h:i A') }}</td>
													<td>{!! use_currency()->symbol !!} {{ number_format($accp->order_amount,2) }}</td>
													<td>{{--Accept--}}Accepté</td>
												</tr>
												@endforeach
											@else
												<tr class="text-center">
													<td colspan="8">{{--Not Found.--}}Aucun</td>
												</tr>
											@endif
										</tbody>
									</table>
								</div>
								{{ $accept->render() }}
							</div>
						</div>
						<div id="item3" class="tab-pane fade {{ Request::is('e/refund/*/rejected')?'in active':'' }}">
							<div class="tickets-type">
								<div class="header">
									<h3>{{--Rejected Refund--}}Remboursement Rejété</h3>
								</div>
								<div class="table-responsive">
									<table class="table">
										<thead class="table-head">
											<tr>
												<th>No.</th>
												<th>{{--Event Name--}}Nom de l'événement</th>
												<th>{{--#Order id--}}#Commande</th>
												<th>Username</th>
												<th>{{--Order Tickets--}}Ticket Commandé</th>
												<th>{{--Request Date--}}Date de Demande</th>
												<th>{{--Paid Amount--}} Montant Payé</th>
												<th width="10%">Note</th>
											</tr>
										</thead>
										<tbody>
											@if(! $reject->isEmpty())
												@foreach($reject as $akey => $rejects)
												<tr>
													<td>{{ ($reject->currentpage()-1) * $reject->perpage() + $akey + 1 }}</td>
													<td>{{ $rejects->event_name }}</td>
													<td>{{ $rejects->order_id }}</td>
													<td>{{ user_data($rejects->user_id)->fullname }}</td>
													<td>{{ $rejects->order_tickets }}</td>
													<td>{{ \Carbon\Carbon::parse($rejects->transation_date)->format('d F, Y h:i A') }}</td>
													<td>{!! use_currency()->symbol !!} {{ number_format($rejects->order_amount,2) }}</td>
													<td>
														<a tabindex="1" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" data-placement="left" data-content="{{ $rejects->reject_note }}"><i class="fa fa-eye"></i>View</a>
													</td>
												</tr>
												@endforeach
											@else
												<tr class="text-center">
													<td colspan="8">{{--Not Found.--}}Aucun</td>
												</tr>
											@endif
										</tbody>
									</table>
								</div>
								{{ $reject->render() }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('pageScript')
<script type="text/javascript">
	$('.popover-dismiss').popover({
	  trigger: 'focus'
	})
</script>
@endsection