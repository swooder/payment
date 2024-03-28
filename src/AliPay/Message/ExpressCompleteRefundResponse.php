<?php
/**
 * Created by PhpStorm.
 * User: shaojie
 * Date: 16/4/20
 * Time: 15:41
 */

namespace Woodfish\Component\Payment\AliPay\Message;


class ExpressCompleteRefundResponse extends ExpressCompletePurchaseResponse
{
    public function getResponseText()
    {
        if ($this->isSuccessful()) {
            return 'success';
        } else {
            return 'fail';
        }
    }
}