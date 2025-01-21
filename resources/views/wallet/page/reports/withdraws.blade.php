@extends('wallet.layout')

@section('page.title', 'Opérations')

@section('page.content')
    @include('wallet.section.header')
    <div class="formBlock">
        @foreach ($withdraws as $w)
        <ul style="list-style:none;text-align:left;font-size:1.3em;padding:0;">
            <li>
                <strong>Transaction ID</strong>
                <p>{{ $w->withdraw->uuid }}</p>
            </li>
            <li>
                <strong>Date</strong>
                <p>{{ $w->created_at }}</p>
            </li>
            <li>
                <strong>Montant</strong>
                <p>{{ $w->withdraw->amount }}</p>
            </li>
            <li>
                <strong>Email utilisateur</strong>
                <p>{{ $w->from->email }}</p>
            </li>
        </ul>
        <hr style="width:100%;">
        @endforeach
        {{ $withdraws->links('wallet.section.pagination') }}
        <button onclick="redirect('{{ route('wallet.reports') }}')" class="btn btn-connecte back">Revenir</button>
    </div>
@endsection

@push('page.scripts')
<script type="text/javascript">
    function redirect(i){window.location=i}
</script>
@endpush