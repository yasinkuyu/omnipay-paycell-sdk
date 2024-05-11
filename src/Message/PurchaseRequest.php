<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class PurchaseRequest extends AbstractTransaction
{
    protected $actionType = 'preauth';

}
