<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class NewsletterSubscription extends Model
{
    protected $fillable = ['email'];
}