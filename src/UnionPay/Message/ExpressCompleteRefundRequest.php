<?php

namespace Woodfish\Component\Payment\UnionPay\Message;


use Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface;

class ExpressCompleteRefundRequest extends BaseAbstractRequest
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
        return $this->getParameters();
    }

    private function validateData()
    {
        $this->validate('request_params','certDir', 'certPath', 'certPath');
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    public function setRequestParams($value)
    {
        return $this->setParameter('request_params', $value);
    }


    public function getRequestParam($key)
    {
        $params = $this->getRequestParams();
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return null;
        }
    }




    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $isVerify = $this->verify($this->getRequestParams(), $this->getCertDir());

        if ($isVerify && $this->getRequestParam('respCode') == '00') {
            $data['verify_success'] = true;
        } else {
            $data['verify_success'] = false;
        }

        return $this->response = new ExpressCompleteRefundResponse($this, $data);
    }
}