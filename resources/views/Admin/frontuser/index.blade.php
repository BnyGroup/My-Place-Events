@extends($AdminTheme)

@section('title','Frontuser List')
@section('content-header')
<h1>Liste des utilisateurs</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
	<li><a href="#"> Liste des utilisateurs</a></li>
</ol>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Liste des utilisateurs</h3>
	</div>
 
	 	
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
		<ul class="nav nav-tabs">
			<li class="active"><a href="{{ route('frontuser.index') }}">Utilisateurs inscrits</a></li>
			<li><a href="{{ route('frontuser.invites') }}">Utilisateurs invités</a></li>
		</ul>
		
		<div  class="baruser"><a href="{{ route('frontuser.exportfrontusersnewsletter') }}">Exporter pour la newsletter</a> &nbsp; | &nbsp; <a href="{{ route('frontuser.exportfrontusers') }}">Exporter liste des Inscrits</a></div>
<style>
	.baruser{
		position:absolute;right: 30px;top: 55px;
	}	
	
@media only screen and (max-width: 480px) {
	.baruser{
		position:unset !important; right: unset !important;top: unset !important;
		padding: 15px 0px;
		
	}	
}
</style>
		<div class="tab-content">
			<div id="success" class="tab-pane fade in active">
			 
				<table id="AllempTable" class="AllempTable table table-bordered table-striped ">
					<thead>
					<tr>
						<th>No</th>
						<th>Photo de Profil</th>
						<th>Nom Complet</th>
						<th>Email</th>
						<th>Téléphone</th>
						<th>Pays/Ville</th>
						<th class="text-center">Date</th>
						<th class="text-center">Newsletter</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
					</thead>
					 
				</table>
				 
			</div>
		</div>
	</td>
	</div>
	<!-- /.box-body -->
</div>
</div>
<!-- /.box -->
@endsection

	

@section('page-level-script')

<script type="text/javascript"> 
     $(document).ready(function(){

         // DataTable
        $('#AllempTable').DataTable({
             processing: true,
             serverSide: true,
			 pageLength: 30,
             ajax: "{{route('frontuser.getfrontusers')}}",
             columns: [
                 { data: 'key' },
                 { data: 'image' },
                 { data: 'firstname' },
                 { data: 'email' },
                 { data: 'cellphone' },
                 { data: 'country' },
                 { data: 'Date' },
                 { data: 'newsletter' },
                 { data: 'status' },
                 { data: 'action' },				 
             ]
         });

      });
</script>


@endsection
	
