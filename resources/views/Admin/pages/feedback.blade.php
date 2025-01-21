@extends($AdminTheme)

@section('title','Feedback Details')

@section('content-header')
<h1>{{--Feedback List--}}Liste de commentaires</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}} Accueil</a></li>
	<li><a href="#">{{--Feedback list--}}Liste de commentaires</a></li>
</ol>
@endsection
@section('content')
	<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--Feedback--}}Commentaires</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">		
		@if($success = Session::get('success'))
	      	<div class="alert alert-success">
				{{ $success }}
	    	</div>
    	@endif
		<table id="datatable" class="datatable table table-bordered table-striped ">
			<thead>
				<tr>
					<th>No</th>
					<th>{{--Name--}}Nom</th>
					<th>Email</th>
					<th>{{--Subject--}}Sujet</th>
					<th>Message</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $key => $datas)
				<tr>
					<td>{{ ++$key }}</td>
					<td>{{ $datas->name }}</td>
					<td>{{ $datas->email }}</td>
					<td>{{ $datas->subject }}</td>
					<td>{{ $datas->message }}</td>
					<td class="text-center">
						@permission('feedback-delete')
						<a href="{{ route('feedback.delete',$datas->id) }}" class="btn-flat btn btn-danger" onclick=" return confirm('are you sure ?')"><i class="fa fa-trash"></i> {{--Delete--}}Supprimer</a>
						@endpermission
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
@endsection