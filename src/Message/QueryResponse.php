<?php

namespace Omnipay\PaycellSDK\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Paycell SDK Query Response
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */
class QueryResponse extends AbstractResponse
{
    /**
     * Check if the query was successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data->responseHeader) && $this->data->responseHeader->responseDescription === "Success";
    }

    /**
     * Get the transaction ID.
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->data->responseHeader->transactionId ?? null;
    }

    /**
     * Get the response code.
     *
     * @return int|null
     */
    public function getResponseCode()
    {
        return $this->data->responseHeader->responseCode ?? null;
    }

    /**
     * Get the response description.
     *
     * @return string|null
     */
    public function getResponseDescription()
    {
        return $this->data->responseHeader->responseDescription ?? null;
    }

    /**
     * Get the amount.
     *
     * @return float|null
     */
    public function getAmount()
    {
        return $this->data->amount ?? null;
    }

    /**
     * Get the currency.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->data->currency ?? null;
    }

    /**
     * Get the approval code.
     *
     * @return string|null
     */
    public function getApprovalCode()
    {
        return $this->data->approvalCode ?? null;
    }

    /**
     * Get the payment reference number.
     *
     * @return string|null
     */
    public function getPaymentReferenceNumber()
    {
        return $this->data->paymentReferenceNumber ?? null;
    }

    /**
     * Get the payment date.
     *
     * @return string|null
     */
    public function getPaymentDate()
    {
        return $this->data->paymentDate ?? null;
    }

    /**
     * Get the reconciliation date.
     *
     * @return string|null
     */
    public function getReconciliationDate()
    {
        return $this->data->reconciliationDate ?? null;
    }

    public function getRetryStatusDescription()
    {
        return $this->data->retryStatusDescription ?? null;
    }

    public function getRetryStatusCode()
    {
        return $this->data->retryStatusCode ?? null;
    }

    /**
     * Get the status.
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->data->status ?? null;
    }

    /**
     * Get the status explanation.
     *
     * @return string|null
     */
    public function getStatusExplanation()
    {
        return $this->data->statusExplanation ?? null;
    }

    /**
     * Get the payment method details.
     *
     * @return array|null
     */
    public function getPaymentMethod()
    {
        return isset($this->data->paymentMethod) ? [
            'paymentMethodId' => $this->data->paymentMethod->paymentMethodId ?? null,
            'paymentMethodNumber' => $this->data->paymentMethod->paymentMethodNumber ?? null,
            'paymentMethodType' => $this->data->paymentMethod->paymentMethodType ?? null,
        ] : null;
    }

    /**
     * Get the merchant ID.
     *
     * @return string|null
     */
    public function getMerchantId()
    {
        return $this->data->merchantId ?? null;
    }

    /**
     * Get the terminal ID.
     *
     * @return string|null
     */
    public function getTerminalId()
    {
        return $this->data->terminalId ?? null;
    }

    /**
     * Get the refunded amount.
     *
     * @return float|null
     */
    public function getRefundedAmount()
    {
        return $this->data->refundedAmount ?? null;
    }

    /**
     * Get the acquirer bank code.
     *
     * @return string|null
     */
    public function getAcquirerBankCode()
    {
        return $this->data->acquirerbankCode ?? null;
    }

    /**
     * Get the MSISDN (phone number).
     *
     * @return string|null
     */
    public function getMsisdn()
    {
        return $this->data->msisdn ?? null;
    }

    /**
     * Get the installment count.
     *
     * @return int|null
     */
    public function getInstallmentCount()
    {
        return $this->data->installmentCount ?? null;
    }

    /**
     * Get the order ID.
     *
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->data->orderId ?? null;
    }

    /**
     * Get the payment security type.
     *
     * @return string|null
     */
    public function getPaymentSecurity()
    {
        return $this->data->paymentSecurity ?? null;
    }

    /**
     * Get the issuer bank code.
     *
     * @return string|null
     */
    public function getIssuerBankCode()
    {
        return $this->data->issuerBankCode ?? null;
    }

    /**
     * Get the amount without HP.
     *
     * @return float|null
     */
    public function getAmountWithoutHP()
    {
        return $this->data->amountWithoutHP ?? null;
    }

    /**
     * Get the used HP amount.
     *
     * @return float|null
     */
    public function getUsedHPAmount()
    {
        return $this->data->usedHPAmount ?? null;
    }

    /**
     * Get the earned HP amount.
     *
     * @return float|null
     */
    public function getEarnedHPAmount()
    {
        return $this->data->earnedHPAmount ?? null;
    }

    /**
     * Get the without HP amount.
     *
     * @return float|null
     */
    public function getWithoutHPAmount()
    {
        return $this->data->withoutHPAmount ?? null;
    }

    /**
     * Get the reconciliation result.
     *
     * @return float|null
     */
    public function getReconciliationResult()
    {
        return $this->data->reconciliationResult ?? null;
    }
 
    public function getTotalSaleAmount()
    {
        return $this->data->totalSaleAmount ?? null;
    }

    public function getTotalReverseAmount()
    {
        return $this->data->totalReverseAmount ?? null;
    }

    public function getTotalRefundAmount()
    {
        return $this->data->totalRefundAmount ?? null;
    }

    public function getTotalPreAuthAmount()
    {
        return $this->data->totalPreAuthAmount ?? null;
    }

    public function getTotalPostAuthAmount()
    {
        return $this->data->totalPostAuthAmount ?? null;
    }

    public function getTotalPreAuthReverseAmount()
    {
        return $this->data->totalPreAuthReverseAmount ?? null;
    }

    public function getTotalPostAuthReverseAmount()
    {
        return $this->data->totalPostAuthReverseAmount ?? null;
    }

    public function getTotalSaleCount()
    {
        return $this->data->totalSaleCount ?? null;
    }

    public function getTotalReverseCount()
    {
        return $this->data->totalReverseCount ?? null;
    }

    public function getTotalRefundCount()
    {
        return $this->data->totalRefundCount ?? null;
    }

    public function getTotalPreAuthCount()
    {
        return $this->data->totalPreAuthCount ?? null;
    }

    public function getTotalPostAuthCount()
    {
        return $this->data->totalPostAuthCount ?? null;
    }

    public function getTotalPreAuthReverseCount()
    {
        return $this->data->totalPreAuthReverseCount ?? null;
    }

    public function getTotalPostAuthReverseCount()
    {
        return $this->data->totalPostAuthReverseCount ?? null;
    }

    public function getExtraParameters()
    {
        return $this->data->extraParameters ?? null;
    }
}
