<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 31/7/18
 * Time: 11:12 AM
 */

namespace Ryandadeng\Securepayframe\Services;

use App\SecurePay\interfaces\SecurePayTokenInterface;

class SecurePayToken implements SecurePayTokenInterface
{

    /**
     * @param string $str
     * @return string
     */
    public function encrypt(string $str)
    {
        $encrypted = '';
        return $encrypted;
    }

    /**
     * @param string $encryptedValue
     * @return bool
     */
    public function validateToken(string $encryptedValue)
    {
        return true;
    }
}