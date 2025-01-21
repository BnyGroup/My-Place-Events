@extends('wallet.layout')

@section('page.title', 'Recharger un compte')

@section('page.content')
@includeWhen(session()->has('success') && session('success'), 'wallet.section.success')
@includeWhen(session()->has('success') && !session('success'), 'wallet.section.fail')
@include('wallet.section.header')
<div class="formBlock">
    <div class="AccountBlock">
        <div class="Userpic">
            <img src="{{ setThumbnail($account->profile_pic) }}">
            <span class="{{ $account->status ? 'ativ_acc' : 'notacc_acc' }}"></span>
        </div>
        <div class="Userdata">
            <span class="Usernam">{{ $account->lastname .' '. $account->firstname }}</span>
            <span class="UserEmail">{{ $account->email }}</span>
            <span class="UserPhone">{{ $account->cellphone }}</span>
            <span class="Userdate">{{ $account->created_date }}</span>
        </div>
    </div>
    <div class="walletAmount"><span class="">Solde : </span><span class="Amount">{{ number_format($account->balance , 0,'.', ' ') }} FCFA</span></div>

    @if ($account->status)
    <h1>Rechargement Wallet</h1>
    <form role="form" autocomplete="off" method="post" id="reload-form" class="reload-form">
        <div class="form-group">
            <input autocomplete="off" type="text" name="amount" placeholder="Montant de Rechargement *" class="form-username form-control" id="form-amount">
            @if ($errors->has('amount'))<span class="error">{{ $errors->first('amount') }}</span>@endif
        </div>
        <button type="submit" name="withdraw" value="withdraw" class="btn btn-connecte btn-debit">Débiter</button>
        <button type="submit" name="deposit" value="deposit" class="btn btn-connecte btn-credit">Créditer</button>
        {{ csrf_field() }}
    </form>
    @else
    <h1 style="font-size: 30px;line-height: 1;color:#e60003;margin-bottom: 2rem;padding: 0 4rem">Compte du
        client inactif.</h1>
    <p style="font-size: 20px;line-height: 1.5;">Veuillez activer votre compte avant de le recharger, <span style="color:#e60003;font-family: brown;display: block">Ou contactez le service technique <br>de
            MY PLACE EVENTS</span></p>
    <button onclick="redirect('{{ route('wallet.index') }}')" class="btn btn-connecte back">Revenir</button>
    @endif

    <div class="paginantion"><span class="pagin first active"><a href="/">.</a></span><span class="pagin second active"><a href="javascript:history.back()">.</a></span><span class="pagin third active"></span></div>
</div>
@endsection

@push('page.scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script>
    jQuery("#reload-form").validate({rules:{amount:{required:!0,digits:!0}},messages:{amount:{required:"@lang('validation.required', ['attribute' => 'montant'])",digits:"@lang('validation.numeric', ['attribute' => 'montant'])"}}});
</script>
<script type="text/javascript">
    function redirect(i){window.location=i}
</script>
@endpush