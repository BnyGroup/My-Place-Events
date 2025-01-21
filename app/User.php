<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use App\ImageUpload;

class User extends Authenticatable implements Wallet
{
    use Notifiable, EntrustUserTrait, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'username','status', 'user_type', 'current_login', 'last_login', 'profile_pic', 'gender', 'email', 'password','brith_date','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findData($mail)
    {
        return static::where('email',$mail)->first();
    }
    public function updateData($token,$pwd)
    {
        return static::where('remember_token',$token)->update(['password'=>$pwd]);
    }
    public function upDatetoken($email,$tok)
    {
        return static::where('email',$email)->update(['remember_token'=>$tok]);
    }
    public function checkValid($token)
    {
        return static::where('remember_token',$token)->first();
    }
    public function updateUserData($input, $id)
    {
        return static::find($id)->update(array_only($input,$this->fillable));
    }
    public function updateUserpwd($pwd,$id)
    {
        return static::find($id)->update(['password'=>$pwd]);
    }
    public function getData()
    {
        return static::get();
    }
    public function createData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }
    public function findsData($id)
    {
        return static::where('id',$id)->first();
    }
    public function deleteData($id)
    {
        $data = static::where('id',$id)->first();

        if(!empty($data['profile_pic']))
        {
          $datas = image_delete($data['profile_pic']);
            $path = $datas['path'];
            $image = $datas['image_name'];
            $image_thum = $datas['image_thumbnail'];
            ImageUpload::removeFile($path,$image,$image_thum);
        }
        return $data->delete();
    }  
    public function countData()
    {
        return static::count();
    }
    public function setLoginTime($id,$input)
    {
        return static::where('id',$id)->update(['current_login'=>$input]);
    }
    public function updateLast_time($id,$input)
    {
        return static::where('id',$id)->update(['last_login'=>$input]);
    }

    public function updateEmail($oldEmail, $newEmail){
        return static::where("email",$oldEmail)->update(["email" => $newEmail]);
    }
    
    /**
     * User tranfer concerning refund to him
     *
     * @return MorphMany
     */
    public function refunds()
    {
        return $this->morphMany(config('wallet.transfer.model'), 'to');
    }
}
