<?php


namespace Woodfish\Component\Payment\UnionPay\Message;


use Woodfish\Component\Payment\Omnipay\Common\Message\AbstractResponse;
use Woodfish\Component\Payment\Omnipay\Common\Message\RedirectResponseInterface;

class WapExpressPurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getRequest()->getEndpoint('front');

    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array
     */
    public function getRedirectData()
    {
        return $this->data;
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }

    public function getRedirectHtml()
    {
        $action = $this->getRequest()->getEndpoint('front');
        $fields = $this->getFormFields();
        $method = $this->getRedirectMethod();

        $html = <<<eot
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>跳转中...</title>
</head>
<body onload="javascript:document.pay_form.submit();">
    <form id="pay_form" name="pay_form" action="{$action}" method="{$method}">
        {$fields}
    </form>
</body>
</html>
eot;

        return $html;
    }


    public function getFormFields()
    {
        $html = '';
        foreach ($this->data as $key => $value) {
            $html .= "<input type='hidden' name='{$key}' value='{$value}'/>\n";
        }

        return $html;
    }
}