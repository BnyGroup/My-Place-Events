@extends($AdminTheme)

@section('title','Sliders List')

@section('content-header')
    <h1>Sliders List</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">{{--Sliders List--}}Liste des Slides</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{--Sliders List--}}Liste des Slides</h3>
        </div>
        <div class="box-body">
            @if($success = Session::get('success'))
                <div class="alert alert-success">{{ $success }}</div>
            @endif
            @permission('slider-create')
            <div style="width: 250px; position: absolute;">
                <a href="{{ route('sliders.create') }}" class="btn btn-primary btn-flat">{{--Create Slider --}}Créer un Slide&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
            </div>
            @endpermission
            <div class="table-responsive">
                <table id="datatable" class="datatable table table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th width="100px">No.</th>
                        <th>Image</th>
                        <th>{{--Title--}}Titre</th>
                        <th>Description</th>
                        <th>{{--Button Text--}}Text du Bouton</th>
                        <th>{{--Button Url--}}Url du Bouton</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sliders as $key => $val)
                        <tr>
                            <td>{{ ++ $key }}</td>
                            <td>
                                <img src="{{ url($val->slide_img) }}" alt="{{ $val->slide_title }}" class="img-responsive" width="50" />
                            </td>
                            <td>{{ $val->slide_title }}</td>
                            <td>{{ $val->slide_desc }}</td>
                            <td>{{ $val->slide_text_btn }}</td>
                            <td>{{ $val->slide_btn_url }}</td>
                            <td>
                                @if($val->slide_status)
                                    <span style="background-color: forestgreen;border-radius: 3px;color: white; padding: 5px;vertical-align:middle;">Activé</span>
                                @else
                                    <span style="background-color: red;border-radius: 3px;color: white; padding: 5px;vertical-align:middle;">Desactivé</span>
                                @endif
                            </td>
                            <td>
                                @permission('slider-edit')
                                <a href="{{ route('sliders.edit',$val->id) }}" class="btn btn-info btn-flat">{{--Edit--}}Modifier <i class="fa fa-edit"></i></a>
                                @endpermission
                                @permission('slider-delete')
                                @if($val->id != 0)
                                    <a href="{{ route('sliders.remove',$val->id) }}" class="btn btn-danger btn-flat" onclick=" return confirm(/*'are you sure ?'*/'Etes vous sûr ?')" >{{--Delete--}}Supprimer <i class="fa fa-trash"></i></a>
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