<?php


namespace Woodfish\Component\Payment\WeChat;



class ExpressGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'Wechat_Express';
    }



    public function purchase(array $parameters = array())
    {
        $params = array(
            'device_info' => 'WEB',
            'body' => $parameters['body'],
            'out_trade_no' => $parameters['out_trade_no'],
            'total_fee' => $parameters['total_fee'],
            'fee_type' => $parameters['fee_type'],
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            'notify_url' => $this->getNotifyUrl(),
        );

        $params['trade_type'] = $parameters['trade_type'];
        if ($params['trade_type'] === 'JSAPI') {
            $params['openid'] = $parameters['openid'];
        }

        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatPrePurchaseRequest', $params);

    }

    /**
     * @param array $parameters  ['body' => 'xml']
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatCompletePurchaseRequest', $parameters);
    }



    public function closePurchase($parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatClosePurchaseRequest', $parameters);
    }


    public function refund(array  $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatRefundRequest', $parameters);
    }

    public function refundQuery(array  $parameters = array())
    {
        return $this->createRequest('\Woodfish\Component\Payment\WeChat\Message\WechatRefundQueryRequest', $parameters);
    }



}