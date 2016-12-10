<?php

namespace Woodfish\Component\Payment\UnionPay;

/**
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Woodfish\Component\Payment\Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class WapExpressGateway extends MobileExpressGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'UnionPay Wap Express';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\WapExpressPurchaseRequest', $parameters);
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