<?php

namespace Omnipay\Paycell\Message;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
abstract class AbstractRequest extends AbstractRequest {

    protected $actionType = 'preauth';

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->getParameter('prefix');
    }

    /**
     * Set the prefix.
     *
     * @param mixed $value The prefix value
     * @return $this
     */
    public function setPrefix($value)
    {
        return $this->setParameter('prefix', $value);
    }

    /**
     * Get the application name.
     *
     * @return mixed
     */
    public function getApplicationName()
    {
        return $this->getParameter('applicationName');
    }

    /**
     * Set the application name.
     *
     * @param mixed $value The application name value
     * @return $this
     */
    public function setApplicationName($value)
    {
        return $this->setParameter('applicationName', $value);
    }

    /**
     * Get the application password.
     *
     * @return mixed
     */
    public function getApplicationPwd()
    {
        return $this->getParameter('applicationPwd');
    }

    /**
     * Set the application password.
     *
     * @param mixed $value The application password value
     * @return $this
     */
    public function setApplicationPwd($value)
    {
        return $this->setParameter('applicationPwd', $value);
    }

    /**
     * Get the secure code.
     *
     * @return mixed
     */
    public function getSecureCode()
    {
        return $this->getParameter('secureCode');
    }
     
    /**
     * Get the End User License Agreement (EULA) ID.
     *
     * @return mixed
     */
    public function getEulaID()
    {
        return $this->getParameter('eulaID');
    }

    /**
     * Set the End User License Agreement (EULA) ID.
     *
     * @param mixed $value The EULA ID value
     * @return $this
     */
    public function setEulaID($value)
    {
        return $this->setParameter('eulaID', $value);
    }

    /**
     * Get the merchant code.
     *
     * @return mixed
     */
    public function getMerchantCode()
    {
        return $this->getParameter('merchantCode');
    }

    /**
     * Set the merchant code.
     *
     * @param mixed $value The merchant code value
     * @return $this
     */
    public function setMerchantCode($value)
    {
        return $this->setParameter('merchantCode', $value);
    }

}