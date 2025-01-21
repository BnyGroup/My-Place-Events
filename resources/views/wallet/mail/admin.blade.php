<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{ forcompany() }} - Recharge e.Dari</title>
	<style type="text/css">
		body{font-family:"Monospace","Helvetica Neue",Helvetica,Roboto,Arial,sans-serif}
		.mail-container{background:#f7f7f7;width:100%;padding:5px 0}
		.mail-inner-content{width:700px;margin:20px auto;border-radius:0}
		.mail-header .mail-logo{text-align:center;padding:20px 10px}
		.mail-header .mail-header-title{background:#b8248d;color:#FFF;text-align:center;padding:15px;letter-spacing:2px}
		.mail-header .mail-header-title h1{padding:0;margin:0}
		.mail-body{padding:10px;background:#fff}
		.body-title h4{padding:5px 0;color:#404040;font-weight:400;font-size:18px;line-height:30px;margin:0;text-align:center}
		.body-title h4 span{color:#b8248d}
		.body-title p{padding:10px 0 5px;margin:0;font-size:14px;color:#777;text-align:center}
		.order-summary{padding:25px 0}
		.order-summary .bg-down,.order-summary .bg-up{height:7px}
		.order-summary .bg-down img{width:100%;height:12px}
		.order-summary .bg-up img{width:100%}
		.order-summary .order-body{background:#ededed;min-height:15px;padding:18px 20px}
		.order-title h2{color:#404040;font-weight:300;margin:0 0 12px;font-size:24px;line-height:30px}
		.order-body table{width:100%;margin-bottom:12px}
		.order-body h2{color:#404040;font-weight:300;margin:0 0 12px;font-size:24px;line-height:30px}
		.bottom-dashed{border-bottom:1px dashed #d3d3d3}
		.order-body .date{color:#666;font-weight:400;font-size:13px;line-height:18px}
		.order-body .order-number{color:#666;font-weight:400;font-size:15px;line-height:21px;margin-bottom:18px}
		.order-body .table-th{border-bottom:1px dashed #d3d3d3;text-align:left;padding:5px 10px 12px 0;padding-right:10px}
		.order-body .table-td{padding:12px 10px 12px 0}
		.order-body .table-th .title{color:#666;font-weight:700;font-size:15px;line-height:21px;letter-spacing:1px}
		.order-body .table-td .title{color:#666;font-weight:400;font-size:15px;line-height:21px}
		.about-event{padding:10px 25px}
		.about-event h2.title{color:#404040;font-weight:300;margin:0 0 12px;font-size:24px;line-height:30px}
		.about-event .event-vanue,.about-event .event-datetime{font-size:14px}
		.about-event .event-vanue strong,.about-event .event-datetime strong{padding:5px;margin:0 0 10px;color:#777}
		.about-event .event-vanue p,.about-event .event-datetime p{font-size:13px;padding:5px;margin:0 0 10px;color:#444}
		.term-service{text-align:center;font-size:10px;color:#999}
		.term-service a{color:#b8248d;text-decoration:none}
		.note{text-align:center;font-size:13px;color:#666}
		.login{padding:20px 0 0}
		.login td.image{width:220px;text-align:center}
		.login h2{color:#404040;font-weight:300;margin:0 0 12px;font-size:24px;line-height:30px;margin-bottom:8px}
		.login .login-link{color:#666;font-weight:400;font-size:15px;line-height:21px;font-weight:300;font-size:14px;line-height:1.5}
		.login .login-link a{text-decoration:none;color:#b8248d;font-weight:400}
		.mail-footer{text-align:center}
		.mail-footer p{font-size:11px;padding:5px 0;margin:5px 0;line-height:20px;color:#999;letter-spacing:1px}
	</style>
</head>

<body>
<div class="mail-container">
    <div class="mail-inner-content">
        <!-- HEADER -->
        <div class="mail-header">
            <div class="mail-logo">
                <a href="">
                    <img src="{{ asset('/img/wallet-logo.svg') }}" alt="MY PLACE - e.Dari" height="50" />
                </a>
            </div>
            <div class="mail-header-title" >
                <h1>{{ $subject }}</h1>
            </div>
        </div>
        <div class="mail-body">
            <div class="body-title">
                <h4>Bonjour Admin,</h4>
                @switch($type)
                    @case('deposit')
                        <h4>le compte de {{ $transfer->to->lastname }} ({{ $transfer->to->email }}) vient de bénéficier d'une recharge de {{ number_format($transfer->deposit->amount , 0,'.', ' ') }} FCFA, effectué par {{ $transfer->from->lastname }} ({{ $transfer->from->email }}) à la date du {{ $transfer->created_at->format('d-m-Y à H:i:s') }}.</h4>
                    @break
                    @case('withdraw')
                        <h4>le compte de {{ $transfer->from->lastname }} ({{ $transfer->from->email }}) vient d'être débiter de {{ number_format($transfer->withdraw->amount , 0,'.', ' ') }} FCFA, effectué par {{ $transfer->to->lastname }} ({{ $transfer->to->email }}) à la date du {{ $transfer->created_at->format('d-m-Y à H:i:s') }}.</h4>
                    @break
                @endswitch
                <div class="bottom-dashed"></div>
            </div>
        </div>
        <!-- FOOTER -->
        <div class="mail-footer">
            <p> @lang('words.mail_tmp.terms_se3') {{ frommail() }} <br/>
                Copyright © {{ date('Y') }} {{ forcompany() }} @lang('words.mail_tmp.terms_se4').  </p>
        </div>
    </div>
</div>
</body>
</html>