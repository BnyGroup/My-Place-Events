@extends($AdminTheme)

@section('title','Sold Tickets By Organizer')
@section('content-header')
<h1>{{--Sold Tickets By Organizer--}}Billets vendus par l'Organisateur</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Sold Tickets By Organizer--}}Billets vendus par l'Organisateur</a></li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">		
    <div class="table-responsive">
		<table class="my-csutom table table-bordered table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>{{--Name--}}Nom</th>
					<th>Website</th>
					<th>Url</th>
					<th>{{--Created Date--}}Date de Création</th>
					<th width="5%">Action</th>
				</tr>
			</thead>
			<tbody>
				@if(! $data->isEmpty())
					@foreach($data as $key => $org)
						<tr>
							<td>{{ ++$key }}</td>
							<td>{{ $org->organizer_name }}</td>
							<td>{{ $org->website }}</td>
							<td>{{ route('org.detail',$org->url_slug) }}</td>
							<td>{{ dateFormat($org->created_at) }}</td>
							<td>
								<a href="{{ route('manage.events',$org->id) }}" class="btn btn-success btn-flat"><i class="fa fa-list-alt"></i> {{--Manage Events--}}Gestion d'événement</a>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection