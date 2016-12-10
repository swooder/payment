<?php

namespace Woodfish\Component\Payment\AliPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * @method \Omnipay\Common\Message\ResponseInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface void(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface deleteCard(array $options = array())
 */
abstract class BaseAbstractGateway extends AbstractGateway
{

    public function getDefaultParameters()
    {
        return array(
            'partner'      => '',
            'key'          => '',
            'signType'     => 'MD5',
            'inputCharset' => 'utf-8',
            'transport'    => 'http',
            'paymentType'  => 1,
            'itBPay'       => '1d',
        );
    }


    public function getPartner()
    {
        return $this->getParameter('partner');
    }


    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }


    public function getKey()
    {
        return $this->getParameter('key');
    }


    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }


    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }


    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }


    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }


    public function setSignType($value)
    {
        return $this->setParameter('sign_type', $value);
    }


    public function getInputCharset()
    {
        return $this->getParameter('input_charset');
    }


    public function setInputCharset($value)
    {
        return $this->setParameter('input_charset', $value);
    }


    public function getTransport()
    {
        return $this->getParameter('transport');
    }


    public function setTransport($value)
    {
        return $this->setParameter('transport', $value);
    }


    public function getAntiPhishingKey()
    {
        return $this->getParameter('anti_phishing_key');
    }


    public function setAntiPhishingKey($value)
    {
        return $this->setParameter('anti_phishing_key', $value);
    }


    public function getExterInvokeIp()
    {
        return $this->getParameter('exter_invoke_ip');
    }


    public function setExterInvokeIp($value)
    {
        return $this->setParameter('exter_invoke_ip', $value);
    }


    public function getBody()
    {
        return $this->getParameter('body');
    }


    public function setBody($value)
    {
        return $this->setParameter('body', $value);
    }


    public function getShowUrl()
    {
        return $this->getParameter('show_url');
    }


    public function setShowUrl($value)
    {
        return $this->setParameter('show_url', $value);
    }


    public function getSellerEmail()
    {
        return $this->getParameter('seller_email');
    }


    public function setSellerEmail($value)
    {
        return $this->setParameter('seller_email', $value);
    }


    public function getService()
    {
        return $this->getParameter('service');
    }


    public function setService($value)
    {
        return $this->setParameter('service', $value);
    }


    public function getDefaultBank()
    {
        return $this->getParameter('default_bank');
    }


    public function setDefaultBank($value)
    {
        return $this->setParameter('default_bank', $value);
    }


    public function getPayMethod()
    {
        return $this->getParameter('pay_method');
    }


    public function setPayMethod($value)
    {
        return $this->setParameter('pay_method', $value);
    }


    public function getPaymentType()
    {
        return $this->getParameter('payment_type');
    }


    public function setPaymentType($value)
    {
        return $this->setParameter('payment_type', $value);
    }


    public function setExpireTime($minutes)
    {
        return $this->setParameter('it_b_pay', sprintf('%dm', $minutes));
    }


    public function getExpireTime()
    {
        return $this->getParameter('it_b_pay');
    }


    public function getAlipayPublicKey()
    {
        return $this->getParameter('alipay_public_key');
    }


    public function setAlipayPublicKey($value)
    {
        return $this->setParameter('alipay_public_key', $value);
    }


    public function getCaCertPath()
    {
        return $this->getParameter('ca_cert_path');
    }


    public function setItBPay($value)
    {
        return $this->setParameter('itBPay', $value);
    }


    public function getItBPay()
    {
        return $this->getParameter('itBPay');
    }


    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }


    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    public function setExtraCommonParam($value)
    {
        $this->setParameter('extra_common_param', $value);
    }

    public function getExtraCommonParam()
    {
        return $this->getParameter('extra_common_param');
    }

    public function setExtendParam($value)
    {
        $this->setParameter('extend_param', $value);
    }

    public function getExtendParam()
    {
        return $this->getParameter('extend_param');
    }

    public function setCaCertPath($value)
    {
        if (! is_file($value)) {
            throw new InvalidRequestException("The ca_cert_path($value) is not exists");
        }

        return $this->setParameter('ca_cert_path', $value);
    }




    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\AliPay\Message\ExpressCompletePurchaseRequest', $parameters);
    }


    /**
     * @param array $parameters[]
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function refundPurchase(array $parameters = array())
    {
        $this->setService('refund_fastpay_by_platform_pwd');
        return $this->createRequest('\Woodfish\Component\Payment\AliPay\Message\ExpressRefundRequest', $parameters);
    }


    public function closePurchase(array $parameters = array())
    {
        $this->setService('close_trade');
        return $this->createRequest('\Woodfish\Component\Payment\AliPay\Message\ExpressCloseRequest', $parameters);
    }


    public function completeRefund(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\AliPay\Message\ExpressCompleteRefundRequest', $parameters);
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
