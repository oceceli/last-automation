<?php

namespace App\Services\Address;

use App\Models\Address;

class AddressService
{
    public static function concatenated(Address $address)
    {
        return $address->adr_name . ' - ' . 
            $address->adr_body . ' - ' . $address->adr_district . '\\' . $address->adr_province . '\\' . $address->adr_country;
    }
}