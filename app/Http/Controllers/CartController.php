<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bavix\Wallet\Objects\Cart;
use Illuminate\Support\Facades\Session;
use Validator;
use Gloudemans\Shoppingcart\Facades\Cart as Carts;
use App\Http\Controllers\FrontController;
use App\Gadget;
use App\Booking;
use App\Frontuser;
use Illuminate\Support\Facades\Auth;


class CartController extends FrontController
{
    private $event_id;

    public function __construct() {
    	parent::__construct();
    	$this->ticket_booking = new Booking;
	}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('theme.cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$bookingdata	= $this->ticket_booking->getData(str_shuffle(csrf_token()));
        //dd($bookingdata);

        $gadget = Gadget::findOrFail($request->gadget_id); 

        $duplicata = Carts::search(function ($cartItem, $rowId) use ($request, $gadget) {
	        return $cartItem->id == $request->gadget_id && $cartItem->options['color'] == $request->color && $cartItem->options['size'] == $request->size && $cartItem->options['event_id'] == $gadget->event_id;
        });


        if (count(Carts::content()) == 0) {
            $price = $request->event_ticket;
            $color = $request->color;
            $size = $request->size;
            Carts::add($gadget->id, $gadget->item_name, 1, $price,['color' => $color,'size' => $size, 'event_id' => $gadget->event_id])
                        ->associate('App\Gadget');
            return redirect()->back()->with('success', 'Le gadget a bien été ajouté au panier !');
        } else {
           if ($duplicata->isNotEmpty()) {
               return redirect()->back()->with('danger', 'Le gadget a déja été ajouté au panier !');
           } else {
               //dd(Carts::content()->first());
               $cart = Carts::content()->first();
              if (($cart->options['event_id']) != $gadget->event_id) {
                    return redirect()->back()->with('danger', 'Vous ne pouvez pas acheter des gadgets de deux évènements différents !');
              } else {$price = $request->event_ticket;
                    $color = $request->color;
                    $size = $request->size;
                    Carts::add($gadget->id, $gadget->item_name, 1, $price,['color' => $color,'size' => $size, 'event_id' => $gadget->event_id])
                        ->associate('App\Gadget');
                    return redirect()->back()->with('success', 'Le gadget a bien été ajouté au panier !');
              }
              
           }
           
        }
    }


        public function payWithWallet(){
            $frontuser = Frontuser::where('id', Auth::guard('frontuser')->id())->first();
            //dd($frontuser);
            $cart = Carts::subtotal();
            $cart = number_format(floatval(preg_replace("/[^-0-9\.]/","",$cart)), 0,'', '');
            //dd(Carts::get());
        try {
                $myWallet = $frontuser->getWallet('default');
                $carts = app(Carts::content());                
                $myWallet->payCart($cart);
                    
                return redirect()
                    ->back()->with('succes', 'Bon');
                    //->route('order.success', 'azertyuhg1235');

                } catch (\Exception $e) {
                    //dd($e);
                    return redirect()
                   ->back()->with('danger', 'Configuration en cours');
                }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();
        Carts::update($rowId, $data['qty']);

        return response()->json(['success' => 'La quantité a été mis à jour !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Carts::remove($rowId);


        return back()->with('danger', 'Le gadget a bien été supprimé !');
    }

    public function arrondi_entier_sup($montant){
        if($montant%5 != 0){
            $montant = ceil($montant);
            while($montant%5 != 0){
                $montant++;
            }
            /*ceil(1.035*$bookingdata->order_amount);
            while($montant%5 != 0){
                $montant++;
            }*/
        }
        return $montant;
    }


}
