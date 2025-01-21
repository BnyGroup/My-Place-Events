<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\WebTV;

class WebTvController extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->webtv = new WebTV;
    }

    //
    public function index(){
        $webtv= WebTV::orderBy('id', 'desc')->paginate(100);
        return view('theme.services.webtv.webtv-home', compact('webtv'));
    }
}
