<?php

namespace PaymentAdapter\Contracts;


interface PaymentDriverInterface {

    /**
     * It will set the user
     * @param $user
     * @return PaymentDriverInterface
     */
    public function setUser($user) : PaymentDriverInterface;

    /**
     * It will charge the amount
     * @param $amountInCents
     * @param $currency
     * @param $sourceId
     * @return bool
     */
    public function charge($amountInCents, $currency, $sourceId) : bool;

    /**
     * It will process a request for refunding given user
     * @param $amountInCents
     * @param $currency
     * @return bool
     */
    public function refund($amountInCents, $currency) : bool;

}
