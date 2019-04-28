<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PayPal\Rest\ApiContext ;
use PayPal\Auth\OAuthTokenCredential ;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use App\Post ;

class PaymentController extends Controller
{

    public function paypal()
    {
        session()->put( "price" , request('price') ) ;

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_SANDBOX_CLIENT_ID'),
                env('PAYPAL_SANDBOX_SECRET')
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl( url('/paypal/done') )
            ->setCancelUrl( url('/paypal/cancel') );

        // Set payment amount
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal( request('price') );

        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription( request('price') );

        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try
        {
            $payment->create($apiContext);
            // Get PayPal redirect URL and redirect the customer
            $approvalUrl = $payment->getApprovalLink();
            if( $approvalUrl )
            {
                return redirect( $approvalUrl ) ;
            }
            else
            {
                return "error in paypal function" ;
            }
            // Redirect the customer to $approvalUrl
        }
        catch(PayPal\Exception\PayPalConnectionException $ex)
        {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        }
        catch (Exception $ex)
        {
            die($ex);
        }
    }

    public function paypalDone(Request $r )
    {


        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_SANDBOX_CLIENT_ID'),
                env('PAYPAL_SANDBOX_SECRET')
            )
        );

        $paymentId = $r->paymentId;
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $r->PayerID ;

        // Execute payment with payer ID
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);


        try
        {
            // Execute payment
            $result = $payment->execute($execution, $apiContext);
            session()->flash( "success" , "Payment Is Successfuly") ;

            $post = Post::find( session()->get("donate") );
            $post->payment += session()->get("price") ;
            $post->save() ;

            return redirect("/needy/persons") ;
            //dd($result);
        }
        catch (PayPal\Exception\PayPalConnectionException $ex)
        {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        }
        catch (Exception $ex)
        {
            die($ex);
        }
    }
    public function paypalCancel()
    {
        session()->flash( "fail" , "Payment Is Not Successfuly") ;
        return redirect("/") ;
    }
}
