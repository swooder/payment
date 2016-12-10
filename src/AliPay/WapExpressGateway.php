<?php

namespace Woodfish\Component\Payment\AliPay;


class WapExpressGateway extends BaseAbstractGateway
{



    public function getDefaultParameters()
    {
        $params = parent::getDefaultParameters();

        $params['signType'] = 'RSA';

        return $params;
    }


    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Wap Express';
    }


    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }


    public function setPrivateKey($value)
    {
        $this->setParameter('private_key', $value);
    }


    public function purchase(array $parameters = array())
    {
        $this->setService('alipay.wap.create.direct.pay.by.user');

        return $this->createRequest('\Woodfish\Component\Payment\AliPay\Message\WapExpressPurchaseRequest', $parameters);
    }


}
