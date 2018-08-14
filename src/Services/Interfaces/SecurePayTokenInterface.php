<?php

namespace Ryandadeng\SecurepaySecureframe\Services\interfaces;

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