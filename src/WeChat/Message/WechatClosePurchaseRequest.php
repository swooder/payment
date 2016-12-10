<?php


namespace Woodfish\Component\Payment\WeChat\Message;


use Symfony\Component\HttpFoundation\ParameterBag;

class WechatClosePurchaseRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/closeorder';

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
            'out_trade_no'
        );
        $params['appid'] = $this->parameters->get('appid');
        $params['mch_id'] = $this->parameters->get('mch_id');
        $params['out_trade_no'] = $this->parameters->get('out_trade_no');
        $params['nonce_str'] = $this->createNoncestr();

        return $params;
    }

    public function sendData($data)
    {
        $data = array(
            'appid' => $data['appid'],
            'mch_id' => $data['mch_id'],
            'out_trade_no' => $data['out_trade_no'],
            'nonce_str' => $data['nonce_str'],
        );
        $data['sign'] = $this->genSign($data);
        $data = $this->arrayToXml($data);
        $data = $this->xmlToArray($this->postSSLStr($this->endpoint, $data));
        return $this->response = new WechatTradeResponse($this, $data);
    }
}