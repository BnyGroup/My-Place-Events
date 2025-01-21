<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Realisation;

class AjaxController extends FrontController
{
    //
    public function __construct() {
        parent::__construct();
        $this->realisations = new Realisation;
    }


    public function deleteFilePreUpdate(){

    }
}
