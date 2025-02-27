<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{--Admin Login --}}Connexion administrateur</title>
        
        @include('AdminTheme.css')

        <!-- iCheck -->        
        <link rel="stylesheet" href="{{ asset('/AdminTheme/plugins/iCheck/square/blue.css')}}">
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}" target="_blank">
            <img src="{{ for_logo() }}">
        </a>
        <a href="{{ route('login') }}"><b>{{ forcompany() }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Connectez-vous pour commencer votre session</p>
            @if($error = Session::get('error'))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @elseif($success = Session::get('success'))
            <div class="alert alert-success">
                    {{ $success }}
                </div>
            @endif
         {!! Form::open(['method'=>'post','route'=>'login.post','autocomplete'=>'off']) !!}
            <div class="form-group has-feedback">                
                <input type="email" name="email" class="form-control" placeholder="Email">
                <!-- {!! Form::email('email',Input::get('email'),['class'=>'form-control','placeholder'=>'Email' ,'autofocus','id'=>'inputEmail']) !!} -->
                 @if ($errors->has('email'))<span class="help-block"><strong><font color="red">{{ $errors->first('email') }}</font></strong></span>@endif
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">                
                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                <!-- {!! Form::password('password',['class'=>'form-control','placeholder'=>/*'Password'*/'Mot de passe' ,'autofocus','id'=>'inputPassword']) !!} -->
                @if ($errors->has('password'))<span class="help-block"><strong><font color="red">{{ $errors->first('password') }}</font></strong></span>@endif
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>                            
                            <a href="{{ route('password.form')}}">Mot de passe oublié</a>
                            <!-- <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me -->
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    {!! Form::submit('Connexion',['class'=>'btn btn-primary btn-block btn-flat cool-btn-purple']) !!}
                </div>
                <!-- /.col -->
            </div>
         {!! Form::close() !!}
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
        <!-- /.login-box -->
        @include('AdminTheme.script')
        <!-- iCheck -->        
        <script src="{{ asset('/AdminTheme/plugins/iCheck/icheck.min.js') }}"></script>
        <script>
          $(function () {
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' /* optional */
            });
          });
        </script>
        <input type="hidden" id="refreshed" value="no">
        <script type="text/javascript">
                onload=function(){
                var e=document.getElementById("refreshed");
                if(e.value=="no")e.value="yes";
                else{e.value="no";location.reload();}
                }
        </script>
    </body>
</html>