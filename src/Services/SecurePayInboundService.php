<?php

namespace Ryandadeng\SecurepaySecureframe\Services;

use Carbon\Carbon;
use Ryandadeng\SecurepaySecureframe\Services\Interfaces\SecurePayCustomDataInterface;

/**
 * Ref: https://www.securepay.com.au/wp-content/uploads/2017/06/SecureFrame_Integration_Guide.pdf
 * Error Codes: https://www.securepay.com.au/wp-content/uploads/2017/06/SecurePay_Response_Codes.pdf
 * Class SecurePayService
 */
class SecurePayInboundService
{
    private $fpTimeStamp;
    private $action;
    private $txnType;


    protected $billName = 'transact';
    protected $merchantId;
    protected $amount = 0;
    protected $primaryRef;
    protected $fingerprint;
    protected $displayReceipt = 'no';
    protected $returnUrl;
    protected $cancelUrl;
    protected $returnUrlTex = 'Continue...';
    protected $returnUrlTarget = 'parent';
    protected $confirmation = 'no';
    protected $template = 'responsive';
    protected $primaryRefName = 'Reference';
    protected $cardTypes = 'VISA|MASTERCARD';
    protected $envPassword;
    protected $callbackUrl;
    protected $pureFingerPrint;
    protected $securePayTokenService;
    protected $externalCss;
    protected $testPassword;
    protected $livePassword;
    protected $liveAction = 'https://payment.securepay.com.au/secureframe/invoice';
    protected $testAction = 'https://test.payment.securepay.com.au/secureframe/invoice';
    protected $config;
    protected $isLive = false;

    public function __construct(SecurePayCustomDataInterface $customData)
    {
        $this->fpTimeStamp = Carbon::now()->setTimezone('GMT')->format('YmdHis');
        $this->amount = $customData->getAmount();
        $this->primaryRef = $customData->getPrimaryRef();
        $this->returnUrl =$customData->getReturnUrl();
        $this->isLive = config('securepayframe.is_live');
        $this->merchantId = config('securepayframe.merchant_id');
        if ($this->isLive == false) {
            $this->txnType = '0';
            $this->envPassword = config('securepayframe.test_password');
            $this->action = $this->testAction;
        } else {
            $this->txnType = '2';
            $this->envPassword = config('securepayframe.live_password');
            $this->action = $this->liveAction;
        }
    }

    /**
     * @return string
     */
    private function generatePlainFingerprint()
    {
        return $this->merchantId . '|' . $this->envPassword . '|' . $this->txnType . '|' . $this->primaryRef . '|' . $this->amount . '|' . $this->fpTimeStamp;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $this->pureFingerPrint = $this->generatePlainFingerprint();
        $this->fingerprint = sha1($this->pureFingerPrint);
        $data = [
            'action' => $this->action,
            'bill_name' => $this->billName,
            'timestamp' => $this->fpTimeStamp,
            'password' => $this->envPassword,
            'merchant' => $this->merchantId,
            'return_url' => $this->returnUrl,
            'cancel_url' => $this->cancelUrl,
            'amount' => $this->amount,
            'primary_ref' => $this->primaryRef,
            'primary_ref_name' => $this->primaryRefName,
            'fingerprint' => $this->fingerprint,
            'txn_type' => $this->txnType,
            'card_types' => $this->cardTypes,
            'display_receipt' => $this->displayReceipt,
            'return_url_text' => $this->returnUrlTex,
            'return_url_target' => $this->returnUrlTarget,
            'template' => $this->template,
            'confirmation' => $this->confirmation,
            'callback_url' => $this->callbackUrl,
            'pureFingerPrint' => $this->pureFingerPrint,
            'external_css' => $this->externalCss
        ];
        return $data;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $view = 'securepayframe::securepay';

        return app('view')->make($view, ['result' => $this->toArray()]);
    }
}