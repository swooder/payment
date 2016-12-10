<?php
/**
 * Created by PhpStorm.
 * User: shaojie
 * Date: 16/4/20
 * Time: 15:38
 */

namespace Woodfish\Component\Payment\AliPay\Message;


class ExpressCompleteRefundRequest extends ExpressCompletePurchaseRequest
{

    public function getData()
    {
        $this->validate('request_params', 'transport', 'partner', 'ca_cert_path', 'sign_type', 'key');
        $this->validateRequestParams('result_details', 'batch_no', 'success_num');
        return $this->getParameters();
    }
    public function sendData($data)
    {
        $notify_id = $this->getNotifyId();
        $sign = $this->getRequestParam('sign');
        $validateSign = !empty($sign);
        $this->verifyResponse = 'true';
        if (!is_null($notify_id))
        {
            $this->verifyResponse = $this->getVerifyResponse($this->getNotifyId());
            $validateSign = true;
        }
        $data = array();
        $data['verify_response'] = $this->verifyResponse;
        if ($this->isResponseOk($this->verifyResponse) && (!$validateSign || $this->isSignMatch()))
        {
            $data['verify_success'] = true;
        }
        else
        {
            $data['verify_success'] = false;
        }
        return $this->response = new ExpressCompleteRefundResponse($this, $data);
    }


}