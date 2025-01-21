@inject('userlist','App\Frontuser')

@extends($AdminTheme)
@section('title','Events List')
@section('content-header')
<h1>{{--Events--}}Evénements </h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
  <li class="active">{{--Events --}}Evénements </li>
</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<br>
			<div id="forms-derach" class="box box-primary box-body">
				{!! Form::open(['method'=>'GET','route'=>'event.list']) !!}
					<div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
						<label>{{--User List --}}Liste des Utilisateurs:</label>
						<select class="form-control" name="fuser">
							<option disabled selected="">{{--Select User--}}Sélectionner un utilisateur</option>
							@foreach($userlist->fetchData() as $datsa)
								<option value="{{ $datsa->firstname.' '.$datsa->lastname }}" {{ ( $datsa->firstname.' '.$datsa->lastname == Input::get('fuser')) ? 'selected' : '' }} >{{ $datsa->firstname }} {{ $datsa->lastname }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
						<label> {{--Current/Upcoming --}}Actuel /A venir:</label>
						{!! Form::select('duration',['Current' => 'Current','Upcoming'=>'Upcoming'],Null,['class'=>'form-control','placeholder' => 'Select Items']) !!}
					</div>
					<div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
						<label>Status :</label>
						{!! Form::select('status',['Publish' => 'Publish','Draft' => 'Draft','Ban' => 'Ban'],null,['class'=>'form-control','placeholder' => 'Select Status']) !!}
					</div>
					<div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3 text-center"><br>
						<button class="btn btn-primary btn-flat"> {{--Submit--}}Envoyer</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	<div class="responsive-tabs">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
			<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Events récents</a>
			</li>
			<li role="presentation" class="">
				<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Events</a>
			</li>
		</ul>
		<div id="tabs-content" class="tab-content panel-group">
			<div id="tab1" role="tabpanel" class="tab-pane active panel-collapse collapse in" aria-labelledby="heading1">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">{{--Event List--}}Liste des Events</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						@if($success = Session::get('success'))
							<div class="alert alert-success">{{ $success }}</div>
						@endif
						@if($error = Session::get('error'))
							<div class="alert alert-danger">{{ $error }}</div>
						@endif
						<table id="datatable" class="datatable table table-bordered table-striped ">
							<thead>
							<tr>
								<th>No.</th>
								<th>{{--Name--}}Nom</th>
								<th>{{--User Name--}}Nom d'Utilisateur</th>
								<th>{{--Event Date--}}Date de l'Event</th>
								<th>{{--Price--}}Prix</th>
								<th width="230" class="text-center">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach($recentEvent as $key => $val)
								<tr>
									<td>{{ ++ $key }}</td>
									<td>{{ $val->event_name }}</td>
									<td>{{ $val->fnm }} {{ $val->lnm }}</td>
									<td>{{ $val->event_start_datetime }} à {{$val->event_end_datetime}}</td>
									<td>{{ $val->event_min_price }} à {{ $val->event_max_price }}</td>
									<td class="text-center">
										{{--<a class="btn-flat btn btn-info" href="{{ route('events.view',$val->id) }}"><i class="fa fa-eye"></i> Voir</a>--}}
										<h5 class="text-danger"><i class="fa fa-ban "></i>Désactivé</h5>
										<a href="{{ route('events.accept',$val->id) }}" class="btn-flat btn btn-success">Activer</a>
										@permission('event-view')
										<a class="btn-flat btn btn-info" href="{{ route('events.view',$val->id) }}"><i class="fa fa-eye"></i> Voir</a>
										@endpermission
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="tab2" role="tabpanel" class="tab-pane panel-collapse collapse" aria-labelledby="heading2">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">{{--Event List--}}Liste des Events</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						@if($success = Session::get('success'))
							<div class="alert alert-success">{{ $success }}</div>
						@endif
						@if($error = Session::get('error'))
							<div class="alert alert-danger">{{ $error }}</div>
						@endif
						<table id="datatable" class="datatable table table-bordered table-striped ">
							<thead>
							<tr>
								<th>No.</th>
								<th>{{--Name--}}Nom</th>
								<th>{{--User Name--}}Nom d'Utilisateur</th>
								<th>{{--Event Date--}}Date de l'Event</th>
								<th>{{--Price--}}Prix</th>
								<th width="230" class="text-center">Event Action</th>
								<th class="text-center">Top Event</th>
								<th class="text-center">Immanquables</th>
							</tr>
							</thead>
							<tbody>
							@foreach($data as $key => $val)
								<tr>
									<td>{{ ++ $key }}</td>
									<td>{{ $val->event_name }}</td>
									<td>{{ $val->fnm }} {{ $val->lnm }}</td>
									<td>{{ $val->event_start_datetime }} à {{$val->event_end_datetime}}</td>
									<td>{{ $val->event_min_price }} à {{ $val->event_max_price }}</td>
									<td class="text-center">

										@permission('event-ban-revoke')
										@if($val->ban == 0)
											<h5 class="text-success"><i class="fa fa-check"></i> Activé</h5>
											<a href="{{ route('events.ban',$val->id) }}" class="btn-flat btn btn-danger">{{--<i class="fa fa-ban"></i>--}} {{--Disabled--}}Désactiver</a>
										@else
											<h5 class="text-danger"><i class="fa fa-ban "></i> Désactivé</h5>
											<a href="{{ route('events.revoke',$val->id) }}" class="btn-flat btn btn-success" >{{--<i class="fa  fa-check"></i>--}} {{--Enabled--}}Activer</a>
										@endif
										@endpermission
										@permission('event-view')
										<a class="btn-flat btn btn-info" href="{{ route('events.view',$val->id) }}"><i class="fa fa-eye"></i> Voir</a>
										@endpermission
									</td>
									<td class="text-center">
										@if($val->event_home_status == 0)
											<h5 class="text-danger"><i class="fa fa-ban "></i> Désactivé</h5>
											<a href="{{ route('events.first',$val->id) }}" class="btn-flat btn btn-success">{{--Disabled--}}Activer</a>
										@elseif($val->event_home_status == 1)
											<h5 class="text-success"><i class="fa fa-check"></i> Activé</h5>
											<a href="{{ route('events.nofirst',$val->id) }}" class="btn-flat btn btn-danger">{{--Disabled--}}Désactiver</a>
										@endif
									</td>
									<td class="text-center">
										@if($val->event_immanquable == 0)
											<h5 class="text-danger"><i class="fa fa-ban "></i> Désactivé</h5>
											<a href="{{ route('events.immanquable',$val->id) }}" class="btn-flat btn btn-success">{{--Disabled--}}Activer</a>
										@elseif($val->event_immanquable == 1)
											<h5 class="text-success"><i class="fa fa-check"></i> Activé</h5>
											<a href="{{ route('events.noimmanquable',$val->id) }}" class="btn-flat btn btn-danger">{{--Disabled--}}Désactiver</a>
										@endif
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection