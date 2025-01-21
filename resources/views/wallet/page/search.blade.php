@extends('wallet.layout')

@section('page.title', 'Recherche de compte')

@section('page.content')
@include('wallet.section.header')
<div class="formBlock">
    <form role="form" autocomplete="off" name="serch" method="post" id="search-form" class="search-form">
        <h1>Informations Client</h1>
        <p>Vérifions la validité du client</p>
        <div class="form-group">
            <input autocomplete="off" type="text" name="lastname" value="{{ old('lastname', '') }}" placeholder="Nom" class="form-lastname form-control" id="form-lastname">
        </div>
        <div class="form-group">
            <input type="email" name="email" value="{{ old('email', '') }}" placeholder="Email" class="form-password form-control" id="form-email" autocomplete="off">
            @if ($errors->has('email'))<span class="error">{{ $errors->first('email') }}</span>@endif
        </div>
        <div class="form-group">
            <input autocomplete="off" type="text" name="cellphone" value="{{ old('cellphone', '') }}" placeholder="Numéro de téléphone" class="form-cellphone form-control" id="form-cellphone">
            @if ($errors->has('cellphone'))<span class="error">{{ $errors->first('cellphone') }}</span>@endif
        </div>
        <button type="submit" class="btn btn-connecte">Vérifier le compte</button>
        {{ csrf_field() }}
    </form>
    <div class="paginantion"><span class="pagin first active"><a href="javascript:history.back()">.</a></span><span class="pagin second active"></span><span class="pagin third"></span></div>
</div>
@endsection

@push('page.scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script>
    jQuery("#search-form").validate({rules:{lastname:{required:!0},email:{required:!0,email:!0},cellphone:{required:!0,digits:!0}},messages:{lastname:{required:"@lang('validation.required', ['attribute' => 'nom'])"},email:{required:"@lang('validation.required', ['attribute' => 'email'])",email:"@lang('validation.email', ['attribute' => 'email'])"},cellphone:{required:"@lang('validation.required', ['attribute' => 'numéro de téléphone'])",digits:"@lang('validation.numeric', ['attribute' => 'numéro de téléphone'])"}}});
</script>
@endpush