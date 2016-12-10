<?php

namespace Woodfish\Component\Payment\WeChat\Message;


use Symfony\Component\HttpFoundation\ParameterBag;

class WechatCompletePurchaseRequest extends BaseAbstractRequest{

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
            'body'
        );
        return $this->getParameters();
    }

    public function sendData($data)
    {
        $xml = $data['body'];

        $data = $this->xmlToArray($xml);
        $data['verify_success'] = $this->isSignMatch($data);
        return $this->response = new  WechatTradeResponse($this, $data);
    }
}