<div class="result" id="succes">
    <span class="icon"><i class="far fa-check-circle"></i></span>
    <span class="msg">Opération éffectuée avec succès</span>
</div>

@push('page.scripts')
<script src="https://kit.fontawesome.com/1d76babbc6.js" crossorigin="anonymous"></script>
<script>
    window.setTimeout(()=>{this.location="{{ route('wallet.index') }}"},5e3);
</script>
@endpush