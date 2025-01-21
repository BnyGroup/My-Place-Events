<?php

namespace App;

use App\Http\Controller\FrontController;
use App\Frontuser;
use App\Helper;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $provider )
    {
        //dd($providerUser,$provider);
        $user = Frontuser::whereOauthProvider($provider)
            ->whereOauthUid($providerUser->getId())
            ->first();

        if (!$user) {
            //return 'Error! Your email is required, Go to app settings and delete our app and try again';
            if(!$providerUser->getEmail()) {
                return redirect("signin")->with(array('login_required' => trans('error.error_required_mail')));
                exit;
            }

            //Verify Email user
            $userEmail = Frontuser::whereEmail($providerUser->getEmail())->first();

            if($userEmail) {
                return redirect("signin")->with(array('login_required' => trans('error.mail_exists')));
                exit;
            }

            //$user = User::whereEmail($providerUser->getEmail())->first();

            $token = str_random(75);

            $avatar = 'default.jpg';
            $nameAvatar = time().$providerUser->getId();

            if(!empty($providerUser->getAvatar())){

                // Get Avatar Large Facebook
                if( $provider == 'facebook' ) {
                    $avatarUser = str_replace('?type=normal', '?type=large', $providerUser->getAvatar());
                }

                // Get Avatar Large Twitter
                if( $provider == 'twitter' ) {
                    $avatarUser = str_replace('_normal', '_200x200', $providerUser->getAvatar());
                }

                // Get Avatar Large Twitter
                if( $provider == 'google' ) {
                    $avatarUser = str_replace('_normal', '?type=large', $providerUser->getAvatar());
                }

                $fileContents = file_get_contents($avatarUser);

                \File::put(public_path().'img/pic/'.$nameAvatar.'.jpg', $fileContents);

                $avatar = 'public/img/pic/'.$nameAvatar.'.jpg';
            }

            /*$username =  explode(' ', $providerUser->getName()); // separe chaque nom et le range dans un tableau
            $taille = sizeof($username); // recupere le nombre de nom

//            $firstname=$username[$taille - 1]; // recuperer le nom de famille
            $firstname=$username[0];

            $othername = array();
            if($taille==2){
                $othername[] = $username;
                $lastname = $othername[0];
            }
            elseif($taille == 1){
                $othername[] = '';
                $lastname = $othername[0];
            }//

            else{
                //recuperer les autres noms
                for($i=1;$i<$taille;$i++){
                    $othername[$i] = $username[$i]; //
                }
                $lastname = implode(' ', $othername);
            }*/


            $user = Frontuser::create([
                'firstname'        => $providerUser->getName(),
                'lastname'        => last(explode(" ", $providerUser->getName())),
                /*'statut'            => '1',*/
                'password'        => '',
                'email'           => strtolower($providerUser->getEmail()),
                'profile_pic'          => $avatar,
                //'cover'           => 'cover.jpg',
                'status'          => '1',
                /*'type_account'    => '1',*/
                'website' => '',
                //'activation_code' => '',
                'oauth_uid' => $providerUser->getId(),
                'oauth_provider' => $provider,
                'token'           => $token,
            ]);

        }// !$user

        return $user;
    }

   /* public function saveImage($image=null){

        $upath  = 'upload/front/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($upath))) {
            File::makeDirectory(public_path($upath),0777,true);
        }

        if (!empty($image)) {
            $iinput['image'] = ImageUpload::upload($upath, $image, 'userprofile');
            ImageUpload::uploadThumbnail($upath, $iinput['image'], 200, 200);
            $image = save_image($upath, $iinput['image']);
        }
        return $image;
    }*/
}
