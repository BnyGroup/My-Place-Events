<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ forcompany() }} - Confirmation de votre commande</title>
    <style>
        *{
            font-size : 18px;
        }
    </style>
</head>
<div>
    <h3>Bonjour {{ $orderData->fnm.' '.$orderData->lnm }}</h3>
    <p>Votre commande n° {{ $orderData->order_id }} a été prise en compte,</p>
    <h3> Détails de la commande</h3>
    <ul>
        <li> Nom de l'événement :{{ ($orderData->event_name == null)?'':$orderData->event_name }} </li>
        <li> Nombre de Ticket(s) : {{ $orderData->order_tickets }} </li>
        <li>
            <ul>
                <?php
                $ticket_qty = unserialize($orderData->order_t_qty);
                $ticket_price = unserialize($orderData->order_t_price);
                $i = 0;
                foreach($ticket_qty as $key => $qty){
                ?>
                <li><?= $qty ?> Ticket(s) de <?= $ticket_price[$i] ?> FCFA</li>
                <?php
                $i++;
                }
                ?>
            </ul>
        </li>
        <li> Montant Total: {{ $orderData->order_amount }} FCFA</li>
        <li> Votre téléphone  : {{ ($orderData->ot_cellphone == null)?$orderData->cellphone:$orderData->ot_cellphone }} </li>
        <li> Votre adresse mail : {{ ($orderData->user_id == 0)?$orderData->ot_email: $orderData->user_email }} </li>
    </ul>
    <p>
        Les billets vous seront délivrés lors du paiement,<br>
        Nous vous contacterons pour plus d’informations.<br>
        Merci
    </p>
</div>
