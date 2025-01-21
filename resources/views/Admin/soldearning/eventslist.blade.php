@extends($AdminTheme)

@section('title','Manage Events')
@section('content-header')
<h1>{{--Manage Events--}}Gérer les événements</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
	<li><a href="#">{{--Manage Events--}}Gérer les événements</a></li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">		
    <div class="table-responsive">
		<table class="out-orrder table table-bordered table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>{{--Name--}}Nom</th>
					<th>Url</th>
					<th>{{--Location--}}Lieu</th>
					<th>{{--Start Date--}}Début</th>
					<th>{{--End Date--}}Fin</th>
					<th>{{--Created By--}}Créé par</th>
					<th width="21%">Action</th>
				</tr>
			</thead>
			<tbody>
				@if(! $data->isEmpty()) 
					@foreach($data as $key => $event) 
						<tr>
							<td>{{++$key}}</td>
							<td>{{ $event->event_name }}</td>
							<td>{{ route('events.details',$event->event_slug) }}</td>
							<td>{{ $event->event_location }}</td>
							<td>{{ dateFormat($event->event_start_datetime) }}</td>
							<td>{{ dateFormat($event->event_end_datetime) }}</td>
							<td>{{ user_data($event->event_create_by)->fullname }}</td>
							<td>
								<button class="btn btn-flat btn-info" data-target="#{{ $event->event_unique_id }}"  data-toggle="modal"><i class="fa fa-ticket"></i> {{--Sold Tickets--}}Billets vendus</button>
								@include('Admin.soldearning.model')
								<a href="{{ route('order.earning',$event->event_unique_id) }}" class="btn btn-success btn-flat"><i class="fa fa-dollar"></i> {{--Order & Earning--}}Commande et gain</a>
								<a href="{{ route('admin.event.dashbaboard',$event->event_unique_id) }}" class="btn btn-warning btn-flat"><i class="fa fa-cog"></i> {{--More--}}Plus</a>
							</td>
						</tr>
					@endforeach 
				@endif 
			</tbody>
		</table>
	</div>
</div>
@endsection


@section('page-level-script')
<!-- 	<script type="text/javascript">
		$(document).ready(function() {
		    var table = $('.group-table').DataTable({
		        "columnDefs": [
		            { "visible": false, "targets": 5 }
		        ],
		        "order":false,
		        "displayLength": false,
		        'searching'   : false,
		        'paging'      : false,
		        'ordering'    : false,
		        'info'        : false,
		        "drawCallback": function ( settings ) {
		            var api = this.api();
		            var rows = api.rows( {page:'current'} ).nodes();
		            var last=null;

		            api.column(5, {page:'current'} ).data().each( function ( group, i ) {
		                if ( last !== group ) {
		                    $(rows).eq( i ).before(
		                        '<tr class="group"><td colspan="5">'+group+'</td></tr>'
		                    );
		                    last = group;
		                }
		            } );
		        }
		    } );
		 
		   
		} );
	</script> -->
@endsection