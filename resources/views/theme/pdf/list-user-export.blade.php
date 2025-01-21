<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('/font-awesome/css/font-awesome.min.css')}}" />
		<link rel="stylesheet" href="{{ asset('/css/bootstrap-3.min.css') }}">
		<style type="text/css">
			@page { margin: 4em; }
			@media print {
				.page-break { height:0; /*page-break-before:always;*/ margin:0;  }
		}
			body, p, span, td, a {
				
			}
			body{
				padding: 0em;
				margin:0em;
				/*border:1px solid #ddd;*/
			}
			.clear{
				clear: both;
			}
			.page-brk{
				page-break-before:always;
			}
			.page{
				/*height:500px;*/
				position: relative;
				padding: 0px;
				/*page-break-before: always;*/
				font-family: Arial, Helvetica, sans-serif;
				position:relative;
				/*border-bottom: 1px solid #999999;*/
			}
			.page .ticket-main{
				background: #ffffff;
				margin: 0px;
				padding: 0px;
				width: 100%;				
				position: relative;
			}
			.page .ticket-main .table{
				padding: 0;
				margin: 0;
				border: 1px solid #ddd;
			}
			.page .ticket-main .table th{
				background: #D600A9
;
				color: #ffffff;
				font-size: 16px;
			}
			.page .ticket-main .table tr,
			.page .ticket-main .table th,
			.page .ticket-main .table td{
				border: 0px;
				padding: 10px;
			}			
			.page .ticket-main .table td{
				font-size: 16px;
			}
			.ticket-main .ticket-order{
				text-align: center;
				color: #ffffff;
				padding: 15px 10px;
				background: #D600A9
;
				margin-bottom: 1px;
				font-size: 20px;
			}
			.ticket-main .ticket-order strong{ font-size: 24px; padding: 10px; display: block; }
			.chackbox{ font-size: 30px; padding: 0px 10px; display: block;}
			.k-box{
				height:20px;
				width:20px;
				border:2px solid rgba(137, 129, 129, 0.9);
				border-radius:5px;
			}
		</style>
	</head>
	<body>
		<div class="page">
			<div class="ticket-main">
				<div class="ticket-order">
					Liste des participants de<br/>
					<strong>{{ $eventData->event_name }}</strong>					
				</div>
				<br/>
				<div class="table">
					<table class="table">
						<thead class="table-head">
							<tr>
								<th>No</th>
								<th>@lang('words.events_tik_tbl.eve_tik_1')</th>
								<th>@lang('words.events_tik_tbl.eve_tik_2')</th>
								<th>@lang('words.events_tik_tbl.eve_tik_3')</th>
								<th>@lang('words.events_tik_tbl.eve_tik_4')</th>
								<th>Email</th>
								<th>Plus d'infos</th>
							</tr>					
						</thead>
						<tbody>
							@if(count($eventTicket) > 0 )
								@php $order_id = ''; $i=1;@endphp
								@foreach($eventTicket as $key => $val)
									@if($val->order_status == 1)
										@if($order_id != $val->ot_order_id)
											<tr style="background:#cccccc;">
												<td colspan="3">
													<strong>@lang('words.events_tik_tbl.eve_tik_1') : </strong> <strong style="letter-spacing:2px;">{{ $val->ot_order_id }}</strong>
												</td>
												<td colspan="5">{{ $val->USER_FNAME }} {{ $val->USER_LNAME }}</td>
											</tr>
										@endif
										@php $order_id = $val->ot_order_id; @endphp
										<?php
											if(!empty($val->moreinfos)){
												$moreinfos = json_decode($val->moreinfos);
											}
										?>
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $val->ot_order_id }}</td>
											<td>{{ $val->ot_qr_code }}</td>
											<td>{{ $val->TICKE_TITLE }}</td>
											<td>{{ $val->ot_f_name }} {{ $val->ot_l_name }}</td>
											<td>{{ $val->ot_email }}</td>
											<td><?php 
											$mm="";$moreinfos="";								 
											if(!empty($val->moreinfos)){ 

												$moreinfos=(array)json_decode($val->moreinfos);
												$keys=array_keys($moreinfos);
												if($keys!=null){
													
													foreach ($moreinfos as $k=>$v){
														$k=str_replace('_',' ',$k);
														$mm.="<span style='text-transform: capitalize'>".$k.":</span> ".$v." <br> ";
													}
												}
												 echo $mm;
											}
 									  ?></td>
										</tr>
										@php $i++; @endphp
									@endif
								@endforeach
							@else
								<tr>
									<td colspan="6">
										@lang('words.events_tik_tbl.eve_not_fo')
									</td>									
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>