@extends('wallet.layout')

@section('page.title', 'Opérations')

@section('page.content')
@include('wallet.section.header')
<div class="formBlock">
    <div>
        <div class="AccountBlock">
            <div class="Userpic">
                <img src="{{ setThumbnail(Auth::user()->profile_pic) }}">
                <span class="{{ Auth::user()->status ? 'ativ_acc' : 'notacc_acc' }}"></span>
            </div>
            <div class="Userdata">
                <span class="Usernam">{{ Auth::user()->lastname .' '. Auth::user()->firstname }}</span>
                <span class="UserEmail">{{ Auth::user()->email }}</span>
                <span class="UserRole">{{ Auth::user()->roles->first()->display_name }}</span>
            </div>
        </div>
        <div class="walletAmount"><span class="">Solde : </span><span class="Amount">{{ number_format(Auth::user()->balance , 0,'.', ' ') }} FCFA</span></div>
    </div>
    <h1>Accédez à tous vos services</h1>
    <div class="servicesBlock">
        <div class="item1 services active"><a href="{{ route('wallet.search') }}">E-Wallet</a></div>
        <div class="item2 services"><a href="{{ route('wallet.reports') }}">Liste des rechargelents</a></div>
        <div class="item3 services off">Bientôt...</div>
        <button type="submit" onclick="redirect('{{ route('wallet.logout') }}')" class="btn btn-connecte" style="margin: 5% 0;">Déconnexion</button>
    </div>
</div>
@endsection


@push('page.scripts')
<script type="text/javascript">
    function redirect(i) {
        window.location = i
    }
</script>
@endpush