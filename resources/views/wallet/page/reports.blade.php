@extends('wallet.layout')

@section('page.title', 'Rapports')

@section('page.content')
    @include('wallet.section.header')
    <div class="formBlock">
        <button type="submit" onclick="redirect('{{ route('wallet.reports', ['type' => 'deposits']) }}')" class="btn btn-connecte">Rechargement créditeur</button>
        <button type="submit" onclick="redirect('{{ route('wallet.reports', ['type' => 'withdraws']) }}')" class="btn btn-connecte">Rechargement débiteur</button>
        <button onclick="redirect('{{ route('wallet.index') }}')" class="btn btn-connecte back">Revenir</button>
    </div>
@endsection

@push('page.scripts')
<script type="text/javascript">
    function redirect(i){window.location=i}
</script>
@endpush