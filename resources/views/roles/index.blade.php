@extends($AdminTheme)

@section('title','Roles List')

@section('content-header')
<h1>{{--Roles List--}}Liste des Roles</h1>
	<ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	  <li class="active">{{--Roles List--}}Liste des Roles</li>
	</ol>
@endsection

@section('content')
	<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--Roles List--}}Liste des Roles</h3>
	</div>
	<div class="box-body">
		@if($success = Session::get('success'))
			<div class="alert alert-success">{{ $success }}</div>
		@endif
		@permission('role-create')
		<div style="width: 250px; position: absolute;">
			<a href="{{ route('roles.create') }}" class="btn btn-primary btn-flat">{{--Create Role --}}Creer une role&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
		</div>
		@endpermission
		<div class="table-responsive">
			<table id="datatable" class="datatable table table-bordered table-striped ">
				<thead>
					<tr>
						<th width="100px">No.</th>
						<th>{{--Name--}}Nom</th>
						<th>{{--Display Name--}}Afficher le Nom</th>
						<th width="200px;">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($roles as $key => $val)
					<tr>
						<td>{{ ++ $key }}</td>
						<td>{{ $val->name }}</td>
						<td>{{ $val->display_name }}</td>
						<td>
							@permission('role-edit')
							<a href="{{ route('roles.edit',$val->id) }}" class="btn btn-info btn-flat">{{--Edit --}}Modifier<i class="fa fa-edit"></i></a>
							@endpermission
							@permission('role-delete')
								@if($val->id != 1)
								<a href="{{ route('roles.remove',$val->id) }}" class="btn btn-danger btn-flat" onclick=" return confirm('are you sure ?')" >{{--Delete --}}Supprimer<i class="fa fa-trash"></i></a>
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
@endsection