<?php

namespace Ryandadeng\SecurepaySecureframe\Services;

/**
 * Ref: https://www.securepay.com.au/wp-content/uploads/2017/06/SecureFrame_Integration_Guide.pdf
 * Class SecurePayService
 * @package Inkstation\SecurePay\Services
 */
class SecurePayOutBoundService
{

    protected $settdate;
    protected $suramount;
    protected $expirydate;
    protected $amount;
    protected $restext;
    protected $merchant;
    protected $baseamount;
    protected $rescode;
    protected $surfee;
    protected $fingerprint;
    protected $currency;
    protected $refid;
    protected $cardtype;
    protected $pan;
    protected $summarycode;
    protected $txnid;
    protected $surrate;
    protected $timestamp;
    protected $envPassword;
    protected $isLive;
    protected $response;

    const SUMMARY_CODE_APPROVED = '1';
    const SUMMARY_CODE_DECLINED_BY_BANK = '2';
    const SUMMARY_CODE_DECLINED_BY_OTHER_REASONS = '3';
    const SUMMARY_CODE_CANCELLED_BY_USER = '4';

    public function __construct($data)
    {
        $this->init($data);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function init($data)
    {
        $this->isLive = config('securepayframe.is_live');
        $this->settdate = $data['settdate'];
        $this->suramount = $data['suramount'];
        $this->expirydate = $data['expirydate'];
        $this->amount = $data['amount'];
        $this->restext = $data['restext'];
        $this->merchant = $data['merchant'];
        $this->baseamount = $data['baseamount'];
        $this->rescode = $data['rescode'];
        $this->surfee = $data['surfee'];
        $this->fingerprint = $data['fingerprint'];
        $this->currency = $data['currency'];
        $this->refid = $data['refid'];
        $this->cardtype = $data['cardtype'];
        $this->pan = $data['pan'];
        $this->summarycode = $data['summarycode'];
        $this->txnid = $data['txnid'];
        $this->surrate = $data['surrate'];
        $this->timestamp = $data['timestamp'];

        if ($this->isLive == false) {
            $this->envPassword = config('securepayframe.test_password');
        } else {
            $this->envPassword = config('securepayframe.live_password');
        }
    }

    /**
     * @return string
     */
    public function getSummaryText()
    {
        switch ($this->summarycode) {
            case 1:
                return 'Approved';
            case 2:
                return 'Declined by the bank';
            case 3:
                return 'Declined for any other reasons';
            case 4:
                return 'Cancelled by user';
        }
    }


    /**
     * @return bool
     */
    public function checkIfApproved()
    {
        return in_array($this->rescode, ['00', '08', '11']) ? true : false;
    }


    /**
     * @param $merchant
     * @param $refId
     * @param $amount
     * @param $timestamp
     * @param $summaryCode
     * @return string
     */
    public function generateOutputFingerprint($merchant, $refId, $amount, $timestamp, $summaryCode)
    {
        $str = $merchant . '|' . $this->envPassword . '|' . $refId . '|' . $amount . '|' . $timestamp . '|' . $summaryCode;
        $outputFingerprint = sha1($str);

        return $outputFingerprint;
    }

    /**
     * @return bool
     */
    public function validateSummaryCode()
    {
        return $this->summarycode == '1' ? true : false;
    }

    /**
     * @return bool
     */
    public function validateOutputFingerprint()
    {

        // check if finger print is right
        $outputFingerPrint = $this->generateOutputFingerprint(
            $this->merchant,
            $this->refid,
            $this->amount,
            $this->timestamp,
            $this->summarycode
        );

        return $outputFingerPrint == $this->fingerprint ? true : false;
    }

    /**
     * @return mixed
     */
    public function getRestext()
    {
        return $this->restext;
    }

    /**
     * @return mixed
     */
    public function getRescode()
    {
        return $this->rescode;
    }

    /**
     * @return mixed
     */
    public function getRefid()
    {
        return $this->refid;
    }

    /**
     * @return mixed
     */
    public function getTxnid()
    {
        return $this->txnid;
    }


    public function fails()
    {
        return (!$this->validateOutputFingerprint() || !$this->validateSummaryCode());
    }

    public function errors()
    {
        if (!$this->validateOutputFingerprint()) {
            return 'Payment fingerprint is not matching.';
        }

        if (!$this->validateSummaryCode()) {
            return $this->getSummaryText() . ' - ' . $this->getRescode() . ' ' . $this->getRestext();
        }

        return false;
    }

}