<?php

namespace Xgenious\Paymentgateway\Base\Gateways;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Xgenious\Paymentgateway\Base\GlobalCurrency;
use Xgenious\Paymentgateway\Base\PaymentGatewayBase;
use Xgenious\Paymentgateway\Base\PaymentGatewayHelpers;
use Xgenious\Paymentgateway\Traits\ConvertUsdSupport;
use Xgenious\Paymentgateway\Traits\CurrencySupport;
use Xgenious\Paymentgateway\Traits\PaymentEnvironment;

class Iyzipay extends PaymentGatewayBase
{
    use PaymentEnvironment, CurrencySupport, ConvertUsdSupport;

    private $apiKey;
    private $secretKay;



    public function setSecretKey($secretKay)
    {
        $this->secretKay = $secretKay;
        return $this;
    }

    public function getSecretKey()
    {
        return $this->secretKay;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }


    /*
    * charge_amount();
    * @required param list
    * $amount
    *
    *
    * */
    public function charge_amount($amount)
    {
        if (in_array($this->getCurrency(), $this->supported_currency_list())) {
            return number_format($amount,2);
        }
        return $this->get_amount_in_usd($amount);
    }


    /**
     * @required param list
     * $args['amount']
     * $args['description']
     * $args['item_name']
     * $args['ipn_url']
     * $args['cancel_url']
     * $args['payment_track']
     * return redirect url for
     * */

    public function view($args)
    {
//        $salt_pay_args = array_merge($args, [
//            'gateway_id' => $this->getPaymentGatewayId(),
//            'merchantid' => $this->getMerchantId(),
//            'language' => in_array($this->getLangPaymentPage(), $this->getAvilableLanguage()) ? $this->getLangPaymentPage() : 'en',
//            'currency' => $this->getCurrency(),
//            'charge_amount' => $this->charge_amount($args['amount']),
//            'environment' => $this->getEnv(),
//            'order_id' => PaymentGatewayHelpers::wrapped_id($args['order_id']),
//            'action_url' => $this->getBaseUrl() . 'default.aspx',
//            'reference' => $args['payment_type']
//        ]);
//        $salt_pay_args['checkhash'] = $this->generateCheckHash($salt_pay_args);
//
//        return view('paymentgateway::saltpay', ['saltpay_data' => $salt_pay_args]);
    }

    public function charge_customer($args)
    {
        //todo:: format data for send in blade file for get user card details
        return $this->view($args);
    }


    /**
     * @required param list
     * $args['request']
     * $args['cancel_url']
     * $args['success_url']
     *
     * return @void
     * */
    public function ipn_response($args = [])
    {

//        $request = request();
//        $status = $request->status;
//        $orderid = $request->orderid;
//        $reference_string = $request->reference;
//        $reference = $reference_string;
//        $order_amount = $request->amount;
//
//        $orderhash = $request->orderhash;
//        $step = $request->step;
//
//        $errordescription = $request->errordescription;
//        $errorcode = $request->errorcode;
//        $errordescription = $request->errordescription;
//
//
//
//        $authorizationcode = $request->authorizationcode;
//        $refundid = $request->refundid;
//
//
//
//        if($status === 'OK' && !empty($orderid)){
//            if (hash_equals($orderhash,$this->getCheckoutHash($order_amount,$orderid))){
//                //todo:: hash verified, now make an api call to cross check the payment is actually maid or not
//                if ( strpos( $step, 'Payment' ) !== false ) {
//                    $xml = '<PaymentNotification>Accepted</PaymentNotification>';
//
//                    //send resopnse to saltpay that we have received the notification
//                    try
//                    {
//                        Http::
//                        withHeaders([
//                            'Content-Type' => 'text/xml'
//                        ])
//                            ->timeout(60)
//                            ->withoutVerifying()
//                            ->maxRedirects(5)
//                            ->post($this->getBaseUrl(). 'default.aspx',[
//                                'postdata' => $xml, 'postfield' => 'value'
//                            ]);
//
//
//                    }catch (\Exception $e){
//                        // abort(501,'failed to send data to salt pay');
//                    }
//                }
//
//
//                return $this->verified_data([
//                    'status' => 'complete',
//                    'transaction_id' => $authorizationcode,
//                    'order_id' => PaymentGatewayHelpers::unwrapped_id($orderid),
//                    'order_type' => $reference
//                ]);
//            }
//        }
//
//        return $this->verified_data([
//            'status' => 'failed',
//            'order_id' => PaymentGatewayHelpers::unwrapped_id(request()->get('order_id')),
//            'order_type' => $reference
//        ]);
    }

    /**
     * geteway_name();
     * return @string
     * */
    public function gateway_name()
    {
        return 'iyzipay';
    }

    /**
     * charge_currency();
     * return @string
     * */
    public function charge_currency()
    {
        if (in_array($this->getCurrency(), $this->supported_currency_list())) {
            return $this->getCurrency();
        }
        return "TRY";
    }

    /**
     * supported_currency_list();
     * it will return all of supported currency for the payment gateway
     * return array
     * */
    public function supported_currency_list()
    {
        return  ['TRY', 'USD', 'EUR', 'GBP','IRR'];
    }

}
