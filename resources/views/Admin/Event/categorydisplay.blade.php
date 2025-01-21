@extends($AdminTheme)

@section('title','Admin')
@section('content-header')
<h1>{{--Events - Category --}}Evénements - Catégories</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
	<li><a href="#">{{--Events--}}Evénements</a></li>
	<li class="active">{{--Category--}}Catégories </li>
</ol>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{--Event Category--}}Catégorie d'événement</h3>
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

    	@permission('event-categories-create')
		<div style="width: 250px; position: absolute;">
			<a href="{{ route('categories.create') }}" class="btn btn-primary btn-flat">{{--Add --}}Ajouter&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
		</div>	
		@endpermission
		<div class="table-responsive">	
			<table class="table table-bordered table-striped tabels-datas">
				<thead>
					<tr>
						<th>Index</th>
						<th>{{--Category Name--}}Nom Catégorie</th>
						<th>Image</th>
						<th>Description</th>
						<th>Parent</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				@if(!empty($data))
				<tbody>				
					<?php $i = 1; ?>
					@foreach($data as $post)
						<tr>
							<td>{{ $i }}</td>
							<td><b>{{ $post->category_name }}</b></td>
							<td>
								<img src="{{ setThumbnail($post->category_image) }}" alt="{{ $post->category_name }}" class="img-responsive" width="50" />
							</td>
							<td>					
								{{ Str::words($post->category_description, 25,'...')  }}						
							</td>
							<td>{{ $post->Parent_name }}</td>
							<td>{{ status($post->category_status) }}</td>
							<td>
								@permission('event-categories-edit')
								<a href="{{ route('categories.edit',['id' => $post->id]) }}" class="btn btn-flat btn-info"><i class="fa fa-edit"></i>&nbsp;&nbsp;{{--Edit--}}Modifier</a>
								@endpermission
								@permission('event-categories-delete')
								<a class="btn btn-danger btn-flat" href="{{ route('categories.remove',$post->id) }}">
								  	<i class="fa fa-trash"></i>&nbsp;&nbsp;{{--Delete--}}Supprimer
							  	</a>
							  	@endpermission
							</td>
						</tr>
						@foreach($post->children as $ckey=>$childrenPost)
							<tr>
								<td class="text-right">{{ $ckey+1 }}</td>
								<td>{{ $childrenPost->category_name }}</td>
								<td>
									<img src="{{ setThumbnail($childrenPost->category_image) }}" alt="{{ $childrenPost->category_name }}" class="img-responsive" width="50" />
								</td>
								<td>					
									{{ Str::words($childrenPost->category_description, 25,'...')  }}						
								</td>
								<td><b>{{ $post->category_name }}</b></td>
								<td>{{ status($childrenPost->category_status) }}</td>				
								<td>
									@permission('event-categories-edit')
									<a href="{{ route('categories.edit',['id' => $childrenPost->id]) }}" class="btn btn-flat btn-info"><i class="fa fa-edit"></i>&nbsp;&nbsp;{{--Edit--}}Modifier</a>
									@endpermission
									@permission('event-categories-delete')
									<a class="btn btn-danger btn-flat" href="{{ route('categories.remove',$childrenPost->id) }}">
									  	<i class="fa fa-trash"></i>&nbsp;&nbsp;{{--Delete--}}Supprimer
								  	</a>
								  	@endpermission
								</td>
							</tr>
						@endforeach
					<?php $i++; ?>
					@endforeach
				</tbody>
				@endif
			</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
