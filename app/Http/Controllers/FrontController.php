<?php

namespace App\Http\Controllers;

use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Setting;
use App\Post;
//use Corcel\Model\Post;
use App\Page;
use App\Frontuser;
use App\Contact;
use App\Booking;
use App\Event;
use Carbon\Carbon;
use App\BannerImmanquables;

class FrontController extends Controller
{

	public function __construct()
	{
		view()->share('theme','layouts.master');
		$this->contact = new Contact;
		$this->settings = new Setting;
		$this->session = new Session();
		$this->pages=new Page;
		$this->wallet = 0;
	}
 	public function index()
 	{ 
  
		$eventImm=Event::where('event_immanquable','1')->where(['event_status'=>1,'ban'=>0])->get();
		$bannerImm=BannerImmanquables::where(['statut'=>1])->get();
		return view('theme.home',compact('eventImm','bannerImm'));
	}


 	public function policy()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.policy',compact('data'));
 	}
 	public function terms()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.terms',compact('data'));
 	}
 	public function contact()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.contact',compact('data'));
 	}
 	public function faqs()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.faqs',compact('data'));
 	}
 	public function server_requirements()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.server_requre',compact('data'));
 	}
 	public function support()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.support',compact('data'));
 	}
 	public function aboutus()
 	{
 		$data = $this->settings->getSettings();
 		return view('pages.aboutus',compact('data'));
 	}

    public function blog()
    {
        //$data = $this->settings->getSettings();
        return view('theme.blog.blog');
    }



  //   public function contact_post(Request $request)
 	// {
 	// 	$input = $request->all();

 	// 		$this->validate($request,[
 	// 		'name' => 'required',
 	// 		'email' => 'required|email',
 	// 		'subject' => 'required',
 	// 		'message' => 'required',
 	// 	]);

 	// 	$user_id = (auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'0');
 	// 	$input['user_id'] = $user_id;

 	// 	$message 	= $input['message'];
 	// 	$mail		= $input['email'];
 	// 	$name		= $input['name'];
 	// 	$subject	= $input['subject'];

 	// 	//dd($mail, $name);
 	// 	$this->contact->createData($input);

 	// 	try {
	 // 		Mail::send('pages.contact-mail',['userdata'=>$input],function($message) use ($mail,$subject,$name)
	 //        {
	 //            $message->from(frommail());
	 //            $message->to(frommail());
	 //            $message->subject($subject);
	 //        });

 	// 	} catch (\Exception $e) {
 	// 		return redirect()->back()->with('success',trans('words.msg.feedbac_msg'));
 	// 	}
 	// 	return redirect()->back()->with('success',trans('words.msg.feedbac_msg'));
 	// }
 	public function contact_post(Request $request)
{
    $input = $request->all();

    // Validation des champs du formulaire
    $this->validate($request,[
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
        'g-recaptcha-response' => 'required|recaptcha', // Validation reCAPTCHA
    ]);

    // Traitement du formulaire
    $user_id = (auth()->guard('frontuser')->check() ? auth()->guard('frontuser')->user()->id : '0');
    $input['user_id'] = $user_id;

    $message = $input['message'];
    $mail = $input['email'];
    $name = $input['name'];
    $subject = $input['subject'];

    $this->contact->createData($input);

    // Envoi du mail
    try {
        Mail::send('pages.contact-mail',['userdata'=>$input],function($message) use ($mail,$subject,$name)
        {
            $message->from(frommail());
            $message->to(frommail());
            $message->subject($subject);
        });
    } catch (\Exception $e) {
        return redirect()->back()->with('success',trans('words.msg.feedbac_msg'));
    }

    return redirect()->back()->with('success',trans('words.msg.feedbac_msg'));
}

 	public function checkHeader(){

		$header = Request::server('HTTP_X_ILPATIBOLOHEADCUSTENC');
		if($header == 'ilpatiboloreq'){
			return false;
		}

		return true;
	}

	public function getPageData($slug)
  	{
     $pdata = array();
     $pdata = Page::where('page_slug',$slug)->first();

      if (is_null($pdata))
          {
              \App::abort(404, 'Page Not Found.');
          }
     else
     {
        return view('pages.pages',compact('pdata'));
    }
  }
}
