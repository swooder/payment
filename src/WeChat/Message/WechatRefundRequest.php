<?php

namespace Woodfish\Component\Payment\WeChat\Message;


use Symfony\Component\HttpFoundation\ParameterBag;

class WechatRefundRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/secapi/pay/refund';

    public function initialize(array $parameters = array())
    {
        if (null !== $this->response) {
            throw new \RuntimeException('Request cannot be modified after it has been sent!');
        }
        $this->parameters = new ParameterBag();
        foreach ($parameters as $k => $v) {
            $this->parameters->set($k, $v);
        }

        return $this;
    }

    public function getData()
    {
        $this->validate(
            'appid',
            'mch_id',
            'transaction_id',
            'out_refund_no',
            'refund_fee',
            'total_fee'
        );
        $params['appid'] = $this->parameters->get('appid');
        $params['mch_id'] = $this->parameters->get('mch_id');
        $params['op_user_id'] = $this->parameters->get('mch_id');
        $params['transaction_id'] = $this->parameters->get('transaction_id');
        $params['out_refund_no'] = $this->parameters->get('out_refund_no');
        $params['refund_fee'] = $this->parameters->get('refund_fee');
        $params['total_fee'] = $this->parameters->get('total_fee');
        $params['nonce_str'] = $this->createNoncestr();

        return $params;
    }

    public function sendData($data)
    {
        $data = array(
            'appid' => $data['appid'],
            'mch_id' => $data['mch_id'],
            'op_user_id' => $data['op_user_id'],
            'transaction_id' => $data['transaction_id'],
            'out_refund_no' => $data['out_refund_no'],
            'refund_fee' => $data['refund_fee'],
            'total_fee' => $data['total_fee'],
            'nonce_str' => $data['nonce_str'],
        );
        $data['sign'] = $this->genSign($data);
        $data = $this->arrayToXml($data);
        $data = $this->xmlToArray($this->postSSLStr($this->endpoint, $data));
        return new WechatTradeResponse($this, $data);
    }
}