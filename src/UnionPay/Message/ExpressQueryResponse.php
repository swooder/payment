<?php


namespace Woodfish\Component\Payment\UnionPay\Message;


use Omnipay\Common\Message\AbstractResponse;

class ExpressQueryResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return isset($this->data['origRespCode']) && $this->data['origRespCode'] == '00';
    }
}