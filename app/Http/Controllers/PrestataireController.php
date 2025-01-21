<?php

namespace App\Http\Controllers;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Storage;
use App\Prestataire;
use App\SouscPrestataire;
use App\PrestataireCategory;
use App\FormulePrestataire;
use App\Http\Controllers\CinetPayController;
use App\Http\Controllers\CinetPay;
use App\Realisation;
use App\Service;
use File;
use App\ImageUpload;
use Validator;
use Mail;
use Carbon\Carbon;
use App\FormuleService;
use App\Frontuser;
use DB;
use App\PaysList;

class PrestataireController extends FrontController
{

    public function __construct()
    {
        parent::__construct();
        $this->prestataires = new Prestataire;
        $this->souscprestataires = new SouscPrestataire;
        $this->services = new Service;
        $this->realisations = new Realisation;
        $this->cinetpayControls = new CinetPayController;
        $this->prestatairesearch = new PrestataireCategory;
        $this->formule_prestataire = new FormulePrestataire;
        $this->formule_service = new FormuleService;
        $this->pays = new PaysList;
//      $this->cinetpay= new CinetPay;
    }


    public function searchhomepage(Request $request)
    {
        $input = $request->all();
        // dd($request);
        $input['categories'] = ($input['categories'] == 'Categorie') ? NULL : $input['categories'];
        $input['pays'] = ($input['pays'] == 'Pays') ? NULL : $input['pays'];
        //dd($input['categories'], $input['pays']);
        if (empty($input['p_name']) && empty($input['categories']) && empty($input['pays'])) return $this->index2();
        $prestList = $this->prestataires->getPrestataireBySearch($input['p_name'], $input['categories'], $input['pays']);
        
        $paysList = PaysList::orderBy('nom_pays','ASC')->get();   
        $categories=PrestataireCategory::where("category_status","1")->orderBy('category_name','ASC')->get();    
        return view('theme.services.prestataires.prestataire-list', compact('prestList','paysList','categories'));
    }

    public function index()
    {
        $id = auth()->guard('frontuser')->user()->id;
        $datas = Prestataire::where('id_frontusers', $id)
            ->orderby('id','DESC')
            ->get();
            
        /*$payment = $this->souscprestataires->getLastDataPaymentByPrestataireId($id);*/
        /*$allPayment = $this->souscprestataires->getLatestData();*/
		// dd($allPayment);
		
        $service = $this->formule_service->getdatabyservicetype(3);
        if (count($datas) == 0):
            return redirect()->route('pre.create');
        else:
            /*$input = array('formule'=>'6 mois','montant'=>'25000','status'=>'1');
            $seeBeforeMaj = $this->souscprestataires->getDataById(14);

            $this->souscprestataires->updateLastData(14,$input);
            $seeMaj = $this->souscprestataires->getDataById(14);
            dd($seeBeforeMaj,$seeMaj);*/
            
        return view('theme.services.prestataires.prestataire-index', compact('datas', /*'payment', 'allPayment'*/'service'));
    endif;
    }

    public function index2()
    {
        setMetaData('Liste des Prestataires', '', 'create prestataire,prestataire,new prestataire', for_logo());
        $prestList = $this->prestataires->getData();
        $paysList = PaysList::orderBy('nom_pays','ASC')->get();   
        $categories=PrestataireCategory::where("category_status","1")->orderBy('category_name','ASC')->get();    
        return view('theme.services.prestataires.prestataire-list', compact('prestList','paysList','categories'));
    }

    public function show($slug)
    {
        $data = $this->prestataires->findDataSlug($slug);
        if (!isset($data)) {
            \App::abort(404, 'Organization Not Found');
        }

        if (isset($data) && $data->status == 0) {
            $user_id = (auth()->guard('frontuser')->check() ? auth()->guard('frontuser')->user()->id : 0);
            if ($user_id != $data->id_frontusers) {
                \App::abort(404, 'Organisation introuvable');
            }
        }
        if (isset($data) && $data->ban == 1) {
            $user_id = (auth()->guard('frontuser')->check() ? auth()->guard('frontuser')->user()->id : 0);
            if ($user_id != $data->id_frontusers) {
                \App::abort(404, 'Organization Not Found');
            }
        }
        $user = Frontuser::where('id',$data->id_frontusers)->first();
		$catdata = DB::table('prestataire_category')->where('prestataire_category.id', $data->activites)->get();
		
        $realisations = $this->realisations->getById($data->id);
        return view('theme.services.prestataires.prestataire-show', compact('data', 'realisations','user','catdata'));
    }

    public function create()
    {
        $id = auth()->guard('frontuser')->user()->id;
        $prestList = $this->prestataires->getAllist($id);
        $datas = Prestataire::where('id_frontusers', $id)->get();
		
		$catdata = DB::table('prestataire_category')->where("category_status",1)->orderby('prestataire_category.category_name', 'ASC')->get();

        if (count($datas) < 10) {
            return view('theme.services.prestataires.prestataire-create', compact('prestList','catdata'));
        } else {
            return redirect()->route('pre.index');
        }
    }

    public function store(Request $request)
    {   
        $input = $request->all();
        $this->validate($request, [
            'profile_pics' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'cover' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'lastname' => 'required',
            'firstname' => 'required',
            'activites' => 'required',
            'descriptions' => 'required',
            'adresse_mail' => 'required',
            'website' => 'nullable|url',
            'imgreal' => 'required',
        ]);
        

        $input['affiche_desc'] = isset($input['affiche_desc']) ? $input['affiche_desc'] : 0;
        //$input['status'] = isset($input['status'])?$input['status']:0;
        $path = 'upload/user/' . date('Y') . '/' . date('m');

        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }

        if (!empty($request->file('profile_pics'))) {

            $input['profile_pics'] = ImageUpload::upload($path, $request->file('profile_pics'), 'prestataire');
            ImageUpload::uploadThumbnail($path, $input['profile_pics'], 400, 400);
            $input['profile_pic'] = save_image($path, $input['profile_pics']);
            $input['url_slug'] = str_slug($input['firstname']) . '-' . str_shuffle(time());
        }

        if (!empty($request->file('cover'))) {
            $image = $request->file('cover');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $new_name);
            $input['cover']='public/'.$path.'/'. $new_name;
        }

        /*if(isset($input['org_link_slug'])){
            $input['org_link_slug'] = $input['org_link_slug'];
        }else{
            $input['org_link_slug'] = $input['url_slug'];
        }*/


        $input['status'] = 3;
        $input['activites'] = ($input['activites'] == 'activites') ? '' : $input['activites'];
        $this->prestataires->insertData($input);
        $lastPrestId = Prestataire::select('id')
            ->where('id_frontusers', auth()->guard('frontuser')->user()->id)
            ->latest()
            ->first();
        //dd($inputt, $request);
		
        $result = static::saveRealisation($input['imgreal'], $lastPrestId->id);

        /*$from = $input['email'];
        $subject = $input['subject'];

        $mail = array($input['org_mail']);
        try {
            \Mail::send('pages.org-contact', ['userdata' => $input], function ($message) use ($mail, $subject, $from) {
                $message->from($from);
                $message->to($mail);
                $message->subject($subject);
            });
        } catch (\Exception $e) {
            return \Response::json(['success' => 'Message sent successfully.']);
        }*/

        if ($result) {
            return redirect()->route('pre.index');
        } else {
            return redirect()->route('pre.create')->withErrors('error', 'Une erreur s\'est produite');
        }
    }

    public function saveRealisation(array $realisations, $id)
    {	
		ini_set("post_max_size", "5M");
		ini_set("upload_max_filesize", "5M");
		
        $path = 'upload/user/' . date('Y') . '/' . date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }
        if (isset($realisations) && isset($id)) {
            $norealisation = count($realisations);
            $tableRealisation = array();
            //dd($realisations, $id);
            $x=0;
            for ($i = 0; $i < $norealisation; $i++) {
				if($realisations[$i]->getSize()>0){
					$realisations[$i] = ImageUpload::upload($path, $realisations[$i], 'realisation-prestataire');
					ImageUpload::uploadThumbnail($path, $realisations[$i], 200, 200);
					$tableRealisation['realisation'] = save_image($path, $realisations[$i]);
					$tableRealisation['id_prestataire'] = $id;
					$data = $this->realisations->insertData($tableRealisation);
				}
                $x++;
            }
        }
        if ($x == $norealisation) {
            return 1;
        } else {
            return 0;
        }
    }

    public function org_insert(Request $request)
    {
        $input = $request->all();
        $useId = auth()->guard('frontuser')->user()->id;

        $validator = Validator::make($input, [
            'organizer_name' => 'required',
        ]);

        $input['display_dis'] = 1;
        $input['status'] = 1;
        $input['user_id'] = $useId;
        $input['url_slug'] = str_slug($input['organizer_name']) . '-' . str_shuffle(time());
        $input['org_link_slug'] = $input['url_slug'];

        if ($validator->passes()) {
            $data = $this->organization->insertData($input);
            return response()->json(['org_id' => $data->id, 'org_name' => $data->organizer_name]);
        } else {
            return response()->json(['errors' => $validator->errors()]);
        }
    }

    public function edit($slug)
    {
        $id = auth()->guard('frontuser')->user()->id;
        $prestList = $this->prestataires->getAllist($id);
        $data = $this->prestataires->findDataSlug($slug);
        /*dd($P_realisations);*/
        if (!isset($data)) {
            \App::abort(404, 'Prestataire Not Found');
        }
        $P_realisations = $this->realisations->getById($data->id);
        return view('theme.services.prestataires.prestataire-update', compact('data', 'prestList', 'P_realisations'));
    }

    public function update(Request $request, $slug)
    {
        $input = $request->all();
        $data = $this->prestataires->findDataSlug($slug);
        //$input['org_link_slug'] = str_slug($input['org_link_slug']);

        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'activites' => 'required',
            'descriptions' => 'required',
            'adresse_mail' => 'required',
            'website' => 'nullable|url',
        ]);

        $input['affiche_desc'] = isset($input['affiche_desc']) ? 1 : 0;
        //$path = '/public/upload/user/'.date('Y').'/'.date('m');
        $path = 'upload/user/' . date('Y') . '/' . date('m');


        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }

        if (!empty($request->file('profile_pics'))) {
            if(isset($data['profile_pic']) && $data['profile_pic'] != '') {
                $datas = image_delete($data['profile_pic']);
                $path = $datas['path'];
                $image = $datas['image_name'];
                $image_thum = $datas['image_thumbnail'];
                $image_resize = 'resize-'.$datas['image_name'];
                ImageUpload::removeFile($path,$image,$image_thum,$image_resize);
            }
            $input['profile_pics'] = ImageUpload::upload($path, $request->file('profile_pics'), 'prestataire');
            ImageUpload::uploadThumbnail($path, $input['profile_pics'], 400, 400);
            $input['profile_pic'] = save_image($path, $input['profile_pics']);
            $input['url_slug'] = str_slug($input['firstname']) . '-' . str_shuffle(time());
        }

        if (!empty($request->file('cover'))) {
            if (\File::exists(public_path($input['cover']))) {
                \File::delete((public_path($data['cover'])));
            }
            $image = $request->file('cover');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $new_name);
            $input['cover'] = 'public/' . $path . '/' . $new_name;
        }

        $this->prestataires->updatepreData($slug, $input);

        if (isset($input['images'])) {

            $result = static::updateRealisation($request, $slug);
            if ($result) {
                return redirect()->route('pre.index')->with('success', 'Mise à jour effectuée avec succès');
            } elseif ($result == 2) {
                return redirect()->route('pre.create');
            } else {
                return redirect()->route('pre.create')->with('failed', 'Une erreur s\'est produite');
            }
        }
        return redirect()->route('pre.index')->with('success', 'Mise à jour effectuée avec succès');
    }

    public function updateRealisation(Request $request, $slug)
    {
        $input = $request->all();
        $path = 'upload/user/' . date('Y') . '/' . date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }
        $prestataires = Prestataire::where('url_slug',$slug);
        //dd($input, $id);
        if ($input['images']!= null && isset($slug)) {
            $norealisation = count($input['images']);
            //dd($input['images'][1], $input['images'][0], $id, $norealisation);
            $tableRealisation = array();
            //dd($norealisation, $id);
            for ($i = 0; $i < $norealisation; $i++) {
                // images
                $this->validate($request,
                    [
                        "images.$i" => 'required|image|mimes:jpeg,jpg,png|max:2000',
                    ]);
                $input['images'][$i] = ImageUpload::upload($path, $input['images'][$i], 'realisation-prestataire');
                ImageUpload::uploadThumbnail($path, $input['images'][$i], 200, 200);
                $tableRealisation['realisation'] = save_image($path, $input['images'][$i]);
                $tableRealisation['id_prestataire'] = $prestataires->id;
                $data = $this->realisations->insertData($tableRealisation);
            }
        }
        if ($i == $norealisation) {
            return 1;
        } else {
            return 0;
        }
    }


    public function pre_detail($slug)
    {
        $data = $this->prestataires->findDataSlug($slug);
        if (!isset($data)) {
            \App::abort(404, 'Prestataire Not Found');
        }

        if (isset($data) && $data->status == 0) {
            $user_id = (auth()->guard('frontuser')->check() ? auth()->guard('frontuser')->user()->id : 0);
            if ($user_id != $data->user_id) {
                \App::abort(404, 'Prestataire Not Found');
            }
        }
        if (isset($data) && $data->ban == 1) {
            $user_id = (auth()->guard('frontuser')->check() ? auth()->guard('frontuser')->user()->id : 0);
            if ($user_id != $data->user_id) {
                \App::abort(404, 'Prestataire Not Found');
            }
        }

        $events = $this->event->event_by_org($data->id);
        return view('theme.prestataires.prestataire-show', compact('data', 'events'));
    }

    public function customLink($slug)
    {
        $data = $this->organization->findDataSlugURL($slug);
        return redirect()->route('org.detail', $data->url_slug);
    }

    public function delete($slug)
    {
        $this->prestataires->deleteData($slug);
        return redirect()->route('pre.index')->with('success', trans('words.msg.org_deleted'));
    }

    public function reaDelete($id, $slug)
    {
        if (!empty($id)) {
            $this->realisations->deleteData($id);
        }
        return $this->edit($slug);
        /*return redirect()->route('pre.edit');*/
    }

    public function orgContact(Request $request)
    {
        $input = $request->all();
        $from = $input['email'];
        $subject = $input['subject'];

        $mail = array($input['org_mail']);
        try {
            \Mail::send('pages.org-contact', ['userdata' => $input], function ($message) use ($mail, $subject, $from) {
                $message->from($from);
                $message->to($mail);
                $message->subject($subject);
            });
        } catch (\Exception $e) {
            return \Response::json(['success' => 'Message sent successfully.']);
        }
        return \Response::json(['success' => 'Message sent successfully.']);
    }

    public function updateSlug(Request $request)
    {
        $input = $request->all();
        $input['slug'] = str_slug($input['slug']);
        $validator = Validator::make($input, [
            'slug' => 'required|unique:organizations,url_slug,' . $input['id'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first());
        }

        $getRouteCollection = \Route::getRoutes();
        $url = [];
        foreach ($getRouteCollection as $route) {
            $url = explode('/', $route->uri());
            $data[] = $url[0];
        }
        $data = array_unique($data);
        $reserveurl = array_values($data);

        if (in_array($input['slug'], $reserveurl)) {
            return response()->json('This url is reserved by system.');
        }

        $slug['url_slug'] = $input['slug'];

        $this->organization->updateorgrData($input['id'], $slug);

        return response()->json(['success' => 'Site settings profile url updated.', 'data' => route('org.detail', $slug['url_slug']), 'url' => route('org.edit', $slug['url_slug'])]);
    }

    public function orgSubmit(Request $request)
    {
        $input = $request->all();
        $mail = array(user_data($input['org_id'])->email);
        $odata = user_data($input['org_id'])->fullname;
        try {
            \Mail::send('theme.reset.contact', ['data' => $input, 'odata' => $odata], function ($message) use ($mail) {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Contact To Organizer');
            });
        } catch (\Exception $e) {
            return response()->json(['success' => "Organizer will review and be in touch soon."]);
        }
        return response()->json(['success' => "Organizer will review and be in touch soon."]);
    }

    public function preContact(Request $request){
        $input = $request->all();
        $from = $input['email'];
        $subject = $input['subject'];

        $mail = array($input['org_mail']);
        try {
            \Mail::send('pages.org-contact',['userdata'=>$input],function($message) use ($mail,$subject,$from){
                $message->from($from);
                $message->to($mail);
                $message->subject($subject);
            });
        } catch (\Exception $e) {
            return \Response::json(['error' => 'Message Not sent']);
        }
        return \Response::json(['success' => 'Message sent successfully.']);
    }

    public function generateForm(Request $request)
    {
        $input =$request->all();
        $puFormule = FormuleService::where('id_service',3)->first();
        $prestataire = Prestataire::where('url_slug', $input['url_slug'])->first();
        if(!isset($puFormule)) \App::abort(404, 'Page Introuvable');
        $this->validate($request, [
            'formule' => 'required',
        ]);
        if($input['formule']<=0)return redirect()->route('pre.index')->with('erreur', 'Valeur non autorisée('.$input['formule'].')');
        $frontuser = auth()->guard('frontuser')->user()->id;
        if($input['montant']!= $input['formule']*$puFormule->montant_service) return redirect()->back(); // envoyer un mail au webmaster
        $lastRecord = SouscPrestataire::where('id_prestataire',$prestataire->id)->where('id_frontuser',$frontuser)->latest()->first();
        if(isset($lastRecord) && $lastRecord->status == 0){
            $this->souscprestataires->deleteLastUpdate($frontuser);
            return redirect()->route('pre.index')->with('erreur', 'vous avez annulé votre transaction');
        }
        /*if ($id == null || $amount == null)
            \App::abort(404, 'Page Introuvable');

        if($id != auth()->guard('frontuser')->user()->id)
            \App::abort(404, 'Page Introuvable');*/
       /* $formule1 =  FormulePrestataire::where('id',1)->first();
        $formule2 =  FormulePrestataire::where('id',2)->first();
        $formule3 =  FormulePrestataire::where('id',3)->first();
        switch ($amount){
            case $formule1->montant :
                $amount = $formule1->montant;
                $formule = $formule1->id;
                break;
            case $formule2->montant :
                $amount = $formule2->montant;
                $formule = $formule2->id;
                break;
            case $formule3->montant :
                $amount = $formule3->montant;
                $formule = $formule3->id;
                break;
            /*case 100:
                $amount = 100;
                $formule = 0;
                break;
            default :
                    \App::abort(404, 'Page Introuvable');
                    break;
        }*/

        $idFrontuser = auth()->guard('frontuser')->user()->id;
        $apiKey = "12225072435af2f658189760.36336854"; //Veuillez entrer votre apiKey
        $site_id = "332112"; //Veuillez entrer votre siteId

        //$id_transaction = CinetPay::generateTransId(); // Identifiant du Paiement
        $id_transaction = $idFrontuser.'-'.$prestataire->id.'-'. CinetPay::generateTransId(); // Identifiant du Paiement
        $description_du_paiement = sprintf('Paiement Mise à la une n°%', $id_transaction); // Description du Payment
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système

        //$montant_a_payer = mt_rand(5, 100); // Montant à Payer : minimun est de 5 francs sur CinetPay
        $montant_a_payer = $input['montant']; // Montant à Payer : minimun est de 5 francs sur CinetPay

        // $identifiant_du_payeur = 'payeur@domaine.ci'; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
        $identifiant_du_payeur = $prestataire->id;

        $formName = "goCinetPay"; // nom du formulaire CinetPay
        $notify_url = route('pre.cinetpaynotify'); // Lien de notification CallBack CinetPay (IPN Link)
        $return_url = route('pre.cinetpayreturn'); // Lien de retour CallBack CinetPay
        $cancel_url = route('pre.cinetpaycancel'); // Lien d'annulation CinetPay
        // Configuration du bouton
        /*$btnType = 2;//1-5xwxxw
        $btnSize = 'large'; // 'small' pour reduire la taille du bouton, 'large' pour une taille moyenne ou 'larger' pour  une taille plus grande*/

        //Enregistrement montant
//        dd($service);

        $iinput = array();
        $iinput['id_frontuser'] = $idFrontuser;
        $iinput['id_prestataire'] = $prestataire->id;
        $iinput['formule'] = $input['formule'];
        $iinput['montant'] = $montant_a_payer;
        $iinput['status'] = 0;
        $iinput['payment_id'] = $id_transaction;
        $iinput['payment_gateway'] = 'CINETPAY';

        //dd($input);


        $this->souscprestataires->insertData($iinput);
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

                $idService = explode('-', $id_transaction);
                $input = array();
                $idFront = $idService[0];
                $idPrest = $idService[1];

                //$latestData = $this->souscprestataires->getLatestData($idPrest);
                if ($cpm_result == '00') {
                    //$paymentDate = Carbon::now();
                    $souscPrestataires = SouscPrestataire::where('payment_id',$id_transaction)->first();
                    $formuleService = FormuleService::where('id_service',3)->first();

                    //------ Action en cas de fraude
                    if($cpm_amount%$formuleService->montant_service != 0)
                    {
                        $this->souscprestataires->deleteLastUpdate($idFront);
                        return redirect()->route('pre.index')->with('erreur', 'Erreur lors du paiement, veullez reessayer');
                    }

                    if($souscPrestataires->formule != $cpm_amount/$formuleService->montant_service){
                        $this->souscprestataires->deleteLastUpdate($idFront);
                        return redirect()->route('pre.index')->with('erreur', 'Erreur lors du paiement, veullez reessayer');
                    }
                    //------ Fin Action en cas de fraude
                    /*switch ($cpm_amount) {
                        case 10000 :
                            $cpm_amount = 10000;
                            $formule = 1;
                            $input['payment_expire'] = $paymentDate->addMonth();
                            break;
                        case 25000 :
                            $cpm_amount = 25000;
                            $formule = 2;
                            $input['payment_expire'] = $paymentDate->addMonths(6);
                            break;
                        case 35000 :
                            $cpm_amount = 35000;
                            $formule = 3;
                            $input['payment_expire'] = $paymentDate->addYear();
                            break;
                        /*case 100:
                            $cpm_amount = 100;
                            $formule = 0;
                            $input['payment_expire'] = $paymentDate->addDays(3);
                            break;
                        default :
                            $input['payment_trans_status'] = 'Fraude';
                            $input['payment_amount'] = $cpm_amount;
                            $input['payment_phone_prefixe'] = $cpm_phone_prefixe;
                            $input['payment_phone_number'] = $cel_phone_num;
                            $input['payment_ipn_ack'] = $cpm_ipn_ack;
                            $this->souscprestataires->updateLastData($idPrest, $input);
                            \App::abort(404, 'Formule non disponible');
                            break;
                    }*/
                    $input['status'] = 1;
                    //$input['payment_expire'] = $paymentDate->addMonth($souscPrestataires->formule);
                    $input['payment_trans_status'] = $cpm_trans_status;
                    $input['payment_amount'] = $cpm_amount;
                    $input['payment_phone_prefixe'] = $cpm_phone_prefixe;
                    $input['payment_phone_number'] = $cel_phone_num;
                    $input['payment_ipn_ack'] = $cpm_ipn_ack;
                    $input['payment_designation'] = $cpm_designation;
                    $input['payment_buyer_name'] = $buyer_name;
                    $input['payment_date'] = $created_at;

                    $this->souscprestataires->updateLastData($idPrest, $input);
                    Prestataire::where('id',$idPrest)->update(['status'=>2]);
                    return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                    //Le paiement est bon
                    // Verifier que le montant correspond à la transaction dans votre système
                    // Traitez dans la base de donnée et delivrez le service au client
                }else{
                    //Le paiement a échoué
                    $this->cinetpayCancel();
                    return redirect()->route('pre.index')->with('erreur','le paiement a echoué');
                }
            } catch (Exception $e) {
                return redirect()->route('pre.index')->with('erreur','le paiement a echoué');
            }
        } else {
            // Tentative d'accès direct au lien IPN
            $this->notifyUrl();
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
                $idFront = $idService[0];
                $idPrest = $idService[1];
                //return $this->testNotifyUrl($idPrestataire[0],'notifyUrl');
                $input=array();

                $infoService = $this->alaunes->getDataByServiceId($idService[1]);

                // Recuperation de la ligne de la transaction dans votre base de données
                // Verification de l'etat du traitement de la commande

                // Si le paiement est bon alors ne traitez plus cette transaction : die();

                // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
                if ($cp->isValidPayment()) {
                    //$paymentDate = Carbon::now();
                    $souscPrestataires = SouscPrestataire::where('payment_id',$id_transaction)->first();
                    $formuleService = FormuleService::where('id_service',3)->first();

                    //------ Action en cas de fraude
                    if($cp->_cpm_amount%$formuleService->montant_service != 0)
                    {
                        $this->souscprestataires->deleteLastUpdate($idFront);
                        return redirect()->route('pre.index')->with('erreur', 'Erreur lors du paiement, veullez reessayer');
                    }

                    if($souscPrestataires->formule != $cp->_cpm_amount/$formuleService->montant_service){
                        $this->souscprestataires->deleteLastUpdate($idFront);
                        return redirect()->route('pre.index')->with('erreur', 'Erreur lors du paiement, veullez reessayer');
                    }
                    //------ Fin Action en cas de fraude
                    /*switch ($cpm_amount) {
                        case 10000 :
                            $cpm_amount = 10000;
                            $formule = 1;
                            $input['payment_expire'] = $paymentDate->addMonth();
                            break;
                        case 25000 :
                            $cpm_amount = 25000;
                            $formule = 2;
                            $input['payment_expire'] = $paymentDate->addMonths(6);
                            break;
                        case 35000 :
                            $cpm_amount = 35000;
                            $formule = 3;
                            $input['payment_expire'] = $paymentDate->addYear();
                            break;
                        /*case 100:
                            $cpm_amount = 100;
                            $formule = 0;
                            $input['payment_expire'] = $paymentDate->addDays(3);
                            break;
                        default :
                            $input['payment_trans_status'] = 'Fraude';
                            $input['payment_amount'] = $cpm_amount;
                            $input['payment_phone_prefixe'] = $cpm_phone_prefixe;
                            $input['payment_phone_number'] = $cel_phone_num;
                            $input['payment_ipn_ack'] = $cpm_ipn_ack;
                            $this->souscprestataires->updateLastData($idPrest, $input);
                            \App::abort(404, 'Formule non disponible');
                            break;
                    }*/
                    $input['status'] = 1;
                    //$input['payment_expire'] = $paymentDate->addMonth($souscPrestataires->formule);
                    $input['payment_trans_status'] = $cpm_trans_status;
                    $input['payment_amount'] = $cpm_amount;
                    $input['payment_phone_prefixe'] = $cpm_phone_prefixe;
                    $input['payment_phone_number'] = $cel_phone_num;
                    $input['payment_ipn_ack'] = $cpm_ipn_ack;
                    $input['payment_designation'] = $cpm_designation;
                    $input['payment_buyer_name'] = $buyer_name;
                    $input['payment_date'] = $created_at;

                    $this->souscprestataires->updateLastData($idPrest, $input);
                    Prestataire::where('id',$idPrest)->update('status',2);
                    return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                    //Le paiement est bon
                    // Verifier que le montant correspond à la transaction dans votre système
                    // Traitez dans la base de donnée et delivrez le service au client
                    /*if($infoService->type_service == 'Slider'){
                        switch ($cp->_cpm_amount){
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
                        }
                    }

                    if($infoService->type_service == 'Tête de liste'){
                        switch ($cp->_cpm_amount){
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
                        }
                    }
                    $input['status_service'] = 1;
                    $input['status_admin'] = 0;

                    //return $cp->_cpm_amount;
                    $this->alaunes->updateData($idService[1],$input);
                    /*echo 'Felicitation, votre paiement a été effectué avec succès';
                    die();*/
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
                return redirect()->route('pre.index')->with('erreur','le paiement a echoué');
            }
        } else {
            // redirection vers la page d'accueil
            //die();
            return redirect()->route('pre.index')->with('erreur','le paiement a echoué');
        }
    }


    public function cancelUrl(){
        //dd($request, 'quelquechose');
        $id = auth()->guard('frontuser')->user()->id;
        $this->souscprestataires->deleteLastUpdate($id);
        return redirect()->route('pre.index')->with('erreur', 'vous avez annulé votre transaction');
    }

    public function demande(Request $request){
        $input = $request->all();

        if($input['type_service'] == 'Séance de Shooting'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'categorie' => 'required',
                'date' => 'required',
                'lieu' => 'required'
            ]);
        }

        if($input['type_service'] == 'Capsules Vidéos'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'duree' => 'required'
            ]);
        }

        if($input['type_service'] == 'Animation Des Réseaux Sociaux'){
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'service' =>'required_without_all',
                'reseau' =>'required_without_all',
                'frequence' =>'required'
            ]);

            if(empty($input['service']) || empty($input['reseau']))
                return redirect()->back()->with('erreur','Remplissez correctement les champs');
        }

        if($input['type_service'] == 'Clip Musical'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'duree' => 'required',
                'recherche_lieu'=> 'required|in:Oui,Non',
                'booking_figurants'=> 'required|in:Oui,Non',
                'proposition_artistique'=> 'required|in:Oui,Non'
            ]);
        }

        if($input['type_service'] == 'Placement d\'Événements'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'categorie' => 'required',
                'lieu' => 'required'
            ]);
        }

        /*dd($input['service'],$input['reseau']);*/
        //$prestataire = Prestataire::where('url_slug', $input['prestataire'])->first();

        $formData = (object)$input;
        //$PrestataireData = (object)$prestataire;
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com'/*,'williamscedricdabo@gmail.com'*/);
        try {
            Mail::send('theme.pdf.mail-demande',['formData'=>$formData,/*'PrestataireData'=>$PrestataireData*/],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Demande de service');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
    return redirect()->back()->with('success', 'Demande envoyée avec succes');
    }

    public function demandeProfil(Request $request){
        $input = $request->all();

        if($input['type_service'] == 'Séance de Shooting'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'categorie' => 'required',
                'date' => 'required',
                'lieu' => 'required'
            ]);
        }

        if($input['type_service'] == 'Capsules Vidéos'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'duree' => 'required'
            ]);
        }

        if($input['type_service'] == 'Animation Des Réseaux Sociaux'){
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'service' =>'required_without_all',
                'reseau' =>'required_without_all',
                'frequence' =>'required'
            ]);

            if(empty($input['service']) || empty($input['reseau']))
                return redirect()->back()->with('erreur','Remplissez correctement les champs');
        }

        if($input['type_service'] == 'Clip Musical'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'duree' => 'required',
                'recherche_lieu'=> 'required|in:Oui,Non',
                'booking_figurants'=> 'required|in:Oui,Non',
                'proposition_artistique'=> 'required|in:Oui,Non'
            ]);
        }

        if($input['type_service'] == 'Placement d\'Evénements'){
            /*dd($input);*/
            $this->validate($request, [
                'nom_prenoms' => 'required',
                'adresse_mail' => 'required',
                'telephone' => 'required',
                //'prestataire' => 'required',
                'categorie' => 'required',
                'lieu' => 'required'
            ]);
        }

        /*dd($input['service'],$input['reseau']);*/
        //$prestataire = Prestataire::where('url_slug', $input['prestataire'])->first();

        $formData = (object)$input;
        //$PrestataireData = (object)$prestataire;
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com'/*,'williamscedricdabo@gmail.com'*/);
        try {
            Mail::send('theme.pdf.mail-demande',['formData'=>$formData,/*'PrestataireData'=>$PrestataireData*/],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Demande de service');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
        return redirect()->back()->with('success', 'Demande envoyée avec succes');
    }
	
	
	
    public function prestatairesbycats() {
        $xx=""; $cat="";
        if(isset($_GET['page'])){
            $offset=($_GET['page']*15)-1;
        }else{
             $offset=0;
        }
        
        if(isset($_GET['cat'])){
            $cat=$_GET['cat']; 
            if($_GET['cat']=='all') $cat='';
        }
        
        $start  = Carbon::today();
        $dataInfos = DB::table("prestataires")->select(DB::raw("prestataires.*, prestataire_category.*, prestataire_category.category_name as this_prestataire_category"))
			->leftJoin('prestataire_category', 'prestataire_category.id', '=', 'prestataires.activites')
			->where('prestataires.status', 1)
            ->orderby('prestataires.id', 'DESC')
            ->offset($offset)->limit(15)->get();
            //$dataInfos->paginate(15);
        
        if ($cat != '') {  
            $catdata = DB::table('prestataire_category')->where('prestataire_category.id', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);            
            
            $dataInfos = DB::table("prestataires")->select(DB::raw("prestataires.*, prestataire_category.*, prestataire_category.category_name as this_prestataire_category"))
			->leftJoin('prestataire_category', 'prestataire_category.id', '=', 'prestataires.activites')
            ->where('prestataires.status','1')
            ->whereIn('activites', $ids)
            ->orderby('prestataires.id', 'DESC')
            ->offset($offset)->limit(15)->get();
        }
        
		
        foreach($dataInfos as $data){
            if($data->status == 1){
               
$nom = (!empty($data->pseudo))? $data->pseudo:($data->firstname.' '.$data->lastname);
				
$xx.='<div class="col-lg-4 col-md-6 col-sm-12 hover ">
           
    <div class="box-icon pull-right share-listing">
        <a href="javascript:void()" data-toggle="tooltip"
           data-original-title="Partager ce prestataire"
           data-placement="right" class="event-share"
           data-url="'.route('pre.detail',$data->url_slug).'"
           data-name="'.$nom.'">
            <i class="fas fa-share"></i>
        </a>
    </div> ';   
    
  $xx.='<div class="box-icon pull-right like-listing">';
        if(auth()->guard('frontuser')->check()){
            $userid = auth()->guard('frontuser')->user()->id;
        }else{
            $userid = '';
        }
                
    $xx.='<a href="javascript:void(0)" data-toggle="tooltip"
           data-original-title="Enregistrer ce prestataire"
           data-placement="right" id="save-event" class="save-event" data-user="'.$userid.'"
           data-event="'.$data->id.'" data-mark="0">';
                
            if(is_null(getbookmark($data->id, $userid)))
                $xx.='<i class="far fa-heart"></i>';
            else
                $xx.='<i class="fas fa-heart"></i>';
            
        $xx.='</a>
    </div>';
    
   $xx.='<div class="box" style="position: relative;">
   
   		<a href="'.route('pre.detail',$data->url_slug).'"><div class="bunique" style="background-image: url(\''.url($data->cover).'\'); "></div></a>
		
		<div class="box-content card__padding prestBox">
            <div class="innercardbox">
                 
                <div class="left_pbox">
                        <a href="'.route('pre.detail',$data->url_slug).'" class="">
							<img class="pimgprof" src="'.setThumbnail($data->profile_pic).'" alt="'.$nom.'">
						</a>                    
                </div>
   
   			   <div class="right_pbox"> 
						<h4 class="card-title"><a  href="'.route('pre.detail',$data->url_slug).'">'.$nom.'</a></h4>
                                   
                    <div class="badge category" style="cursor: default">
                          <a href="'.route('prestataire').'?cat='.$data->activites.'"><span class="">
                           '.$data->this_prestataire_category.'
                          </span></a>
                    </div> 
					
					<div class="descBox">'.$data->descriptions.'</div>
                     
					<div class="geoCard card__location-content">
						<i class="fas fa-map-marker-alt third-color"></i>
						<a href="" rel="tag" class="adgeo third-color">'.$data->adresse_geo.'</a>
					</div>
                    
                </div> 
    
   			</div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>';               
               
               
            }
        }
        if($_GET['cat']!='all'){ if($xx==null) $xx=0; }
        return $xx;
    }


		
	
    public function prestatairesbytopcats() {
        
        $xx=""; $cat="";
        if(isset($_GET['page'])){
            $offset=($_GET['page']*15)-1;
        }else{
             $offset=0;
        }
        
        if(isset($_GET['cat'])){
            $cat=$_GET['cat']; 
            if($_GET['cat']=='all') $cat='';
        }
 		
        $start  = Carbon::today();
         $dataInfos = DB::table("prestataires")->select(DB::raw("prestataires.*, prestataire_category.*, prestataire_category.category_name as this_prestataire_category"))
			->leftJoin('prestataire_category', 'prestataire_category.id', '=', 'prestataires.activites')
			->where('prestataires.status', 1)
			->where('prestataires.top', 1)
            ->orderby('prestataires.id', 'DESC')
            ->offset($offset)->limit(15)->get();
            //$dataInfos->paginate(15);
        
        if ($cat != '') {  
            $catdata = DB::table('prestataire_category')->where('prestataire_category.id', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);            
            
            $dataInfos = DB::table("prestataires")->select(DB::raw("prestataires.*, prestataire_category.*, prestataire_category.category_name as this_prestataire_category"))
            ->where('prestataires.status','1')
			->leftJoin('prestataire_category', 'prestataire_category.id', '=', 'prestataires.activites')
			->where('prestataires.top', 1)
            ->whereIn('prestataires.activites', $ids)
            ->orderby('prestataires.id', 'DESC')
            ->offset($offset)->limit(15)->get();
        }
        
		
        foreach($dataInfos as $data){
            if($data->status == 1){
               
$nom = (!empty($data->pseudo))? $data->pseudo:($data->firstname.' '.$data->lastname);
				
$xx.='<div class="col-lg-4 col-md-6 col-sm-12 hover ">
           
    <div class="box-icon pull-right share-listing">
        <a href="javascript:void()" data-toggle="tooltip"
           data-original-title="Partager ce prestataire"
           data-placement="right" class="event-share"
           data-url="'.route('pre.detail',$data->url_slug).'"
           data-name="'.$nom.'">
            <i class="fas fa-share"></i>
        </a>
    </div> ';   
    
  $xx.='<div class="box-icon pull-right like-listing">';
        if(auth()->guard('frontuser')->check()){
            $userid = auth()->guard('frontuser')->user()->id;
        }else{
            $userid = '';
        }
                
    $xx.='<a href="javascript:void(0)" data-toggle="tooltip"
           data-original-title="Enregistrer ce prestataire"
           data-placement="right" id="save-event" class="save-event" data-user="'.$userid.'"
           data-event="'.$data->id.'" data-mark="0">';
                
            if(is_null(getbookmark($data->id, $userid)))
                $xx.='<i class="far fa-heart"></i>';
            else
                $xx.='<i class="fas fa-heart"></i>';
            
        $xx.='</a>
    </div>';
    
   $xx.='<div class="box" style="position: relative;">
   
   		<a href="'.route('pre.detail',$data->url_slug).'"><div class="bunique" style="background-image: url(\''.url($data->cover).'\'); "></div></a>
		
		<div class="box-content card__padding prestBox">
            <div class="innercardbox">
                 
                <div class="left_pbox">
                        <a href="'.route('pre.detail',$data->url_slug).'" class="">
							<img class="pimgprof" src="'.setThumbnail($data->profile_pic).'" alt="'.$nom.'">
						</a>                    
                </div>
   
   			   <div class="right_pbox"> 
						<h4 class="card-title"><a  href="'.route('pre.detail',$data->url_slug).'">'.$nom.'</a></h4>
                                   
                    <div class="badge category" style="cursor: default">
                           <a href="'.route('prestataire').'?cat='.$data->activites.'"><span class="">
                           '.$data->this_prestataire_category.'
                          </span></a>
                    </div> 
					
					<div class="descBox">'.$data->descriptions.'</div>
                     
					<div class="geoCard card__location-content">
						<i class="fas fa-map-marker-alt third-color"></i>
						<a href="" rel="tag" class="adgeo third-color">'.$data->adresse_geo.'</a>
					</div>
                    
                </div> 
    
   			</div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>';               
               
               
            }
        }
        // if(isset($_GET['cat']) && $_GET['cat']!='all')
        // { 
        //     if($xx==null) 
        //     $xx=0; 
        // }
        return $xx;
    }
	

}