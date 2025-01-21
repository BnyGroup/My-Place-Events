@extends('wallet.layout')

@section('page.title', 'Connexion')

@section('page.content')
    @includeWhen(session('loading', false), 'wallet.section.loading')
    @include('wallet.section.header')
    <div class="formBlock">
        <form role="form" autocomplete="off" action="{{ route('wallet.login') }}" method="post" id="login-form" class="login-form">
            <h1>Connexion</h1>
            @if ($errors->has('email'))
            <p style="color:red;">{{ $errors->first('email') }}</p>
            @else
            <p>Veuillez vous connecter</p>
            @endif
            <div class="form-group">
                <input type="email" name="email" value="{{ old('email', '') }}" placeholder="Email" class="form-password form-control" id="form-email" autocomplete="off">
            </div>
            <div class="form-group">
                <input autocomplete="false" type="password" name="password" placeholder="Mot de passe" class="form-password form-control" id="form-password">
            </div>
            <button type="submit" class="btn btn-connecte">Connexion</button>
            {{ csrf_field() }}
        </form>
    </div>
@endsection

@push('page.scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script>
        jQuery("#login-form").validate({rules:{email:{required:!0,email:!0},password:{required:!0}},messages:{email:{required:"@lang('validation.required', ['attribute' => 'email'])",email:"@lang('validation.email', ['attribute' => 'email'])"},password:{required:"@lang('validation.required', ['attribute' => 'mot de passe'])"}}});
    </script>
@endpush