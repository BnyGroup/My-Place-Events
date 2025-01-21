@extends('wallet.layout')

@section('page.title', 'Compte inexistant')

@section('page.content')
@include('wallet.section.header')
<div class="formBlock">
    <h1 style="font-size: 30px;line-height: 1;color:#e60003;margin-bottom: 2rem;padding: 0 4rem">Nous n'avon
        trouvé aucune information sur ce compte.</h1>
    <p style="font-size: 20px;line-height: 1;color:#e60003;">Veuillez créer un compte sur <span style="font-family: brown;display: block">www.myplace-events.com</span></p>
    <button onclick="redirect('{{ route('wallet.search') }}')"class="btn btn-connecte back">Revenir</button>
</div>
@endsection

@push('page.scripts')
<script type="text/javascript">
    function redirect(i) {
        window.location = i
    }
</script>
@endpush