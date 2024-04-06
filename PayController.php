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


       /*
TWILIO_SID=ACfab61f84cf4f4bddb0e4c7d781a6604a
TWILIO_AUTH_TOKEN=b0fea3006c513f5197040a88706cc5bf
TWILIO_WHATSAPP_NUMBER="whatsapp:+14155238886"

# payMob

paymob_api_key="ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2T1RZNU56Y3dMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuX3pLTWFHRU1yenFRX3BLMUY5OXFqZlFOV1pIQ21WSVQ4UXI4Q21nZUZWU0VqaEJmUUp5dEN2cnd0UEQyeWdQQ1lvZXUxSlF6ZHl4TnZLbG9tNlJFenc="
integration_id=4553359
*/


        $status =  Whatsapp::SendWhatsAppMessage("messag: http://www.yummycupcakes.com/");
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

        // $url = Paymob::Auth_Paymob()->Register_Order($data_order)->Get_Payment_key($data_to_pay)->Url_Card_toIftame_ToPay(836963);
        // $url = Paymob::Auth_Paymob()->Register_Order($data_order)->Get_Payment_key($data_to_pay)->Wallet("01010101010");
        return redirect($url);
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
