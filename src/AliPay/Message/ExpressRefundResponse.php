<?php

namespace Woodfish\Component\Payment\AliPay\Message;


class ExpressRefundResponse extends PurchaseResponse
{

    public function isSuccessful()
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }

}