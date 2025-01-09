<?php

namespace Omnipay\Paycell\Message;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */
abstract class AbstractRequest extends PaycellService {
    
    // Ödeme işlem tipini belirtir, ön otorizasyon uygulaması söz konusu değilse 
    // SALE değeri gönderilir[SALE, PREAUTH, POSTAUTH].
    protected $actionType = 'SALE';
  
}