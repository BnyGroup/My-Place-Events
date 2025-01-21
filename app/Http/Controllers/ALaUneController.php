<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\ALaUne;
use App\User;
use App\Frontuser;
use App\Http\Controllers\CinetPayController;
use App\Http\Controllers\CinetPay;
use File;
use App\ImageUpload;
use Validator;
use Mail;
use App\FormuleService;


class ALaUneController extends FrontController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->alaunes = new ALaUne;
        $this->frontusers = new Frontuser;
    }

    public function index(){

        $id = auth()->guard('frontuser')->user()->id;
//      dd($id);
        $souscriptions = $this->alaunes->getDataById($id);
        return view('theme.services.slider_service.alu-index',compact('souscriptions'));
    }

    public function getCreate(){
        $serviceSlide = FormuleService::where('id_service',4)->where('type_service','slide')->first();
        $serviceListe = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
        $frontuser = Frontuser::where('id',auth()->guard('frontuser')->user()->id)->first();
        return view('theme.services.slider_service.alu-create', compact('serviceListe','serviceSlide','frontuser'));
    }

    public function postCreate(Request $request){
        $input = $request->all();
        return view('theme.services.slider_service.alu-create', compact('input'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'type_service' => 'required'
        ]);
        $input = $request->all();
        if($input['type_service'] == 'slider'){
            $this->validate($request,[
                'duree_service' => 'required|integer',
                'titre_slide' => 'required',
                'url_entete_slide' => 'url',
                'slide_btn_text' => 'required',
                'montant' => 'required'
            ]);
            $input['type_service'] = 'Slider';
            $puFormule = FormuleService::where('id_service',4)->where('type_service','slide')->first();
           /* switch ($input['duree_service']){
                case '1_semaine':
                    $input['duree_service'] = 1;
                    $input['montant'] = 5000;
                    break;
                case '2_semaines':
                    $input['duree_service'] = 2;
                    $input['montant'] = 10000;
                    break;
                case '3_semaines':
                    $input['duree_service'] = 3;
                    $input['montant'] = 15000;
                    break;
                case '4_semaines':
                    $input['duree_service'] = 4;
                    $input['montant'] = 20000;
                    break;
                default:
                    break;
            }*/
        }elseif($input['type_service'] == 'tete-de-liste'){
            $this->validate($request,[
                'duree_service' => 'required',
                'url_entete_slide' => 'url',
            ]);
            $input['type_service'] = 'Tête de liste';
            $puFormule = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
            /*switch ($input['duree_service']){
                case '1_semaine':
                    $input['duree_service'] = 1;
                    $input['montant'] = 3000;
                    break;
                case '2_semaines':
                    $input['duree_service'] = 2;
                    $input['montant'] = 6000;
                    break;
                case '3_semaines':
                    $input['duree_service'] = 3;
                    $input['montant'] = 9000;
                    break;
                case '4_semaines':
                    $input['duree_service'] = 4;
                    $input['montant'] = 12000;
                    break;
                default:
                    break;
            }*/
        }else{
            return redirect()->route('alu.create')->with('erreur', 'Une erreur s\'est produite, veuillez réessayer plus tard');
        }

        $this->validate($request,[
            'image_slide_entete' => 'required|image|mimes:jpeg,jpg,png|max:12000',
        ]);

        switch ($input['type_service']){
            case 'slider':
                $input['type_service'] = 'Slider';
                break;
            case 'tete-de-liste':
                $input['duree_service'] = 'Tête de liste';
                break;
            default:
                break;
        }
        if($input['type_service'] == 'Tête de liste' || $input['type_service'] == 'Slider') {
            if ($input['montant'] <= 0) {
                return redirect()->route('alu.create')->with('erreur', 'Désolé ce choix ne correspond à aucune de nos formule disponible');
            }
            if ($input['montant'] != $input['duree_service'] * $puFormule->montant_service) {
                return redirect()->route('alu.create')->with('erreur', 'Désolé ce choix ne correspond à aucune de nos formule disponible');
            }
        }
        $id = auth()->guard('frontuser')->user()->id;
        $path = 'upload/user/'.date('Y').'/'.date('m');

        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('image_slide_entete'))) {
            $image = $request->file('image_slide_entete');
            $new_name = 'alu-slider-tdl'.rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $new_name);
            $input['image_slide_entete'] = 'public/'.$path.'/'.$new_name;
            //dd($input['image_slide_entete']);
            $input['slug'] = str_slug($new_name).'-'.str_shuffle(time());
        }

        $input['id_frontuser'] = $id;
        $input['status_service']=0;
        $this->alaunes->insertData($input);

        return redirect()->route('alu.valider');
    }

    /*public function edit(Request $request){
        $input = $request->all();
        $infoService = $this->alaunes->getDataByServiceId($input['id']);
        return view('theme.services.slider_service.alu-edit',compact('infoService'));
    }*/

    public function edit($slug)
    {
        $infoService = $this->alaunes->findDataSlug($slug);
        $serviceSlide = FormuleService::where('id_service',4)->where('type_service','slide')->first();
        $serviceListe = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
        if (! isset($infoService)) {
            \App::abort(404, 'Prestataire Not Found');
        }
        return view('theme.services.slider_service.alu-edit',compact('infoService','serviceSlide','serviceListe'));
    }

    public function delete($id)
    {
        $this->alaunes->deleteData($id);
        return redirect()->route('alu.index')->with('success',trans('words.msg.org_deleted'));
    }

    public function update(Request $request,$id){
        $input = $request->all();
        /*dd($input);*/
        $this->validate($request,[
            'type_service' => 'required'
        ]);
        if($input['type_service'] == 'Slider'){
            $this->validate($request,[
                'duree_service' => 'required',
                'titre_slide' => 'required',
                'url_entete_slide' => 'url',
                'slide_btn_text' => 'required',
            ]);
            $input['type_service'] = 'Slider';
            $puFormule = FormuleService::where('id_service',4)->where('type_service','slide')->first();
            /*switch ($input['duree_service']){
                case '1_semaine':
                    $input['duree_service'] = 1;
                    $input['montant'] = 5000;
                    break;
                case '2_semaines':
                    $input['duree_service'] = 2;
                    $input['montant'] = 10000;
                    break;
                case '3_semaines':
                    $input['duree_service'] = 3;
                    $input['montant'] = 15000;
                    break;
                case '4_semaines':
                    $input['duree_service'] = 4;
                    $input['montant'] = 20000;
                    break;
                default:
                    break;
            }*/
        }
        if($input['type_service'] == 'Tête de liste'){
            $this->validate($request,[
                'duree_service' => 'required',
                'url_entete_slide' => 'url',
            ]);
            $input['type_service'] = 'Tête de liste';
            $puFormule = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
            /*switch ($input['duree_service']){
                case '1_semaine':
                    $input['duree_service'] = 1;
                    $input['montant'] = 5000/*3000;
                    break;
                case '2_semaines':
                    $input['duree_service'] = 2;
                    $input['montant'] = 10000/*6000;
                    break;
                case '3_semaines':
                    $input['duree_service'] = 3;
                    $input['montant'] = 15000/*9000;
                    break;
                case '4_semaines':
                    $input['duree_service'] = 4;
                    $input['montant'] = 20000/*12000;
                    break;
                default:
                    break;
            }*/
        }


        $this->validate($request,[
            'image_slide_entete' => 'required|image|mimes:jpeg,jpg,png|max:12000',
        ]);

        if($input['type_service'] == 'Tête de liste' || $input['type_service'] == 'Slider') {
            if ($input['montant'] <= 0) {
                return redirect()->route('alu.edit',$input['slug'])->with('erreur', 'Désolé ce choix ne correspond à aucune de nos formule disponible');
            }
            if ($input['montant'] != $input['duree_service'] * $puFormule->montant_service) {
                return redirect()->route('alu.edit',$input['slug'])->with('erreur', 'Désolé ce choix ne correspond à aucune de nos formule disponible');
            }
        }

        $path = 'upload/user/'.date('Y').'/'.date('m');

        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('image_slide_entete'))) {

            $image = $request->file('image_slide_entete');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path($path), $new_name);
            $input['image_slide_entete'] ='public/'.$path.'/'.$new_name;
        } else {
        $input['image_slide_entete'] = 'public/'.$path.'/'.$input['old_image'];
        }
        if (!empty($input['old_image'])) {
            File::delete($input['old_image']);
        }

        $this->alaunes->updateData($id,$input);
        return redirect()->route('alu.index')->with('success','Modification éffectué avec succes');
    }

    public function valider(){

        $id = auth()->guard('frontuser')->user()->id;
        $maluInfo = ALaUne::where('id_frontuser',$id)
            ->latest()
            ->first();
        return view('theme.services.slider_service.alu-payment',compact('maluInfo'));
    }

    protected function generateForm(Request $request)
    {
        /*
            * Preparation des elements constituant le panier
        */
        $input =$request->all();
        $this->validate($request, [
            'duree' => 'required',
            'service' => 'required',
            'montant' => 'required',
            //'id' => 'required',
        ]);
        $id = auth()->guard('frontuser')->user()->id;

        if($input['service'] == 'Tête de liste'){
            $puFormule = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
            $service = 'tete-de-liste';
        }elseif($input['service'] == 'Slider') {
            $puFormule = FormuleService::where('id_service',4)->where('type_service','slide')->first();
            $service = 'slider';
        }else{
            return redirect()->route('alu.valider')->with('erreur','Désolé ce choix ne correspond à aucune de nos formules disponible');
        }

        $apiKey = "12225072435af2f658189760.36336854"; //Veuillez entrer votre apiKey
        $site_id = "332112"; //Veuillez entrer votre siteId

        //$id_transaction = CinetPay::generateTransId(); // Identifiant du Paiement
        $id_transaction = $id.'-'.$input['id'].'-'. CinetPay::generateTransId(); // Identifiant du Paiement
        /*$id_transaction = $id.'-'.$input['id']. '.' . CinetPay::generateTransId(); // Identifiant du Paiement*/
        $description_du_paiement = sprintf('Paiement Mise à la une', $id_transaction); // Description du Payment
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système

        //$montant_a_payer = mt_rand(5, 100); // Montant à Payer : minimun est de 5 francs sur CinetPay
        $montant_a_payer = $input['montant']; // Montant à Payer : minimun est de 5 francs sur CinetPay

        // $identifiant_du_payeur = 'payeur@domaine.ci'; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
        $identifiant_du_payeur = $id;

        $formName = "goCinetPay"; // nom du formulaire CinetPay
        $notify_url = route('alu.cinetpaynotify'); // Lien de notification CallBack CinetPay (IPN Link)
        $return_url = route('alu.cinetpayreturn'); // Lien de retour CallBack CinetPay
        $cancel_url = route('alu.cinetpaycancel'); // Lien d'annulation CinetPay
        // Configuration du bouton
        /*$btnType = 2;//1-5xwxxw
        $btnSize = 'large'; // 'small' pour reduire la taille du bouton, 'large' pour une taille moyenne ou 'larger' pour  une taille plus grande*/

        //Enregistrement montant
//        dd($service);
        if($service == 'tete-de-liste' || $service == 'slider') {
            if ($input['montant'] <= 0) {
                return redirect()->route('alu.valider')->with('erreur', 'Désolé ce choix ne correspond à aucune de nos formule disponible');
            }
            if ($input['montant'] != $input['duree'] * $puFormule->montant_service) {
                return redirect()->route('alu.valider')->with('erreur', 'Désolé ce choix ne correspond à aucune de nos formule disponible');
            }
        }
        $iinput = array();

        $iinput['payment_id'] = $id_transaction;
        $iinput['payment_gateway'] = 'Cinetpay';
        $iinput['payment_date'] = $date_transaction;
        $iinput['payment_state'] = 0;

        $this->alaunes->updateData($input['id'],$iinput);
        // Paramétrage du panier CinetPay et affichage du formulaire
        $cp = new CinetPay($site_id, $apiKey);
        try {
            $cp->setTransId($id_transaction)
                ->setDesignation($description_du_paiement)
                ->setTransDate($date_transaction)
                ->setAmount($montant_a_payer)
                ->setDebug(false)// Valorisé à true, si vous voulez activer le mode debug sur cinetpay afin d'afficher toutes les variables envoyées chez CinetPay
                ->setCustom($identifiant_du_payeur)// optional
                ->setNotifyUrl($notify_url)// optional
                ->setReturnUrl($return_url)// optional
                ->setCancelUrl($cancel_url)// optional
                //->getOnlyPayButtonToSubmit($formName, $btnType, $btnSize)
                ->submitCinetPayForm();
        } catch (\Exception $e) {
            print $e->getMessage();
        }
    }

    public function notifyUrl(){

        $id_transaction = $_POST['cpm_trans_id'];


        if (!empty($id_transaction)) {
            //return 'notifyUrl2';
            try {
                $apiKey = "12225072435af2f658189760.36336854"; //Veuillez entrer votre apiKey
                $site_id = "332112"; //Veuillez entrer votre siteId

                $cp = new CinetPay($site_id, $apiKey);

                // Reprise exacte des bonnes données chez CinetPay
                $cp->setTransId($id_transaction)->getPayStatus();
                $paymentData = [
                    "cpm_site_id" => $cp->_cpm_site_id,
                    "signature" => $cp->_signature,
                    "cpm_amount" => $cp->_cpm_amount,
                    "cpm_trans_id" => $cp->_cpm_trans_id,
                    "cpm_custom" => $cp->_cpm_custom,
                    "cpm_currency" => $cp->_cpm_currency,
                    "cpm_payid" => $cp->_cpm_payid,
                    "cpm_payment_date" => $cp->_cpm_payment_date,
                    "cpm_payment_time" => $cp->_cpm_payment_time,
                    "cpm_error_message" => $cp->_cpm_error_message,
                    "payment_method" => $cp->_payment_method,
                    "cpm_phone_prefixe" => $cp->_cpm_phone_prefixe,
                    "cel_phone_num" => $cp->_cel_phone_num,
                    "cpm_ipn_ack" => $cp->_cpm_ipn_ack,
                    "created_at" => $cp->_created_at,
                    "updated_at" => $cp->_updated_at,
                    "cpm_result" => $cp->_cpm_result,
                    "cpm_trans_status" => $cp->_cpm_trans_status,
                    "cpm_designation" => $cp->_cpm_designation,
                    "buyer_name" => $cp->_buyer_name,
                ];
                $idService = explode('-',$cp->_cpm_trans_id);
                //return $this->testNotifyUrl($idPrestataire[0],'notifyUrl');
                $input=array();
                $infoService = $this->alaunes->getDataByServiceId($idService[1]);

                // Recuperation de la ligne de la transaction dans votre base de données
                // Verification de l'etat du traitement de la commande

                // Si le paiement est bon alors ne traitez plus cette transaction : die();

                // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
                if ($cp->isValidPayment()) {
                    if($infoService->type_service == 'Slider'){
                        $puFormule = FormuleService::where('id_service',4)->where('type_service','slider')->first();
                        $servicePu = $puFormule->montant_service;
                        $service = 'slider';
                        /*switch ($cp->_cpm_amount){
                            case 5000 :
                                $input['duree_service'] = 1;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            case 10000 :
                                $input['duree_service'] = 2;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            case 15000 :
                                $input['duree_service'] = 3;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            case 20000 :
                                $input['duree_service'] = 4;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            /*case 100:
                                $input['type_service'] = 'Test';
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            default :
                                break;
                        }*/
                    }
                    if($infoService->type_service == 'Tête de liste'){
                        $puFormule = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
                        $servicePu = $puFormule->montant_service;
                        $service = 'slider';
                        /*switch ($cp->_cpm_amount){
                            case 3000 :
                                $input['duree_service'] = 1;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            case 6000 :
                                $input['duree_service'] = 2;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            case 9000 :
                                $input['duree_service'] = 3;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            case 12000 :
                                $input['duree_service'] = 4;
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            /*case 100:
                                $input['duree_service'] = 'Test';
                                $input['montant'] = $cp->_cpm_amount;
                                break;
                            default :
                                break;
                        }*/
                    }
                    if($infoService->montant != $cp->_cpm_amount || $infoService->duree_service != $cp->_cpm_amount/$servicePu )
                        return redirect()->route('alu.index')->with('erreur','le paiement a echoué');

                    $input['duree_service'] = $infoService->duree_service;
                    $input['montant'] = $cp->_cpm_amount;
                    $input['status_service'] = 1;
                    $input['status_admin'] = 0;
                    //return $cp->_cpm_amount;
                    $this->alaunes->updateData($idService[1],$input);
                    /*echo 'Felicitation, votre paiement a été effectué avec succès';*/
                    die();
                } else {
                    echo 'Echec, votre paiement a échoué pour cause : ' . $cp->_cpm_error_message;
                    $input['status_service'] = 2;
                    $this->alaunes->updateData($idService[1],$input);
                    die();
                }

                // On verifie que le paiement est valide
            } catch (\Exception $e) {
                // Une erreur s'est produite
                //echo "Erreur :" . $e->getMessage();
                return redirect()->route('alu.index')->with('erreur','le paiement a echoué');
            }
        } else {
            // redirection vers la page d'accueil
            //die();
            return redirect()->route('alu.index')->with('erreur','le paiement a echoué');
        }

    }

    public function returnUrl()
    {
        if(isset($_POST['cpm_trans_id'])) {
            // SDK PHP de CinetPay
            //dd('on entre même pas dans try');
            try {
                // Initialisation de CinetPay et Identification du paiement
                $id_transaction = $_POST['cpm_trans_id'];
                //Veuillez entrer votre apiKey et site ID
                $apiKey = "12225072435af2f658189760.36336854";
                $site_id = "332112";
                $plateform = "PROD";
                $version = "V1";
                $CinetPay = new CinetPay($site_id, $apiKey, $plateform, $version);
                //Prise des données chez CinetPay correspondant à ce paiement
                $CinetPay->setTransId($id_transaction)->getPayStatus();
                $cpm_site_id = $CinetPay->_cpm_site_id;
                $signature = $CinetPay->_signature;
                $cpm_amount = $CinetPay->_cpm_amount;
                $cpm_trans_id = $CinetPay->_cpm_trans_id;
                $cpm_custom = $CinetPay->_cpm_custom;
                $cpm_currency = $CinetPay->_cpm_currency;
                $cpm_payid = $CinetPay->_cpm_payid;
                $cpm_payment_date = $CinetPay->_cpm_payment_date;
                $cpm_payment_time = $CinetPay->_cpm_payment_time;
                $cpm_error_message = $CinetPay->_cpm_error_message;
                $payment_method = $CinetPay->_payment_method;
                $cpm_phone_prefixe = $CinetPay->_cpm_phone_prefixe;
                $cel_phone_num = $CinetPay->_cel_phone_num;
                $cpm_ipn_ack = $CinetPay->_cpm_ipn_ack;
                $created_at = $CinetPay->_created_at;
                $updated_at = $CinetPay->_updated_at;
                $cpm_result = $CinetPay->_cpm_result;
                $cpm_trans_status = $CinetPay->_cpm_trans_status;
                $cpm_designation = $CinetPay->_cpm_designation;
                $buyer_name = $CinetPay->_buyer_name;

                $idService = explode('-',$id_transaction);
                $input=array();

                $infoService = $this->alaunes->getDataByServiceId($idService[1]);

                if($cpm_result == '00'){
                    if($infoService->type_service == 'Slider'){
                        $puFormule = FormuleService::where('id_service',4)->where('type_service','slider')->first();
                        $servicePu = $puFormule->montant_service;
/*                        switch ($cpm_amount){
                            case 5000 :
                                $input['duree_service'] = 1;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 10000 :
                                $input['duree_service'] = 2;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 15000 :
                                $input['duree_service'] = 3;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 20000 :
                                $input['duree_service'] = 4;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 100:
                                $input['type_service'] = 'Test';
                                $input['montant'] = $cpm_amount;
                                break;
                            default :
                                break;
                        }*/
                    }

                    if($infoService->type_service == 'Tête de liste'){
                        $puFormule = FormuleService::where('id_service',4)->where('type_service','tete-de-liste')->first();
                        $servicePu = $puFormule->montant_service;
                        /*switch ($cpm_amount){
                            case 3000 :
                                $input['duree_service'] = 1;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 6000 :
                                $input['duree_service'] = 2;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 9000 :
                                $input['duree_service'] = 3;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 12000 :
                                $input['duree_service'] = 4;
                                $input['montant'] = $cpm_amount;
                                break;
                            case 100:
                                $input['duree_service'] = 'Test';
                                $input['montant'] = $cpm_amount;
                                break;
                            default :
                                break;
                        }*/
                    }
                    if($infoService->montant != $cpm_amount || $infoService->duree_service != $cpm_amount/$servicePu )
                        return redirect()->route('alu.index')->with('erreur','le paiement a echoué');
                    $input['duree_service'] = $infoService->duree_service;
                    $input['montant'] = $cpm_amount;
                    $input['status_service'] = 1;
                    $input['status_admin'] = 0;

                    //return $cp->_cpm_amount;
                    $this->alaunes->updateData($idService[1],$input);
                    return redirect()->route('alu.index')->with('success','le paiement a été effectué avec succès');
                    //Le paiement est bon
                    // Verifier que le montant correspond à la transaction dans votre système
                    // Traitez dans la base de donnée et delivrez le service au client
                }else{
                    //Le paiement a échoué
                    $this->cinetpayCancel();
                    return redirect()->route('alu.index')->with('erreur','le paiement a echoué');
                }
            } catch (Exception $e) {
                return redirect()->route('alu.index')->with('erreur','le paiement a echoué');
            }
        } else {
            // Tentative d'accès direct au lien IPN
            $this->cancelUrl();
        }
    }

    public function cancelUrl(){
        //dd($request, 'quelquechose');
        return redirect()->route('alu.index')->with('erreur', 'vous avez annulé votre transaction');
    }

}
