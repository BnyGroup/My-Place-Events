<div class="result" id="fail">
    <span class="icon"><i class="far fa-times-circle"></i></span>
    <span class="msg">@if(session()->has('deposit.error')) {{ session('deposit.error') }} @else {{ 'Opération impossible, veuillez réessayer plus tard' }} @endif</span>
</div>

@push('page.scripts')
<script src="https://kit.fontawesome.com/1d76babbc6.js" crossorigin="anonymous"></script>
<script>
    window.setTimeout(()=>{this.location="{{ route('wallet.index') }}"},5e3);
</script>
@endpush