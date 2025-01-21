@extends($AdminTheme)

@section('title','Admin')

@section('content-header')

<h1>{{--User Profile--}}Profil Utilisateur </h1>

<ol class="breadcrumb">

  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>

  <li><a href="#">Examples</a></li>

  <li class="active">{{--User Profile --}}Profil Utilisateur</li>

</ol>

@endsection



@section('content')

<div class="row">

  <div class="col-md-3">

    <!-- Profile Image -->

    <div class="box box-primary">

        <div class="box-header with-border">

        <h3 class="box-title">{{--User Login Details--}}Détails de connexion utilisateur</h3>

      </div>  
      <div class="box-body box-profile">

        <img class="profile-user-img img-responsive img-circle" src="{{ setThumbnail(auth()->user()->profile_pic) }}" alt="User profile picture" style="height: 100px;">

        <h3 class="profile-username text-center">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h3>

        @if(auth()->user()->admin_type == 0)

        <p class="text-muted text-center">{{--Master Admin--}}Admin Principal</p>

        @else

        <p class="text-muted text-center">{{--Sub Admin--}}Second Admin</p>

        @endif

        <ul class="list-group list-group-unbordered">

          <li class="list-group-item">

            <b>Nom d'Utilisateur</b> <span class="pull-right">{{ auth()->user()->username }}</span>

          </li>

          <li class="list-group-item">

            <b>{{--User Email--}}Email Utilisateur</b> <span class="pull-right">{{ auth()->user()->email }}</span>

          </li>

          <li class="list-group-item">

            <b>{{--Last Login--}}Dernier Login</b> <span class="pull-right">{{ auth()->user()->last_login }}</span>

          </li>

        </ul>

        

      </div>

      <!-- /.box-body -->

    </div>

    <!-- /.box -->

  </div>

  <!-- /.col -->

  <div class="col-md-5">

    <div class="box box-primary">

      <div class="box-header with-border">

        <h3 class="box-title">{{--User Personal Details--}}Informations personnelles de l'utilisateur</h3>

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

        {!! Form::open(['method'=>'post','route'=>['user.post','id'=>auth()->user()->id], 'class'=>'form-horizontal','files'=>'true']) !!}

        <div class="form-group">

          <label for="inputName" class="col-sm-3 control-label">{{--First Name--}}Nom</label>

          <div class="col-sm-9">

            {!! Form::text('firstname', auth()->user()->firstname,['class'=>'form-control','placeholder'=>'First Name' ,'autofocus','id'=>'firstname']) !!}

             @if ($errors->has('firstname'))<span class="help-block"><strong><font color="red">{{ $errors->first('firstname') }}</font></strong></span>@endif

          </div>

        </div>

        <div class="form-group">

          <label for="inputName" class="col-sm-3 control-label">{{--Last Name--}}Prénoms</label>

          <div class="col-sm-9">

            {!! Form::text('lastname', auth()->user()->lastname,['class'=>'form-control','placeholder'=>'Last Name' ,'autofocus','id'=>'lastname']) !!}

            @if ($errors->has('lastname'))<span class="help-block"><strong><font color="red">{{ $errors->first('lastname') }}</font></strong></span>@endif

          </div>

        </div>

        <div class="form-group">

          <label for="inputEmail" class="col-sm-3 control-label">Image</label>

            <div class="col-sm-9">

              {!! Form::hidden('old_image',auth()->user()->profile_pic) !!}

              {!! Form::file('image',['class'=>'form-control']) !!}

              @if ($errors->has('image'))<span class="help-block"><strong><font color="red">{{ $errors->first('image') }}</font></strong></span>@endif

            </div>

        </div>

        <div class="form-group">

          <label for="inputEmail" class="col-sm-3 control-label">{{--Gender--}}Genre</label>

          <div class="col-sm-9">

            <label>

              {{ Form::radio('gender', '0', (auth()->user()->gender == '0'), ['class'=>'minimal']) }} {{--Male--}}Homme

            </label>

            &nbsp;&nbsp;&nbsp;

            <label>

              {{ Form::radio('gender', '1', (auth()->user()->gender == '1'), ['class'=>'minimal']) }} Femme

            </label>

          </div>

        </div>

        <div class="form-group">

          <div class="col-sm-offset-3 col-sm-9">

            {{ Form::submit('Update Profile', ['class'=>'btn btn-primary btn-flat']) }}

          </div>

        </div>

        {!! Form::close() !!}

      </div>

    </div>

  </div>

  <!-- /.col -->
@permission('change-password-box')
  <div class="col-md-4">

    <div class="box box-primary">

      <div class="box-header with-border">

        <h3 class="box-title">{{--User Password Details--}}Détails du mot de passe utilisateur</h3>

      </div>

      <div class="box-body">

        @if($error = Session::get('error_pass'))

              <div class="alert alert-danger">

                  {{ $error }}

              </div>

          @elseif($success = Session::get('success_pass'))

          <div class="alert alert-success">

                  {{ $success }}

              </div>

          @endif

        {!! Form::open(['method'=>'post','route'=>['user.password','id' => auth()->user()->id ], 'class'=>'form-horizontal']) !!}

        <div class="form-group">

          <label for="inputName" class="col-sm-4 control-label">{{--Old Password--}}Ancien mot de passe</label>

          <div class="col-sm-8">

            {!! Form::password('old_password', ['class'=>'form-control','placeholder'=>'Old Password' ,'autofocus','id'=>'old_password']) !!}

            @if ($errors->has('old_password'))<span class="help-block"><strong><font color="red">{{ $errors->first('old_password') }}</font></strong></span>@endif

          </div>

        </div>

        <div class="form-group">

          <label for="inputName" class="col-sm-4 control-label">{{--New Password--}}Nouveau de mot de passe</label>

          <div class="col-sm-8">

            {!! Form::password('password', ['class'=>'form-control','placeholder'=>'New Password' ,'autofocus','id'=>'password']) !!}

            @if ($errors->has('password'))<span class="help-block"><strong><font color="red">{{ $errors->first('password') }}</font></strong></span>@endif

          </div>

        </div>

         <div class="form-group">

          <label for="inputName" class="col-sm-4 control-label">{{--Re-Enter Password--}}Ressaisir le Mot de Passe</label>

          <div class="col-sm-8">

            {!! Form::password('reenter_password', ['class'=>'form-control','placeholder'=>'Re-Enter Password' ,'autofocus','id'=>'reenter_password']) !!}

            @if ($errors->has('reenter_password'))<span class="help-block"><strong><font color="red">{{ $errors->first('reenter_password') }}</font></strong></span>@endif

          </div>

        </div>

       

        <div class="form-group">

          <div class="col-sm-offset-4 col-sm-10">

            {{ Form::submit('Update Password', ['class'=>'btn btn-primary btn-flat']) }}

          </div>

        </div>

        {!! Form::close() !!}

      </div>

    </div>

  </div>
@endpermission
  <!-- /.col -->

</div>

@endsection