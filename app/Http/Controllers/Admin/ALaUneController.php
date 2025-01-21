<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ALaUne;
use App\Slider;
use App\TeteDeListe;
use App\Frontuser;
use Hash;
use Carbon\Carbon;
use App\AluPayment;


class ALaUneController extends AdminController
{
    //
    public function __construct() {
        parent::__construct();
        $this->alaunes = new ALaune;
        $this->sliders = new Slider;
        $this->tetedelistes = new TeteDeListe;
        $this->frontusers = new Frontuser;
    }
    public function index() {
        $data = $this->alaunes->getData();
        return view('Admin.alu.alu-list',compact('data'));
    }
    public function shows($id)
    {
        $data = $this->alaunes->getDatas($id);
        return view('Admin.alu.alu-view',compact('data','tik'));
    }

    public function enable($id)
    {
        $alu = ALaUne::where('id',$id)->first();
        $alupayment = AluPayment::where('id_transaction',$alu->id_last_transaction)->first();
        $dateExpiration = Carbon::now()->addWeeks($alupayment->formule)->format('Y-m-d H:i:s');
        //dd($alupayment,$alu,$dateExpiration);
        ALaUne::where('id',$id)->update(['status_service'=>1,'status_admin'=>1,'date_fin'=>$dateExpiration]);
        return $this->mettreEnLigneAlu($id);
    }

    public function pause($id){
        ALaUne::where('id',$id)->update(['status_admin'=>2]);
        $datePause = Carbon::now();
        /*dd($datePause);*/
        Slider::where('id_panier_malu',$id)->update(['slide_status'=>0,'date_derniere_pause'=>$datePause]);
        return redirect()->back()->with('info','Le Slide est en pause');
    }

    public function disable($id)
    {
        ALaUne::where('id',$id)->update(['status_admin'=>3]);
        return $this->retirerEnLigneAlu($id);
    }

    public function mettreEnLigneAlu($id){
        $data = $this->alaunes->getDataByServiceId($id);
        if($data->type_service == 'Slider'){
            $existSlider = Slider::where('id_panier_malu',$id)->first();
            if($existSlider && $existSlider->slide_status == 1){
                return redirect()->back()->with('info','Le Slide est déjà en ligne');
            }elseif($existSlider && $existSlider->slide_status == 0){
                $existSlider->slide_status = 1;
                if(!empty($existSlider->date_derniere_pause)  && isset($existSlider->date_derniere_pause)){
                    $dernierPause = Carbon::parse($existSlider->date_derniere_pause);
                    $intervalle = $dernierPause->diffInDays($dernierPause->copy()->now());
                    $dateFin = Carbon::parse($existSlider->date_fin);
                    $newDateFin = $dateFin->addDays($intervalle);
                    /*dd($newDateFin, $dateFin, $intervalle, $dernierPause, $existSlider->date_derniere_pause, $existSlider->date_fin);*/
                    $existSlider->date_fin = $newDateFin;

                    // Inserer la nouvelle date de fin
                }
                $existSlider->update();
                return redirect()->back()->with('info','Le Slide a été remis en ligne');
            }

            //Ajout du service dans la table des slides
            $this->sliders->slide_title = $data->titre_slide;
            $this->sliders->slide_desc = $data->description_slide;
            $this->sliders->slide_img = $data->image_slide_entete;
            $this->sliders->slide_text_btn = $data->slide_btn_text;
            $this->sliders->slide_btn_url = $data->url_entete_slide;
            $this->sliders->slide_status = 1;
            $this->sliders->date_demarre = Carbon::now();

            $dateDemarre = Carbon::now();
            $delai = $data->duree_service;
            $datefin = $dateDemarre->addWeek($delai);

            $this->sliders->date_fin = $datefin;
            $this->sliders->admin_id = Auth()->user()->id;
            $this->sliders->id_frontuser = $data->id_frontuser;
            $this->sliders->id_panier_malu = $data->id;
            $this->sliders->save();
            $infoSlidersUpdated = Slider::where('id_panier_malu',$id)->first();
            ALaUne::where('id',$id)->update(['date_demarre'=>$infoSlidersUpdated->date_demarre,'date_fin'=>$infoSlidersUpdated->date_fin]);
            return redirect()->back()->with('success','Le Slide est maintenant en ligne.');
        }

        if($data->type_service == 'Tête de Liste'){
            $existTeteDeListe = TeteDeListe::where('id_panier_malu',$id)->first();
            if($existTeteDeListe && $existTeteDeListe->status == 1){
                return redirect()->back()->with('info','La Tête a été remis en ligne');
            }elseif($existTeteDeListe && $existTeteDeListe->status == 0){
                $existTeteDeListe->status = 2;
                $existTeteDeListe->update();
                return redirect()->back()->with('info','La tête de liste est maintenant en ligne');
            }
            $this->tetedelistes->id_frontuser = $data->id_frontuser;
            $this->tetedelistes->id_admin = Auth()->user()->id;
            $this->tetedelistes->id_panier_malu = $data->id;
            $this->tetedelistes->url_entete = $data->url_entete_slide;
            $this->tetedelistes->image_entete = $data->image_slide_entete;
            $this->tetedelistes->status = 1;

            $this->tetedelistes->save();
            return redirect()->back()->with('success','The Event has been successfully Enabled.');
        }

        return redirect()->back()->with('error','No changes occur.');
    }

    public function retirerEnLigneAlu($id){
        $data = $this->alaunes->getDataByServiceId($id);
        if($data->type_service == 'Slider'){
            Slider::where('id_panier_malu',$id)->update(['slide_status'=>0]);
            return redirect()->back()->with('error','Le Slide a été désactivé et retirer en ligne.');
        }

        if($data->type_service == 'Tête de Liste'){
            TeteDeListe::where('id_panier_malu',$id)->update(['status'=>0]);
            return redirect()->back()->with('error','La tête de liste a été désactivé et retirer en ligne.');
        }

        return redirect()->back()->with('error','No changes occur.');
    }

}
