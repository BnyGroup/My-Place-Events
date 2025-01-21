<?php

namespace App\Http\Controllers\Wallet;

// By jeancinck
// Wallet Controller Class
// --- 

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Bavix\Wallet\Models\Transfer;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Frontuser;
use App\User;

class WalletController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! Auth::guard('web')->check()) {
                if ($request->routeIs('wallet.index')) session()->flash('loading', true);
                return redirect()->route('wallet.login');
            }
            return $next($request);
        });
    }

    /**
     * Show the search page and do research if form request is attached.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wallet.page.index');
    }

    /**
     * Show the search page and do research if form request is attached.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $request = resolve('Illuminate\Http\Request');
        if ($request->has(['email', 'cellphone'])){
            // Validate request data
            $request->validate([
                'lastname' => 'required',
                'email'=>'required|email',
                'cellphone' => 'numeric|digits:10',
            ]);
            // Set frontUser search query
            $frontUserQuery = Frontuser::select(['id', 'cellphone', 'status'])
                                        ->where('email', $request->email);
            // If no user found display specific view
            if ($frontUserQuery->doesntExist()) return view('wallet.page.noresults');
            // Get user data
            $frontUser = $frontUserQuery->get()->first();
            // Check user cellphone, else set the cellphone attribute as new
            if ($frontUser->status && (empty($frontUser->cellphone) || strlen(str_replace('+225', '', $frontUser->cellphone)) < 10)) {
                $frontUser->cellphone = $request->cellphone;
                $frontUser->save();
            }
            return redirect()->route('wallet.deposit', ['frontuser' => $frontUser->id]);
        }
        return view('wallet.page.search');
    }

    /**
     * Show the search page and do research if form request is attached.
     *
     * @param  App\Frontuser  $frontuser
     * @return \Illuminate\Http\Response
     */
    public function deposit(Frontuser $frontuser)
    {
        // Init session key
        session()->forget('success');
        session()->forget('deposit.error');

        $request = resolve('Illuminate\Http\Request');
        if ($request->has(['deposit', 'amount'])) {
            // Validate request data
            $request->validate(['amount' => 'required|numeric']);
            try {
                // $frontuser->deposit($request->amount);
                $tranfer = Auth::user()->transfer($frontuser, $request->amount, [
                                            'description' => 'deposit',
                                            'author' => Auth::user()->email,
                                        ], Transfer::STATUS_TRANSFER);
                // Notify admin via email
                $this->notifyEmail('deposit', User::find(5), $tranfer);
                // Notify holder via SMS
                $this->notifySmsMailPro('deposit', $tranfer);
                // Flash operation success
                session()->flash('success', true);
            } catch (\Exception $e) {
                // Flash operation success
                session()->flash('success', false);
                session()->flash('deposit.error', $e->getMessage());
            }
        }

        if ($request->has(['withdraw', 'amount'])) {
            // Validate request data
            $request->validate(['amount' => 'required|numeric']);
            try {
                // $frontuser->withdraw($request->amount);
                $tranfer = $frontuser->transfer(value(Auth::user()), $request->amount, [
                                        'description' => 'withdraw',
                                        'author' => Auth::user()->email,
                                    ], Transfer::STATUS_REFUND);
                // Notify admin via email
                $this->notifyEmail('withdraw', User::find(5), $tranfer);
                // Flash operation success
                session()->flash('success', true);
            } catch (\Exception $e) {
                // Flash operation success
                session()->flash('success', false);
                session()->flash('deposit.error', $e->getMessage());
            }
        }

        // Set date to display
        $frontuser->created_date = Date::parse($frontuser->created_at)->format('d F Y');

        return view('wallet.page.deposit', ['account' => $frontuser]);
    }

    /**
     * Show available reports or display specific report according to route parameter.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function reports($type = '')
    {
        if (!empty($type)) {
            switch ($type) {
                case 'deposits':
                    $deposits = Auth::user()->transfers()->where('status', Transfer::STATUS_TRANSFER)
                                                         ->orderBy('created_at', 'desc')
                                                         ->simplePaginate(5);
                    return view('wallet.page.reports.deposits', compact('deposits'));
                    break;
                
                case 'withdraws':
                    $withdraws = Auth::user()->refunds()->where('status', Transfer::STATUS_REFUND)
                                                        ->orderBy('created_at', 'desc')
                                                        ->simplePaginate(5);
                    return view('wallet.page.reports.withdraws', compact('withdraws'));
                    break;
            }
        }
        else {
            return view('wallet.page.reports');
        }
    }

    /**
     * Notify user via email.
     *
     * @param  string  $type
     * @param  Illuminate\Database\Eloquent\Model|Illuminate\Support\Collection  $user
     * @param  Bavix\Wallet\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    protected function notifyEmail($type, $user, Transfer $transfer)
    {
        $recipient = ($user instanceof Collection) ? $user->pluck('email')->toArray() : (array) $user->email;
        $subject = 'Nouveau rechargement e.Dari';
        try {
            Mail::send('wallet.mail.admin', compact('type', 'subject', 'transfer'), function ($message) use ($recipient, $subject) {
                $message->from(frommail(), forcompany());
                $message->to($recipient);
                $message->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error('Wallet notification via email error : ' . $e->getMessage());
        }
    }

    /**
     * Notify holder via SMS Mail Pro.
     *
     * @param  string  $type
     * @param  Bavix\Wallet\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    protected function notifySmsMailPro($type, Transfer $transfer)
    {
        // Init max attempts
        $max_attempts = 0;

        // Get apiKey
        $apiKey = config('services.sms_mail_pro.api_key');

        // Set SMS sender id
        $sms_sender_id = urlencode(config('services.sms_mail_pro.sender_id'));

        do {
            switch ($type) {
                case 'deposit':
                    // Set SMS recipient & message
                    $sms_recipient = str_start($transfer->to->cellphone, '+225');
                    $sms_message = urlencode(<<<EOT
                    Bonjour {$transfer->to->lastname}, votre recharge E-Dari de {$transfer->deposit->amount} FCFA a été effectuée avec succès. Votre solde Wallet est maintenant de {$transfer->to->balance} FCFA, rendez vous sur https://myplace-events.com
                    EOT);

                    // Send SMS notification
                    // Try send SMS to SMS Mail Pro
                    try {
                        // Set HTTP Get and callback function to handle relevant event
                        $context = stream_context_create([
                            'http' => [
                                'method' => 'GET',
                            ],
                        ],
                        [
                            'notification' => function ($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max) use (&$msg, &$code) {
                
                                    switch ($notification_code) {
                                        case STREAM_NOTIFY_RESOLVE:
                                        case STREAM_NOTIFY_REDIRECTED:
                                        case STREAM_NOTIFY_CONNECT:
                                        case STREAM_NOTIFY_FILE_SIZE_IS:
                                        case STREAM_NOTIFY_MIME_TYPE_IS:
                                        case STREAM_NOTIFY_PROGRESS:
                                        case STREAM_NOTIFY_AUTH_RESULT:
                                            // nothing to do
                                            break;
                                        
                                        case STREAM_NOTIFY_AUTH_REQUIRED:
                                        case STREAM_NOTIFY_FAILURE:
                                            throw new \Exception($message, $message_code);
                                            break;
                                    }
                                }
                        ]);
                        // Get and parse response from SMS Mail Pro
                        $response = json_decode(file_get_contents('https://admin.sms-mail.pro/sms/api?action=send-sms&api_key='. $apiKey .'&to='. $sms_recipient .'&from='. $sms_sender_id .'&sms='. $sms_message, false, $context));

                        // If message not sent successfully throw error
                        if ($response->code != 'ok') throw new \Exception($response->message, $response->code);

                        return $response;
                    }
                    catch (\Exception $e) {
                        Log::error('Wallet - Send SMS Mail Pro error : ' . $e->getMessage(), ['error_code' => $e->getCode()]);
                    }
                break;
            }

            $max_attempts++;
            if ($max_attempts == config('services.sms_mail_pro.max_attempts'))
                Log::error("Wallet SMS Mail Pro max_attempts exceed - Unable to send SMS notification to ". $transfer->to->email);
        }
        while (!isset($response) && $max_attempts < config('services.sms_mail_pro.max_attempts'));
    }

    /**
     * Notify holder via Orange SMS.
     *
     * @param  string  $type
     * @param  Bavix\Wallet\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    protected function notifyOrangeSms($type, Transfer $transfer)
    {
        // Init max attempts
        $max_attempts = 0;

        // Set SMS sender
        $sms_sender = config('services.orange_sms.dev_phone_number');

        do {
            switch ($type) {
                case 'deposit':
                    // Get current token or request a new
                    $token = $this->getOrangeSmsToken();

                    // Set SMS recipient & message
                    $sms_recipient = str_start($transfer->to->cellphone, '225');
                    $sms_message = <<<EOT
                    Bonjour {$transfer->to->lastname}, votre recharge E-Dari de {$transfer->deposit->amount} FCFA a été effectuée avec succès. Votre solde Wallet est maintenant de {$transfer->to->balance} FCFA, rendez vous sur https://myplace-events.com .
                    EOT;

                    // Send SMS notification
                    // Try connect Orange SMS API
                    try {
                        // Set HTTP Header and callback function to handle relevant event
                        $context = stream_context_create([
                            'http' => [
                                'method' => 'POST',
                                'header' => "Authorization: ". $token->token_type ." ". $token->access_token ."\r\n" .
                                            "Content-Type: application/json\r\n",
                                'content' => '{"outboundSMSMessageRequest":'.
                                                '{'.
                                                    '"address": "tel:+'. $sms_recipient .'",'.
                                                    '"senderAddress":"tel:+'. $sms_sender .'",'.
                                                    '"outboundSMSTextMessage":'.
                                                    '{'.
                                                        '"message": "'. $sms_message .'"'.
                                                    '}'.
                                                '}'.
                                            '}',
                            ],
                        ],
                        [
                            'notification' => function ($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max) use (&$msg, &$code) {
                
                                    switch ($notification_code) {
                                        case STREAM_NOTIFY_RESOLVE:
                                        case STREAM_NOTIFY_REDIRECTED:
                                        case STREAM_NOTIFY_CONNECT:
                                        case STREAM_NOTIFY_FILE_SIZE_IS:
                                        case STREAM_NOTIFY_MIME_TYPE_IS:
                                        case STREAM_NOTIFY_PROGRESS:
                                        case STREAM_NOTIFY_AUTH_RESULT:
                                            // nothing to do
                                            break;
                                        
                                        case STREAM_NOTIFY_AUTH_REQUIRED:
                                        case STREAM_NOTIFY_FAILURE:
                                            throw new \Exception($message, $message_code);
                                            break;
                                    }
                                }
                        ]);
                        // Get and parse response from Orange SMS API
                        $response = json_decode(file_get_contents('https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B'. $sms_sender .'/requests', false, $context));

                        return $response;
                    }
                    catch (\Exception $e) {
                        // If error 401:Unauthorized access
                        if ($e->getCode() == 401) {
                            // Clear token_type && access_token from config
                            if (Storage::disk('config')->exists('services.php')) {
                                $content = Storage::disk('config')->get('services.php');
                                $content = str_replace("'token_type' => '". $token->token_type ."'", "'token_type' => ''", $content);
                                $content = str_replace("'access_token' => '". $token->access_token ."'", "'access_token' => ''", $content);
                                Storage::disk('config')->put('services.php', $content);
                                unset($content);
                            }
                            // Clear from configuration runtime
                            config(['services.orange_sms.token_type' => '', 'services.orange_sms.access_token' => '']);
                        }
                        else
                            Log::error('Wallet - Send Orange SMS error : ' . $e->getMessage(), ['error_code' => $e->getCode()]);
                    }
                break;
            }

            $max_attempts++;
            if ($max_attempts == config('services.orange_sms.max_attempts'))
                Log::error("Wallet Orange SMS max_attempts exceed - Unable to send SMS notification to ". $transfer->to->email);
        }
        while (!isset($response) && $max_attempts < config('services.orange_sms.max_attempts'));

        // Delay execution due to Orange SMS API limit to 5 requests per second 
        sleep(1/4);
    }

    /**
     * Get fresh token from either Orange SMS API or config.
     *
     * @return \StdClass
     */
    protected function getOrangeSmsToken()
    {
        if (empty(config('services.orange_sms.token_type')) || empty(config('services.orange_sms.access_token'))) {
            // Try connect Orange SMS API
            try {
                // Set HTTP Header, and callback function to handle relevant event
                $context = stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => "Authorization: Basic ". base64_encode(config('services.orange_sms.client_id') .':'. config('services.orange_sms.client_secret')) ."\r\n" .
                                    "Content-Type: application/x-www-form-urlencoded\r\n" .
                                    "Accept: application/json\r\n",
                        'content' => "grant_type=client_credentials",
                    ],
                ],
                [
                    'notification' => function ($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max) use (&$msg, &$code) {
        
                            switch ($notification_code) {
                                case STREAM_NOTIFY_RESOLVE:
                                case STREAM_NOTIFY_REDIRECTED:
                                case STREAM_NOTIFY_CONNECT:
                                case STREAM_NOTIFY_FILE_SIZE_IS:
                                case STREAM_NOTIFY_MIME_TYPE_IS:
                                case STREAM_NOTIFY_PROGRESS:
                                case STREAM_NOTIFY_AUTH_RESULT:
                                    // nothing to do
                                    break;
                                
                                case STREAM_NOTIFY_AUTH_REQUIRED:
                                case STREAM_NOTIFY_FAILURE:
                                    throw new \Exception($message, $message_code);
                                    break;
                            }
                        }
                ]);
                // Get and parse response from Orange SMS API
                $response = json_decode(file_get_contents('https://api.orange.com/oauth/v3/token', false, $context));

                // Store token_type && access_token into config
                if (Storage::disk('config')->exists('services.php')) {
                    $content = Storage::disk('config')->get('services.php');
                    $content = str_replace("'token_type' => ''", "'token_type' => '". $response->token_type ."'", $content);
                    $content = str_replace("'access_token' => ''", "'access_token' => '". $response->access_token ."'", $content);
                    Storage::disk('config')->put('services.php', $content);
                }

                return $response;
            }
            catch (\Exception $e) {
                Log::error('Wallet - Get Orange SMS API token error : ' . $e->getMessage(), ['error_code' => $e->getCode(), 'response' => $response]);
            }
        }
        else 
            return (object) ['token_type' => config('services.orange_sms.token_type'), 'access_token' => config('services.orange_sms.access_token'), ];
    }

}