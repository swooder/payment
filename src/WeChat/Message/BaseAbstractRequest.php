<?php


namespace Woodfish\Component\Payment\WeChat\Message;


use Woodfish\Component\Payment\Omnipay\Common\Message\AbstractRequest;

abstract class BaseAbstractRequest extends AbstractRequest
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

    public function getBody()
    {
        return $this->getParameter('body');
    }

    public function setBody()
    {
        return $this->getParameter('body');
    }

    protected function postStr($url, $data)
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_URL => $url,
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }



    protected function postSSLStr($url, $data, $second  = 30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, false);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, $this->getParameter('cert'));
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, $this->getParameter('ssl_key'));
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);

            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);

            return false;
        }
    }


    protected function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<".$key.">".$val."</".$key.">";
            } else {
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml .= "</xml>";

        return $xml;
    }

    protected function xmlToArray($xml)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        return $array_data;
    }

    protected static function httpBuildQuery($params)
    {
        ksort($params);
        $str = http_build_query($params);

        return $str;
    }

    public function genSign($params)
    {
        foreach ($params as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$this->getAppKey();
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);

        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    public function isSignMatch(array $data)
    {
        $requestSign = $data['sign'];
        unset($data['sign']);
        $sign = $this->genSign($data);
        return $requestSign == $sign;
    }


    function formatBizQueryParaMap($paraMap, $urlEncode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlEncode) {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k."=".$v."&";
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }

        return $reqPar;
    }


    /**
     *    作用：产生随机字符串，不长于32位
     */
    public function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }


}