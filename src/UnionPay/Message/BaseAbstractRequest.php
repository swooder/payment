<?php

namespace Woodfish\Component\Payment\UnionPay\Message;
use Omnipay\Common\Message\AbstractRequest;


abstract class BaseAbstractRequest extends AbstractRequest
{

    protected $endPoint = "https://gateway.95516.com/gateway/api/";

    protected $methods = array(
        'front' => 'frontTransReq.do',
        'back'  => 'backTransReq.do',
        'app'   => 'appTransReq.do',
        'query' => 'queryTrans.do',
    );

    public function getEndpoint($type)
    {
        return $this->endPoint . $this->methods[$type];
    }

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
    public function getTxnSubType()
    {
        return $this->getParameter('txnSubType');
    }
    public function setTxnSubType($value)
    {
        return $this->setParameter('txnSubType', $value);
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
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }
    public function setTxnTime($value)
    {
        return $this->setParameter('txnTime', $value);
    }
    public function getTxnTime()
    {
        return $this->getParameter('txnTime');
    }
    public function setTxnAmt($value)
    {
        return $this->setParameter('txnAmt', $value);
    }
    public function getTxnAmt()
    {
        return $this->getParameter('txnAmt');
    }
    public function setRequestType($value)
    {
        return $this->setParameter('requestType', $value);
    }
    public function getRequestType()
    {
        return $this->getParameter('requestType');
    }
    public function setDefaultPayType($value)
    {
        return $this->setParameter('defaultPayType', $value);
    }
    public function getDefaultPayType()
    {
        return $this->getParameter('defaultPayType');
    }
    public function setCertDir($value)
    {
        return $this->setParameter('certDir', $value);
    }
    public function getCertDir()
    {
        return $this->getParameter('certDir');
    }
    protected function httpRequest($method, $data)
    {
        $result = self::sendHttpRequest($this->getEndpoint($method), $data);
        parse_str($result, $data);
        if (! is_array($data)) {
            $data = array();
        }
        return $data;
    }


    public  function getCertId()
    {
        $certPath = $this->getCertPath();
        $password = $this->getCertPassword();
        $data = file_get_contents($certPath);
        openssl_pkcs12_read($data, $certs, $password);
        $x509data = $certs ['cert'];
        openssl_x509_read($x509data);
        $certData = openssl_x509_parse($x509data);
        return $certData['serialNumber'];
    }

    public static function verify($params, $certDir)
    {
        $publicKey        = self::getPublicKeyByCertId($params['certId'], $certDir);
        $requestSignature = $params ['signature'];
        unset($params['signature']);
        ksort($params);
        $query = http_build_query($params);
        $query = urldecode($query);
        $signature     = base64_decode($requestSignature);
        $paramsSha1x16 = sha1($query, false);
        $isSuccess     = openssl_verify($paramsSha1x16, $signature, $publicKey, OPENSSL_ALGO_SHA1);
        return (bool)$isSuccess;
    }

    protected static function getPrivateKey($certPath, $password)
    {
        $data = file_get_contents($certPath);
        openssl_pkcs12_read($data, $certs, $password);
        return $certs['pkey'];
    }


    public static function getPublicKeyByCertId($certId, $certDir)
    {
        $handle = opendir($certDir);
        if ($handle) {
            while ($file = readdir($handle)) {
                //clearstatcache();
                $filePath = rtrim($certDir, '/\\') . '/' . $file;
                if (is_file($filePath) && self::endsWith($filePath, '.cer')) {
                    if (self::getCertIdByCerPath($filePath) == $certId) {
                        closedir($handle);
                        return file_get_contents($filePath);
                    }
                }
            }
            throw new \Exception(sprintf('Can not find certId in certDir %s', $certDir));
        } else {
            throw new \Exception('certDir is not exists');
        }
    }

    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }
        return false;
    }


    protected static function getCertIdByCerPath($certPath)
    {
        $x509data = file_get_contents($certPath);
        openssl_x509_read($x509data);
        $certData = openssl_x509_parse($x509data);
        return $certData ['serialNumber'];
    }

    public static function sendHttpRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-type:application/x-www-form-urlencoded;charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public  function filterData($data)
    {
        $data = array_filter(
            $data,
            function ($v) {
                return $v !== '';
            }
        );
        return $data;
    }
    /**
     * @param $params
     *
     * @return string
     */
    public function getStringToSign($params)
    {
        ksort($params);
        $query = http_build_query($params);
        $query = urldecode($query);
        return $query;
    }

    public  function getParamsSignatureWithRSA($params)
    {

        $certPath = $this->getCertPath();
        $password = $this->getCertPassword();

        $query = self::getStringToSign($params);

        $params_sha1x16 = sha1($query, false);
        $privateKey     = self::getPrivateKey($certPath, $password);
        openssl_sign($params_sha1x16, $signature, $privateKey, OPENSSL_ALGO_SHA1);

        return base64_encode($signature);
    }


}