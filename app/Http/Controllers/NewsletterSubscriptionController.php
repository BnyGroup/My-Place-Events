<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class NewsletterSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email'
        ]);

        NewsletterSubscription::create([
            'email' => $request->email
        ]);

        return redirect()->back()->with('success', 'Vous êtes maintenant abonné à la newsletter.');
    }


}