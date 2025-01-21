<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\PaysList;
use App\Service;

class ServiceController extends FrontController
{
    //

    public function __construct() {
        parent::__construct();
        $this->services = new Service;
    }

    public function index(){

        $services = $this->services->getList();
        $pays = PaysList::orderBy('nom_pays','asc')->get();
        return view('theme.services.service-home',compact('services','pays'));
    }
}
