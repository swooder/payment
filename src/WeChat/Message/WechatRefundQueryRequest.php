<?php


namespace Woodfish\Component\Payment\WeChat\Message;


use Symfony\Component\HttpFoundation\ParameterBag;

class WechatRefundQueryRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/refundquery';

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
            'out_refund_no'
        );
        $params['appid'] = $this->parameters->get('appid');
        $params['mch_id'] = $this->parameters->get('mch_id');
        $params['out_refund_no'] = $this->parameters->get('out_refund_no');
        $params['nonce_str'] = $this->createNoncestr();

        return $params;
    }

    public function sendData($data)
    {
        $data = array(
            'appid' => $data['appid'],
            'mch_id' => $data['mch_id'],
            'out_refund_no' => $data['out_refund_no'],
            'nonce_str' => $data['nonce_str'],
        );
        $data['sign'] = $this->genSign($data);
        $data = $this->arrayToXml($data);
        $data = $this->xmlToArray($this->postStr($this->endpoint, $data));

        return new WechatTradeResponse($this, $data);
    }
}