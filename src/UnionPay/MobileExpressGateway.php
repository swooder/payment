<?php


namespace Woodfish\Component\Payment\UnionPay;

/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class MobileExpressGateway extends BaseAbstractGateWay
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'UnionPay Mobile Express';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\MobileExpressPurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\ExpressRefundRequest', $parameters);
    }
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\ExpressVoidRequest', $parameters);
    }

    public function query(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\ExpressQueryRequest', $parameters);
    }

    public function completePurchase(array $parameters = array()) {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\ExpressCompletePurchaseRequest', $parameters);
    }

    public function completeRefund(array $parameters = array()) {
        return $this->createRequest('\Woodfish\Component\Payment\UnionPay\Message\ExpressCompleteRefundRequest', $parameters);
    }

    public function purchaseWap(array $parameters = array())
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