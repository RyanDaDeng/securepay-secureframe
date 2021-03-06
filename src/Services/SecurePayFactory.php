<?php

namespace Ryandadeng\SecurepaySecureframe\Services;

use Ryandadeng\SecurepaySecureframe\Services\Interfaces\SecurePayCustomDataInterface;


/**
 * Ref: https://www.securepay.com.au/wp-content/uploads/2017/06/SecureFrame_Integration_Guide.pdf
 * Class SecurePayService
 */
class SecurePayFactory
{


    /**
     * @param $data
     * @return SecurePayOutBoundService
     */
    public static function receive($data)
    {
        $secureOutBoundService = new SecurePayOutBoundService($data);
        return $secureOutBoundService;
    }


    /**
     * @param SecurePayCustomDataInterface $customData
     * @return SecurePayInboundService
     */
    public static function send(SecurePayCustomDataInterface $customData)
    {
        $secureOutBoundService = new SecurePayInboundService($customData);
        return $secureOutBoundService;
    }
}