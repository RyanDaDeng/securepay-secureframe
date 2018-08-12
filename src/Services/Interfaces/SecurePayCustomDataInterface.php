<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 3/8/18
 * Time: 4:13 PM
 */

namespace Ryandadeng\SecurepaySecureframe\Services\Interfaces;


interface SecurePayCustomDataInterface
{

    public function getPrimaryRef();

    public function getAmount();

    public function getReturnUrl();
}