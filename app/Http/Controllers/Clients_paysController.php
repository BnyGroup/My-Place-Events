<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use App\Models\Clients_pays;



public function store(Request $request) {

    // Valider les données du formulaire

    $validatedData = $request->validate([
        'guestUserPhone' => 'required|min:10|max:14',
        'guestuserName' => 'required',
        'guestUserEmail' => 'required|email',
        'confirmguestUserEmail' => 'required|same:guestUserEmail',
    ]);

    // Créer un nouvel objet client_pays avec les données validées

    $client_pays = new client_pays();
    $client_pays->guestUserPhone = $request->guestUserPhone;
    $client_pays->guestuserName = $request->guestuserName;
    $client_pays->guestUserEmail = $request->guestUserEmail;

    // Enregistrer le client_pays dans la base de données

    $client_pays->save();

    // Rediriger l'utilisateur après l'enregistrement
   return view('theme.booking.ticket-payment',compact('bookingdata','organization','typepay','paypalId','orderSessionTime','bookingdatasAll'));
}
