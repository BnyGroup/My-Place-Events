<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Exception;
use Bavix\Wallet\Models\Transaction;
use App\User;
use App\Organization;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Frontuser;
use App\GuestUser;
use App\Event;
use App\Bankdetail;
use App\PaysList; 
use App\orderTickets;
use Illuminate\Support\Facades\Response;


class FrontuserController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->frontuser = new Frontuser;
		$this->guestuser = new GuestUser;
	}

    public function index()
    {
    	$data = $this->frontuser->orderBy(
                'id',
                'desc'
            )->limit(800)->get();
    	return view('Admin.frontuser.index',compact('data'));
    }
	
	
	public function getfrontusers(Request $request)
    {
    	$draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
		if(empty($rowperpage)) $rowperpage=30;
		if(empty($start)) $start=0;
		
		$columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
		
		
		// Total records
        $totalRecords = Frontuser::select('count(*) as allcount')
            ->count();
		
        $totalRecordswithFilter = Frontuser::select('count(*) as allcount')
			->where('frontusers.firstname', 'like', '%' .$searchValue . '%')	
			->orWhere('frontusers.lastname', 'like', '%' .$searchValue . '%')
			->orWhere('frontusers.email', 'like', '%' .$searchValue . '%')
            ->orderBy('frontusers.id','desc')
            ->count();
 		 
        // Fetch records //
		 
    	$records = Frontuser::select('*')
			->orderBy('frontusers.id', 'DESC')
			->skip($start)
			->take($rowperpage);
		
		if(!empty($searchValue)){
			$records->where('frontusers.firstname', 'like', '%' .$searchValue . '%')
					->orwhere('frontusers.lastname', 'like', '%' .$searchValue . '%')
					->orwhere('frontusers.email', 'like', '%' .$searchValue . '%'); 
		}		
		
		$recs=$records->get();
 
		$data_arr = array();
		$key="1";
		
        foreach($recs as $record){
           $id = $record->id;
           $firstname = $record->firstname.' '.$record->lastname;
           $status = $record->status;
           $gender = $record->gender;
           $email = $record->email;
           $cellphone = $record->cellphone;
           $country = $record->country;
           $city = $record->city;
		   $newsletter = $record->newsletter;	
			
           $updated_at = $record->created_at;
		   $dateUp = date_create($updated_at); 
			$rdate=date_format($dateUp,'d-m-Y h:i A');
           
		   $qx=PaysList::where('id_pays',$country)->first();
			if(!empty($qx)){
		   		$pays=$qx->nom_pays;	
			}else{
				$pays="N/D";
			}
			
		   if($record->oauth_provider== null):
				$imgp='<img src="'.setThumbnail($record->profile_pic).'" class="user-image" style="width: 80px;" alt="User Image">';
			else:
				$imgp='<img src="'.url($record->profile_pic).'" class="user-image" style="width: 80px;" alt="User Image">';
			endif;
			
			$stat='<span class="'.frontuser($record->status)->class.'">'.frontuser($record->status)->message.'</span>';
 			
			$action='<a href="'.route('frontuser.show',$record->id).'" class="btn btn-flat btn-info"><i class="fa fa-eye"></i> Vue</a> <a href="'.route('frontuser.delete',$record->id).'" class="btn btn-danger btn-flat" onclick=" return confirm(\'are you sure ?\')">Supprimer<i class="fa fa-trash"></i></a>';
			if($newsletter==1){
				$ns='<center><span class="label label-success">Oui</span></center>';
			}else{
				$ns='<center><span class="label label-danger">Non</span></center>';
			}
 					
		    $data_arr[] = array(
			   "key" => $key,
			   "image" => $imgp,
			   "firstname" => $firstname,
			   "email" => $email,
			   "cellphone" => $cellphone,
			   "country" => $pays.'/'.$city,
			   "Date" => $rdate,
			   "newsletter" => $ns,
			   "status" => $stat,
			   "action" => $action,						   
		    );
			
			$key++;
		}
		
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response); 
		
		
		
		
    }
	
	public function invites()
    {
     	return view('Admin.frontuser.invites');
    }
	
	public function exportfrontusersnewsletter()
	{
		ini_set('memory_limit', '512M');
		
		$headers = array(
				'Content-Type'        => 'text/csv',
				'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
				'Content-Disposition' => 'attachment; filename=frontusers_newsletter_'.gmdate("d_m_Y_His").'.csv',
				'Expires'             => '0',
				'Pragma'              => 'public',
			);

			$response = new \Symfony\Component\HttpFoundation\StreamedResponse(function(){
				// Open output stream
				$handle = fopen('php://output', 'w');

				// Add CSV headers
				fputcsv($handle, ['Prenom(s)', 'Nom','Genre', 'Email','Telephone', 'Pays']);

				Frontuser::select('*')->where('newsletter',1)->orderBy('frontusers.id', 'DESC')          
					->chunk(500, function($users) use($handle) {
					foreach ($users as $product) { 
						$c=$product->country;
						$qx=PaysList::where('id_pays',$c)->first();
						if(!empty($qx)){
							$pays=$qx->nom_pays;	
						}else{
							$pays="N/D";
						}

						$fname=utf8_encode(strip_tags($product->firstname));
						$fname = str_replace( array( '<br>', '<br />', "\n", "\r" ), array( '', '', '', '' ), $fname );
						fputcsv($handle, [$fname, strip_tags($product->lastname), $product->gender, $product->email, $product->cellphone, $pays]); // Add more fields as needed	
					}
				});

				// Close the output stream
				fclose($handle);
			}, 200, $headers);

			return $response->send();
	}
	
	public function exportguestusersnewsletter()
	{
		ini_set('memory_limit', '512M');
		
		$headers = array(
			'Content-Type'        => 'text/csv',
			'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
			'Content-Disposition' => 'attachment; filename=guestusers_newsletter_'.gmdate("d_m_Y_His").'.csv',
			'Expires'             => '0',
			'Pragma'              => 'public',
		);

		$response = new \Symfony\Component\HttpFoundation\StreamedResponse(function(){
			// Open output stream
			$handle = fopen('php://output', 'w');

			// Add CSV headers
			fputcsv($handle, ['Nom & Prenom(s)', 'Email','Telephone']);

			GuestUser::select('*')->where('newsletter',1)->orderBy('guest_user.guest_id', 'DESC')           
				->chunk(500, function($users) use($handle) {
				foreach ($users as $product) { 
					fputcsv($handle, [$product->user_name, $product->guest_email,$product->cellphone]); 
				}
			});

			// Close the output stream
			fclose($handle);
		}, 200, $headers);

		return $response->send();
 
	}
	
	
	public function exportfrontusers()
	{
			ini_set('memory_limit', '512M');		
		
			$headers = array(
				'Content-Type'        => 'text/csv',
				'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
				'Content-Disposition' => 'attachment; filename=frontusers.csv',
				'Expires'             => '0',
				'Pragma'              => 'public',
			);

			$response = new \Symfony\Component\HttpFoundation\StreamedResponse(function(){
				// Open output stream
				$handle = fopen('php://output', 'w');

				// Add CSV headers
				fputcsv($handle, ['Prenom(s)', 'Nom','Genre', 'Email','Telephone', 'Pays']);

				Frontuser::orderBy('frontusers.id', 'DESC')           
					->chunk(500, function($users) use($handle) {
					foreach ($users as $product) { 
						$c=$product->country;
						$qx=PaysList::where('id_pays',$c)->first();
						if(!empty($qx)){
							$pays=$qx->nom_pays;	
						}else{
							$pays="N/D";
						}

						$fname=utf8_encode(strip_tags($product->firstname));
						$fname = str_replace( array( '<br>', '<br />', "\n", "\r" ), array( '', '', '', '' ), $fname );
						fputcsv($handle, [$fname, strip_tags($product->lastname), $product->gender, $product->email, $product->cellphone, $pays]); // Add more fields as needed	
					}
				});

				// Close the output stream
				fclose($handle);
			}, 200, $headers);

			return $response->send();
 	}
	
	public function exportguestusers()
	{
		ini_set('memory_limit', '512M');
		ini_set('max_execution_time', 30000);
		
		$headers = array(
			'Content-Type'        => 'text/csv',
			'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
			'Content-Disposition' => 'attachment; filename=guestusers.csv',
			'Expires'             => '0',
			'Pragma'              => 'public',
		);

		$response = new \Symfony\Component\HttpFoundation\StreamedResponse(function(){
			// Open output stream
			$handle = fopen('php://output', 'w');

			// Add CSV headers
			fputcsv($handle, ['Nom & Prenom(s)', 'Email','Telephone']);

			GuestUser::orderBy('guest_user.guest_id', 'DESC')           
				->chunk(500, function($users) use($handle) {
				foreach ($users as $product) { 
					fputcsv($handle, [$product->user_name, $product->guest_email,$product->cellphone]); 
				}
			});

			// Close the output stream
			fclose($handle);
		}, 200, $headers);

		return $response->send();
		 
	}	
	 
	
	public function getinvites(Request $request){
		
    	$draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
		if(empty($rowperpage)) $rowperpage=30;
		if(empty($start)) $start=0;
		
		$columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
		
		
		// Total records
        $totalRecords = GuestUser::select('count(*) as allcount')
            ->count();
		
        $totalRecordswithFilter = GuestUser::select('count(*) as allcount')
			->where('guest_user.user_name', 'like', '%' .$searchValue . '%')	
			->orWhere('guest_user.guest_email', 'like', '%' .$searchValue . '%')
			->orWhere('guest_user.cellphone', 'like', '%' .$searchValue . '%')
            ->orderBy('guest_user.created_at','desc')
            ->count();
 		 
        // Fetch records //
		 
    	$records = GuestUser::select('*')
			->orderBy('guest_user.created_at', 'DESC')
			->skip($start)
			->take($rowperpage);
		
		if(!empty($searchValue)){
			$records->where('guest_user.user_name', 'like', '%' .$searchValue . '%')
					->orwhere('guest_user.guest_email', 'like', '%' .$searchValue . '%')
					->orwhere('guest_user.cellphone', 'like', '%' .$searchValue . '%'); 
		}		
		
		$recs=$records->get();
 
		$data_arr = array();
		$key="1";
		
        foreach($recs as $record){
           $id = $record->id;
           $firstname = $record->user_name;
           $email = $record->guest_email;
           $cellphone = $record->cellphone;
		   $newsletter = $record->newsletter;	
			
           $updated_at = $record->created_at;
		   $dateUp = date_create($updated_at); 
		   $rdate=date_format($dateUp,'d-m-Y h:i A');
 			
			$actions='<a href="'.route('frontuser.showguest',$record->guest_id).'" class="btn btn-flat btn-info"><i class="fa fa-eye"></i> Vue</a> <a href="'.route('frontuser.deleteguest',$record->guest_id).'" class="btn btn-danger btn-flat" onclick=" return confirm(\'are you sure ?\')">Supprimer<i class="fa fa-trash"></i></a>';
			
			if($newsletter==1){
				$ns='<center><span class="label label-success">Oui</span></center>';
			}else{
				$ns='<center><span class="label label-danger">Non</span></center>';
			}
 					
		    $data_arr[] = array(
			   "key" => $key,
			   "firstname" => $firstname,
			   "email" => $email,
			   "cellphone" => $cellphone,
			   "Date" => $rdate,
			   "newsletter" => $ns,
			   "action" => $actions,						   
		    );
			
			$key++;
		}
		
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response); 
	}	
	
    public function show($id)
    {
    	$data = Frontuser::where('id',$id)->first();
    	$org = Organization::where('user_id',$data->id)->get();
    	$event = Event::where('event_create_by',$data->id)->get();
        $bank  = Bankdetail::where('user_id',$data->id)->get();

        //Wallet
        $transactions = $data->transactions->reverse()->take(5);

    	return view('Admin.frontuser.view',compact('data','org','event','bank','transactions'));
    }

    public function showguest($id)
    {
    	$data = GuestUser::where('guest_id',$id)->first();

        //Wallet
        $transactions = orderTickets::select('events.*','event_tickets.ticket_title as TICKE_TITLE','event_tickets.ticket_price_buyer as TICKE_PRICE', 'guest_user.user_name as USER_FNAME', 'guest_user.guest_email as USER_EMAIL', 'guest_user.cellphone as USER_PHONE', 'order_tickets.*' ,'order_tickets.created_at as ORDER_ON', 'event_category.category_name')
		->leftjoin('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
		->leftjoin('events','order_tickets.ot_event_id','=','events.event_unique_id')
		->leftjoin('event_category','event_category.id','=','events.event_category')
		->leftjoin('guest_user','order_tickets.gust_id','=','guest_user.guest_id')
		->where('guest_user.guest_id',$id)
		->get();

    	return view('Admin.frontuser.viewguest',compact('data','transactions'));
    }	
	
    /**
     * @param Request $request
     */
    public function addOrSubstractMoneyToWallet(Request $request)
    {
        $data = Frontuser::where('id',$request->id)->first();

        //Add or Substract Wallet
        if($data) {
            if ($request->has('deposit')) {
                try {
                    $data->deposit($request->add_amount, ['description' => $request->add_amount_description]);
                $alert = new PushNotify();
                $alert->sendWalletAlert($request->id, $request->add_amount, $request->add_amount_description, $type = 'deposit');
                return redirect()
                  ->route('frontuser.show', $request->id)->with(['success' => config('messages.addToWallet')]);
                } catch (\Illuminate\Database\QueryException $qe) {
                    return redirect()->back()->with(['message' => $qe->getMessage()]);
                } catch (Exception $e) {
                    return redirect()->back()->with(['message' => $e->getMessage()]);
                } catch (\Throwable $th) {
                    return redirect()->back()->with(['message' => $th]);
                }

              }

              if ($request->has('withdraw')) {
                if ($data->balance >= $request->add_amount){
                    try {
                        $data->withdraw($request->add_amount, ['description' => $request->add_amount_description]);

                        $alert = new PushNotify();
                        $alert->sendWalletAlert($request->id, $request->add_amount, $request->add_amount_description, $type = 'withdraw');

                        return redirect()
                        ->route('frontuser.show', $request->id)->with('success' , 'Retrait éffectué avec success !');
                    } catch (\Illuminate\Database\QueryException $qe) {
                        return redirect()->back()->with(['message' => $qe->getMessage()]);
                    } catch (Exception $e) {
                        return redirect()->back()->with(['message' => $e->getMessage()]);
                    } catch (\Throwable $th) {
                        return redirect()->back()->with(['message' => $th]);
                    }
                }else {
                    return redirect()->route('frontuser.show', $request->id)->with('danger' , "Le solde de votre portefeuille n'est pas suffisant ! ");
                }
            }
        }
    }


    public function change_status($id,$sid)
    {
        $data = Frontuser::where('id',$id)->update(['status'=>$sid]);

        if($sid == 3):
            Event::where('event_create_by',$id)->update(['ban'=>1]);
            Organization::where('user_id',$id)->update(['ban' => 1]);
        else:
            Event::where('event_create_by',$id)->update(['ban'=>0]);
            Organization::where('user_id',$id)->update(['ban' => 0]);
        endif;
    	return redirect()->back();
    }

    public function delete($id)
    {
       $data = $this->frontuser->deleteData($id);
       return redirect()->route('frontuser.index')->with(['success' => 'User Delete Successfully.']);
    }
	
    public function deleteguest($id)
    {
       $data = $this->guestuser->deleteData($id);
       return redirect()->route('frontuser.invites')->with(['success' => 'User Delete Successfully.']);
    }	

}
