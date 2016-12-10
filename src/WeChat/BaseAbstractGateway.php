<?php


namespace Woodfish\Component\Payment\WeChat;

use Woodfish\Component\Payment\Omnipay\Common\AbstractGateway;

/**
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface authorize(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface completeAuthorize(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface capture(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface refund(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface void(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface createCard(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface updateCard(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface deleteCard(array $options = array())
 */
abstract class BaseAbstractGateway extends AbstractGateway
{


    public function setAppId($appId)
    {
        $this->setParameter('appid', $appId);
    }

    public function getAppId()
    {
        return $this->getParameter('appid');
    }

    public function setAppKey($appKey)
    {
        $this->setParameter('app_key', $appKey);
    }

    public function getAppKey()
    {
        return $this->getParameter('app_key');
    }

    public function setMchId($mchId)
    {
        $this->setParameter('mch_id', $mchId);
    }

    public function getMchId()
    {
        return $this->getParameter('mch_id');
    }

    public function setNotifyUrl($url)
    {
        $this->setParameter('notify_url', $url);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    public function purchase(array  $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatPrePurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatCompletePurchaseRequest', array_merge($parameters, $this->getBaseParams()));
    }

    public function closePurchase($parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatClosePurchaseRequest', array_merge($parameters, $this->getBaseParams()));
    }

    public function refundPurchase($parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatRefundRequest', array_merge($parameters, $this->getBaseParams()));
    }


    public function purchaseQuery($parameters = array())
    {

        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatPurchaseQueryRequest', array_merge($parameters, $this->getBaseParams()));
    }


    public function refundPurchaseQuery($parameters = array())
    {

        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatRefundQueryRequest', array_merge($parameters, $this->getBaseParams()));
    }

    public function checkSign($params)
    {

        $sign = $params['sign'];
        unset($params['sign']);
        $signVal = $this->doSign($params);
        return $sign == $signVal;
    }

    public function doSign($params)
    {
        /** @var  $request  \Woodfish\Component\Payment\WeChat\Message\WechatPurchaseRequest */
        $request = $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatPurchaseRequest', $params);
        return $request->genSign($params);
    }


    private function getBaseParams()
    {
        $parameters['appid']= $this->getAppId();
        $parameters['mch_id']= $this->getMchId();
        $parameters['cert']= $this->getParameter('cert');
        $parameters['ssl_key']= $this->getParameter('ssl_key');
        return $parameters;
    }


    function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface refund(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\ResponseInterface deleteCard(array $options = array())
    }
}