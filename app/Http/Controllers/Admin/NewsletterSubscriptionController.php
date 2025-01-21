<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class NewsletterSubscriptionController extends Controller
{
   

         public function showAbonnes()
            {
                     $newsletterAbonnes = NewsletterSubscription::all();
             $AdminTheme = [
                    'master' => 'layout.master', // Assurez-vous que 'layout.master' est le chemin correct vers votre layout principal
                    'header' => view('AdminTheme.header')->render(),
                    'sidebar' => view('AdminTheme.sidebar')->render(),
                    'footer' => view('AdminTheme.footer')->render(),
                    'script' => view('AdminTheme.script')->render(),
                    'css' => view('AdminTheme.css')->render(),
                ];
                return view('Admin.newsletter.abonnes', compact('newsletterAbonnes', 'AdminTheme'));            }


}