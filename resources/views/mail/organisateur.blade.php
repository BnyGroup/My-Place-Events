<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Nouvelle Commande</title>
	<style type="text/css">
		body{font-family:monospace,Arial,sans-serif}
		.mail-container{background:#f7f7f7;width:100%;padding:5px 0}
		.mail-inner-content{width:700px;margin:20px auto;border-radius:0}
		.mail-header .mail-logo{text-align:center;padding:20px 10px}
		.mail-header .mail-header-title{background:#D600A9
;color:#FFF;text-align:center;padding:15px;letter-spacing:normal}
		.mail-header .mail-header-title h1{padding:0;margin:0}
		.mail-body{padding:20px;background:#fff}
		.body-title h4{padding:5px 0;color:#404040;font-weight:400;font-size:18px;line-height:30px;margin:0}
		.body-title p span,.body-title h4 span{color:#D600A9
}
		.body-title p{padding:10px 0 5px;margin:0;font-size:14px;color:#777}
		.bottom-dashed{border-bottom:1px dashed #d3d3d3}
		.term-service{text-align:center;font-size:10px;color:#999}
		.term-service a{color:#D600A9
;text-decoration:none}
		.note{text-align:center;font-size:13px;color:#666}
		.mail-footer{text-align:center}
		.mail-footer p{font-size:11px;padding:5px 0;margin:5px 0;line-height:20px;color:#999;letter-spacing:normal}
		a.mail-button{background-color:transparent;border:2px solid #D600A9
;border-radius:3px;color:#D600A9
;display:inline-block;font-size:14px;letter-spacing:normal;margin:10px 0;padding:10px 18px;text-decoration:none;width:auto}
		a.mail-button:hover{transition:all .3s;background:#D600A9
;color:#fff}
	</style>
</head>
<body>
	<div class="mail-container">
		<div class="mail-inner-content">
			<!-- HEADER -->
			<div class="mail-header">
				<div class="mail-logo">
					<a href="">
						<img src="{{ for_logo() }}" alt="{{ forcompany() }}" height="50" style="margin-bottom: 10px;"/>
					</a>
				</div>
				<div class="mail-header-title" >
					<h1>Nouvelle Commande - # </h1>
				</div>
			</div>
			<div class="mail-body">
				<div class="body-title">
					<h4>
						Bonjour cher organisateur, nous avons enrégistré une nouvelle commande <span>#NUMERO</span> pour votre évènement <span>NOM EVENEMENT</span>,
					</h4>
					<h4 style="text-align: center"> Détails </h4>
					<h4> Nombre de ticket(s):  NOMBRE TICKET</h4>
					<h4> Montant Total:  MONTANT TICHET</h4>
					<h4> Email client:  
						
					</h4>
				</div>
				<div class="bottom-dashed"></div>
			</div>
			<div class="mail-footer">
				<p> Cet email a été envoyé depuis contact@myplace-events.com <br/>
				 Copyright © 2021 My Place Events. Tous droits réservés. </p>
			</div>

		</div>
	</div>
</body>
</html>