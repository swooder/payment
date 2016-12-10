<?php

namespace Woodfish\Component\Payment\AliPay\Message;

class ExpressCloseRequest extends BasePurchaseRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();
        $data = $this->getParamsToSign();
        $data              = array_filter($data);
        $data['sign']      = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();

        return $data;
    }

    protected function validateData()
    {
        $this->validate('partner', 'out_trade_no', 'private_key');
    }

    private function getParamsToSign()
    {
        return array(
            'partner'        => $this->getPartner(),
            'out_trade_no'   => $this->getOutTradeNo(),
            'service'        => $this->getService(),
            '_input_charset' => $this->getInputCharset(),
        );
    }





}
