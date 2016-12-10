<?php

namespace Woodfish\Component\Payment\UnionPay\Message;


use Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface;

class MobileExpressPurchaseRequest extends BaseAbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array (
            //版本号
            'version'        => $this->getVersion(),
            //编码方式
            'encoding'       => $this->getEncoding(),
            //证书ID
            'certId'         => $this->getCertId(),
            //交易类型
            'txnType'        => $this->getTxnSubType() ?: '01',
            //交易子类
            'txnSubType'     => $this->getTxnSubType() ?: '01',
            //业务类型
            'bizType'        => $this->getBizType(),
            //后台通知地址
            'backUrl'        => $this->getNotifyUrl(),
            //签名方法
            'signMethod'     => $this->getSignMethod(),
            //渠道类型，07-PC，08-手机
            'channelType'    => '08',
            //接入类型
            'accessType'     => $this->getAccessType(),
            //商户代码，请改自己的测试商户号
            'merId'          => $this->getMerId(),
            //商户订单号
            'orderId'        => $this->getOrderId(),
            //订单发送时间
            'txnTime'        => $this->getTxnTime(),
            //交易金额，单位分
            'txnAmt'         => $this->getTxnAmt(),
            //交易币种
            'currencyCode'   => $this->getCurrencyCode(),
            //默认支付方式
            'defaultPayType' => $this->getDefaultPayType(),
            //订单描述，网关支付和wap支付暂时不起作用
            'orderDesc'      => $this->getOrderDesc(),
            //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
            'reqReserved'    => $this->getReqReserved(),
        );

        $data = $this->filterData($data);
        $data['signature'] = $this->getParamsSignatureWithRSA($data);
        return $data;
    }



    private function validateData()
    {
        $this->validate(
            'certPath',
            'certPassword',
            'notifyUrl',
            'merId',
            'orderId',
            'txnTime',
            'txnAmt'
        );
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $data = $this->httpRequest('app', $data);
        return $this->response = new MobileExpressPurchaseResponse($this, $data);
    }
}