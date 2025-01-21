@extends($AdminTheme)

@section('title',/*'Service List'*/'Liste des Services')

@section('content-header')
    <h1>{{--Service List--}}Liste des Services</h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">{{--Service List--}}Liste des Services</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{--Service List--}}Liste des Services</h3>
        </div>
        <div class="box-body">
            @if($success = Session::get('success'))
                <div class="alert alert-success">{{ $success }}</div>
            @endif
            @permission('service-create')
            <div style="width: 250px; position: absolute;">
                <a href="{{ route('service.create') }}" class="btn btn-primary btn-flat">{{--Create Service --}}Créer un service&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
            </div>
            @endpermission
            <div class="table-responsive">
                <table id="datatable" class="datatable table table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th width="100px">No.</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1 @endphp
                    @foreach($service as $key => $val)
                        <tr>
                            <td>{{ $i}}</td>
                            <td>
                                <img src="{{ setThumbnail($val->service_icon) }}" alt="{{ $val->service_icon}}" class="img-responsive" width="50" />
                            </td>
                            <td>{{ $val->service_title}}</td>
                            <td>{{ $val->service_description}}</td>
                            <td>
                                @if($val->service_status)
                                    <span style="background-color: forestgreen;border-radius: 3px;color: white; padding: 5px;vertical-align:middle;">Activé</span>
                                @else
                                    <span style="background-color: red;border-radius: 3px;color: white; padding: 5px;vertical-align:middle;">Desactivé</span>
                                @endif
                            </td>
                            <td>
                                @permission('service-edit')
                                <a href="{{ route('service.edit',$val->id) }}" class="btn btn-info btn-flat">{{--Edit--}}Modifier <i class="fa fa-edit"></i></a>
                                @endpermission
                                @permission('service-delete')
                                @if($val->id != 0)
                                    <a href="{{ route('service.remove',$val->id) }}" class="btn btn-danger btn-flat" onclick=" return confirm('are you sure ?')" >{{--Delete--}}Supprimer <i class="fa fa-trash"></i></a>
                                @endif
                                @endpermission
                            </td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
@endsection