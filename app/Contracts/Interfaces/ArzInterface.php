<?php

namespace App\Contracts\Interfaces;

interface ArzInterface
{
    /**
     * for deposit wallet transaction
     */
    public function deposit($price);
    /**
     * for withdraw wallet transaction
     */
    public function withdraw($price);
    /**
     * get wallet user
     */
    public function showStock();
    /**
     * get transaction list
     */
    public function transactionList();
}
