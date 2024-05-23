<?php

namespace Omnipay\Paycell\Message;


/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
abstract class AbstractRequest extends AbstractPayment {
     
    protected $actionType = 'SALE';
 
    
}