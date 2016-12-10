<?php

namespace Woodfish\Component\Payment\WeChat\Message;


use Symfony\Component\HttpFoundation\ParameterBag;

class WechatPrePurchaseRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

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
            'body',
            'out_trade_no',
            'total_fee',
            'spbill_create_ip',
            'notify_url',
            'trade_type'
        );
        $params['appid'] = $this->parameters->get('appid');
        $params['mch_id'] = $this->parameters->get('mch_id');
        $params['nonce_str'] = $this->createNoncestr();
        $params['body'] = $this->parameters->get('body');
        $params['out_trade_no'] = $this->parameters->get('out_trade_no');
        $params['total_fee'] = $this->parameters->get('total_fee');
        $params['spbill_create_ip'] = $this->parameters->get('spbill_create_ip');
        $params['notify_url'] = $this->parameters->get('notify_url');
        $params['trade_type'] = $this->parameters->get('trade_type');
        if ($this->getParameter('product_id')) {
            $params['product_id'] = $this->getParameter('product_id');
        }
        if ($this->getParameter('openid')) {
            $params['openid'] = $this->getParameter('openid');
        }
        if ($this->getParameter('time_start')) {
            $params['time_start'] = $this->getParameter('time_start');
        }

        if ($this->getParameter('time_expire')) {
            $params['time_expire'] = $this->getParameter('time_expire');
        }

        return $params;
    }

    public function sendData($data)
    {
        $params = array(
            'appid' => $data['appid'],
            'mch_id' => $data['mch_id'],
            'device_info' => 'WEB',
            'nonce_str' => $data['nonce_str'],
            'body' => $data['body'],
            'out_trade_no' => $data['out_trade_no'],
            'total_fee' => $data['total_fee'],
            'spbill_create_ip' => $data['spbill_create_ip'],
            'notify_url' => $data['notify_url'],
            'trade_type' => $data['trade_type'],

        );
        if (isset($data['product_id'])) {
            $params['product_id'] = $data['product_id'];
        }
        if (isset($data['openid'])) {
            $params['openid'] = $data['openid'];
        }
        $params['sign'] = $this->genSign($params);
        $data = $this->arrayToXml($params);
        $data = $this->xmlToArray($this->postSSLStr($this->endpoint, $data));
        return new WechatTradeResponse($this, $data);
    }
}