<?php

namespace App\Http\Controllers\Admin;

use App\SouscPrestataire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Prestataire;
use App\ImageUpload;
use App\Permission;
use Hash;
use Carbon\Carbon;

class PrestataireController extends AdminController
{
    public function __construct() {
        parent::__construct();
        $this->prestataires = new Prestataire;
        $this->sousc_prestataire = new SouscPrestataire;
    }
    public function index() {
        $data = $this->prestataires->getPaidData();
        //$voirRecenteFormule = $this->sousc_prestataire->getData();
        return view('Admin.prestataire.prestatairesview',compact('data'));
    }
    public function shows($id)
    {
        $data = $this->prestataires->getDatas($id);
        return view('Admin.prestataire.prestatairedetails',compact('data'));
    }
    public function ban($id)
    {
        Prestataire::where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('error','The Event has been successfully Disabled.');
    }
    public function revoke($slug)
    {
        Prestataire::where('url_slug',$slug)->update(['status'=>1]);
        return redirect()->back()->with('success','The Event has been successfully Enabled.');
    }

    public function activeFormule($slug, $idTransaction)
    {
        $detailsSouscription = SouscPrestataire::where('id_transaction',$idTransaction)->first();
        $today = Carbon::now();
        $dateExpiration = Carbon::now()->addMonths($detailsSouscription->formule)->format('Y-m-d H:i:s');
        //dd($today,$dateExpiration,$detailsSouscription->formule);
        Prestataire::where('url_slug',$slug)->update(['status'=>1]);
        SouscPrestataire::where('id_transaction',$idTransaction)->update(['payment_expire'=>$dateExpiration]);
        $data = $this->prestataires->getPaidData();
        return view('Admin.prestataire.prestatairesview',compact('data'));
    }
}
