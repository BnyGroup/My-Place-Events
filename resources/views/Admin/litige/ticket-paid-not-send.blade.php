@inject('userlist','App\Frontuser')

@extends($AdminTheme)
@section('title','A la Une')
@section('content-header')
    <h1>Mise à la une </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">Litige</li>
    </ol>
@endsection

@section('content')

    {{--<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <br>
            <div id="forms-derach" class="box box-primary box-body">
                {!! Form::open(['method'=>'GET','route'=>'event.list']) !!}
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label>User List :</label>
                    <select class="form-control" name="fuser">
                        <option disabled selected="">Select User</option>
                        @foreach($userlist->fetchData() as $datsa)
                            <option value="{{ $datsa->firstname.' '.$datsa->lastname }}" {{ ( $datsa->firstname.' '.$datsa->lastname == Input::get('fuser')) ? 'selected' : '' }} >{{ $datsa->firstname }} {{ $datsa->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label> Current/Upcoming :</label>
                    {!! Form::select('duration',['Current' => 'Current','Upcoming'=>'Upcoming'],Null,['class'=>'form-control','placeholder' => 'Select Items']) !!}
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label>Status :</label>
                    {!! Form::select('status',['Publish' => 'Publish','Draft' => 'Draft','Ban' => 'Ban'],null,['class'=>'form-control','placeholder' => 'Select Status']) !!}
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3 text-center"><br>
                    <button class="btn btn-primary btn-flat"> Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>--}}

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Cas litigieux</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if($success = Session::get('success'))
                <div class="alert alert-success">{{ $success }}</div>
            @endif
            @if($error = Session::get('error'))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            @if($info = Session::get('info'))
                <div class="alert alert-info">{{ $info }}</div>
            @endif
            {!! Form::open(array('route' => 'litige.send', 'method' => 'POST', 'id' => 'litige')) !!}
            <div class="col-sm-8">
                <div class="row">
                    <label class="col-sm-4">
                        Identifiant de la transaction
                    </label>
                    <div class="col-sm-4 form-control">
                        <input type="text" name="order_id" placeholder="Identifiant de la transaction">
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" value="Envoyer le ticket">
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <p>------------ OU -------------</p>
        {{-- Resolution par adresse mail --}}
        <div class="box-body">
            @if($success = Session::get('success'))
                <div class="alert alert-success">{{ $success }}</div>
            @endif
            @if($error = Session::get('error'))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            @if($info = Session::get('info'))
                <div class="alert alert-info">{{ $info }}</div>
            @endif
            {!! Form::open(array('route' => 'litige.byEmail.send', 'method' => 'POST', 'id' => 'litige-by-email')) !!}
            <div class="col-sm-8">
                <div class="row">
                    <label class="col-sm-4">
                        Adresse mail
                    </label>
                    <div class="col-sm-4 form-control">
                        <input type="email" name="ot_email" placeholder="Adresse mail de la transaction">
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" value="Envoyer le ticket">
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>

        {{--{{ dd(session('litige')) }}--}}
    </div>
@endsection