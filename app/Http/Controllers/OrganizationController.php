<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Organization;
use App\Event;
use File;
use App\ImageUpload;
use Validator;
use Mail;

class OrganizationController extends FrontController
{

    public function __construct()
    {
        parent::__construct();
        $this->organization = new Organization;
        $this->event = new Event;
    }

    public function index()
    {
        $data = $this->organization->getData();

        $id = auth()->guard('frontuser')->user()->id;   
        $datas = Organization::where('user_id',$id)->get();

        if(count($datas) == 0):
            return redirect()->route('org.create');
        else:
            return view('theme.org.organization-index',compact('data','datas'));
        endif;
    }

    public function create()
    {
        $id = auth()->guard('frontuser')->user()->id;
        $orglist = $this->organization->getAllist($id);
        $datas = Organization::where('user_id',$id)->get();

        /*if(count($datas) < 10){*/
            return view('theme.org.user-organization',compact('orglist'));
        /*}
        else
        {
            return redirect()->route('org.index');
        }*/
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'profile_pics' => 'required|image|mimes:jpeg,jpg,png|max:1000',
            'organizer_name' => 'required',
            'about_organizer' => 'required',
            'website' => 'nullable|url',
        ]);

        $input['display_dis'] = isset($input['display_dis']) ? $input['display_dis'] : 0;
        $input['status'] = isset($input['status'])?$input['status']:0;
 		$path = 'upload/user/'.date('Y').'/'.date('m'); 

        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('profile_pics'))) {

            $input['profile_pics'] = ImageUpload::upload($path,$request->file('profile_pics'),'organization');
            ImageUpload::uploadThumbnail($path,$input['profile_pics'],200,200);
            $input['profile_pic'] = save_image($path,$input['profile_pics']);
            $input['url_slug'] = str_slug($input['organizer_name']).'-'.str_shuffle(time());
        }
		
		 if (!empty($request->file('cover'))) {

            $covers = ImageUpload::upload($path,$request->file('cover'),'organization');
            $input['cover'] = save_image($path,$covers);
        }

        if(isset($input['org_link_slug'])){
            $input['org_link_slug'] = $input['org_link_slug'];
        }else{
            $input['org_link_slug'] = $input['url_slug'];
        }

        $this->organization->insertData($input);
        return redirect()->route('org.create')->with('success',trans('words.msg.org_create'));      
    }

    public function org_insert(Request $request)
    {
        $input  = $request->all();
        $useId  = auth()->guard('frontuser')->user()->id;
        
       $validator = Validator::make($input,[
            'organizer_name' => 'required',        
        ]);
          
        $input['display_dis']   = 1;
        $input['status']        = 1;
        $input['user_id']       = $useId;
        $input['url_slug']      = str_slug($input['organizer_name']).'-'.str_shuffle(time());
        $input['org_link_slug'] = $input['url_slug'];

        if ($validator->passes()) {
            $data=$this->organization->insertData($input);
            return response()->json(['org_id' => $data->id, 'org_name' => $data->organizer_name]);
        }else{
            return response()->json(['errors'=>$validator->errors()]);
        }
    }
    
    public function edit($slug)
    {
        $id = auth()->guard('frontuser')->user()->id;
        $orglist = $this->organization->getAllist($id);
        $data = $this->organization->findDataSlug($slug);
        if (! isset($data)) {
            \App::abort(404, 'Organization Not Found');
        }
        return view('theme.org.user-organization-update',compact('data','orglist'));
    }

    public function update(Request $request,$id)
    {	
		
        $input = $request->all();
        $input['org_link_slug'] = str_slug($input['org_link_slug']);

        $this->validate($request,[
            'profile_pics' => 'image|mimes:jpeg,jpg,png|max:1000',
            'organizer_name' => 'required',
            //'about_organizer' => 'required',
            'website' => 'nullable|url',
            'org_link_slug' => 'nullable|unique:organizations,org_link_slug,'.$id,
        ]);

        $input['display_dis'] = isset($input['display_dis']) ? 1 : 0;
        $input['status'] = isset($input['status']) ? $input['status'] : 0;
        $path = '/public/upload/user/'.date('Y').'/'.date('m'); 
        $updath = 'upload/user/'.date('Y').'/'.date('m');

        $org_link_slug = isset($input['org_link_slug'])?str_slug($input['org_link_slug']):$input['url_slug'];
        $input['org_link_slug'] = $org_link_slug;

        $getRouteCollection = \Route::getRoutes();
        $url = [];
        foreach ($getRouteCollection as $route) {
            $url = explode('/',$route->uri());
            $data[] = $url[0];
        }
        $data = array_unique($data);
        $reserveurl = array_values($data);

        if(in_array($input['org_link_slug'],$reserveurl)){
            return redirect()->route('org.edit',$input['url_slug'])->with('error','This custom url is reserved by system.');
        }
        
        if (!is_dir(public_path($updath))) {
            File::makeDirectory(public_path($updath),0777,true);
        }
		
        if (!empty($request->file('profile_pics'))) {
			
            $iinput['profile_pics'] = ImageUpload::upload($updath,$request->file('profile_pics'),'organization');
            ImageUpload::uploadThumbnail($updath,$iinput['profile_pics'],200,200);
              
                if (!empty($input['old_image'])) {
                    $data = image_delete($input['old_image']);

                    $path = $data['path'];
                    $image = $data['image_name'];
                    $image_thum = $data['image_thumbnail'];

                    ImageUpload::removeFile($path,$image,$image_thum);
                }
                
            $input['profile_pic'] = save_image($updath,$iinput['profile_pics']);
            $this->organization->updateorgrData($id,$input);
			
        }else{
            $input['profile_pic'] = $input['old_image'];
            $this->organization->updateorgrData($id,$input);   
        }
		//print_r($request->file('cover'));
		//die("---");
		if(!empty($request->file('cover'))) {
             $iinput['cover'] = ImageUpload::upload($updath,$request->file('cover'),'organization');
               
                if (!empty($input['old_cover'])) {
                    $data = image_delete($input['old_cover']);

                    $path = $data['path'];
                    $image = $data['image_name'];
                    $image_thum = $data['image_thumbnail'];

                    ImageUpload::removeFile($path,$image,$image_thum);
                }
                
            $input['cover'] = save_image($updath,$iinput['cover']);
            $this->organization->updateorgrData($id,$input);
        }else{
            $input['cover'] = $input['old_cover'];
            $this->organization->updateorgrData($id,$input);   
        }
		
        //return redirect()->route('org.edit',$input['url_slug'])->with('success',trans('words.msg.org_updated'));
        return redirect()->route('org.index');

    }
    public function org_detail($slug)
    {
        $data = $this->organization->findDataSlug($slug);
        if (! isset($data)) {
            \App::abort(404, 'Organization Not Found');
        }

        if(isset($data) && $data->status == 0) {
            $user_id = (auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:0);
            if($user_id != $data->user_id){
                \App::abort(404, 'Organization Not Found');
            }
        }
        if (isset($data) && $data->ban == 1) {
            $user_id = (auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:0);
            if($user_id != $data->user_id){
                \App::abort(404, 'Organization Not Found');
            }
        }

        $events = $this->event->event_by_org($data->id);
        return view('theme.org.organization-view',compact('data', 'events'));
    }

    public function customLink($slug)
    {
        $data = $this->organization->findDataSlugURL($slug);
        return redirect()->route('org.detail',$data->url_slug);
    }

    public function delete($id)
    {
        $this->organization->deleteData($id);
        return redirect()->route('org.index')->with('success',trans('words.msg.org_deleted'));
    }

    public function orgContact(Request $request){
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
            return \Response::json(['success' => 'Message sent successfully.']);
        }
        return \Response::json(['success' => 'Message sent successfully.']);
    }

     public function updateSlug(Request $request)
    {
        $input = $request->all();
        $input['slug'] = str_slug($input['slug']);
        $validator = Validator::make($input,[
          'slug' => 'required|unique:organizations,url_slug,'.$input['id'],
        ]);

        if($validator->fails()){
          return response()->json($validator->errors()->first());
        }
        
        $getRouteCollection = \Route::getRoutes();
        $url = [];
        foreach ($getRouteCollection as $route) {
            $url = explode('/',$route->uri());
            $data[] = $url[0];
        }
        $data = array_unique($data);
        $reserveurl = array_values($data);

        if(in_array($input['slug'],$reserveurl)){
          return response()->json('This url is reserved by system.');
        }

        $slug['url_slug'] = $input['slug'];

        $this->organization->updateorgrData($input['id'],$slug);

        return response()->json(['success' => 'Site settings profile url updated.','data' => route('org.detail',$slug['url_slug']),'url' => route('org.edit',$slug['url_slug'])]);
    }

    public function orgSubmit(Request $request)
    {
        $input = $request->all();
        $mail = array(user_data($input['org_id'])->email);
        $odata = user_data($input['org_id'])->fullname;
        try {
            \Mail::send('theme.reset.contact',['data' => $input,'odata' => $odata],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Contact To Organizer');
            });
        } catch (\Exception $e) {
            return response()->json(['success' => "Organizer will review and be in touch soon."]);
        }
        return response()->json(['success' => "Organizer will review and be in touch soon."]);
    }
}
