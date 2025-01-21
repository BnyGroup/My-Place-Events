<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\User;
use App\Role;
use App\RoleUser;
use Mail;
use Illuminate\Support\Facades\Auth;
use Bavix\Wallet\Models\Transfer;
use Bavix\Wallet\Models\Transaction;

class UsersController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->user = new User;
        $this->roles = new Role;
		$this->roleuser = new RoleUser;
	}
    public function index()
    {
    	$data = $this->user->getData();
    	return view('Admin.user.index',compact('data'));
    }
    public function create()
    {	
    	$data = $this->roles->getRole();
    	return view('Admin.user.create',compact('data'));
    }
    public function store(Request $request)
    {	
    	$input = $request->all();
    	$this->validate($request,[
    		'firstname'=>'required',
    		'lastname'=>'required',
    		'role_id'=>'required',
    		'email'=>'required|email|unique:users,email',
    	]);

        $date = date('d', strtotime($input['brith_date']));
 
        $input['username'] = $input['firstname'].'_'.$date;
    	$input['password'] = str_random(8);
        $pwd = $input['password'];

        $mail = array($request->email);

        $input['user_type'] = 2;
        $input['password'] = bcrypt($input['password']);
        $input['remember_token'] = str_random(60);

        $user = $this->user->createData($input);
        $roleId = $this->roles->getRoleId($input['role_id']);
        $roleData = [];
        $roleData['user_id'] = $user->id;
        $roleData['role_id'] = $roleId->id;
        $role = $this->roleuser->addRoleUser($roleData);
        
        try {
            Mail::send('Admin.mail.pwdmail',['password'=> $pwd ,'username'=>$input['email']],function($message) use ($mail)
            {
                $message->from(frommail(),forcompany())->subject("Login Id or Password");
                $message->to($mail);
            });
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('success','Admin Created Successfully but email are not send.');
        }

    	return redirect()->route('users.index')->with('success','Admin Created Successfully');
    }
    public function edit($id)
    {
        $data = $this->user->findsData($id);
        
    	$listrole = $this->roles->getRole();
        $roleslists = $this->roleuser->getRoleUser($data->id);
        $transactions = $data->transactions()->orderby('created_at', 'desc')->take(5)->get();
        $total = new \stdClass;
        $deposits = $data->transfers()->where('status', Transfer::STATUS_TRANSFER)
                                      ->tap(function ($collection) use ($total) {
                                        $deposit_ids = $collection->get(['deposit_id'])->pluck('deposit_id')->toArray();
                                        $total->deposits = Transaction::whereIn('id', $deposit_ids)->sum('amount');
                                      })
                                      ->orderBy('created_at', 'desc')
                                      ->take(5)->get();
        $withdraws = $data->refunds()->where('status', Transfer::STATUS_REFUND)
                                     ->tap(function ($collection) use ($total) {
                                        $withdraw_ids = $collection->get(['withdraw_id'])->pluck('withdraw_id')->toArray();
                                        $total->withdraws = Transaction::whereIn('id', $withdraw_ids)->sum('amount');
                                     })
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)->get();

    	return view('Admin.user.edit', compact('data', 'listrole', 'roleslists', 'transactions', 'deposits', 'withdraws', 'total'));
    }

    /**
     * Deposit or withdraw User wallet
     *
     * @param App\User $user
     * @return void
     */
    public function addOrSubstractMoneyToUserWallet(User $user)
    {
        $request = resolve('Illuminate\Http\Request');

        // Validate request
        $request->validate([
            'add_amount' => 'required|numeric',
            'add_amount_description' => 'required|string',
        ]);

        try {
            // Make deposit
            if ($request->has('deposit')) {
                $user->deposit($request->add_amount, [
                    'description' => $request->add_amount_description,
                    'author' => Auth::user()->email,
                ]);
                return redirect()->route('users.edit', ['user' => $user->id])->with('success', config('messages.addToWallet'));
            }
            // Else make withdraw
            else if ($request->has('withdraw')) {
                // Check if user can withdraw
                if (!$user->canWithdraw($request->add_amount))
                    return redirect()->back()->with('danger' , "Le solde de votre portefeuille n'est pas suffisant ! ");

                $user->withdraw($request->add_amount, [
                    'description' => $request->add_amount_description,
                    'author' => Auth::user()->email,
                ]);
                return redirect()->route('users.edit', ['user' => $user->id])->with('success' , 'Retrait éffectué avec success !');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'brith_date'=>'required',
            'role_id'=>'required',
        ]);
        $data = $this->user->updateUserData($input,$id);
        $this->roleuser->updateRoleUser($id,$input['role_id']);
        return redirect()->route('users.index')->with('success','User Update Successfully');
    }
    
    public function show($id)
    {
        $show = User::find($id);
        return view('Admin.user.model',compact('show'));
    }

    public function destroy($id)
    {
        $this->user->deleteData($id);
        return redirect()->route('users.index')->with('success','User Delete Successfully');
    }
}
