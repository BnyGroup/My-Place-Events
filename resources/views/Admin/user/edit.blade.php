@extends($AdminTheme)

@section('title','Create User')

@section('content-header')
<h1>{{--Edit User--}}Modifier Utilisateur</h1>
	<ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
	  <li class="active">{{--Edit User--}}Modifier Utilisateur</li>
	</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">{{--Edit User--}}Modifier Utilisateur</h3>
			</div>
			<div class="box-body">
				{!! Form::model($data,['method'=>'patch','route'=>['users.update',$data->id], 'class'=>'form-horizontal']) !!}
				<div class="box-body">
				<div class="form-group">
					<label for="firstname" class="col-sm-3 control-label">{{--First Name--}}Nom </label>
					<div class="col-sm-9">
						{!! Form::text('firstname',$data->firstname,['class'=>'form-control','placeholder'=>'First Name' ,'autofocus','id'=>'firstname']) !!}
						@if ($errors->has('firstname'))<span class="help-block"><strong><font color="red">{{ $errors->first('firstname') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="lastname" class="col-sm-3 control-label">{{--Last Name--}}Prénoms</label>
					<div class="col-sm-9">
						{!! Form::text('lastname',$data->lastname,['class'=>'form-control','placeholder'=>'Last Name' ,'autofocus','id'=>'lastname']) !!}
						@if ($errors->has('lastname'))<span class="help-block"><strong><font color="red">{{ $errors->first('lastname') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="brith_date" class="col-sm-3 control-label">{{--Brith Date--}}Date de naissance</label>
					<div class="col-sm-9">
						{!! Form::text('brith_date',$data->brith_date,['class'=>'form-control datepicker','placeholder'=>'Brith Date' ,'autofocus','id'=>'brith_date','readonly']) !!}
						@if ($errors->has('brith_date'))<span class="help-block"><strong><font color="red">{{ $errors->first('brith_date') }}</font></strong></span>@endif
					</div>
				</div>
				<div class="form-group">
					<label for="role_id" class="col-sm-3 control-label">{{--Admin Type--}}Type Admin</label>
					<div class="col-sm-9">
						{!! Form::select('role_id',[''=>'Select Role']+$listrole,$roleslists->role_id,['class' => 'form-control','selected']) !!}
						@if ($errors->has('role_id'))<span class="help-block"><strong><font color="red">{{ $errors->first('role_id') }}</font></strong></span>@endif
					</div>
				</div>
			 	<div class="form-group">
		          	<label for="inputEmail" class="col-sm-3 control-label">{{--Gender--}}Genre</label>
			          <div class="col-sm-9">
				            <label>
				              {{ Form::radio('gender', '0',true,['class'=>'minimal']) }} {{--Male--}}Masculin
				            </label>
			            		&nbsp;&nbsp;&nbsp;
				            <label>
				              {{ Form::radio('gender', '1',false,['class'=>'minimal']) }} {{--Female--}}Feminin
				            </label>
			          </div>
		        </div>
		        <div class="form-group">
		          	<label for="inputEmail" class="col-sm-3 control-label">Status</label>
			          <div class="col-sm-9">
				            <label>
				              {{ Form::radio('status', '1',true,['class'=>'minimal']) }} {{--Active--}}Active
				            </label>
			            		&nbsp;&nbsp;&nbsp;
				            <label>
				              {{ Form::radio('status', '0',false,['class'=>'minimal']) }} {{--DisActive--}}Désactiver
				            </label>
			          </div>
		        </div>
		        <div class="form-group">
					<label for="username" class="col-sm-3 control-label">{{--Username--}}Nom d'utilisateur</label>
					<div class="col-sm-9">
						{!! Form::text('username',$data->username,['class'=>'form-control','placeholder'=>'Enter Email' ,'autofocus','id'=>'username','readonly'=>'true']) !!}
						@if ($errors->has('email'))<span class="help-block"><strong><font color="red">{{ $errors->first('email') }}</font></strong></span>@endif
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-10 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Solde Portefeuille :<b> {{ number_format($data->balance , 0,'.', ' ') }} F CFA</b></h3>
			</div>
			<div class="box-body">

				<form action="{{ route('addOrSubstractMoneyToUserWallet', ['user' => $data->id]) }}" method="POST" id="addAmountForm" style="margin-top: 2rem;">
					{{ csrf_field() }}
					<div class="form-group row">
						<label class="col-lg-2 col-form-label"><span class="text-danger">*</span> Montant </label>
						<div class="col-lg-7">
							<input type="number" class="form-control form-control-lg balance" name="add_amount" placeholder="Ajouter ou retirer un montant" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label"><span class="text-danger">*</span> Motif:</label>
						<div class="col-lg-7">
							<input type="text" class="form-control form-control-lg" name="add_amount_description" placeholder="Motif de la transaction" required>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						</div>
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<button type="submit" class="btn btn-danger" name="withdraw" value="withdraw">
								Débiter le Compte
								<i class="icon-database-insert ml-1"></i>
							</button>
						</div>

						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<button type="submit" class="btn btn-success" name="deposit" value="deposit">
								Créditer le Compte
								<i class="icon-database-insert ml-1"></i>
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Liste des 5 dernières Transactions </h3>
			</div>
			<div class="box-body">
				@if(count($data->transactions) > 0)
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									Transaction ID
								</th>
								<th>
									Type
								</th>
								<th>
									Montant
								</th>
								<th>
									Description
								</th>
								<th>
									Initiateur
								</th>
								<th>
									Date
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($transactions as $transaction)
							<tr>
								<td style="font-size:1.1rem">
									{{ $transaction->uuid }}
								</td>
								<td style="font-size:1.2rem">
									@if($transaction->type === "deposit")
									<span class="badge badge-flat border-grey-800 text-default text-capitalize">{{$transaction->type}}</span>
									@else
									<span class="badge badge-flat border-grey-800 text-danger text-capitalize">{{$transaction->type}}</span>
									@endif
								</td>
								<td class="text-right" style="font-size:1.2rem">
									{{ number_format($transaction->amount, 0,'.', ' ') }}
								</td>
								<td style="font-size:1.2rem">
									{{ $transaction->meta["description"] }}
								</td>
								<td style="font-size:1.2rem">
									{{ $transaction->meta["author"] }}
								</td>
								<td class="small" style="font-size:1.2rem">
									{{ ucwords(Jenssegers\Date\Date::parse($transaction->created_at)->format('l j F Y H:i'))}}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				@else
				<p class="text-center" colspan="4">Pas de transactions ! </p>
				@endif
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Liste des 5 derniers rechargements créditeurs </h3>
			</div>
			<div class="box-body">
				@if(count($deposits))
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									Transaction ID
								</th>
								<th>
									Montant
								</th>
								<th>
									Date
								</th>
								<th>
									Email utilisateur
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($deposits as $d)
							<tr>
								<td style="font-size:1.1rem">
									{{ $d->deposit->uuid }}
								</td>
								<td class="text-right" style="font-size:1.2rem">
									{{ number_format($d->deposit->amount, 0,'.', ' ') }}
								</td>
								<td class="small" style="font-size:1.2rem">
									{{ ucwords(Jenssegers\Date\Date::parse($d->created_at)->format('l j F Y H:i'))}}
								</td>
								<td style="font-size:1.2rem">
									{{ $d->to->email }}
								</td>
							</tr>
							@endforeach
							<tr style="background-color:#fdaf0a;">
								<td class="text-right" style="font-size:1.1rem">
									<b>TOTAL</b>
								</td>
								<td class="text-right" style="font-size:1.2rem">
									<b>{{ number_format($total->deposits, 0,'.', ' ') }}</b>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				@else
				<p class="text-center" colspan="4">Pas de rechargement ! </p>
				@endif
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Liste des 5 derniers rechargements débiteurs </h3>
			</div>
			<div class="box-body">
				@if(count($withdraws))
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									Transaction ID
								</th>
								<th>
									Montant
								</th>
								<th>
									Date
								</th>
								<th>
									Email utilisateur
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($withdraws as $w)
							<tr>
								<td style="font-size:1.1rem">
									{{ $w->withdraw->uuid }}
								</td>
								<td class="text-right" style="font-size:1.2rem">
									{{ number_format($w->withdraw->amount, 0,'.', ' ') }}
								</td>
								<td class="small" style="font-size:1.2rem">
									{{ ucwords(Jenssegers\Date\Date::parse($w->created_at)->format('l j F Y H:i'))}}
								</td>
								<td style="font-size:1.2rem">
									{{ $w->to->email }}
								</td>
							</tr>
							@endforeach
							<tr style="background-color:#fdaf0a;">
								<td class="text-right" style="font-size:1.1rem">
									<b>TOTAL</b>
								</td>
								<td class="text-right" style="font-size:1.2rem">
									<b>{{ number_format($total->withdraws, 0,'.', ' ') }}</b>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				@else
				<p class="text-center" colspan="4">Pas de rechargement ! </p>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection