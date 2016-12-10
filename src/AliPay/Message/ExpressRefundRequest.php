<?php

namespace Woodfish\Component\Payment\AliPay\Message;


class ExpressRefundRequest extends BasePurchaseRequest
{

    protected $service = "refund_fastpay_by_platform_pwd";

    protected function validateData()
    {
        return $this->validate(
            'service',
            'partner',
            'seller_email',
            'refund_data',
            'refund_notify_url'
        );
    }



    function getRefundData()
    {
        return $this->parameters->get('refund_data');
    }

    function setRefundData($data)
    {
        $this->parameters->set('refund_data', $data);
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();
        $detail = $this->getRefundData();
        foreach ($detail as &$v)
        {
            $v = $v['trade_no'] . '^' . $v['total_fee'] . '^' . $v['memo'];
        }
        $data = array(
            "service" => $this->service,
            "partner" => $this->getPartner(),
            "seller_user_id" => $this->getPartner(),
            "refund_date" => date('Y-m-d H:i:s'),
            "batch_no" => date('YmdHi') . rand(10000, 99999),
            'batch_num' => count($detail),
            'detail_data' => implode('#', $detail),
            "notify_url" => $this->getRefundNotifyUrl(),
            "seller_email" => $this->getSellerEmail(),
            "_input_charset" => $this->getInputCharset(),
        );
        $data = array_filter($data);
        $data['sign'] = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();
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
        return $this->response = new ExpressRefundResponse($this, $data);
    }

}