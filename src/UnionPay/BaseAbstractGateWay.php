<?php

namespace Woodfish\Component\Payment\UnionPay;
/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */



use Omnipay\Common\AbstractGateway;

abstract class BaseAbstractGateWay extends AbstractGateway
{


    public function setVersion($value)
    {
        return $this->setParameter('version', $value);
    }
    public function getVersion()
    {
        return $this->getParameter('version');
    }
    public function setEncoding($value)
    {
        return $this->setParameter('encoding', $value);
    }
    public function getEncoding()
    {
        return $this->getParameter('encoding');
    }
    public function setTxnType($value)
    {
        return $this->setParameter('txnType', $value);
    }
    public function getTxnType()
    {
        return $this->getParameter('txnType');
    }
    public function setTxnSubType($value)
    {
        return $this->setParameter('txnSubType', $value);
    }
    public function getTxnSubType()
    {
        return $this->getParameter('txnSubType');
    }
    public function setBizType($value)
    {
        return $this->setParameter('bizType', $value);
    }
    public function getBizType()
    {
        return $this->getParameter('bizType');
    }
    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }
    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notifyUrl', $value);
    }
    public function getNotifyUrl()
    {
        return $this->getParameter('notifyUrl');
    }

    public function setRefundNotifyUrl($value)
    {
        return $this->setParameter('refundNotifyUrl', $value);
    }
    public function getRefundNotifyUrl()
    {
        return $this->getParameter('refundNotifyUrl');
    }

    public function setSignMethod($value)
    {
        return $this->setParameter('signMethod', $value);
    }
    public function getSignMethod()
    {
        return $this->getParameter('signMethod');
    }
    public function setChannelType($value)
    {
        return $this->setParameter('channelType', $value);
    }
    public function getChannelType()
    {
        return $this->getParameter('channelType');
    }
    public function setAccessType($value)
    {
        return $this->setParameter('accessType', $value);
    }
    public function getAccessType()
    {
        return $this->getParameter('accessType');
    }
    public function setMerId($value)
    {
        return $this->setParameter('merId', $value);
    }
    public function getMerId()
    {
        return $this->getParameter('merId');
    }
    public function setCurrencyCode($value)
    {
        return $this->setParameter('currencyCode', $value);
    }
    public function getCurrencyCode()
    {
        return $this->getParameter('currencyCode');
    }
    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }
    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }
    public function setCertDir($value)
    {
        return $this->setParameter('certDir', $value);
    }
    public function getCertDir()
    {
        return $this->getParameter('certDir');
    }
    public function setCertPath($value)
    {
        return $this->setParameter('certPath', $value);
    }
    public function getCertPath()
    {
        return $this->getParameter('certPath');
    }
    public function setCertPassword($value)
    {
        return $this->setParameter('certPassword', $value);
    }
    public function getCertPassword()
    {
        return $this->getParameter('certPassword');
    }
    public function setOrderDesc($value)
    {
        return $this->setParameter('orderDesc', $value);
    }
    public function getOrderDesc()
    {
        return $this->getParameter('orderDesc');
    }
    public function setReqReserved($value)
    {
        return $this->setParameter('reqReserved', $value);
    }
    public function getReqReserved()
    {
        return $this->getParameter('reqReserved');
    }
    public function setDefaultPayType($value)
    {
        return $this->setParameter('defaultPayType', $value);
    }
    public function getDefaultPayType()
    {
        return $this->getParameter('defaultPayType');
    }


    function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}