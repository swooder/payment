<?php

namespace Woodfish\Component\Payment\UnionPay\Message;


use Omnipay\Common\Message\AbstractResponse;

class ExpressCompletePurchaseResponse extends AbstractResponse
{

    public function getResponseText()
    {
        if ($this->isSuccessful()) {
            return 'success';
        } else {
            return 'fail';
        }
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['verify_success'];
    }
}