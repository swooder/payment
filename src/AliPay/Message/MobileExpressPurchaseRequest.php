<?php

namespace Woodfish\Component\Payment\AliPay\Message;

use Woodfish\Component\Payment\Omnipay\Common\Message\ResponseInterface;

class MobileExpressPurchaseRequest extends BasePurchaseRequest
{


    /**
     * @return mixed
     * @throws \Exception
     */
    public function getData()
    {
        $this->validateData();

        $data = $this->getParamsToSign();

        $orderInfoStr = $this->getOrderString($data);


        if ($this->getSignType() == 'RSA') {
            $signature = $this->signWithRSA($orderInfoStr, $this->getPrivateKey(), 'RSA');
        } elseif ($this->getSignType() == 'RSA2') {
            $signature = $this->signWithRSA($orderInfoStr, $this->getPrivateKey(), 'RSA2');
        } elseif ($this->getSignType() == 'MD5') {
            $signature = $this->signWithMD5($orderInfoStr);
        } else {
            throw new \Exception(
                sprintf(
                    'Alipay_MobileExpress gateway support RSA and MD5 only, not support %s.',
                    $this->getSignType()
                )
            );
        }

//        $signature = $this->signWithRSA($orderInfoStr, $this->getPrivateKey(), $this->getSignType());

        $resp['order_info_str'] = sprintf('%s&sign="%s"&sign_type="RSA"', $orderInfoStr, urlencode($signature));

        return $resp;
    }


    protected function validateData()
    {
        $this->validate(
            'appid',
            'input_charset',
            'sign_type',
            'version',
            'notify_url',
            'subject',
            'out_trade_no',
            'total_amount',
            'product_code',
            'private_key'
        );
    }


    private function getParamsToSign()
    {
        $params = array(
            'app_id'                       => $this->getAppid(),
            'method'                       => $this->getService(),
            'charset'                      => $this->getInputCharset(),
            'sign_type'                    => $this->getSignType(),
            'version'                      => $this->getVersion(),
            'notify_url'                   => $this->getNotifyUrl(),
            'fotmat'                       => $this->getFormat(),
            'timestamp'                    => date("Y-m-d H:i:s"),
            'biz_content'                  => [
                'subject' => $this->getSubject(),
                'out_trade_no' => $this->getOutTradeNo(),
                'total_amount' => $this->getTotalAmount(),
                'product_code' => $this->getProductCode(),
                'goods_type' => $this->getGoodsType(),
            ],
        );

        if ($ip = $this->getParameter('clientIp')) {
            $exp = explode('.', $ip);
            if ($exp &&  count($exp) == 4 && !in_array($exp[0], ['192', '172', '10'])) {
                $params['biz_content']['business_params'] = [
                    'mcCreateTradeIp' => $ip,
                    'outTradeRiskInfo' => json_encode([
                        'mcCreateTradeTime' => (new \DateTime())->format('Y-m-d H:i:s'),
                    ])
                ];
            }
        }


        if ($this->getGoodsType() == 0) {  //虚拟商品,禁用信用卡付款
            $params['biz_content']['disable_pay_channels'] = 'credit_group';
        }

        $params['biz_content'] = json_encode($params['biz_content'], JSON_UNESCAPED_UNICODE);

        ksort($params);

        return $params;
    }



    private function getOrderString($data)
    {
        $str = http_build_query($data);
        $str = str_replace('&', '"&', $str);
        $str = str_replace('=', '="', $str) . '"';
        $str = urldecode($str);

        return $str;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new MobileExpressPurchaseResponse($this, $data);
    }
}
