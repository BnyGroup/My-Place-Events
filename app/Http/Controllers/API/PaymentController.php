<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;

class PaymentController extends UserController
{
    
public function checkedCardData(Request $request) {
		$input = $request->all();

        $card_name      = $input['email'];
        $card_number    = $input['card_number'];
        $cvc            = $input['card_cvc'];
        $exp_month      = $input['card_exp_month'];
        $exp_year       = $input['card_exp_year'];
        $address_zip    = $input['card_zip'];
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $token = \Stripe\Token::create( 
                array(
                    "card" => array( 
                        'name' => $card_name,
                        'number' => $card_number, 
                        'cvc' => $cvc, 
                        'exp_month' => $exp_month, 
                        'exp_year' => $exp_year, 
                        'address_zip' => $address_zip ,
                    )
                )
            );

            $data = [];
            $data['token'] = $token['id'];
            
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

            // $post['data'] = array( 'token' => $token['id'] );
            // $post['message'] = 'Success!';
            // $post['response'] = true;

        } catch (\Stripe\Error\Card $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];

            // $post['data'] = array();
            // $post['message'] = $err['message'];
            // $post['response'] = false;
        }
          return response()->json(['msg'=>'No Content'],204);
    }


    public function stripeCharges($s_token, $s_amount, $s_currency, $s_description) {
    	// $input = $request->all();
    	\Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try {        	
            $charge = \Stripe\Charge::create([
                'amount' => $s_amount,
                'currency' => $s_currency,
                'description' => $s_description,
                'source' => $s_token,
            ]);
            $post['data'] = $charge;
            $post['response'] = true;

        } catch (\Stripe\Error\Card $e) {
        	$body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $post['data'] = $err;            
            $post['response'] = false;
        }
        return (Object)$post;
        // return response()->json($post);
    }
}
