<?php

namespace Omnipay\Paycell;

use Omnipay\Common\AbstractGateway;
use Omnipay\Paycell\Message\PurchaseRequest;
use Omnipay\Paycell\Message\Purchase3dRequest;

/**
 * Paycell Gateway
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class Gateway extends AbstractGateway
{
    
    use CommonParameters;


    public function getName()
    {
        return 'Paycell';
    }

    /**
     * Initiate a purchase request.
     *
     * @param array $parameters Additional parameters for the purchase
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Initiate a purchase 3d request.
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase3d(array $parameters = [])
    {
        return $this->createRequest(Purchase3dRequest::class, $parameters);
    }
}