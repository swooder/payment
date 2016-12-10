<?php


namespace Woodfish\Component\Payment\UnionPay\Message;

use Omnipay\Common\Message\ResponseInterface;

class ExpressQueryRequest extends BaseAbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('certPath', 'certPassword', 'orderId', 'txnTime');
        $data = array(
            'version'     => $this->getVersion(),
            'encoding'    => $this->getEncoding(),
            'certId'      => $this->getCertId(),
            'signMethod'  => $this->getSignMethod(),
            'txnType'     => '00',
            'txnSubType'  => '00',
            'bizType'     => $this->getBizType(),
            'accessType'  => $this->getAccessType(),
            'channelType' => '07',
            'orderId'     => $this->getOrderId(),
            'merId'       => $this->getMerId(),
            'txnTime'     => $this->getTxnTime(),
        );

        $data = $this->filterData($data);

        $data['signature'] = $this->getParamsSignatureWithRSA($data, $this->getCertPath(), $this->getCertPassword());

        return $data;

    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $data = $this->httpRequest('query', $data);

        return $this->response = new ExpressQueryResponse($this, $data);
    }
}