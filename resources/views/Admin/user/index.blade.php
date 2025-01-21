@extends($AdminTheme)
@section('title','User List')
@section('content-header')
<h1>{{--User List --}}Liste des Utilisateurs</h1>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--User List--}}Liste des Utilisateurs</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		@if($success = Session::get('success'))
		<div class="alert alert-success">{{ $success }}</div>
		@endif
		@permission('admin-user-cerate')
			<div style="width: 250px; position: absolute;">
				<a href="{{ route('users.create') }}" class="btn btn-primary btn-flat">{{--Add --}}Ajouter&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
			</div>
		@endpermission
		<div class="table-responsive">
			<table id="datatable" class="datatable table table-bordered table-striped ">
				<thead>
					<tr>
						<th>No.</th>
						<th>{{--Fullname--}}Nom Complet</th>
						<th>{{--Username--}}Nom d'utilisateur</th>
						<th>{{--Admintype--}}Type Admin</th>
						<th>Status</th>
						<th>Email</th>
						<th width="250px">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $key => $val)
					<tr>
						<td>{{ ++ $key }}</td>
						<td>{{ $val->firstname }} {{ $val->lastname }}</td>
						<td>{{ $val->username }}</td>
						<td>{{ adminType($val->admin_type) }}</td>
						<td>
							@foreach ($val->roles as $role)
								@if ($loop->iteration > 1) / @endif
								{{ $role->display_name }}
							@endforeach
						</td>
						<td>{{ status($val->status) }}</td>
						<td>{{ $val->email }}</td>
						<td>
							@permission('admin-user-edit')
								<a href="{{ route('users.edit',$val->id) }}" class="btn btn-info btn-flat">Edit <i class="fa fa-edit"></i></a>
							@endpermission
							@permission('admin-user-view')
								<button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#{{ $val->id }}-modal-default">View <i class="fa fa-eye"></i></button>
								@include('Admin.user.model')
							@endpermission
							@permission('admin-user-delete')
								@if($val->id != 1)
									<a href="{{ route('users.delete',$val->id) }}" class="btn btn-danger btn-flat" onclick=" return confirm('are you sure ?')">Delete <i class="fa fa-trash"></i></a>
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
<!--modal-->
@endsection