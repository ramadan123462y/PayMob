<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;

class Whatsapp extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'WatsappService';
    }
}
