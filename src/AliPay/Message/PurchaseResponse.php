<?php

namespace Woodfish\Payment\AliPay\Message;

use Woodfish\Component\Payment\Omnipay\Common\Message\AbstractResponse;
use Woodfish\Component\Payment\Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Buckaroo Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    public function isSuccessful()
    {
        return false;
    }


    public function isRedirect()
    {
        return true;
    }


    public function getRedirectUrl()
    {
        if ($this->getRedirectMethod() == 'GET') {
            return $this->getRequest()->getEndpoint() . '?' . http_build_query($this->getRedirectData());
        } else {
            return $this->getRequest()->getEndpoint();
        }
    }


    public function getRedirectMethod()
    {
        return 'GET';
    }


    public function getRedirectData()
    {
        return $this->data;
    }
}
