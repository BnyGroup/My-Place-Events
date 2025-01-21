@extends($AdminTheme)

@section('title','Organization List')
@section('content-header')
<h1>{{--Organization List--}}Liste des organisateurs</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Organization list--}}Liste des organisateurs</a></li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--Organization--}}Organisation</h3>
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
	    <div class="table-responsive">
			<table id="datatable" class="datatable table table-bordered table-striped ">
				<thead>
					<tr>
						<th>No</th>
						<th>{{--Name--}}Nom</th>
						<th>{{--Created By--}}Créé par</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $key => $datas)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ $datas->organizer_name }}</td>
						<td>{{ $datas->fnm }} {{ $datas->lnm }}</td>
						<td class="text-center">{{ org_status($datas->status) }}</td>
						<td class="text-center">
							@permission('organization-view')
							<a class="btn-flat btn btn-info" href="{{ route('org.view',$datas->id) }}"><i class="fa fa-eye"></i> {{--View--}}Vue</a>
							@endpermission
							@permission('organization-ban-revoke')
							@if($datas->ban == 0)
								<a href="{{ route('org.ban',$datas->id) }}" class="btn-flat btn btn-danger"><i class="fa fa-ban"></i> {{--Disabled--}}Désactivé</a>
							@else
								<a href="{{ route('org.revoke',$datas->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> {{--Enabled--}}Activé</a>
							@endif
							@endpermission
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
@endsection


