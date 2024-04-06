<?php

namespace App\Http\Services;

use App\Http\Services\Interfaces\PaymobInterface;
use Illuminate\Support\Facades\Http;

class Paymob
{

    public $token;
    public $order_id;
    public $Payment_Key_Request;
    public static $count = 0;


    public function __construct()
    {

        $this->token = $this->get_token();
        self::$count++;
        return true;
    }

    /**
     *
     *
     * @Returns Token Auth
     * @Descreption:  Used To Send All Requests
     */



    public function get_token()
    {
        return $this->token;
    }

    public function Auth_Paymob()
    {
        $response =  Http::withHeader('content-type', 'application/json')->post(
            'https://accept.paymob.com/api/auth/tokens',
            [
                "api_key" => env('paymob_api_key')
            ]
        );
        $this->token = $response['token'];

        return $this;
    }
    /**
     *
     *
     * @Returns Id Orders Registeration
     * @Descreption:  Used To Register Order To Pay After_Later
     */


    public function Register_Order(array $data_order)
    {
        $data = [

            "auth_token" => $this->token,
        ];
        $all_data =  array_merge($data, $data_order);
        $response2 = Http::asJson()->withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://accept.paymob.com/api/ecommerce/orders', $all_data);



        $this->order_id = $response2['id'];

        return  $this;
    }
    public function Order_id()
    {

        return  $this->order_id;
    }

    /**
     *
     *
     * @Returns  Payment Key Request
     * @Descreption:  It will be also used for verifying your transaction request metadata.
     */

    public function Get_Payment_key($data_to_pay)
    {

        $data = [
            "auth_token" => $this->token,
            "order_id" => $this->order_id
        ];

        $all_data =  array_merge($data, $data_to_pay);

        $response3 = Http::asJson()->withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://accept.paymob.com/api/acceptance/payment_keys', $all_data);
        $this->Payment_Key_Request = $response3['token'];
        return $this;
    }


    /**
     *
     *
     * @Returns  redirect To Pay In iFrame
     * @Descreption:  checkout
     */

    public function Url_Card_toIftame_ToPay($id_iframes)
    {


        return "https://accept.paymob.com/api/acceptance/iframes/$id_iframes?payment_token=$this->Payment_Key_Request";
    }


    public function Wallet()
    {

        $Payment_Key_Request = $this->Payment_Key_Request;

        $data_wallet = [

            "source" => [
                "identifier" => "wallet mobile number",
                "subtype" => "WALLET"
            ],
            "payment_token" => "$Payment_Key_Request"  // token obtained in step 3
        ];

        $response = Http::asJson()->withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://accept.paymob.com/api/acceptance/payments/pay', $data_wallet);
        return $response;
    }
}
