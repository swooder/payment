<?php

namespace Woodfish\Component\Payment\AliPay\Message;

class WapExpressPurchaseRequest extends BasePurchaseRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData1()
    {
        $this->validateData();

        $data = array(
            "service" => $this->getService(),
            "partner" => $this->getPartner(),
            "seller_id" => $this->getPartner(),
            "payment_type" => $this->getPaymentType(),
            "notify_url" => $this->getNotifyUrl(),
            "return_url" => $this->getReturnUrl(),
            "out_trade_no" => $this->getOutTradeNo(),
            "subject" => $this->getSubject(),
            "total_fee" => $this->getTotalFee(),
            "show_url" => $this->getShowUrl(),
            "body" => $this->getBody(),
            "it_b_pay" => $this->getItBPay(),
            "_input_charset" => $this->getInputCharset(),
        );

        $data = array_filter($data);
        $data['sign'] = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();

        return $data;
    }

    public function getData()
    {
        $this->validateData();

        $data = array(
            "method" => $this->getService(),
            "app_id" => $this->getAppid(),
            "notify_url" => $this->getNotifyUrl(),
            "return_url" => $this->getReturnUrl(),
            "sign_type" => $this->getSignType(),
            'version' => '1.0',
            'timestamp' => date("Y-m-d H:i:s"),
            "charset" => 'utf-8',
            'biz_content' => [
                'subject' => $this->getSubject(),
                'out_trade_no' => $this->getOutTradeNo(),
                'total_amount' => $this->getTotalFee(),
                'goods_type' => 1,
                'quit_url' => $this->getReturnUrl(),
            ],
        );
        $data['biz_content'] = json_encode($data['biz_content'], JSON_UNESCAPED_UNICODE);

        $data = array_filter($data);
        $data['sign'] = $this->getParamsSignature($data);
//        $data['sign_type'] = $this->getSignType();

        return $data;

    }


    protected function validateData()
    {
        parent::validateData();
        //       $this->validate('total_fee');
    }


    public function getPayMethod()
    {
        return $this->getParameter('pay_method');
    }


    public function getDefaultBank()
    {
        return $this->getParameter('default_bank');
    }


    public function setDefaultBank($value)
    {
        $this->setParameter('default_bank', $value);
    }


    public function setPayMethod($value)
    {
        $this->setParameter('pay_method', $value);
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new WapExpressPurchaseResponse($this, $data);
    }
}
