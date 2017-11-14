<?php

namespace Ahelos\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPalController extends Controller
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * PayPalController constructor.
     */
    public function __construct()
    {
        $paypalConf = Config::get('paypal');
        $this->apiContext = new ApiContext(new OAuthTokenCredential($paypalConf['client_id'], $paypalConf['secret']));
        $this->apiContext->setConfig($paypalConf['settings']);
    }

    /**
     * @return Response
     */
    public function donateWithPayPal()
    {
        return view('paypal');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'amount' => 'required|numeric'
            ],
            [
               'amount.required' => 'Iznos je obavezan.',
                'amount.numeric' => 'Iznos mora biti broj.',
            ]
        );
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $price = $request->input('amount');

        $item = new Item();
        $item->setName('Donacija')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($price);

        // add items to list
        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($price);

        $description = 'Ahelos donacija';

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($description);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('payment.status'))
            ->setCancelUrl(route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (Exception $e) {
            if (Config::get('app.debug')) {
                dd($e->getMessage());
            } else {
                die('Dogodila se greška. Molimo pokušajte kasnije.');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() === 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID, service ID, and user ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            // redirect to paypal
            return redirect()->away($redirect_url);
        }
        return redirect()->route('payment')
            ->with('error', 'Greška.');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function getPaymentStatus(Request $request): RedirectResponse
    {
        // Get the payment ID before session clear
        $paymentId = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (!$request->filled('PayerID') || !$request->filled('token')) {
            return redirect()->route('donate-with-paypal')->with('error', 'Dogodila se pogreška');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to the site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') { // payment made
            //get transaction details
            $data['transaction_id'] = $result->transactions[0]->related_resources[0]->sale->id;
            $data['transaction_time'] = Carbon::now();
            $data['transaction_amount'] = $result->transactions[0]->related_resources[0]->sale->amount->total;
            $data['transaction_currency'] = $result->transactions[0]->related_resources[0]->sale->amount->currency;
            //get payer details
            $data['payer_first_name'] = $result->payer->payer_info->first_name;
            $data['payer_last_name'] = $result->payer->payer_info->last_name;
            $data['payer_email'] = $result->payer->payer_info->email;



            DB::table('paypal_transactions')->insert(
                [
                    'payer_user_id' => Auth::user()->id,
                    'payer_first_name' => $data['payer_first_name'],
                    'payer_last_name' => $data['payer_last_name'],
                    'payer_email' => $data['payer_email'],
                    'transaction_id' => $data['transaction_id'],
                    'transaction_time' => $data['transaction_time'],
                    'transaction_amount' => $data['transaction_amount'],
                    'transaction_currency' => $data['transaction_currency'],
                ]
            );

            return redirect()->route('donate-with-paypal')->with('success', 'Zahvaljujemo se na donaciji.');
        }

        return redirect()->route('payment')
            ->with('error', 'Plaćanje nije uspjelo.');
    }
}
