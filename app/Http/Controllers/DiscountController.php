<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ALaUne;
use App\Event;
use App\Slider;
use Carbon\Carbon;

use App\Http\Controllers\FrontController;
use App\Booking;
use App\OrderPayment;
use App\Refund;
use App\GuestUser;
use App\EventTicket;
use App\orderTickets;
//use CinetPay\CinetPay;
use App\Http\Controllers\CinetPay;
use Mail;
use App\Http\Controllers\TicketController;
use App\Prestataire;
use App\SouscPrestataire;
use App\PrestataireCategory;
use App\FormuleService;
use App\Frontuser;
use App\AluPayment;
use App\StoreRegularise;
use App\CinetpayTrack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gabievi\Promocodes\Facades\Promocode;
use Illuminate\Support\Facades\DB;
//use Gabievi\Promocodes\Models\Promocode;

class DiscountController extends Controller
{
    public function storeDiscount(Request $request){
        
        $bookingdata	= $this->ticket_booking->getOrderData($request->input('order_id'));

        if ($request->ajax()) {
        $this->validate($request, [
            'code' => 'string',
        ]);

        $code = $request->get('code');
        $discount = DB::table('promocodes')->where('code', $code)->first();
        /*
        if (!$discount) {
             return redirect('payment');
        }

        if (!\Promocodes::check($discount)) {
             return redirect('payment');
        }
        */
        $request->session()->put('discount', [
        'code'=>$discount->code,
        'reward'=>$discount->discount($bookingdata->order_amount)
        ]);
        return response ()->json ();
    }
    abort(404);

    }

    public function discount($order_amount){
        return $order_amount-25;
    }
}
