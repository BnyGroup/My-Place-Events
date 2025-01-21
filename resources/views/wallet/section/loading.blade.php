@push('page.css')
<style>
    .wallet-start-loading{position:absolute;width:100%;height:100%;background:#f1f1f1;z-index:999;}
    .wallet-start-loading .logo_looading {position: absolute;width: 50%;left: 0;right: 0;top: 0;bottom: 0;margin: auto;text-align: center;max-height: 170px;display: -webkit-box;display: -moz-box;display: -webkit-flex;display: -ms-flexbox;display: flex;flex-direction: column;align-items: center;justify-content: center;display: none;}
    .wallet-start-loading .Wallet_loading {display:none;}
    .wallet-start-loading span.dot.first{animation: dotFirst 1.5s infinite linear;}
    .wallet-start-loading span.dot.second{animation: dotSecond 1.5s infinite linear;}
    .wallet-start-loading span.dot.third{animation: dotThird 1.5s infinite linear;}
    @keyframes dotFirst{0%{top:0}16.667%{top:-10px}33.333%{top:0}50%{top:0}66.667%{top:0}83.333%{top:0}100%{top:0}}
    @keyframes dotSecond{0%{top:0}16.667%{top:0}33.333%{top:0}50%{top:-10px}66.667%{top:0}83.333%{top:0}100%{top:0}}
    @keyframes dotThird{0%{top:0}16.667%{top:0}33.333%{top:0}50%{top:0}66.667%{top:0}83.333%{top:-10px}100%{top:0}}
    </style>
@endpush

<div class="wallet-start-loading">
    <div class="logo_looading">
        <img src="{{ asset('/wallet/assets/images/LOGO-OFF.svg') }}" title="Logo My Place Events" alt="Logo My Place Events" style="max-width: 50%" />
        <div class="Wallet_loading">Rechargement E-Wallet <span class="dot first">.</span><span class="dot second">.</span><span class="dot third">.</span></div>
    </div>
</div>

@push('page.scripts')
<script>
    var start=600,step=3e3,end=600,start_wallet=1e3;!function(a){a(document).ready(function(){var t;t=Number(start_wallet-start),a(".wallet-start-loading").fadeIn(start).delay(step+t).fadeOut(end),a(".wallet-start-loading .logo_looading").fadeIn(start).delay(step).fadeOut(end),a(".wallet-start-loading .logo_looading .Wallet_loading").fadeIn(start_wallet).delay(step+t).fadeOut(end)})}(jQuery);
</script>
@endpush