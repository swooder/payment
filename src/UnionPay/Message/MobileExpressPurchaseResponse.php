<?php


namespace Woodfish\Component\Payment\UnionPay\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class MobileExpressPurchaseResponse extends AbstractResponse implements ResponseInterface
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }


    public function isRedirect()
    {
        return false;
    }


    public function getRedirectData()
    {
        return $this->data;
    }

    public function getTradeNo()
    {
        if (isset($this->data['tn'])) {
            return $this->data['tn'];
        } else {
            return null;
        }
    }

}