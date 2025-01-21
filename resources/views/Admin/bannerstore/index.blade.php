@extends($AdminTheme)
@section('title','Bannières du Store')
@section('content-header')
<h1>Liste des Bannières du Store</h1>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Gestion des Bannières du Store</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		@if($success = Session::get('success'))
		<div class="alert alert-success">{{ $success }}</div>
		@endif
		@permission('admin-user-cerate')
			<div style="width: auto;position: absolute;right: 12px;top: 10px;">
				<a href="javascript:void(0)" class="btn btn-primary btn-flat addbanner">Ajouter&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
			</div>
		@endpermission
		<div class="table-responsive">
			<table class="table table-bordered table-striped ">
				<thead>
					<tr>
						<th>No.</th>
						<th>Image</th>
						<th>Titre</th>
						<th>Description</th>
						<th>Position</th>
						<th>Status</th>
						<th width="250px">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $key => $val)
					<tr>
						<td>{{ ++ $key }}</td>
						<td> <?php $imThumb= getImage($val->image, 'thumb'); $im= getImage($val->image); ?>
						<a href="{{ $im }}" target="_blank"><img src="{{ $imThumb }}" style="height:75px"></a></td>
						<td><?php if(empty($val->title)){ echo"Bannière ".$key; }else{ echo $val->title; } ?></td>
						<td>{{ $val->description }}</td>
						<td>{{ $val->position }}</td>
						<td>
							<?php 
    							if($val->statut == 1){
    							  echo"Actif";
    							}else{
    							  echo"Inactif";
    							}
							?>
						</td>
						<td>
							@permission('admin-user-edit')
								<a href="javascript:void(0)" class="btn btn-info btn-flat editme" data-idb="{{ $val->idb }}">Editer <i class="fa fa-edit"></i></a>
							@endpermission
						 
							@permission('admin-user-delete')
								@if($val->id != 1)
									<a href="{{ route('admin.banner.store.delete',$val->id) }}" class="btn btn-danger btn-flat" onclick=" return confirm('Êtes-vous sûr de vouloir supprimer cette bannière ?')">Supprimer <i class="fa fa-trash"></i></a>
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



<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="BannerModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="{{ route('admin.banner.store.add') }}" method="POST" enctype="multipart/form-data">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une bannière</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Titre:</label>
            <input type="text" class="form-control" id="titre" name="titre">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Image:</label>
            <input type="file" class="form-control" name="image" required>
          </div>
           <div class="form-group">
            <label for="message-text" class="col-form-label">Position:</label>
            <select name="position" class="form-control" required style="height: auto;">
                <option value="">Sélectionnez une position</option>
                <option value="m">Slider Principal</option>
                <option value="r1">Droite 1</option>
                <option value="r2">Droite 2</option>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Url:</label>
            <input type="text" class="form-control" id="url" name="url" required>
          </div>
           <div class="form-group">
            <label for="message-text" class="col-form-label">Statut:</label>
            <select name="statut" class="form-control" required style="height: auto;">
                 <option value="">Sélectionnez le statut</option>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div> 
      </form>
    </div>
  </div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="EditBannerModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="{{ route('admin.banner.store.edit') }}" method="POST" enctype="multipart/form-data">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
     <input type="hidden" name="idb" id="idb" value="">
      <div class="modal-header">
        <h5 class="modal-title">Editer une bannière</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Titre:</label>
            <input type="text" class="form-control" id="titre2" name="titre">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description:</label>
            <textarea class="form-control" id="description2" name="description"></textarea>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Image:</label>
            <input type="file" class="form-control" name="image">
            <img src="" id="imgs" style="height:150px; margin: 15px 0">
          </div>
           <div class="form-group">
            <label for="message-text" class="col-form-label">Position:</label>
            <select name="position" id="position" class="form-control" required style="height: auto;">
                <option value="">Sélectionnez une position</option>
                <option value="m">Slider Principal</option>
                <option value="r1">Droite 1</option>
                <option value="r2">Droite 2</option>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Url:</label>
            <input type="text" class="form-control" id="url2" name="url" required>
          </div>
           <div class="form-group">
            <label for="message-text" class="col-form-label">Statut:</label>
            <select name="statut" id="statut" class="form-control" required style="height: auto;">
                <option value="">Sélectionnez le statut</option>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div> 
      </form>
    </div>
  </div>
</div>


@endsection


@section('page-level-script')



<style>
    
body {
    font-family: 'Quicksand', sans-serif !important;
    font-width: 400 !important;
    font-size: 14px !important;
}    
.navbar {
       display: block !important; 
}
.btn, .form-control{
    font-size:14px !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
      
      $(document).ready(function () {
    /* When click show user */
    $('body').on('click', '.editme', function () {
        var idb = $(this).data('idb');
        var userURL = "https://myplace-events.com/fr/ub7qfzTBzX8JXdr8V4kV7sq/banner-immanquables/getdatas?idb=" + idb;
       
        $.get(userURL, function (data) {
            console.log(data.description);
            $('#EditBannerModal').modal('show');
            $('#idb').val(data.idb);
            $('#titre2').val(data.title);
            $('#imgs').attr("src", data.imgs);
            $('#description2').val(data.description);
            $('#url2').val(data.url);

            // Mettez à jour la sélection du statut à l'intérieur de cette fonction
            var statut = data.statut;
            $('#statut option').each(function () {
                if (this.value == statut) {
                    this.selected = true;
                }
            });
        });
    });
});
  
</script>

<script>
    $('.addbanner').on('click', function(){
        $("#BannerModal").modal(); 
    })
</script>

@endsection
