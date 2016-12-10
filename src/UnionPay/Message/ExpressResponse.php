<?php

/**
 *
 */

namespace Woodfish\Component\Payment\UnionPay\Message;


use Woodfish\Component\Payment\Omnipay\Common\Message\AbstractResponse;

class ExpressResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return isset($this->data['respCode']) && $this->data['respCode'] == '00';
    }
}