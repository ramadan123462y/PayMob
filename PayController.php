<?php

namespace App\Http\Controllers;

use App\Http\Facades\Paymob;
use App\Http\Facades\Whatsapp;
use App\Http\Services\Paymob as ServicesPaymob;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class PayController extends Controller
{
    public function order_registration()
    {

        $status =  Whatsapp::SendWhatsAppMessage("Your Yummy Cupcakes Company order of 1 dozen frosted cupcakes has shipped and should be delivered on July 10, 2019. Details: http://www.yummycupcakes.com/");
        $data_order = [
            "delivery_needed" => "false",
            "amount_cents" => "888",
            "currency" => "EGP",
            "merchant_order_id" => rand(1, 10000),
            "items" => [],

        ];
        $data_to_pay = [
            "amount_cents" => "100",
            "expiration" => 3600,
            "billing_data" => [
                "apartment" => "803",
                "email" => "claudette09@exa.com",
                "floor" => "42",
                "first_name" => "Clifford",
                "street" => "Ethan Land",
                "building" => "8028",
                "phone_number" => "+86(8)9135210487",
                "shipping_method" => "PKG",
                "postal_code" => "01898",
                "city" => "Jaskolskiburgh",
                "country" => "CR",
                "last_name" => "Nicolas",
                "state" => "Utah"
            ],
            "currency" => "EGP",
            "integration_id" => env('integration_id'),
            "lock_order_when_paid" => "false"
        ];

        $url = Paymob::Auth_Paymob()->Register_Order($data_order)->Get_Payment_key($data_to_pay)->Url_Card_toIftame_ToPay(836963);
        return redirect($url);

        // -------------------------------

        //--------------------------------------------------

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json'
        // ])->post('https://accept.paymob.com/api/auth/tokens', [
        //     "api_key" => "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2T1RZNU56Y3dMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuX3pLTWFHRU1yenFRX3BLMUY5OXFqZlFOV1pIQ21WSVQ4UXI4Q21nZUZWU0VqaEJmUUp5dEN2cnd0UEQyeWdQQ1lvZXUxSlF6ZHl4TnZLbG9tNlJFenc="
        // ]);

        // $token = $response->json()['token'];

        // $data_order = [
        //     "auth_token" => $token,
        //     "delivery_needed" => "false",
        //     "amount_cents" => "888",
        //     "currency" => "EGP",
        //     "merchant_order_id" => rand(1, 10000),
        //     "items" => [],

        // ];

        // $response2 = Http::asJson()->withHeaders([
        //     'Content-Type' => 'application/json'
        // ])->post('https://accept.paymob.com/api/ecommerce/orders', $data_order);

        // $order_id = $response2['id'];


        // $data_to_pay = [
        //     "auth_token" => $token,
        //     "amount_cents" => "100",
        //     "expiration" => 3600,
        //     "order_id" => $order_id,
        //     "billing_data" => [
        //         "apartment" => "803",
        //         "email" => "claudette09@exa.com",
        //         "floor" => "42",
        //         "first_name" => "Clifford",
        //         "street" => "Ethan Land",
        //         "building" => "8028",
        //         "phone_number" => "+86(8)9135210487",
        //         "shipping_method" => "PKG",
        //         "postal_code" => "01898",
        //         "city" => "Jaskolskiburgh",
        //         "country" => "CR",
        //         "last_name" => "Nicolas",
        //         "state" => "Utah"
        //     ],
        //     "currency" => "EGP",
        //     "integration_id" => 4553121,
        //     "lock_order_when_paid" => "false"
        // ];

        // $response3 = Http::asJson()->withHeaders([
        //     'Content-Type' => 'application/json'
        // ])->post('https://accept.paymob.com/api/acceptance/payment_keys', $data_to_pay);
        // $Payment_Key_Request = $response3['token'];



        // return redirect("https://accept.paymob.com/api/acceptance/iframes/836963?payment_token=$Payment_Key_Request");
    }

    public function back(HttpRequest $request)
    {
        dd($request);
    }
    public function status()
    {

        dd((request()->query())['success'], (request()->query())['id'], (request()->query())['order'], (request()->query())['pending'], (request()->query())['hmac']);
    }
}
