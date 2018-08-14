<?php

namespace Ryandadeng\SecurepaySecureframe\Services\Interfaces;


interface SecurePayCustomDataInterface
{

    public function getPrimaryRef();

    public function getAmount();

    public function getReturnUrl();
}