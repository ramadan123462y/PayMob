<?php

namespace App\Http\Facades;

use App\Http\Services\Paymob as ServicesPaymob;
use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static \App\Http\Services\Paymob|Token get_token()
 * @method static \App\Http\Services\Paymob|Token order_register(array $data_order)
 * @method static \App\Http\Services\Paymob|Token get_token_payKey_Order($data_to_pay)
 * @method static \App\Http\Services\Paymob|Token $token;
 * @method static \App\Http\Services\Paymob|Token public $order_id;
 * @method static \App\Http\Services\Paymob|Token public $Payment_Key_Request;
 */

class Paymob extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'Paymob';
    }
}
