@extends($AdminTheme)

@section('title','Liste des videos')
@section('content-header')
    <h1>Liste des vidéos</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li><a href="#">Liste des vidéos</a></li>
    </ol>
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Liste des vidéos</h3>
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
            @permission('webtv-create')
            <div style="width: 250px; position: absolute;">
                <a href="{{ route('webtv.create') }}" class="btn btn-primary btn-flat">Ajouter une Video <i class="fa fa-plus"></i></a>
            </div>
            @endpermission
            <div class="table-responsive">
                <table id="datatable" class="datatable table table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Titre</th>
                        <th>{{--Poster--}}Affiche</th>
                        <th>Lien Video</th>
                        <th class="text-center">Status</th>
                        @permission('front-user-view')
                        <th class="text-center">Action</th>
                        @endpermission
                    </tr>
                    </thead>
                    @if(!empty($webtv))
                        <tbody style="text-align: center;">
                        @foreach($webtv as $key => $post)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $post->titre }}</td>
                                <td><img src="{{ $post->lien_poster }}" style="width: 30%;"></td>
                                <td>{{ $post->lien_video }}</td>
                                <td class="text-center" >
                                    @if($post->status == 0)
                                        <span class="" style="background-color: red"> Inactif </span>
                                    @else
                                        <span class="" style="background-color: forestgreen"> Actif </span>
                                    @endif

                                </td>
                                <td class="text-center">
                                    @permission('webtv-edit')
                                    <a href="{{ route('webtv.edit',$post->id) }}" class="btn btn-flat btn-info"><i class="fa fa-eye"></i> Modifier </a>
                                    @endpermission
                                    @permission('webtv-delete')
                                    <a href="{{ route('webtv.delete',$post->id) }}" class="btn btn-danger btn-flat" onclick=" return confirm('are you sure ?')">{{--Delete--}} Supprimer <i class="fa fa-trash"></i></a>
                                    @endpermission
                                </td>
                            </tr>
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


