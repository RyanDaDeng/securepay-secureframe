<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 3/8/18
 * Time: 4:13 PM
 */

namespace App\SecurePay\interfaces;


interface SecurePayTokenInterface
{

    /**
     * @param string $str
     * @return string
     */
    public function encrypt(string $str);

    /**
     * @param string $encryptedValue
     * @return bool
     */
    public function validateToken(string $encryptedValue);

}